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

    public function store(Request $request) 
    {
       
        $course = [
            'subject_id' => $request->subject_id,
            'shift_id' => $request->shift_id,
            'code' => $request->code,
            'total' => $request->total
        ];

        DB::beginTransaction();
        try {
            $data = Course::query()->insert($course);
            DB::commit();
            return response([
                'status' => 200,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollBack();
            return response()->json(['error' => 'server_error'], 500);
        }
    }
}
