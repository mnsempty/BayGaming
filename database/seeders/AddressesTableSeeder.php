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
            'tax_code' => '41020',
            'country' => 'USA',
            'telephone_number' => '123456789',
            'users_id' => 1,
        ]);
    }
}
