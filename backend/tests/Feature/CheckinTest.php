<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckinTest extends TestCase
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

    public function test_index_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/checkin');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
    }

    public function test_show_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/checkin/1');
        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404);
        } else {
            $response->assertStatus(200)->assertJsonStructure(['date']);
        }

    }

    public function test_store_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/checkin/checkin', [
                'user_id' => 1,
                'date' => '2021-05-12',
                'time_in' => '2021-05-12 09:00:00',
                'time_out' => ''
            ]);
        $response->assertStatus(201)->assertJsonStructure(['date']);
    }

    public function test_update_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/checkin/checkin/1', [
                'time_out' => '2021-05-12 18:00:00'
            ]);
        $response->assertStatus(202)->assertJsonStructure(['date']);
    }

    public function test_destroy_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/checkin/checkin/17');

        if ($response->getStatusCode() === 404) {
            $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200);
        }
    }

    public function test_calendar()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?start_date=2021-05-01&end_date=2021-05-31');
        $response->assertStatus(200)->assertJsonStructure([]);
    }

    public function test_calendar_without_start_date()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?end_date=2021-05-01');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['start_date']]);
    }

    public function test_calendar_without_end_date()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?start_date=2021-05-01');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['end_date']]);
    }

    public function test_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/checkin');
        if ($response->getStatusCode() === 500) {
            $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
        }
    }

    public function test_checkout()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/checkout');
        if ($response->getStatusCode() === 500) {
            $response->assertStatus(500)->assertJsonStructure(['status', 'message']);
        } else {
            $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
        }
    }

    public function test_get_last_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/last-checkin');
        $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
    }
}
