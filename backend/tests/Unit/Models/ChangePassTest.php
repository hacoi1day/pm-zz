<?php

namespace Tests\Unit\Models;

use App\Models\ChangePass;
use PHPUnit\Framework\TestCase;

class ChangePassTest extends TestCase
{

    public function test_change_pass()
    {
        $changePass = new ChangePass;
        $changePass->user_id = 1;
        $changePass->token = 'new_token';
        $changePass->type_id = 2;

        $this->assertIsNumeric($changePass->user_id);
        $this->assertIsString($changePass->token);
        $this->assertIsNumeric($changePass->type_id);
    }
}
