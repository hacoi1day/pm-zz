<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    private static $token;
    private static $user;

    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('api/v1/login', [
            'email' => 'manager1@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        self::$token = $user->token;
        self::$user = $user;
    }

    public function test_list_department()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-department');
        $response->assertStatus(200)->assertJsonStructure(['status', 'departments']);
        $resData = json_decode($response->getContent(), true);
        $departmentsByManager = Department::where('manager_id', self::$user->id)->count();
        $this->assertEquals($departmentsByManager, count($resData['departments']));
    }

    public function test_user_by_department()
    {
        $departmentId = 1;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/'.$departmentId);
        $response->assertStatus(200)->assertJsonStructure(['status', 'users']);
        $resData = json_decode($response->getContent(), true);
        $countUserByDepartment = User::where('department_id', $departmentId)->count();
        $this->assertEquals($countUserByDepartment, count($resData['users']));
    }

    public function test_user_by_department_not_manager()
    {
        $departmentId = 3;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/'.$departmentId);
        $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
        $department = Department::find($departmentId);
        $this->assertNotEquals($department->manager_id, $departmentId);
    }

    public function test_user_by_department_is_not_define()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-user-by-department/999');
        $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseMissing('departments', [
            'id' => 999
        ]);
    }

    public function test_list_request_by_department()
    {
        $departmentId = 1;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/list-request/'.$departmentId);
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
        $resData = json_decode($response->getContent(), true);

        $countRequest = Request::join('users', 'users.id', 'requests.user_id')
        ->where('department_id', $departmentId)
        ->count();
        $this->assertEquals($countRequest, $resData['total']);
    }

    public function test_approval_request()
    {
        $request = Request::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/approval-request/'.$request->id);
        $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'status' => 2
        ]);
    }

    public function test_approval_request_not_found()
    {
        $requestId = 999;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/approval-request/'.$requestId);
        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseMissing('requests', [
            'id' => $requestId,
            'status' => 1
        ]);
    }

    public function test_refuse_request()
    {
        $request = Request::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/refuse-request/'.$request->id);

        $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'status' => 3
        ]);
    }

    public function test_refuse_request_not_found()
    {
        $requestId = 999;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/manager/refuse-request/'.$requestId);

        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseMissing('requests', [
            'id' => $requestId,
            'status' => 1
        ]);
    }
}
