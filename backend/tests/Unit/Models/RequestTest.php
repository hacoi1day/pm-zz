<?php

namespace Tests\Unit\Models;

use App\Models\Request;
use Tests\TestCase;
use Faker\Factory as Faker;

class RequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->request = [
            'user_id' => 1,
            'type' => 1,
            'start' => $this->faker->dateTime,
            'end' => $this->faker->dateTime,
            'phone' => $this->faker->phoneNumber,
            'cause' => $this->faker->jobTitle,
            'project' => $this->faker->catchPhrase,
        ];
    }

    public function test_store_request()
    {
        $request = Request::create($this->request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals($this->request['user_id'], $request->user_id);
        $this->assertEquals($this->request['type'], $request->type);
        $this->assertEquals($this->request['start'], $request->start);
        $this->assertEquals($this->request['end'], $request->end);
        $this->assertEquals($this->request['phone'], $request->phone);
        $this->assertEquals($this->request['cause'], $request->cause);
        $this->assertEquals($this->request['project'], $request->project);
        $this->assertDatabaseHas('requests', $this->request);
    }

    public function test_show_request()
    {
        $request = Request::factory()->create();
        // dd($request->start->toDateTimeString());
        $found = Request::find($request->id);
        $this->assertInstanceOf(Request::class, $found);
        $this->assertEquals($request->user_id, $found->user_id);
        $this->assertEquals($request->type, $found->type);
        $this->assertObjectEquals($request->start, $found->start);
        // $this->assertEquals($request->end, $found->end);
        $this->assertEquals($request->phone, $found->phone);
        $this->assertEquals($request->cause, $found->cause);
        $this->assertEquals($request->project, $found->project);
    }
}
