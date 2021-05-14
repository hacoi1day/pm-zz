<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckTokenTest extends TestCase
{

    public function test_check_token_true()
    {
        $response = $this->get('api/v1/check-token?token=NhZWrZG24HmfvV9qrHxAFYoUW0m2rafXu6kHQAv3pEgVFZqaT9G6bI3bU6rV');
        $response->assertStatus(200)->assertJsonStructure(['message']);
    }

    public function test_check_token_false()
    {
        $response = $this->get('api/v1/check-token?token=121224');
        $response->assertStatus(500)->assertJsonStructure(['message']);
    }

    public function test_check_without_token()
    {
        $response = $this->get('api/v1/check-token?token=');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['token']]);
    }
}
