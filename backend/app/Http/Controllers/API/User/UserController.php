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

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
