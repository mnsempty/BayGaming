<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Wishlist::create([
            'users_id' => 1,
        ]);

        foreach ($users as $user) {
            Wishlist::create([
                'users_id' => $user->id,
            ]);
        }
    }
}
