<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Str::random(50),
            'role_id' => 3
        ];
    }

    public function test_store_user()
    {
        $user = User::create($this->user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($this->user['name'], $user->name);
        $this->assertEquals($this->user['email'], $user->email);
        $this->assertEquals($this->user['role_id'], $user->role_id);
        $this->assertDatabaseHas('users', $this->user);
    }

    public function test_show_user()
    {
        $user = User::factory()->create();
        $found = User::find($user->id);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($found->name, $found->name);
        $this->assertEquals($found->email, $found->email);
        $this->assertEquals($found->role_id, $found->role_id);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $found = User::find($user->id);
        $found->update($this->user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($this->user['name'], $found->name);
        $this->assertEquals($this->user['email'], $found->email);
        $this->assertEquals($this->user['role_id'], $found->role_id);
        $this->assertDatabaseHas('users', $this->user);
    }

    public function test_destroy_user()
    {
        $user = User::factory()->create();
        $found = User::find($user->id);
        $delete = $found->delete();
        $this->assertTrue($delete);
        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
