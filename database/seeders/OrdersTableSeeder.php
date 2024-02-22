<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'state' => 'pending',
            'orderData' => '{
                "user": {
                    "real_name": "María Rodríguez",
                    "surname": "García"
                },
                "address": {
                    "address": "Avenida de América,  456, Madrid, España",
                    "secondary_address": "Piso  3, Puerta  5",
                    "country": "España",
                    "zip": "28001",
                    "telephone_number": "+34912345678"
                }
            }
            ',
            'subtotal' => 111.11,
            'total' => 100.00,
            'users_id' => 1,
        ]);

        Order::create([
            'state' => 'completed',
            'orderData' => '{
                "user": {
                    "real_name": "Juan Pérez2",
                    "surname": ""
                },
                "address": {
                    "address": "Calle Principal,   123, Ciudad, País",
                    "secondary_address": null,
                    "country": "",
                    "zip": "",
                    "telephone_number": "+1234567890"
                }
            }
            ',
            'subtotal' => 222.22,
            'total' => 200.00,
            'users_id' => 2,
        ]);
    }
}
