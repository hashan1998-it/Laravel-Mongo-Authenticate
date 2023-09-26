<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/user/{email}', [UserController::class, 'show']);

//User Routes
Route::get('/users', [UserController::class, 'index']);

Route::post('/user/profile/update', [UserController::class, 'update']);

Route::post('/user/profile/image/update', [UserController::class, 'uploadProfileImage']);

Route::post('/user/profile/image/show', [UserController::class, 'showProfileImage']);


//Post Routes
Route::get('/posts', [PostController::class, 'index']);

Route::post('/posts/store', [PostController::class, 'store']);

Route::get('/posts/show', [PostController::class, 'show']);

Route::post('/posts/update', [PostController::class, 'update']);

Route::post('/posts/delete', [PostController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
