<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\User\UserController;

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

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::get('check', [AuthenticationController::class, 'check']);

    // API Resources
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);

    // Posts
    Route::get('my/posts', [UserController::class, 'getMyPosts']);
});
