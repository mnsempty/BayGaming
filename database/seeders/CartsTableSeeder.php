<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::create([
            'quantity' => 1,
            'users_id' => 1,
        ]);
        Cart::create([
            'quantity' => 5,
            'users_id' => 2,
        ]);
    }
}
