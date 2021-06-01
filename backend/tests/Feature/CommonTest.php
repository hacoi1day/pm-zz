<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommonTest extends TestCase
{
    private static $token;

    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        self::$token = $user->token;
    }

    public function test_check_unique_true()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/common/check-unique/users/email/1', [
                'value' => 'admin@gmail.com'
            ]);
        $response->assertStatus(200)->assertSeeText('1');
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'email' => 'admin@gmail.com'
        ]);
    }

    public function test_check_unique_false()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/common/check-unique/users/email/2', [
                'value' => 'admin@gmail.com'
            ]);
        $response->assertStatus(200)->assertSeeText('0');
        $this->assertDatabaseMissing('users', [
            'id' => 2,
            'email' => 'admin@gmail.com'
        ]);
    }
}
