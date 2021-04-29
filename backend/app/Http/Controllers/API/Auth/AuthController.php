<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActiveRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ChangePasswordTokenRequest;
use App\Http\Requests\Auth\ChangeUserInfoRequest;
use App\Http\Requests\Auth\CheckTokenRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\Mail\Auth\ResetPassword;
use App\Models\ChangePass;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $user;
    private $changePass;

    public function __construct(User $user, ChangePass $changePass) {
        $this->user = $user;
        $this->changePass = $changePass;
    }

    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = $this->user->where('email', $request->email)->first();
                $user->token = $user->createToken('token')->accessToken;
                return response()->json($user, 200);
            }
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        try {
            $user = Auth::guard('api')->user();
            $user->department;
            return response()->json($user);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            if (Auth::guard('api')->check()) {
                $tokens = Auth::guard('api')->user()->tokens;
                foreach($tokens as $token) {
                    $token->revoke();
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Logout successfully'
                ], 200);
            }
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function active(ActiveRequest $request)
    {
        try {
            $token = $request->token;
            $item = $this->changePass->where('token', $token)->firstOrFail();
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Kích hoạt tài khoản thành công !'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword (ChangePasswordRequest $request)
    {
        try {
            $params = $request->all();
            $currentPassword = $params['currentPassword'];
            $newPassword = $params['password'];

            $user = $this->user->where('id', Auth::guard('api')->id())
            ->firstOrFail();
            if (!Hash::check($currentPassword, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mật khẩu cũ không chính xác.'
                ], 500);
            }
            $user->update([
                'password' => Hash::make($newPassword)
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Đổi mật khẩu thành công.'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changeUserInfo (ChangeUserInfoRequest $request)
    {
        try {
            if (!Auth::guard('api')->check()) {
                abort(401);
            }
            $params = $request->only(
                'name',
                'phone',
                'birthday',
                'gender',
                'address',
                // 'avatar'
            );
            $user = $this->user
                ->where('id', Auth::guard('api')->id())
                ->firstOrFail();
            $user->update($params);
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật dữ liệu thành công'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword (ResetPasswordRequest $request)
    {
        try {
            $email = $request->input('email');
            $user = $this->user->where('email', $email)->firstOrFail();
            $token = Str::random(60);

            // insert record to table change_passes
            $this->changePass->create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            // send token to email user
            $data = [
                'email' => $email,
                'token' => $token
            ];
            ResetPassword::dispatch($email, $data)->delay(Carbon::now());

            return response()->json([
                'status' => 'success',
                'message' => 'Đã gửi một email về địa chỉ ' . $email . '.'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkToken (CheckTokenRequest $request)
    {
        try {
            $token = $request->input('token');
            $change = $this->changePass->where('token', $token)->first();
            if (!$change) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token không chính xác hoặc đã hết hạn, xin thử lại.'
                ], 500);
            }
            return response()->json([
                'success',
                'message' => 'Token hợp lệ.',
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changePasswordToken(ChangePasswordTokenRequest $request)
    {
        try {
            $token = $request->input('token');
            $password = $request->input('password');

            // check has token
            $change = $this->changePass->where('token', $token)->first();
            if (!$change) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token không hợp lệ.'
                ], 500);
            }

            // check has user
            $user = $this->user->where('id', $change->user_id)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản không tồn tại hoặc đã bị vô hiệu hoá.'
                ], 500);
            }

            $user->update([
                'password' => Hash::make($password)
            ]);

            $change->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Thay đổi mật khẩu thành công.'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
