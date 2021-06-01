<?php

namespace Tests\Unit\Models;

use App\Models\Department;
use Tests\TestCase;
use Faker\Factory as Faker;

class DepartmentTest extends TestCase
{
    protected $department;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->department = [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
        ];
    }

    public function test_store_department()
    {
        $department = Department::create($this->department);
        $this->assertInstanceOf(Department::class, $department);
        $this->assertEquals($this->department['name'], $department->name);
        $this->assertEquals($this->department['description'], $department->description);
        $this->assertDatabaseHas('departments', $this->department);
    }

    public function test_show_department()
    {
        $department = Department::factory()->create();
        $found = Department::find($department->id);
        $this->assertInstanceOf(Department::class, $found);
        $this->assertEquals($found->name, $found->name);
        $this->assertEquals($found->description, $found->description);
    }

    public function test_update_department()
    {
        $department = Department::factory()->create();
        $found = Department::find($department->id);
        $found->update($this->department);
        $this->assertInstanceOf(Department::class, $found);
        $this->assertEquals($this->department['name'], $found->name);
        $this->assertEquals($this->department['description'], $found->description);
        $this->assertDatabaseHas('departments', $this->department);
    }

    public function test_destroy_user()
    {
        $department = Department::factory()->create();
        $found = Department::find($department->id);
        $delete = $found->delete();
        $this->assertTrue($delete);
        $this->assertDatabaseMissing('departments', $department->toArray());
    }
}
