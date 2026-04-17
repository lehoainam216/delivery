<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $customerIds = DB::table('customers')->pluck('id')->all();
        $priorityIds = DB::table('priorities')->pluck('id')->all();
        $gasIds = DB::table('gases')->pluck('id')->all();
        $gasTypeIds = DB::table('gas_types')->pluck('id')->all();
        $carIds = DB::table('cars')->pluck('id')->all();
        $driverIds = DB::table('drivers')->pluck('id')->all();

        $orders = [];
        $startCode = 26001;

        for ($i = 0; $i < 100; $i++) {
            $orders[] = [
                'code' => $startCode + $i,
                'customer_id' => empty($customerIds) ? null : fake()->randomElement($customerIds),
                'priority_id' => empty($priorityIds) ? null : fake()->randomElement($priorityIds),
                'gas_id' => empty($gasIds) ? null : fake()->randomElement($gasIds),
                'car_id' => empty($carIds) ? null : fake()->randomElement($carIds),
                'driver_id' => empty($driverIds) ? null : fake()->randomElement($driverIds),
                'user_id' => 7,
                'status_id' => fake()->randomElement([1, 2]),
                'note' => fake()->optional(0.6)->sentence(),
                'warehouse_id' => fake()->randomElement([1, 2, 3]),
                'gas_type_id' => empty($gasTypeIds) ? null : fake()->randomElement($gasTypeIds),
                'quantity' => fake()->numberBetween(1, 30),
                'weight' => fake()->numberBetween(5, 200),
                'delivery_date' => fake()->dateTimeBetween('-7 days', '+7 days')->format('Y-m-d'),
                'create_date' => $now->format('Y-m-d'),
                'uuid' => (string) Str::uuid(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Schema::disableForeignKeyConstraints();
        DB::table('orders')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('orders')->insert($orders);
    }
}
