<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function saveAddress(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            // Agrega aquí las reglas de validación para los demás campos
        ]);
    
        // Crear o actualizar la dirección en la base de datos
        // Asegúrate de que tienes un modelo Address y que los campos coinciden con los del formulario
        $address = new Address();
        $address->firstName = $request->firstName;
        $address->lastName = $request->lastName;
        $address->address = $request->address;
        // Asigna los demás campos del formulario a la instancia de Address
        // ...
    
        // Guardar la dirección en la base de datos
        $address->save();
    
        // Obtener el ID del pedido de la sesión
        $orderId = session('orderId');
    
        // Redirigir a la ruta 'send.invoice' con el ID del pedido
        return redirect()->route('send.invoice', ['order' => $orderId]);
    }
}
