<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressesController extends Controller
{
    //!save address un table and orders
    public function createAddress(Request $request)
    {
        // Validar los datos del formulario

        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'telephone_number' => 'nullable|numeric',
            'secondary_address' => 'nullable',
            'country' => 'required',
            'zip' => 'required',
            'saveAddress' => 'nullable'
        ]);

        //todo en user guardar 
        // Crear o actualizar la dirección en la base de datos
        // Asegúrate de que tienes un modelo Address y que los campos coinciden con los del formulario
        if (!$request->input('saveAddress')) {
            try {
                DB::beginTransaction();
                $address = new Address();
                $address->users_id = auth()->id();
                $address->address = $request->address;
                $address->secondary_address = $request->secondary_address;
                $address->telephone_number = $request->telephone_number;
                $address->country = $request->country;
                $address->zip = $request->zip;

                // Guardar la dirección en la base de datos
                $address->save();
                DB::commit();
                //!para volver al dashboard, si lo hacemos modal idk quizá back()
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['message' => 'Error al enviar las direcciones: ' . $e->getMessage()]);
            }
        }
        // Obtener el ID del pedido de la sesión
        $orderId = session('orderId');
        try {
            DB::beginTransaction();
            $order = Order::find($orderId);
            // dd($order);
            // si ese pedido existe le metemos los datos de dirección en json para evitar su borrado
            if ($order) {
                // guardamos los datos de la order en json
                $orderData = [
                    'user' => [
                        'real_name' => $request->firstName,
                        'surname' => $request->lastName,
                    ],
                    'address' => [
                        'address' => $request->address,
                        'secondary_address' => $request->secondary_address,
                        'country' => $request->country,
                        'zip' => $request->zip,
                    ],
                ];
                $serializedOrderData = json_encode($orderData);
                //guardamos el json_encoded(sin encoded no funca)en la db
                $order->orderData = $serializedOrderData;
                $order->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al guardar las orders: ' . $e->getMessage()]);
        }
        // Redirigir a landing
        // return redirect()->route('send.invoice', ['order' => $orderId]);
        return redirect()->route('create.invoice', ['order' => $orderId]);
    }

    public function deleteAddress($addressId)
    {
        // Buscar la dirección en la base de datos
        try{
            DB::beginTransaction();
            $address = Address::findOrFail($addressId);

            // Eliminar la dirección
            $address->delete();
            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'Dirección eliminada');
        } catch (\exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al borrar la dirección.'. $e->getMessage()]);
        }
    }
}
