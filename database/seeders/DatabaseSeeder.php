<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Product::factory(10)->create();

        // \App\Models\Product::factory()->create([
        // ]);

        // \App\Models\Cart::factory(10)->create();

        // \App\Models\Cart::factory()->create([
        // ]);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UsersTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
      //  $this->call(ReviewsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(OrdersHasProductsTableSeeder::class);
        $this->call(CartsTableSeeder::class);
        $this->call(CartsHasProductsTableSeeder::class);
        $this->call(WishlistsTableSeeder::class);
        $this->call(WishlistsHasProductsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoriesHasProductsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ProductsHasImagesTableSeeder::class);
        $this->call(DiscountsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);

        
    }
}
