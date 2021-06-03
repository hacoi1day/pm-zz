<?php

namespace Tests\Feature;

use App\Models\Checkin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

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
        $this->faker = Faker::create();
    }

    public function test_index_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/checkin');
        $response->assertStatus(200)->assertJsonStructure(['current_page', 'data', 'total']);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseCount('checkins', $resData['total']);
    }

    public function test_store_checkin()
    {
        $checkin = Checkin::factory()->make();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->post('api/v1/checkin/checkin', $checkin->toArray());
        $checkin = json_decode($response->getContent(), true);
        $response->assertStatus(201)->assertJsonStructure(['date', 'id']);
        $this->assertDatabaseHas('checkins', [
            'id' => $checkin['id']
        ]);
    }

    public function test_show_checkin()
    {
        $id = 1;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/checkin/'.$id);
        $response->assertStatus(200)->assertJsonStructure(['date']);
        $this->assertDatabaseHas('checkins', [
            'id' => 1
        ]);
    }

    public function test_show_checkin_not_found()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/checkin/99999');
        $response->assertStatus(404);
    }

    public function test_update_checkin()
    {
        $checkin = Checkin::factory()->create();
        $data = [
            'time_out' => $this->faker->dateTime
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->put('api/v1/checkin/checkin/'.$checkin->id, $data);
        $response->assertStatus(202)->assertJsonStructure(['date']);
        $this->assertDatabaseHas('checkins', [
            'id' => $checkin->id,
            'time_out' => $data['time_out']
        ]);
    }

    public function test_destroy_checkin()
    {
        $checkin = Checkin::factory()->create();
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/checkin/checkin/'.$checkin->id);

        $response->assertStatus(200);
        $this->assertDeleted('checkins', [
            'id' => 17
        ]);
    }

    public function test_destroy_checkin_not_found()
    {
        $checkinId = 9999;
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->delete('api/v1/checkin/checkin/'.$checkinId);

        $response->assertStatus(404)->assertJsonStructure(['status', 'message']);
        $this->assertDatabaseMissing('checkins', [
            'id' => $checkinId
        ]);
    }

    public function test_calendar()
    {
        $startDate = '2021-06-01';
        $endDate = '2021-06-30';
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?start_date='.$startDate.'&end_date='.$endDate);
        $response->assertStatus(200)->assertJsonStructure([]);
        $resData = json_decode($response->getContent(), true);
        $startDate = date($startDate);
        $endDate = date($endDate);
        $countCheckin = Checkin::whereBetween('date', [$startDate, $endDate])->count();
        $this->assertEquals($countCheckin, count($resData));
    }

    public function test_calendar_without_start_date()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?end_date=2021-06-01');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['start_date']]);
    }

    public function test_calendar_without_end_date()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/calendar?start_date=2021-06-01');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['end_date']]);
    }

    public function test_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/checkin');
        $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('checkins', [
            'id' => $resData['item']['id']
        ]);
    }

    public function test_checkout()
    {
        $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/checkin');
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/checkout');
        $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('checkins', [
            'id' => $resData['item']['id']
        ]);
    }

    public function test_get_last_checkin()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer '.self::$token)
            ->get('api/v1/checkin/me/last-checkin');
        $response->assertStatus(200)->assertJsonStructure(['status', 'item' => ['date']]);
        $resData = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('checkins', [
            'id' => $resData['item']['id']
        ]);
    }
}
