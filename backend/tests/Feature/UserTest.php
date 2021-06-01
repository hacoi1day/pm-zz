<?php

namespace Tests\Feature;

use App\Models\User;
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
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseCount('users', $resData['total']);
    }

    public function test_show_user()
    {
        $user = User::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/user/user/'.$user->id);
        $response->assertStatus(200)->assertJsonStructure(['name']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('users', [
            'id' => $resData['id']
        ]);
    }

    public function test_store_user()
    {
        $user = [
            'name' => 'Test',
            'email' => Str::random(6).'@gmail.com',
            'role_id' => 3,
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/user/user', $user);
        $resData = json_decode($response->getContent(), true);
        $response->assertStatus(201)->assertJsonStructure(['name', 'email']);
        $this->assertDatabaseHas('users', [
            'id' => $resData['id']
        ]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Update Name User'
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/user/user/'.$user->id, $data);
        $response->assertStatus(202)->assertJsonStructure(['name', 'email']);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $data['name']
        ]);
    }

    public function test_destroy_user()
    {
        $user = User::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/user/user/'.$user->id);

        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200);
            $this->assertDeleted('users', [
                'id' => $user->id
            ]);
        }
    }

    public function test_dropdown_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/user/dropdown');

        $response->assertStatus(200)->assertJsonStructure([]);
        $resData = json_decode($response->getContent());
        $this->assertDatabaseCount('users', count($resData));
    }
}
