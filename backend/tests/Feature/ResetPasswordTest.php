<?php

namespace Tests\Feature;

use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    public function test_reset_password()
    {
        $response = $this->post('api/v1/reset-password', ['email' => 'admin@gmail.com']);
        $response->assertStatus(200);
    }

    public function test_reset_without_email()
    {
        $response = $this->post('api/v1/reset-password');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    }


}
