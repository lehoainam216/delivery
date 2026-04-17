<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $statuses = [
            ['status_name' => 'pending', 'status_name_vn' => 'Cho duyet', 'status_color' => '#f59e0b', 'hide' => 0],
            ['status_name' => 'approved', 'status_name_vn' => 'Da duyet', 'status_color' => '#22c55e', 'hide' => 0],
            ['status_name' => 'rejected', 'status_name_vn' => 'Tu choi', 'status_color' => '#ef4444', 'hide' => 0],
            ['status_name' => 'completed', 'status_name_vn' => 'Hoan tat', 'status_color' => '#3b82f6', 'hide' => 0],
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->updateOrInsert(
                ['status_name' => $status['status_name']],
                array_merge($status, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
