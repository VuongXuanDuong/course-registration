<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\MailResetPassword;
use App\Models\DeviceInfo;
use App\Models\PasswordReset;
use App\Models\User;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['user_name', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'unauthenticated'], 401);
            }

            $user = Auth::user();
            $isAdmin = $user->is_admin;

            $scope = [];
            if ($isAdmin === 0) $scope[] = 'user';
            if ($isAdmin === 1) $scope[] = 'admin';
            $token = $request->user()->createToken('Access Token', $scope)->plainTextToken;

            $userData = fractal($user, new UserTransformer());
            return response()->json(['success' => true, 'access_token' => $token, 'user' => $userData]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }

    }

    public function register(Request $request)
    {
        $user = new User();
        $data = $request->only($user->getFillable());
        $user->fill($data);

        DB::beginTransaction();
        try {
            $user->save();

            DB::commit();
            return fractal($user, new UserTransformer());
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollBack();
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    /**
     * Logout.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        $unique_device_id = $request->header('UniqueDeviceId');


        $deviceInfo = $user->deviceInfos()->where('unique_device_id', $unique_device_id)->first();

        if (!$deviceInfo) return response()->json(['error' => 'device info not found'], 404);
        $deviceInfo->status = DeviceInfo::STATUS['logout'];
        $deviceInfo->save();

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }


    /**
     * Get user infomation from access_token.
     *
     * @return
     */
    public function me()
    {
        $user = Auth::user();
        return fractal($user, new UserTransformer());
    }

    protected function _updateDeviceInfo($request, $user)
    {
        $deviceInfo = DeviceInfo::query()->where('user_id', $user->id)
            ->where('unique_device_id', $request->unique_device_id)->first();

        if ($deviceInfo) {
            $deviceInfo->update(['status' => DeviceInfo::STATUS['login'], 'fcm_token' => $request->fcm_token]);
        } else {
            $deviceInfo = new DeviceInfo();
            $deviceInfo['status'] = DeviceInfo::STATUS['login'];
            $deviceInfo['fcm_token'] = $request->fcm_token;
            $deviceInfo['user_id'] = $user->id;
            $deviceInfo['unique_device_id'] = $request->unique_device_id;
            $deviceInfo->save();
        }
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->email;
        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => 'The email is invalid.'
                ]], 401);
        }
        $digits = 6;

        //create token to send reset password mail
        $token = Rand(pow(10, $digits-1), pow(10, $digits)-1);

        PasswordReset::query()->create([
           'email' => $email,
           'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        Mail::to($email)->send(new MailResetPassword($token));

        return  response()->json([
            'success' => 'true',
            'email to reset password' => $email
            ], 200);
    }

    public function checkCodeResetPassword(Request $request)
    {
        $token = $request->code;
        $email = $request->email;
        $resetPassword = PasswordReset::query()->where([
            'email' => $email,
            'token' => $token
        ])->first();

        if (!$resetPassword) {
            return response()->json([
                'errors' => [
                    'code' =>'The code is invalid'
                ]
            ], 401);
        }
        if (Carbon::parse($resetPassword->created_at)->addMinutes(10)->isPast()) {
            $resetPassword->delete();
            return response()->json([
                'errors' => [
                    'code' =>'The code is invalid'
                ]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'code' => $token,
            'email' => $email
            ], 200);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $token = $request->code;
        $password = $request->password;

        $resetPassword = PasswordReset::query()->where([
            'email' => $email,
            'token' => $token
        ])->first();

        if (!$resetPassword) {
            return response()->json([
                'errors' => [
                    'code' =>'The code is invalid'
                ]
            ], 401);
        }

        $user = User::query()->where('email', $email)->firstOrFail();
        $user->password = $password;
        DB::beginTransaction();
        try {
            $user->save();
            $resetPassword->delete();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'server_error'], 500);
        }

    }

}
