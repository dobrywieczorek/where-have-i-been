<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Facebook login
route::get('auth/facebook',[FacebookController::class, 'facebookpage']);
route::get('auth/facebook/callback',[FacebookController::class, 'facebookredirect']);

//Google login
route::get('auth/google',[GoogleController::class, 'googlepage']);
route::get('auth/google/callback',[GoogleController::class, 'googleredirect']);
