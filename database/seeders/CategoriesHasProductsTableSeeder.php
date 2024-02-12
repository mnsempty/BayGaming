<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesHasProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::all();
        $product = Product::find(1);

        if ($category && $product) {
            foreach ($category as $category) {
                $category->products()->attach($product->id);
            }
        }
    }
}
