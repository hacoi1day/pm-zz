<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Tests\TestCase;
use Faker\Factory as Faker;

class RoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->role = [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
            'permissions' => json_encode($this->faker->words(3, false))
        ];
    }

    public function test_insert_role()
    {
        $role = Role::create($this->role);
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($this->role['name'], $role->name);
        $this->assertEquals($this->role['description'], $role->description);
        $this->assertEquals($this->role['permissions'], $role->permissions);
        // $this->assertDatabaseHas('roles', $this->role);
    }

    public function test_show_role()
    {
        $role = Role::factory()->create();
        $found = Role::find($role->id);
        $this->assertEquals($role->name, $found->name);
        $this->assertEquals($role->description, $found->description);
        $this->assertEquals($role->permissions, $found->permissions);
    }

    public function test_update_role()
    {
        $role = Role::factory()->create();
        $found = Role::find($role->id);
        $found->update($this->role);
        $this->assertInstanceOf(Role::class, $found);
        $this->assertEquals($this->role['name'], $found->name);
        $this->assertEquals($this->role['description'], $found->description);
        $this->assertEquals($this->role['permissions'], $found->permissions);
    }

    public function test_destroy_role()
    {
        $role = Role::factory()->create();
        $found = Role::find($role->id);
        $delete = $found->delete();
        $this->assertTrue($delete);
        $this->assertDatabaseMissing('roles', $role->toArray());
    }
}
