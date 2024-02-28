<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AddressesController extends Controller
{
    //!save address un table and orders
    public function createAddress(Request $request, $discount = null)
    {
        //todo Validar los datos del formulario
        try {
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
        } catch (ValidationException $e) {
            return back()->withErrors(['message' => 'Error de validación.' . $e->getMessage()]);
        }

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
            if ($discount) {
                // buscamos el descuento  y en caso de que tenga usos disponibles (done in redeem code/applyDiscount too)
                // restamos los usos para evitar que con 1 uso se 7 users hagan 7 pedidos
                $discount = Discount::findOrFail($discount);
                $discount->uses >= 0 ? $discount->uses-- : throw new \Exception('El descuento no tiene usos disponibles.');
                $discount->save();

                //calc total with discount
                $order->total = $order->subtotal - ($order->subtotal * ($discount->percent /   100));
            }
            // metemos los datos de dirección en json para evitar su borrado + discount si existe
                $orderData = [
                    'user' => [
                        'real_name' => $request->firstName,
                        'surname' => $request->lastName,
                    ],
                    'address' => [
                        'address' => $request->address,
                        'secondary_address' => $request->secondary_address,
                        'telephone_number' => $request->telephone_number,
                        'country' => $request->country,
                        'zip' => $request->zip,
                    ],
                    'discount' => $discount ? ['code' => $discount->code, 'percent' => $discount->percent] : null,
                ];
                $serializedOrderData = json_encode($orderData);
                //guardamos el json_encoded(sin encoded no funca)en la db
                $order->orderData = $serializedOrderData;
                $order->save();
                
                // Limpia el carrito
                $cart = Cart::where('users_id', auth()->id())->first();
                $cart->products()->detach();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al guardar las orders: ' . $e->getMessage()]);
        }
        // Redirigir a landing
        /*        return redirect()->route('create.invoice', ['order' => $orderId]);*/
        // con un if user role == user/admin modificable
        return redirect()->route('landing');
    }
    //create address desde fuera de un pedido without 
    public function simpleCreateAddress(Request $request){
        //todo Validar los datos del formulario
        try {
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
        } catch (ValidationException $e) {
            return back()->withErrors(['message' => 'Error de validación.' . $e->getMessage()]);
        }
        
        try {
            DB::beginTransaction();
            $address = new Address();
            $address->users_id = auth()->id();
            $address->address = $request->address;
            $address->secondary_address = $request->secondary_address;
            $address->telephone_number = $request->telephone_number;
            $address->country = $request->country;
            $address->zip = $request->zip;

            $address->save();
            DB::commit();
            return back()->with('success', 'Dirección actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al enviar las direcciones: ' . $e->getMessage()]);
        }
    }
    public function showAddressProfile(){
        $usersId= auth()->id();
        $addresses = Address::where('users_id', $usersId)->paginate(3);
        $user = auth()->user();
        return view('user.user_profile', compact('addresses', 'user'));
    }
    public function deleteAddressProfile($addressId){
        try {
            DB::beginTransaction();
            $address = Address::findOrFail($addressId);

            // Eliminar la dirección
            $address->delete();
            DB::commit();
            // Redirigir al usuario a la página de éxito
            return redirect()->route('show.addresses')->with('success', 'Dirección actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('show.addresses')->withErrors(['message' => 'Error 4042 al borrar las direcciones: ' . $e->getMessage()]);
        }
    }
    public function updateAddress(Request $request, $id)
    {
        try {
            $request->validate([
                'address' => 'required',
                'secondary_address' => 'nullable',
                'telephone_number' => 'nullable',
                'country' => 'required',
                'zip' => 'required',
            ]);
        } catch (ValidationException $ev) {
            return back()->withErrors(['message' => 'Error de validación.' . $ev->getMessage()]);
        }
        try {
            DB::beginTransaction();

            // Encuentra la dirección por su ID y actualiza los datos
            $address = Address::findOrFail($id);
            $address->address = $request->address;
            $address->secondary_address = $request->secondary_address;
            $address->telephone_number = $request->telephone_number;
            $address->country = $request->country;
            $address->zip = $request->zip;
            $address->save();
            // Redirige al usuario con un mensaje de éxito
            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'Dirección actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al modificar la dirección.' . $e->getMessage()]);
        }
    }
    //buscamos los datos con el id dado y lo devolvemos en json para el value del edit modal
    public function showAddress($addressId) {
        $address = Address::findOrFail($addressId);
        return response()->json($address);
    }

    public function deleteAddress($addressId)
    {
        // Buscar la dirección en la base de datos
        try {
            DB::beginTransaction();
            $address = Address::findOrFail($addressId);

            // Eliminar la dirección
            $address->delete();
            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'Dirección eliminada');
        } catch (\exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al borrar la dirección.' . $e->getMessage()]);
        }
    }
}
