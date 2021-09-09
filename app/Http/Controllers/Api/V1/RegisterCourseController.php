<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Register;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterCourseController extends Controller
{
    public function index(Request $request)
    {
       // do somethings
    }

    public function courseOfUser(Request $request)
    {
        $userId = $request->user_id ?? 2;

        $register = Register::query()->where(['user_id' => $userId])->get();
        return response([
            'status' => 200,
            'data' => $register
        ], 200);
    }

    public function courseRegister(Request $request)
    {
        $userId = $request->user_id;
        $courseId = $request->course_id;

        $register = [
            'user_id' => $userId,
            'course_id' => $courseId
        ];

        DB::beginTransaction();
        try {
            $data = Register::query()->insert($register);
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
