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
        // rol admin con verificación
        User::create([
            'name' => 'Admin',
            'email' => 'nonameb41@gmail.com',
            'email_verified_at' => '2024-01-30 10:34:45',
            'password' => Hash::make('qweqweqwe123'),
            'role' => 'admin',
        ]);
        
        // rol admin sin verificación
        User::create([
            'name' => 'Admin2',
            'email' => 'example2a@gmail.com',
            'password' => Hash::make('qweqweqwe1234'),
            'role' => 'admin',
        ]);
        // rol user con verificación
        User::create([
            'name' => 'testUser',
            'email' => 'mnsemptymail@gmail.com',
            'password' => Hash::make('12345678qwe'),
            'email_verified_at' => '2024-01-30 10:30:43',
            'role' => 'user',
        ]);
        // rol user sin verificación
        User::create([
            'name' => 'testUser2',
            'email' => 'exampleawe@gmail.com',
            'password' => Hash::make('12345678qwer'),
            'role' => 'user',
        ]);

    }
}
