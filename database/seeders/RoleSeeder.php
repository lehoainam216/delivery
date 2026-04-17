<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $roles = [
            ['role_name' => 'Admin', 'limit' => 999, 'hide' => 0],
            ['role_name' => 'Manager', 'limit' => 20, 'hide' => 0],
            ['role_name' => 'Staff', 'limit' => 10, 'hide' => 0],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['role_name' => $role['role_name']],
                array_merge($role, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
