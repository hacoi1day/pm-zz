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
use App\Services\AuthService;
use App\Services\ChangePasswordService;

class AuthController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Auth",
     *      description="Auth",
     *      @OA\Contact(
     *          email="admin@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url="L5_SWAGGER_CONST_HOST",
     *      description="PM API Server"
     * )
     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of PM Projects"
     * )
     */

    private $authService;
    private $changePasswordService;

    public function __construct(AuthService $authService, ChangePasswordService $changePasswordService) {
        $this->authService = $authService;
        $this->changePasswordService = $changePasswordService;
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="postLogin",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="Login",
     *      @OA\Response(
     *          response=200,
     *          description="User Info and Token",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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

    /**
     * @OA\Get(
     *      path="/auth/me",
     *      operationId="getMe",
     *      tags={"Auth"},
     *      summary="Me",
     *      description="Me",
     *      @OA\Response(
     *          response=200,
     *          description="User Info",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function me()
    {
        $user = $this->authService->me();
        return response()->json($user);
    }

    /**
     * @OA\Get(
     *      path="/auth/logout",
     *      operationId="getLogout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      description="Logout",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Đăng xuất thành công.'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/auth/active",
     *      operationId="getActive",
     *      tags={"Auth"},
     *      summary="Active",
     *      description="Active",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function active(ActiveRequest $request)
    {
        $token = $request->token;
        $this->authService->active($token);
        return response()->json([
            'status' => 'success',
            'message' => 'Kích hoạt tài khoản thành công !'
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/auth/change-password",
     *      operationId="postChangePassword",
     *      tags={"Auth"},
     *      summary="Change Password",
     *      description="Change Password",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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

    /**
     * @OA\Post(
     *      path="/auth/change-user-info",
     *      operationId="postChangeUserInfo",
     *      tags={"Auth"},
     *      summary="Change User Info",
     *      description="Change User Info",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function changeUserInfo (ChangeUserInfoRequest $request)
    {
        $params = $request->only(
            'name',
            'phone',
            'birthday',
            'gender',
            'address',
            'avatar'
        );
        $user = $this->authService->changeUserInfo($params);
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật dữ liệu thành công',
            'user' => $user
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/auth/reset-password",
     *      operationId="postResetPassword",
     *      tags={"Auth"},
     *      summary="Reset Password",
     *      description="Reset Password",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function resetPassword (ResetPasswordRequest $request)
    {
        $email = $request->input('email');
        $this->authService->resetPassword($email);
        return response()->json([
            'status' => 'success',
            'message' => 'Đã gửi một email về địa chỉ ' . $email . '.'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/auth/check-token",
     *      operationId="getCheckToken",
     *      tags={"Auth"},
     *      summary="Check Token",
     *      description="Check Token",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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
            'status' => 'success',
            'message' => 'Token hợp lệ.',
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/auth/change-password-token",
     *      operationId="postChangePasswordToken",
     *      tags={"Auth"},
     *      summary="Change Password Token",
     *      description="Change Password Token",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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
        $user = $this->authService->checkUser($change->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại hoặc đã bị vô hiệu hoá.'
            ], 500);
        }

        $this->authService->changePasswordWithUserId($password, $user->id);

        $this->changePasswordService->delete($change->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Thay đổi mật khẩu thành công.'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/auth/check-permission",
     *      operationId="getCheckPermission",
     *      tags={"Auth"},
     *      summary="Check Permission",
     *      description="Check Permission",
     *      @OA\Response(
     *          response=200,
     *          description="Status Success Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function checkPermission(CheckPermissionRequest $request)
    {
        $name = $request->input('name');
        $check = $this->authService->checkHasPermission($name);
        return response()->json([
            'status' => $check
        ], 200);
    }
}
