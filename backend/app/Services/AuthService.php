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
        $user = $this->user->where('id', $userId)->first();
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
        return true;
    }

    public function changePasswordWithUserId($password, $userId)
    {
        $user = $this->user->where('id', $userId)->first();
        $user->update([
            'password' => Hash::make($password)
        ]);
        return true;
    }

    public function changeUserInfo($params = [])
    {
        $user = $this->user
            ->where('id', Auth::guard('api')->id())
            ->firstOrFail();
        $user->update($params);
        return $user;
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
        $user = $this->user->where('id', $userId)->firstOrFail();
        return $user;
    }

    public function checkHasPermission($name)
    {
        $rootRole = $this->role->find(1);
        $listPermission = json_decode($rootRole->permissions);
        if (!in_array($name, $listPermission)) {
            return response()->json([
                'status' => true
            ], 200);
        }

        $user = Auth::guard('api')->user();

        // Check user has role
        // If user hasn't role => false
        if (!$user->role_id) {
            return false;
        }

        $role = $this->role->find($user->role_id);
        if ($role) {
            $permissions = json_decode($role->permissions);
            if (in_array($name, $permissions)) {
                return true;
            }
        }
        return false;
    }
}
