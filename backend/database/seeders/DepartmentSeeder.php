<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'id' => 1,
            'name' => 'Phòng ban 1',
            'description' => 'Mô tả phòng ban 1',
            'manager_id' => 2
        ]);
        Department::create([
            'id' => 2,
            'name' => 'Phòng ban 2',
            'description' => 'Mô tả phòng ban 2',
            'manager_id' => 3
        ]);
    }
}
