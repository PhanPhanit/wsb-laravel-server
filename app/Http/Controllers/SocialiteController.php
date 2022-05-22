<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();


        $role = '';
        $userExist = User::where('googleId', $googleUser->id)->first();
        if($userExist){
            if(!$userExist->isActive){
                $urlSigin = env('FRONT_END_URL').'/signin?disable=true';
                return redirect()->away($urlSigin);
            }
            $role = $userExist->role;
        }else{
            $countUser = User::count('id');
            $role = $countUser>0?"user":"admin";
        }


        $user = User::updateOrCreate([
            'googleId' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'role' => $role,
            'password' => bcrypt(Str::random(24)),
            'googleId' => $googleUser->id,
            'facebookId' => ''
        ]);
        $token = $user->createToken('wsbtoken')->plainTextToken;
        $url = env('FRONT_END_URL').'/send-token?token='.$token;
        return redirect()->away($url);
    }

    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();


        $role = '';
        $userExist = User::where('facebookId', $facebookUser->id)->first();
        if($userExist){
            if(!$userExist->isActive){
                $urlSigin = env('FRONT_END_URL').'/signin?disable=true';
                return redirect()->away($urlSigin);
            }
            $role = $userExist->role;
        }else{
            $countUser = User::count('id');
            $role = $countUser>0?"user":"admin";
        }


        $user = User::updateOrCreate([
            'facebookId' => $facebookUser->id,
        ], [
            'name' => $facebookUser->name,
            'email' => '',
            'role' => $role,
            'password' => bcrypt(Str::random(24)),
            'googleId' => '',
            'facebookId' => $facebookUser->id
        ]);
        $token = $user->createToken('wsbtoken')->plainTextToken;
        $url = env('FRONT_END_URL').'/send-token?token='.$token;
        return redirect()->away($url);
    }
}
