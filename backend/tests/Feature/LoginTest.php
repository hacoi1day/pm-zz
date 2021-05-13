<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_login()
    {
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        $response->assertStatus(200)->assertJsonStructure(['email', 'token']);
    }

    public function test_login_without_params()
    {
        $response = $this->post('api/v1/login');
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email', 'password']]);
    }

    public function test_login_without_email()
    {
        $response = $this->post('api/v1/login', ['password']);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['password']]);
    }

    public function test_login_without_password()
    {
        $response = $this->post('api/v1/login', ['email']);
        $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    }
}
