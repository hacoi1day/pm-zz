<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentTest extends TestCase
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
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/department/department');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
    }

    public function test_show_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/department/department/1');
        $response->assertStatus(200)->assertJsonStructure(['name']);
    }

    public function test_store_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/department/department', [
                'name' => 'Test',
                'description' => 'description',
                'manager_id' => 2,

            ]);
        $response->assertStatus(201)->assertJsonStructure(['name']);
    }

    public function test_update_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/department/department/1', [
                'name' => 'Root 1',
            ]);
        $response->assertStatus(202)->assertJsonStructure(['name']);
    }

    public function test_destroy_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/department/department/17');

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
            ->post('api/v1/department/dropdown');

        $response->assertStatus(200)->assertJsonStructure([]);
    }
}
