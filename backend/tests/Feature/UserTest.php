<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertWithoutParam()
    {
        // $response = $this->post('api/v1/user/user');
        // dd($response);
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
