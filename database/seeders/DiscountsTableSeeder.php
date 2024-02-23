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
            'code' => 'testCode01', 
            'uses' => 10,
        ]);
        Discount::create([
            'percent' => 20,
            'code' => 'testCode02',
            'active' => false,
            // 'products_id' => 2,
        ]);

    }
}
