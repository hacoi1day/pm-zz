<?php

namespace App\Services;

use App\Models\ChangePass;

class ChangePasswordService
{
    private $changePass;

    public function __construct(ChangePass $changePass) {
        $this->changePass = $changePass;
    }

    public function get($id)
    {
        $change = $this->changePass->findOrFail($id);
        return $change;
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

    public function delete($id)
    {
        $change = $this->get($id);
        $change->delete();
        return true;
    }
}
