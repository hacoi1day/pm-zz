<?php

namespace Tests\Feature;

use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestTest extends TestCase
{
    private static $token;
    private static $user;

    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        self::$token = $user->token;
        self::$user = $user;
    }

    public function test_index_request()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/request/request');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseCount('requests', $resData['total']);
    }

    public function test_show_request()
    {
        $request = Request::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/request/request/'.$request->id);
        $response->assertStatus(200)->assertJsonStructure(['type', 'start', 'end']);
        $this->assertDatabaseHas('requests', [
            'id' => $request->id
        ]);
    }

    public function test_show_request_not_found()
    {
        $requestId = 999;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/request/request/'.$requestId);
        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseMissing('requests', [
            'id' => $requestId
        ]);
    }

    public function test_my_request()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/my-request');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
        $resData = json_decode($response->getContent(), true);
        $countMyRequest = Request::where('user_id', self::$user->id)->count();
        $this->assertEquals($countMyRequest, $resData['total']);
    }

    public function test_my_request_with_page()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/my-request?page=2');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
    }

    public function test_create_my_request()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/create-my-request', [
                'type' => 1,
                'start' => '2021-05-12 09:00:00',
                'end' => '2021-05-12 18:00:00',
                'phone' => '12345',
                'cause' => 'Cause',
                'project' => 'Project',
                'status' => 1,
            ]);
        $response->assertStatus(201)->assertJsonStructure(['type', 'start', 'end', 'cause', 'project', 'status']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('requests', [
            'id' => $resData['id']
        ]);
    }
}
