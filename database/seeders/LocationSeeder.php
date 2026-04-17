<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $locations = [
            ['location_name' => 'Head Office - Floor 1', 'hide' => 0],
            ['location_name' => 'Head Office - Floor 2', 'hide' => 0],
            ['location_name' => 'Branch Office', 'hide' => 0],
        ];

        foreach ($locations as $location) {
            DB::table('locations')->updateOrInsert(
                ['location_name' => $location['location_name']],
                array_merge($location, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
