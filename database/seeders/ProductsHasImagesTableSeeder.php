<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsHasImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = Image::all();
        $product = Product::find(1);

        if ($image && $product) {
            $product->images()->attach($image);
        }

    }
}
