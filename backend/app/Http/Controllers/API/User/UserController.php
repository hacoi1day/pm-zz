<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Jobs\Mail\User\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @OA\Post(
     *      path="/user/reset-password",
     *      operationId="postResetPassword",
     *      tags={"User"},
     *      summary="Reset Password",
     *      description="Reset Password",
     *      @OA\Response(
     *          response=200,
     *          description="Status Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user_ids = $request->input('user_ids');
        $password = $request->has('password') ? $request->input('password') : Str::random(8);

        foreach($user_ids as $user_id) {
            $user = $this->user->find($user_id);
            if ($user) {
                $user->update([
                    'password' => Hash::make($password)
                ]);
                $data = [
                    'email' => $user->email,
                    'password' => $password
                ];
                ResetPasswordMail::dispatch($user, $data)->delay(Carbon::now());
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đặt lại mật khẩu thành công.'
        ], 200);
    }
}
