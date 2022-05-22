<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function createUser(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'isActive' => 'required'
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

        $userExist = User::where('email', $request->input('email'))
            ->where('googleId', '')->first();
        if($userExist){
            return response([
                "message" => "Your email ({$request->input('email')}) already exist!"
            ], 400);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'isActive' => $request->input('isActive'),
            'facebookId' => "",
            'googleId' => ""
        ]);

        return response([
            'user' => $user
        ], 201);;
    }
    public function getAllUser(Request $request)
    {
        $query = new User;
        if($request->filled('search')){
            $search = $request->input('search');
            $query = $query->where('id', $search)
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('role', '=', $search)
                ->orWhere('facebookId', '=', $search)
                ->orWhere('googleId', '=', $search);

            if($request->input('search')=='true' || $request->input('search')=='false'){
                $query = $query->orWhere('isActive', $request->boolean('search'));
            }
        }
        if($request->has('name')){
            $query = $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if($request->has('email')){
            $query = $query->where('email', '=', $request->input('email'));
        }
        if($request->has('role')){
            $query = $query->where('role', '=', $request->input('role'));
        }
        if($request->has('isActive')){
            $tempIsActive = $request->input('isActive') === 'true' ? true:false;
            $query = $query->where('isActive', '=', $tempIsActive);
        }
        if($request->has('sort')){
            $sortText = $request->input('sort');
            $sort = $sortText[0]=="-"?"DESC":"ASC";
            $field = $sortText[0]=="-"?substr($sortText, 1):$sortText;
            $query = $query->orderBy($field, $sort);
        }

        $totalUser = $query->count();
        $page = $request->input('page')?(int) $request->input('page') : 1;
        $limit = $request->input('limit')?(int) $request->input('limit') : 10;
        $skip = ($page-1) * $limit;
        $totalPage = ceil($totalUser / $limit);
        $users = $query->skip($skip)->take($limit)->get();

        return response()->json([
            "users" => $users,
            "count" => count($users),
            "currentPage" => $page,
            "totalPage" => $totalPage,
            "totalUser" => $totalUser
        ], 200);
    }
    public function getSingleUser(Request $request, $userId)
    {
        if($request->user()->role==="user"){
            if($userId!=$request->user()->id){
                return response()->json([
                    "message" => "Not authorized to access this route"
                ], 401);
            }
        }
        return response()->json([
            "user" => User::where('id', '=', $userId)->first()
        ]);
    }
    public function showCurrentUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function updateUser(Request $request)
    {
        if($request->input('name')=="" || $request->input('email')==""){
            return response()->json([
                'message' => 'Please provide name and email.'
            ], 400);
        }
        $user = User::find($request->user()->id);
        if($user->email !== $request->input('email')){
            $emailAlreadyExist = User::where('email', '=', $request->input('email'))->first();
            if($emailAlreadyExist){
                return response()->json([
                    'message' => 'Email is already exist!'
                ], 400);
            }
        }
        if($user->googleId || $user->facebookId){
            return response()->json([
                'message' => 'Can not update'
            ], 400);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function adminUpdateUser(Request $request, $userId)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'isActive' => 'required'
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

        $user = User::find($userId);
        if(!$user){
            return response()->json([
                'message' => 'No user with: '.$userId
            ], 400);
        }

        $isEmailAlreadyExist = User::where('email', '=', $request->input('email'))->first();
        if($isEmailAlreadyExist){
            if($request->input('email') !== $user->email){
                return response()->json([
                    "message" => "Email is already exist!"
                ], 400);
            }
        }

        // optional
        if($user->googleId || $user->facebookId){
            $user->isActive = $request->input('isActive');
            $user->role = $request->input('role');
        }else{
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = $request->input('role');
            $user->isActive = $request->input('isActive');
        }
        $user->save();

        
        return response()->json([
            'user' => $user
        ], 200);

    }
    public function updateUserPassword(Request $request)
    {
        if($request->input('oldPassword')=="" || $request->input('newPassword')==""){
            return response()->json([
                "message" => "Please provide all value!"
            ], 400);
        }
        $user = User::find($request->user()->id);
        if($user->googleId || $user->facebookId){
            return response()->json([
                'message' => 'Can not update'
            ], 400);
        }
        if(!$user || !Hash::check($request->input('oldPassword'), $user->password)){
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $user->password = bcrypt($request->input('newPassword'));
        $user->save();
        return response()->json([
            'message' => 'Success! Password Updated.'
        ], 200);
    }
    public function countAllUser(Request $request)
    {
        $query = new User;
        if($request->filled('role')){
            $query = $query->where('role', '=', $request->input('role'));
        }
        if($request->filled('isActive')){
            $query = $query->where('isActive', '=', $request->boolean('isActive'));
        }
        $totalUser = $query->count();
        return response([
            'totalUser' => $totalUser
        ], 200);
    }
}
