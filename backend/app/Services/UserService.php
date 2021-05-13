<?php

namespace App\Services;

use App\Jobs\Mail\User\StoreUserMail;
use App\Models\ChangePass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    private $user;
    private $changePass;

    public function __construct(User $user, ChangePass $changePass) {
        $this->user = $user;
        $this->changePass = $changePass;
    }

    public function paginate()
    {
        $paginate = $this->user->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->department;
            return $item;
        });
        return $paginate;
    }

    public function get($id)
    {
        $user = $this->user->findOrFail($id);
        return $user;
    }

    public function create($params)
    {
        $password = (array_key_exists('password', $params) && !is_null($params['password'])) ? $params['password'] : Str::random(6);
        $params['password'] = Hash::make($password);
        $user = $this->user->create($params);

        $this->changePass->create([
            'type_id' => 1,
            'token' => '',
            'user_id' => $user->id
        ]);

        $message = [
            'type' => 'Store user',
            'email' => $user->email,
            'password' => $password,
            'content' => 'User has been created!',
        ];

        StoreUserMail::dispatch($message, $user)->delay(now());

        return $user;
    }

    public function update($params, $id)
    {
        $user = $this->get($id);
        if (array_key_exists('password', $params)) {
            $params['password'] = Hash::make($params['password']);
        }
        if (!$user) {
            return false;
        }
        $user->update($params);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->get($id);
        $user->delete();
        return true;
    }

    public function dropdown($role_id = '')
    {
        $items = $this->user
            ->where(function ($query) use ($role_id) {
                if ($role_id && $role_id !== null) {
                    $query->where('role_id', $role_id);
                }
            })
            ->get();
        $result = [];
        foreach ($items as $item) {
            array_push($result, [
                'id' => $item->id,
                'name' => $item->name,
            ]);
        }
        return $result;
    }
}
