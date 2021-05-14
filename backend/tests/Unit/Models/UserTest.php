<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_store_user()
    {
        $user = new User;
        $user->name = 'Test';
        $user->email = 'test@gmail.com';
        $user->password = '123456';

        $this->assertIsString($user->name);
        $this->assertIsString($user->email);
        $this->assertIsString($user->password);
    }
}
