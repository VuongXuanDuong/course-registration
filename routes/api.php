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
    // params; { name: string }
    Route::post('subjects', [CourseController::class, 'store']);

    // courses
    Route::get('courses', [CourseController::class, 'index']);
    // get all shifts of subject
    Route::get('courses/{id}', [CourseController::class, 'detailOneCourse']);
    // create a new course
    // params; { subject_id: int, shift_id: int, code: string, total: int }
    Route::post('courses', [CourseController::class, 'store']);

    // params; { user_id: int, course_id: int }
    Route::post('register-course', [RegisterCourseController::class, 'courseRegister']);

    // params; { user_id: int }
    Route::post('register-course/user', [RegisterCourseController::class, 'courseOfUser']);
});
