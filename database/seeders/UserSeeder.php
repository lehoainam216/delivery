<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $adminRoleId = DB::table('roles')->where('role_name', 'Admin')->value('id');
        $managerRoleId = DB::table('roles')->where('role_name', 'Manager')->value('id');
        $staffRoleId = DB::table('roles')->where('role_name', 'Staff')->value('id');

        $users = [
            [
                'name' => 'System Admin',
                'name_vn' => 'Quan tri he thong',
                'email' => 'admin@booking.test',
                'password' => Hash::make('password'),
                'role_id' => $adminRoleId,
                'active' => 1,
                'email_verified_at' => $now,
            ],
            [
                'name' => 'Office Manager',
                'name_vn' => 'Truong phong',
                'email' => 'manager@booking.test',
                'password' => Hash::make('password'),
                'role_id' => $managerRoleId,
                'active' => 1,
                'email_verified_at' => $now,
            ],
            [
                'name' => 'Staff User',
                'name_vn' => 'Nhan vien',
                'email' => 'staff@booking.test',
                'password' => Hash::make('password'),
                'role_id' => $staffRoleId,
                'active' => 1,
                'email_verified_at' => $now,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
