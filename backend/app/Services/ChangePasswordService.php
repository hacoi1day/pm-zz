<?php

namespace App\Services;

use App\Models\ChangePass;

class ChangePasswordService
{
    private $changePass;

    public function __construct(ChangePass $changePass) {
        $this->changePass = $changePass;
    }

    public function getAll()
    {

    }

    public function get()
    {

    }

    public function getByToken($token)
    {
        $change = $this->changePass->where('token', $token)->first();
        return $change;
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
