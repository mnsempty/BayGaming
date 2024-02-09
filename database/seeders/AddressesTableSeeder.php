<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'address' => '123 Callejón Nogalada',
            'secondary_address' => '1234 te mato',
            'zip' => '41020',
            'country' => 'USA',
            'telephone_number' => '123456789',
            'users_id' => 1,
        ]);
        Address::create([
            'address' => '123 Callejón2 Nogalada2',
            'secondary_address' => '1234 te mato',
            'zip' => '41020',
            'country' => 'USA',
            'telephone_number' => '123456789',
            'users_id' => 2,
        ]);
        Address::create([
            'address' => '123 Callejón3 Nogalada3',
            'secondary_address' => '1234 te mato',
            'zip' => '41020',
            'country' => 'USA',
            'telephone_number' => '123456789',
            'users_id' => 3,
        ]);
    }
}
