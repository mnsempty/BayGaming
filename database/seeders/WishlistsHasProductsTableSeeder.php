<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistsHasProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wishlist = Wishlist::find(1);
        $product = Product::find(1);

        if ($wishlist && $product) {
            $wishlist->products()->attach($product);
        }

    }
}
