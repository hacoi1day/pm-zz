<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function test_index_user()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/user/user');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
    }

    public function test_show_user()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/user/user/1');
        $response->assertStatus(200)->assertJsonStructure(['name']);
    }

    public function test_store_user()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/user/user', [
                'name' => 'Test',
                'email' => Str::random(6).'@gmail.com',
                'role_id' => 3,

            ]);
        $response->assertStatus(201)->assertJsonStructure(['name', 'email']);
    }

    public function test_update_user()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/user/user/1', [
                'name' => 'Root 1',
            ]);
        $response->assertStatus(202)->assertJsonStructure(['name', 'email']);
    }

    public function test_destroy_user()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/user/user/17');

        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200);
        }
    }

    public function test_dropdown_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/user/dropdown');

        $response->assertStatus(200)->assertJsonStructure([]);
    }
}
