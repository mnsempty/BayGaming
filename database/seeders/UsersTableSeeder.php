<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'nonameb41@gmail.com',
            'password' => Hash::make('qweqweqwe123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'testUser',
            'email' => 'mnsemptymail@gmail.com',
            'password' => Hash::make('12345678qwe'),
            'role' => 'user',
        ]);
    }
}
