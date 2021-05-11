<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Root',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1
        ]);
        User::create([
            'id' => 2,
            'name' => 'Quản lý 1',
            'email' => 'manager1@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 2
        ]);
        User::create([
            'id' => 3,
            'name' => 'Quản lý 2',
            'email' => 'manager2@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 2
        ]);
        User::create([
            'id' => 4,
            'name' => 'Nhân viên 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 3,
            'department_id' => 1
        ]);
        User::create([
            'id' => 5,
            'name' => 'Nhân viên 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 3,
            'department_id' => 1
        ]);
        User::create([
            'id' => 6,
            'name' => 'Nhân viên 3',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 3,
            'department_id' => 2
        ]);
    }
}
