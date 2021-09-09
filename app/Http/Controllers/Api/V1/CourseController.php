<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with(['shift', 'subject'])->get();
        return response([
            'status' => 200,
            'data' => $courses
        ], 200);
    }

    public function detailOneCourse($id)
    {
        $course = Course::query()->where(['subject_id' => $id])->with(['shift', 'subject'])->get();
        return response([
            'status' => 200,
            'data' => $course
        ], 200);
    }
}
