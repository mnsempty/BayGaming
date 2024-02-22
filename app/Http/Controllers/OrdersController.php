<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    //! en verdad lleva a la order puesto que no hay pagos reales ni guardamos datos de pago
    public function proceedToPayment(Request $request)
    {
        // Obtén el carrito del usuario actual
        $cart = Cart::where('users_id', auth()->id())->first();

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
        // Si no hay una order existente, crea una nueva

        $order = Order::create([
            'users_id' => auth()->id(),
            'state' => 'processing',
            'total' => 0
        ]);
        // Calcula el total de la order y añade los productos del carrito a la order
        $total = 0;
        foreach ($cart->products as $product) {
            $quantity = $product->pivot->quantity;
            $subtotals = $product->price * $quantity;
            $total += $subtotals;

            // Verifica si el producto ya está en la order
            $existingProduct = $order->products()->where('products.id', $product->id)->first();

            if ($existingProduct) {
                // El producto ya está en la order, actualiza la cantidad
                // Establece la cantidad en la order igual a la cantidad en el carrito
                $order->products()->updateExistingPivot($product->id, ['quantity' => $quantity]);
            } else {
                // El producto no está en la order, lo añade con la cantidad dada
                $order->products()->attach($product->id, ['quantity' => $quantity]);
            }
        }

        // Actualiza el total de la order con ->update no funciona
        $order->total = $total;
        $order->subtotal = $total;
        $order->save();

        // guardamos el id del pedido creado para enviar la factura atraves del controlador de address
        // se podría hacer todo en invoices but i love order
        session(['orderId' => $order->id]);

        return redirect()->route('payment.confirmation', ['order' => $order->id]);
    }

    public function applyDiscount(Request $request, Order $order)
    {
        $discountCode = $request->input('discount_code');
        $discount = Discount::where('code', $discountCode)->first();
        if ($discount) {
            return redirect()->route('payment.confirmation', ['order' => $order->id, 'discount' => $discount]);
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid discount code.']);
        }
    }

    public function showPaymentConfirmation(Order $order, Discount $discount = null)
    {
        // Asegura que la order pertenezca al usuario autenticado
        if ($order->users_id !== auth()->id()) {
            abort(403, 'Acceso no autorizado.');
        }
        // direcciones para la tabla de direcciones
        $addresses = auth()->user()->addresses;

        // Pasa la order a la vista
        return view('user.payment_confirmation', compact('order', 'addresses', 'discount'));
    }

    public function saveOrder($addressId , $discount = null)
    {

        // Obtener el ID de la order de la sesión
        $orderId = session('orderId');
        try {
            DB::beginTransaction();
            // Buscar la dirección en la base de datos
            $address = Address::findOrFail($addressId);
            // Buscar la order en la base de datos
            $order = Order::findOrFail($orderId);
            $user = $order->user;
            // Preparar los datos de la dirección para actualizar orderData
            $orderData = [
                'user' => [
                    'real_name' => $user->real_name, // Asegúrate de que estos campos existan en tu modelo Address
                    'surname' => $user->surname, // Asegúrate de que estos campos existan en tu modelo Address
                ],
                'address' => [
                    'address' => $address->address,
                    'secondary_address' => $address->secondary_address,
                    'country' => $address->country,
                    'zip' => $address->zip,
                ],
            ];
            // Aplicar el descuento al subtotal y al total del pedido si hay descuento
            // hecho con session por que si no es fumada meterlo en este punto
            $discount = Discount::findOrFail($discount);
            if ($discount) {
                $order->subtotal = $order->subtotal - ($order->subtotal * ($discount->percent /   100));
                $order->total = $order->total - ($order->total * ($discount->percent /   100));
            }

            // Actualizar orderData en la order
            $order->orderData = json_encode($orderData);
            $order->save();

            // Limpia el carrito
            $cart = Cart::where('users_id', auth()->id())->first();
            $cart->products()->detach();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al guardar las orders: ' . $e->getMessage()]);
        }
        return redirect()->route('create.invoice', ['order' => $orderId]);
    }
    //find the user orders and paginate them,+ link to view my_orders
    public function showMyOrders()
    {
        $userId = auth()->id();
        $orders = Order::where('users_id', $userId)->paginate(4);
        return view('user.my_orders', compact('orders'));
    }
    //if the user is admin,show him all the orders
    public function showAllOrders()
    {
        $userId = auth()->id();
        $userAdmin = User::find($userId);
        if ($userAdmin->role !== 'admin') {
            return back();
        }
        $orders = Order::paginate(5);
        return view('admin.admin_orders', compact('orders'));
    }
    // update the state of the product to completed and reduce stock
    public function acceptOrder(Order $order)
    {
        if ($order->state !== 'completed' && $order->state !== 'cancelled') {
            // Inicia una transacción para asegurar la consistencia de los datos
            DB::beginTransaction();

            try {
                // checks stock of every product and throws error in case that any of them can`t be reduce
                foreach ($order->products as $product) {
                    if ($product->pivot->quantity > $product->stock) {
                        //! no funciona el update por el rollback
                        $order->update(['state' => 'cancelled']);
                        throw new \Exception('No hay suficiente stock para el producto: ' . $product->name);
                    }
                }
                // Actualiza el estado del pedido a 'completed'
                $order->update(['state' => 'completed']);

                // reduce every product stock in case of
                foreach ($order->products as $product) {
                    $product->decrement('stock', $product->pivot->quantity);
                }
                DB::commit();

                return back()->with('success', 'Pedido aceptado con éxito y stock actualizado.');
            } catch (\Exception $e) {
                DB::rollBack();

                return back()->withErrors(['message' => 'Error al aceptar el pedido: ' . $e->getMessage()]);
            }
        } else {
            // error if the order is completed or cancelled
            //todo dejar el boton de completar pedido como disabled
            return back()->withErrors(['message' => 'El pedido ya está completado o cancelado.']);
        }
    }

    // update de state of the product to cancelled
    public function cancelOrder(Order $order)
    {
        $order->update(['state' => 'cancelled']);
        return back()->with('success', 'Pedido cancelado con éxito.');
    }
}
