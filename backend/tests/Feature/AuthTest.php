<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private static $user;
    private static $email = 'admin@gmail.com';
    private static $password = '123456';
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
            'email' => self::$email,
            'password' => self::$password
        ]);
        $user = json_decode($response->getContent());
        self::$user = $user;
        $response->assertStatus(200)->assertJsonStructure(['email', 'token']);
        $resData = json_decode($response->getContent(), true);
        $this->assertEquals($resData['email'], self::$email);
    }

    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('api/v1/login', [
            'email' => self::$email,
            'password' => self::$password
        ]);
        $user = json_decode($response->getContent());
        self::$token = $user->token;
    }

    public function test_me()
    {
        $response = $this->withHeader('Authorization', 'Bearer '.self::$token)->get('api/v1/auth/me');
        $response->assertStatus(200)->assertJsonStructure(['email', 'name']);
        $resData = json_decode($response->getContent(), true);
        $this->assertEquals($resData['email'], self::$email);
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
        $newData = [
            'name' => 'Root 2'
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/auth/change-user-info', $newData);
        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'user' => [
                'name'
            ]
        ]);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('users', [
            'id' => $resData['user']['id'],
            'name' => $newData['name']
        ]);
    }

    public function test_check_permission()
    {
        $permission = 'user.index';
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/auth/check-permission?name='.$permission);
        $response->assertStatus(200)->assertJsonStructure(['status']);
        // check user has permission
        $role = Role::find(self::$user->role_id);
        $permissions = json_decode($role->permissions, true);
        $this->assertContains($permission, $permissions);
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
        $email = 'admin@gmail.com';
        $response = $this->post('api/v1/reset-password', ['email' => $email]);
        $response->assertStatus(200)->assertJsonStructure(['message']);
        $user = User::where('email', $email)->first();
        // check database record change password
        $this->assertDatabaseHas('change_passes', [
            'user_id' => $user->id,
            'type_id' => 2
        ]);
    }

    public function test_reset_password_without_email()
    {
        $response = $this->post('api/v1/reset-password');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    }
}
