<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
        //! en verdad lleva a la order puesto que no hay pagos reales ni guardamos datos de pago
    public function proceedToPayment(Request $request)
    {
        // Obtén el carrito del usuario actual
        $cart = Cart::where('users_id', auth()->id())->first();

        // Busca una orden existente para el usuario
        $order = Order::where('users_id', auth()->id())->first();

        //guardamos los datos de la dirección del pedido en un string para evitar que al
        //borrar un pedido se borren
        /* 
         *          $address = $user->address;
         *                  'address' => [
                   'address' => $address->address,
                    'secondary_address' => $address->secondary_address,
                    'tax_code' => $address->tax_code,
                    'country' => $address->country,
                    'telephone_number' => $address->telephone_number,
                ],
         */
        // Si no hay una orden existente, crea una nueva
        if (!$order) {
            $user = auth()->user();
            $orderData = [
                'user' => [
                    'real_name' => $user->real_name,
                    'surname' => $user->surname,
                ],

            ];
            $serializedOrderData = json_encode($orderData);
            $order = Order::create([
                'users_id' => auth()->id(),
                'state' => 'processing',
                'orderData' => $serializedOrderData,
                'total' => 0
            ]);
        }
        // Calcula el total de la orden y añade los productos del carrito a la orden
        $total = 0;
        foreach ($cart->products as $product) {
            $quantity = $product->pivot->quantity;
            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            // Verifica si el producto ya está en la orden
            $existingProduct = $order->products()->where('products.id', $product->id)->first();

            // Verifica si el producto ya está en la orden
            $existingProduct = $order->products()->where('products.id', $product->id)->first();

            if ($existingProduct) {
                // El producto ya está en la orden, actualiza la cantidad
                // Establece la cantidad en la orden igual a la cantidad en el carrito
                $order->products()->updateExistingPivot($product->id, ['quantity' => $quantity]);
            } else {
                // El producto no está en la orden, lo añade con la cantidad dada
                $order->products()->attach($product->id, ['quantity' => $quantity]);
            }
        }

        // Actualiza el total de la orden
        $order->update(['total' => $total]);

        // guardamos el id del pedido creado para enviar la factura atraves del controlador de address
        // se podría hacer todo en invoices but i love order
        session(['orderId' => $order->id]);

        //! probablemente eliminar
        // Limpia el carrito
        $cart->products()->detach();
        //! no encuenta datos
        $addresses = auth()->user()->addresses;

        // Redirige al usuario a la vista de confirmación de pago
        return redirect()->route('payment.confirmation', ['order' => $order->id, 'addresses' => $addresses]);
    }



    public function showPaymentConfirmation(Order $order)
    {
        // Asegura que la orden pertenezca al usuario autenticado
        if ($order->users_id !== auth()->id()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Pasa la orden a la vista
        return view('auth.payment_confirmation', compact('order'));
    }
}
