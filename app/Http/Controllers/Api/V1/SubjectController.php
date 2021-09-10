<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::all();
        return response([
            'status' => 200,
            'data' => $subjects
        ], 200);
    }

    public function store(Request $request)
    {

        $subject = [
            'name' => $request->name
        ];

        DB::beginTransaction();
        try {
            $data = Subject::query()->insert($subject);
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
