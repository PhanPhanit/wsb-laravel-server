<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SocialiteController::class)->prefix('api/v1/auth')->group(function(){
    Route::get('/google', 'googleLogin');
    Route::get('/google/callback', 'googleCallback');
    Route::get('/facebook', 'facebookLogin');
    Route::get('/facebook/callback', 'facebookCallback');
});


