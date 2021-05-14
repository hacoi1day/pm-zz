<?php

namespace Tests\Unit\Models;

use App\Models\Department;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{

    public function test_department()
    {
        $department = new Department;
        $department->name = 'Department Test';
        $department->description = 'Description department test';
        $department->manager_id = 1;

        $this->assertIsString($department->name);
        $this->assertIsString($department->description);
        $this->assertIsNumeric($department->manager_id);
    }
}
