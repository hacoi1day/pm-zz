<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActiveRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ChangePasswordTokenRequest;
use App\Http\Requests\Auth\ChangeUserInfoRequest;
use App\Http\Requests\Auth\CheckPermissionRequest;
use App\Http\Requests\Auth\CheckTokenRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\Mail\Auth\ResetPassword;
use App\Models\ChangePass;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ChangePasswordService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $user;
    private $changePass;
    private $role;

    private $authService;
    private $changePasswordService;

    public function __construct(
        AuthService $authService,
        ChangePasswordService $changePasswordService,

        User $user, ChangePass $changePass, Role $role
    ) {
        $this->authService = $authService;
        $this->changePasswordService = $changePasswordService;

        $this->user = $user;
        $this->changePass = $changePass;
        $this->role = $role;
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->authService->login($email, $password);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], 500);
        }
        return response()->json($user);
    }

    public function me()
    {
        $user = $this->authService->me();
        return response()->json($user);
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Đăng xuất thành công.'
        ], 200);
    }

    public function active(ActiveRequest $request)
    {
        $token = $request->token;
        $this->authService->active($token);
        return response()->json([
            'status' => 'success',
            'message' => 'Kích hoạt tài khoản thành công !'
        ], 200);
    }

    public function changePassword (ChangePasswordRequest $request)
    {
        $params = $request->all();
        $currentPassword = $params['currentPassword'];
        $newPassword = $params['password'];

        $checkPassword = $this->authService->checkPassword($currentPassword);
        if (!$checkPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ không chính xác.'
            ], 500);
        }
        $this->authService->changePassword($newPassword);
        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công.'
        ], 200);
    }

    public function changeUserInfo (ChangeUserInfoRequest $request)
    {
        if (!Auth::guard('api')->check()) {
            abort(401);
        }
        $params = $request->only(
            'name',
            'phone',
            'birthday',
            'gender',
            'address',
            'avatar'
        );
        $this->authService->changeUserInfo($params);
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật dữ liệu thành công'
        ], 200);
    }

    public function resetPassword (ResetPasswordRequest $request)
    {
        $email = $request->input('email');
        $this->authService->resetPassword($email);
        return response()->json([
            'status' => 'success',
            'message' => 'Đã gửi một email về địa chỉ ' . $email . '.'
        ], 200);
    }

    public function checkToken (CheckTokenRequest $request)
    {
        $token = $request->input('token');
        $change = $this->authService->checkToken($token);
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
    }

    public function changePasswordToken(ChangePasswordTokenRequest $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');

        // check has token
        $change = $this->changePasswordService->getByToken($token);
        if (!$change) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token không hợp lệ.'
            ], 500);
        }

        // check has user
        if (!$this->authService->checkUser($change->user_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại hoặc đã bị vô hiệu hoá.'
            ], 500);
        }

        $this->authService->changePassword($password);

        $change->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi mật khẩu thành công.'
        ], 200);
    }

    public function checkPermission(CheckPermissionRequest $request)
    {
        $name = $request->input('name');

        $listPermission = json_decode($this->role->find(1)->permissions);
        if (!in_array($name, $listPermission)) {
            return response()->json([
                'status' => true
            ], 200);
        }

        $user = Auth::guard('api')->user();

        // Check user has role
        // If user hasn't rol => false
        if (!$user->role_id) {
            return response()->json([
                'status' => false
            ], 200);
        }

        $role = $this->role->find($user->role_id);
        $permissions = json_decode($role->permissions);
        if (in_array($name, $permissions)) {
            return response()->json([
                'status' => true
            ], 200);
        }

        return response()->json([
            'status' => false
        ], 200);
    }

}
