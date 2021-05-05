<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'Root',
            'description' => 'Quản lý',
            'permissions' => json_encode([
                'user.index', 'user.store', 'user.show', 'user.update', 'user.destroy',
                'department.index', 'department.store', 'department.show', 'department.update', 'department.destroy',
                'manager.list_department', 'manager.list_user', 'manager.export_user', 'manager.export_checkin',
                'manager.list_request', 'manager.approval_request', 'manager.refuse_request'
            ])
        ]);
        Role::create([
            'id' => 2,
            'name' => 'Manager',
            'description' => 'Quản lý phòng ban',
            'permissions' => json_encode([
                'manager.list_department', 'manager.list_user', 'manager.export_user', 'manager.export_checkin',
                'manager.list_request', 'manager.approval_request', 'manager.refuse_request'
            ])
        ]);
    }
}
