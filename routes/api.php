<?php

use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\ReactionController;
use App\Http\Controllers\Api\V1\RegisterCourseController;
use App\Http\Controllers\Api\V1\SubjectController;
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

    // subject
    Route::get('subjects', [SubjectController::class, 'index']);

    // courses
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'detailOneCourse']);

    // params; { user_id, course_id }
    Route::post('register-course', [RegisterCourseController::class, 'courseRegister']);

    // params; { user_id }
    Route::post('register-course/user', [RegisterCourseController::class, 'courseOfUser']);
});
