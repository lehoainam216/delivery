<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrinkSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $drinks = [
            ['drink_name' => 'none', 'drink_name_vn' => 'Khong su dung', 'drink_icon' => null, 'hide' => 0],
            ['drink_name' => 'water', 'drink_name_vn' => 'Nuoc suoi', 'drink_icon' => 'fa fa-tint', 'hide' => 0],
            ['drink_name' => 'coffee', 'drink_name_vn' => 'Ca phe', 'drink_icon' => 'fa fa-coffee', 'hide' => 0],
            ['drink_name' => 'tea', 'drink_name_vn' => 'Tra', 'drink_icon' => 'fa fa-leaf', 'hide' => 0],
        ];

        foreach ($drinks as $drink) {
            DB::table('drinks')->updateOrInsert(
                ['drink_name' => $drink['drink_name']],
                array_merge($drink, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
