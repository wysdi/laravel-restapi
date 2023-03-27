<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

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


Route::post('token', [AuthController::class, 'login']);
//Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('posts', PostController::class, ['except'=> ['create']]);
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', UserController::class, ['except'=> [ 'create']]);
    });

});


