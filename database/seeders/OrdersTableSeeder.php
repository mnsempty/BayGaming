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
            'orderData'=> 'Nombre2 del2 Cliente2: Juan Pérez2
            Dirección2 de Envío2: Calle Principal, 123, Ciudad, País
            Correo2 Electrónico2: juanperez@example.com
            Teléfono2: +1234567890',
            'total' => 100.00,
            'users_id' => 1,
        ]);

        Order::create([
            'state' => 'completed',
            'orderData'=> 'Nombre del Cliente: Juan Pérez
            Dirección de Envío: Calle Principal, 123, Ciudad, País
            Correo Electrónico: juanperez@example.com
            Teléfono: +1234567890',
            'total' => 200.00,
            'users_id' => 2,
        ]);

    }
}
