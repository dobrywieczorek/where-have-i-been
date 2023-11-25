<?php

use App\Http\Controllers\FriendsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StatisticsController;
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
Route::post('/logout', [UserAuthController::class, 'LogoutUser'])->middleware('auth:sanctum');
Route::post('/whoami', [UserAuthController::class, 'GetCurrentUser'])->middleware('auth:sanctum');
Route::post('/edituser', [UserAuthController::class, 'EditUser'])->middleware('auth:sanctum');
Route::post('/addfriend', [FriendsController::class, 'AddFriend'])->middleware('auth:sanctum');
Route::post('/deletefriend', [FriendsController::class, 'DeleteFriend'])->middleware('auth:sanctum');
Route::get('/getusersbyname', [UserAuthController::class, 'GetUsersByName']);
Route::get('/getuserbyid', [UserAuthController::class, 'GetUserById']);
Route::get('/getuserfriends', [FriendsController::class, 'GetUserFriends'])->middleware('auth:sanctum');
Route::get('/get-map-pins', [MapController::class, 'getMapPins'])->middleware('auth:sanctum');
Route::get('/getUserStats', [StatisticsController::class, 'GetUserStatistics'])->middleware('auth:sanctum');

// Map pins routing
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/map-pins', [MapController::class, 'index']);
    Route::get('/map-pins/{mapPin}', [MapController::class, 'show']);
    Route::post('/map-pins', [MapController::class, 'store']);
    Route::put('/map-pins/{mapPin}', [MapController::class, 'update']);
    Route::delete('/map-pins/{mapPin}', [MapController::class, 'destroy']);
});
