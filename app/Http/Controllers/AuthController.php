<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\SendResetPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ];
        $validated = \Validator::make($request->all(), $rules);
        if($validated->fails())
        {
            $errorArray = $validated->errors()->get('*');
            $errorMessage = "The ";
            foreach(array_keys($errorArray) as $keyError){
                $errorMessage .= $keyError." field ";
            }
            $errorMessage .= "required";
            return response()->json([
                "message" => $errorMessage
            ], 400);
        }
        $countUser = User::count('id');
        $role = $countUser>0?"user":"admin";
        $existUser = User::where('email', '=', $request->input('email'))
            ->where('googleId', '=', '')->first();
        if($existUser){
            return response([
                'message' => 'Email already exist'
            ], 404);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $role,
            'facebookId' => "",
            'googleId' => ""
        ]);
        $user['isActive'] = true;
        $token = $user->createToken('wsbtoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
        $validated = \Validator::make($request->all(), $rules);
        if($validated->fails())
        {
            $errorArray = $validated->errors()->get('*');
            $errorMessage = "The ";
            foreach(array_keys($errorArray) as $keyError){
                $errorMessage .= $keyError." field ";
            }
            $errorMessage .= "required";
            return response()->json([
                "message" => $errorMessage
            ], 400);
        }

        // Check email
        $user = User::where('email', $request->input('email'))
            ->where('googleId', '')->first();

        if(!$user){
            return response([
                'message' => 'Invalid Email'
            ], 401);
        }
        if(!$user->isActive){
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        // Check password
        if(!$user || !Hash::check($request->input('password'), $user->password)){
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('wsbtoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
    public function forgotPassword(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
        ];
        $validated = \Validator::make($request->all(), $rules);
        if($validated->fails())
        {
            $errorArray = $validated->errors()->get('*');
            $errorMessage = "The ";
            foreach(array_keys($errorArray) as $keyError){
                $errorMessage .= $keyError." field ";
            }
            $errorMessage .= "required";
            return response()->json([
                "message" => $errorMessage
            ], 400);
        }
        $user = User::where('email', $request->input('email'))
            ->where('googleId', '')
            ->where('isActive', true)->first();

        if(!$user){
            return response([
                'message' => 'This email does not exist'
            ], 400);
        }
        $verify = DB::table('password_resets')->where('email', $request->input('email'));
        if($verify->exists()){
            $verify->delete();
        }
        $token = Hash::make(Str::random(64));
        $password_reset = DB::table('password_resets')->insert([
            'email' => $request->input('email'),
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        if($password_reset){
            $origin = env('FRONT_END_URL');
            $resetPasswordUrl = "{$origin}/reset-password?token={$token}&email={$request->input('email')}";
            $data = [
                'name' => $user->name,
                'origin' => $origin,
                'reset_password_url' => $resetPasswordUrl
            ];
            Mail::to($request->input('email'))->send(new SendResetPasswordEmail($data));
        }


        return response([
            'message' => 'Please check your email for reset password link'
        ], 200);
    }
    public function resetPassword(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'token' => 'required',
            'password' => 'required'
        ];
        $validated = \Validator::make($request->all(), $rules);
        if($validated->fails())
        {
            $errorArray = $validated->errors()->get('*');
            $errorMessage = "The ";
            foreach(array_keys($errorArray) as $keyError){
                $errorMessage .= $keyError." field ";
            }
            $errorMessage .= "required";
            return response()->json([
                "message" => $errorMessage
            ], 400);
        }

        $check = DB::table('password_resets')->where([
            ['email', $request->input('email')],
            ['token', $request->input('token')]
        ]);

        if(!$check->exists()){
            return response([
                'message' => 'Invalid token'
            ], 401);
        }
        $difference = Carbon::now()->diffInSeconds($check->first()->created_at);
        $oneHour = 1 * 60 * 60;
        if($difference > $oneHour){
            return response([
                'message' => 'Token Expired'
            ], 400);
        }


        $user = User::where('email', $request->input('email'))
            ->where('googleId', '')
            ->where('isActive', true);
        if(!$user->exists()){
            return response([
                'message' => 'Invalid user'
            ], 401);
        }
        $user->update(['password' => bcrypt($request->input('password'))]);

        $delete = DB::table('password_resets')->where([
            ['email', $request->input('email')],
            ['token', $request->input('token')]
        ])->delete();

        return response([
            "message" => "Success reset password."
        ], 200);
    }
}
