<?php

use App\Http\Controllers\FriendsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\UserAuthController;
Route::post('/register', [UserAuthController::class, 'RegisterUser']);
Route::post('/login', [UserAuthController::class, 'LoginUser']);
Route::post('/whoami', [UserAuthController::class, 'GetCurrentUser'])->middleware('auth:sanctum');
Route::post('/edituser', [UserAuthController::class, 'EditUser'])->middleware('auth:sanctum');
Route::post('/addfriend', [FriendsController::class, 'AddFriend'])->middleware('auth:sanctum');
Route::post('/deletefriend', [FriendsController::class, 'DeleteFriend'])->middleware('auth:sanctum');