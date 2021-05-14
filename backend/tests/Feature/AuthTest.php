<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $user;
    private static $token;

    public function test_login_without_params()
    {
        $response = $this->post('api/v1/login');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email', 'password']]);
    }

    public function test_login_without_email()
    {
        $response = $this->post('api/v1/login', [
            'password' => '123456'
        ]);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    }

    public function test_login_without_password()
    {
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
        ]);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['password']]);
    }

    public function test_login()
    {
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        // dd($user);
        $this->user = $user;
        $response->assertStatus(200)->assertJsonStructure(['email', 'token']);
    }

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

    public function test_me()
    {
        $response = $this->withHeader('Authorization', 'Bearer '.self::$token)->get('api/v1/auth/me');
        $response->assertStatus(200)->assertJsonStructure(['email', 'name']);
    }

    public function test_change_password()
    {
        $response = $this->withHeader('Authorization', 'Bearer '.self::$token)->post('api/v1/auth/change-password', [
            'currentPassword' => '123456',
            'password' => '123456',
            'passwordConfirm' => '123456'
        ]);
        $response->assertStatus(200)->assertJsonStructure(['message', 'status']);
    }

    public function test_change_password_without_current_password()
    {
        $response = $this->withHeader('Authorization', 'Bearer '.self::$token)->post('api/v1/auth/change-password', [
            'password' => '123456',
            'passwordConfirm' => '123456'
        ]);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['currentPassword']]);
    }

    public function test_change_password_without_password()
    {
        $response = $this->withHeader('Authorization', 'Bearer '.self::$token)->post('api/v1/auth/change-password', [
            'currentPassword' => '123456',
            'passwordConfirm' => '123456'
        ]);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['password', 'passwordConfirm']]);
    }

    public function test_change_user_info()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/auth/change-user-info', [
                'name' => 'Root 1',
            ]);
        $response->assertStatus(200)->assertJsonStructure(['message']);
    }

    public function test_check_permission()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/auth/check-permission?name=user.index');

        $response->assertStatus(200)->assertJsonStructure(['status']);
    }

    public function test_check_permission_without_name()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/auth/check-permission');

        $response->assertStatus(422)->assertJsonStructure(['errors' => ['name']]);
    }

    public function test_reset_password()
    {
        $response = $this->post('api/v1/reset-password', ['email' => 'admin@gmail.com']);
        $response->assertStatus(200)->assertJsonStructure(['message']);
    }

    public function test_reset_password_without_email()
    {
        $response = $this->post('api/v1/reset-password');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    }
}
