<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'state' => 'pending',
            'total' => 100.00,
            'users_id' => 1,
        ]);

        Order::create([
            'state' => 'completed',
            'total' => 200.00,
            'users_id' => 2,
        ]);

    }
}
