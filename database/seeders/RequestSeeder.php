<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $managerId = DB::table('users')->where('email', 'manager@booking.test')->value('id');
        $staffId = DB::table('users')->where('email', 'staff@booking.test')->value('id');
        $pendingStatusId = DB::table('statuses')->where('status_name', 'pending')->value('id');
        $approvedStatusId = DB::table('statuses')->where('status_name', 'approved')->value('id');

        $requests = [
            [
                'code' => 1001,
                'request_date' => now()->toDateString(),
                'user_id' => $managerId,
                'status_id' => $approvedStatusId,
                'request_uuid' => (string) Str::uuid(),
                'email_request' => 'manager@booking.test',
                'hide' => 0,
            ],
            [
                'code' => 1002,
                'request_date' => now()->toDateString(),
                'user_id' => $staffId,
                'status_id' => $pendingStatusId,
                'request_uuid' => (string) Str::uuid(),
                'email_request' => 'staff@booking.test',
                'hide' => 0,
            ],
        ];

        foreach ($requests as $request) {
            DB::table('requests')->updateOrInsert(
                ['code' => $request['code']],
                array_merge($request, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
