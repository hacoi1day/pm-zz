<?php

namespace Tests\Feature;

use App\Models\Department;
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

    public function test_index_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/department/department');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseCount('departments', $resData['total']);
    }

    public function test_show_department()
    {
        $department = Department::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/department/department/'.$department->id);
        $response->assertStatus(200)->assertJsonStructure(['name']);
        $this->assertDatabaseHas('departments', [
            'id' => $department->id
        ]);
    }

    public function test_store_department()
    {
        $department = Department::factory()->make();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/department/department', $department->toArray());
        $response->assertStatus(201)->assertJsonStructure(['name']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('departments', [
            'id' => $resData['id']
        ]);
    }

    public function test_update_department()
    {
        $department = Department::factory()->create();
        $data = [
            'name' => 'New Name',
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/department/department/'.$department->id, $data);
        $response->assertStatus(202)->assertJsonStructure(['name']);
        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'name' => $data['name']
        ]);
    }

    public function test_destroy_department()
    {
        $department = Department::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/department/department/'.$department->id);

        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200);
            $this->assertDeleted('departments', [
                'id' => $department->id
            ]);
        }
    }

    public function test_dropdown_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/department/dropdown');
        $response->assertStatus(200)->assertJsonStructure([]);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseCount('departments', count($resData));
    }
}
