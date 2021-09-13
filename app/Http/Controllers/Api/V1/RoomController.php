<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Subject;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::all();
        return response([
            'status' => 200,
            'data' => $rooms
        ], 200);
    }

    public function store(Request $request)
    {

        $room = [
            'name' => $request->name
        ];

        DB::beginTransaction();
        try {
            $data = Room::query()->insert($room);
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
