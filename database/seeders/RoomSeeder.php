<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $locationFloor1 = DB::table('locations')->where('location_name', 'Head Office - Floor 1')->value('id');
        $locationFloor2 = DB::table('locations')->where('location_name', 'Head Office - Floor 2')->value('id');
        $locationBranch = DB::table('locations')->where('location_name', 'Branch Office')->value('id');

        $rooms = [
            [
                'room_name' => 'Sunrise',
                'seat' => 8,
                'location_id' => $locationFloor1,
                'projector' => 1,
                'whiteboard' => 1,
                'tv' => 1,
                'video_conference' => 1,
                'hide' => 0,
            ],
            [
                'room_name' => 'Ocean',
                'seat' => 12,
                'location_id' => $locationFloor2,
                'projector' => 1,
                'whiteboard' => 1,
                'tv' => 1,
                'video_conference' => 0,
                'hide' => 0,
            ],
            [
                'room_name' => 'Lotus',
                'seat' => 6,
                'location_id' => $locationBranch,
                'projector' => 0,
                'whiteboard' => 1,
                'tv' => 1,
                'video_conference' => 0,
                'hide' => 0,
            ],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->updateOrInsert(
                ['room_name' => $room['room_name']],
                array_merge($room, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
