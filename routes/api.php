<?php

use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\ReactionController;
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

Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {

    // do not use.
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('check-codeReset', [AuthController::class, 'checkCodeResetPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::post('me', 'AuthController@me');
    Route::get('logout', 'AuthController@logout');



    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('user')->group(function () {
          // do somethings
        });

        Route::prefix('admin')->namespace('Admin')->group(function () {
            Route::middleware('scope:admin')->group(function () {
               // do somethings
            });
        });

    });
});
