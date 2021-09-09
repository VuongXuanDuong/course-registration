<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Room;
use App\Models\User;
use App\Rules\MatchOldPassword;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if (isset($request['name'])) {
            $query = $query
                ->where('name', 'like', "%$request->name%");
        }

        if (isset($request['user_name'])) {
            $query = $query
                ->where('user_name', 'like', "%$request->user_name%");
        }

        return $query->paginateAndTransform(new UserTransformer());
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->toArray();
        $user = new User();
        $user->is_admin = 0;
        $user->fill($data);

        DB::beginTransaction();
        try {
            $user->save();
            // room_id = 1 is id of room General
            DB::table('user_room_relations')->insert([
                'user_id' => $user->id,
                'room_id' => 1,
                'join_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollBack();
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'not_found'], 404);
        }
        return fractal($user, new UserTransformer())->toArray();
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->toArray();
        $user = Auth::user();
        if ($id != $user->id) {
            return response()->json(['error' => 'You do not have permission for this']);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'not_found'], 404);
        }

        if ($request->has('avatar')) {
            $image = $request->file('avatar');
            $path = $image->store('images', 'public');

            $user->profile_url = $path;
        }

        $user->fill($data);
        DB::beginTransaction();
        try {
            $user->update();
            DB::commit();
            return response()->json(['success' => true, 'data' => fractal($user, new UserTransformer())]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        try {
            foreach ($ids as $id) {
                $user = User::findOrFail($id);
                if (!$user) return response()->json(['error' => 'not_found'], 404);
                DB::beginTransaction();

                $user->rooms()->where('is_group', 0)->update(['icon_url' => User::AVATAR_USER_DELETE]);
                $user->delete();
                DB::commit();
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    public function changePassword(Request $request, $id)
    {

        $currentPassword = $request->get('current_password');
        if (!Hash::check($currentPassword, Auth::user()->password)) {
            return response()->json([
                'errors' => [
                    'current_password' => 'The current password is not true.'
                ]
            ], 422);
        }

        $password = $request->get('new_password');

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'not_found'], 404);
        }
        $user->password = $password;
        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isAdmin = $request->is_admin;

        $user->is_admin = $isAdmin;
        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
            return response()->json(['success' => true, 'data' => fractal($user, new UserTransformer())]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }

    }
}
