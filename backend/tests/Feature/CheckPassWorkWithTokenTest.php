<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckPassWorkWithTokenTest extends TestCase
{

    // public function test_change_password_with_token()
    // {
    //     $response = $this->post('api/v1/change-password-token?token=mg74X5HKyeq5wrdPXKjhMu8yXmQdP87OGfkEohXWeTsc8r6Ub73XSygEWykt', [
    //         'password' => '123456',
    //         'passwordConfirm' => '123456'
    //     ]);

    //     $response->assertStatus(200)->assertJsonStructure(['message']);
    // }

    public function test_change_password_without_token()
    {
        $response = $this->post('api/v1/change-password-token', [
            'password' => '123456',
            'passwordConfirm' => '123456'
        ]);

        $response->assertStatus(422)->assertJsonStructure(['errors' => ['token']]);
    }

    public function test_change_password_without_password()
    {
        $response = $this->post('api/v1/change-password-token?token=KbeQG9RLSzRgddLgrN0ipyyNNkNu1aifC9gW9dfCdGf5znElTwBj1oRJEg8j');

        $response->assertStatus(422)->assertJsonStructure(['errors' => ['password', 'passwordConfirm']]);
    }
}
