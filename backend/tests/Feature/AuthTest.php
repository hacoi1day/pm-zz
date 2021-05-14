<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $user;

    // public function test_login_without_params()
    // {
    //     $response = $this->post('api/v1/login');
    //     $response->assertStatus(422)->assertJsonStructure(['errors' => ['email', 'password']]);
    // }

    // public function test_login_without_email()
    // {
    //     $response = $this->post('api/v1/login', [
    //         'password' => '123456'
    //     ]);
    //     $response->assertStatus(422)->assertJsonStructure(['errors' => ['email']]);
    // }

    // public function test_login_without_password()
    // {
    //     $response = $this->post('api/v1/login', [
    //         'email' => 'admin@gmail.com',
    //     ]);
    //     $response->assertStatus(422)->assertJsonStructure(['errors' => ['password']]);
    // }

    public function test_login()
    {
        $response = $this->post('api/v1/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        $user = json_decode($response->getContent());
        $response->assertStatus(200)->assertJsonStructure(['email', 'token']);
    }

    // public function test_get_me()
    // {
    //     $response = $this->get('api/v1/auth/me?access_token='.$this->user);

    //     $response->assertStatus(200)->assertJsonStructure(['email', 'token']);
    // }
}
