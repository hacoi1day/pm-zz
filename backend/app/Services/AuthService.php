<?php

namespace App\Services;

use App\Jobs\Mail\Auth\ResetPassword;
use App\Models\ChangePass;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    private $user;
    private $changePass;
    private $role;

    public function __construct(User $user, ChangePass $changePass, Role $role) {
        $this->user = $user;
        $this->changePass = $changePass;
        $this->role = $role;
    }

    public function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = $this->user->where('email', $email)->first();
            $user->token = $user->createToken('token')->accessToken;
            $user->role;
            if ($user->role) {
                $user->role->permissions = json_decode($user->role->permissions);
            }
            $user->department;
            if ($user->department) {
                $user->department->manager;
            }

            $change = $this->changePass
                ->where('user_id', $user->id)
                ->where('type_id', 1)->get();
            $user->change_password = $change;
            return $user;
        } else {
            return null;
        }
    }

    public function me()
    {
        $user = Auth::guard('api')->user();
        $user->role;
        if ($user->role) {
            $user->role->permissions = json_decode($user->role->permissions);
        }
        if ($user->department) {
            $user->department->manager;
        }
        $change = $this->changePass
            ->where('user_id', $user->id)
            ->where('type_id', 1)->get();
        $user->change_password = $change;

        return $user;
    }

    public function logout()
    {
        if (Auth::guard('api')->check()) {
            $tokens = Auth::guard('api')->user()->tokens;
            foreach($tokens as $token) {
                $token->revoke();
            }
            return true;
        }
        return false;
    }

    public function active($token)
    {
        $item = $this->changePass->where('token', $token)->firstOrFail();
        $item->delete();
    }

    public function checkPassword($currentPassword)
    {
        $user = Auth::guard('api')->user();
        if (Hash::check($currentPassword, $user->password)) {
            return true;
        }
        return false;
    }

    public function changePassword($newPassword)
    {
        $userId = Auth::guard('api')->id();
        $user = $this->user->where('id', $userId)->fist();
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
        $change = $this->changePass
            ->where('user_id', $user->id)
            ->where('type_id', 1)->first();
        if ($change) {
            $change->delete();
        }
    }

    public function changeUserInfo($params = [])
    {
        $user = $this->user
            ->where('id', Auth::guard('api')->id())
            ->firstOrFail();
        $user->update($params);
    }

    public function resetPassword($email)
    {
        $user = $this->user->where('email', $email)->firstOrFail();
        $token = Str::random(60);

        // insert record to table change_passes
        $this->changePass->create([
            'user_id' => $user->id,
            'token' => $token,
            'type_id' => 2
        ]);
        // send token to email user
        $data = [
            'email' => $email,
            'token' => $token
        ];
        ResetPassword::dispatch($email, $data)->delay(Carbon::now());
    }

    public function checkToken($token)
    {
        $change = $this->changePass->where('token', $token)->first();
        return $change;
    }

    public function checkUser($userId)
    {
        $user = $this->user->where('id', $userId)->first();
        return $user;
    }
}
