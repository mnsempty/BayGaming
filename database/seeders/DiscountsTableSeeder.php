<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'percent' => 10,
            'code' => 'testcode1', 
            'products_id' => 1,
        ]);
        Discount::create([
            'percent' => 20,
            'code' => 'testcode2', 
            'products_id' => 2,
        ]);

    }
}
