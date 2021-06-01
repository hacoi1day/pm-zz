<?php

namespace Tests\Feature;

use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    private static $token;

    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('api/v1/login', [
            'email' => 'manager1@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        self::$token = $user->token;
    }

    public function test_list_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-department');
        $response->assertStatus(200)->assertJsonStructure(['status', 'departments']);
    }

    public function test_user_by_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/1');
        $response->assertStatus(200)->assertJsonStructure(['status', 'users']);
    }

    public function test_user_by_department_not_manager()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/3');
        $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
    }

    public function test_user_by_department_is_not_define()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/10');
        $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
    }

    public function test_list_request_by_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-request/1');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
    }

    public function test_approval_request()
    {
        $request = Request::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/approval-request/'.$request->id);
        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
            $this->assertDatabaseHas('requests', [
                'id' => $request->id,
                'status' => 2
            ]);
        }
    }

    public function test_refuse_request()
    {
        $request = Request::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/refuse-request/'.$request->id);

        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
            $this->assertDatabaseHas('requests', [
                'id' => $request->id,
                'status' => 3
            ]);
        }
    }
}
