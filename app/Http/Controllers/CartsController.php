<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        // try {
        //     DB::beginTransaction();
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1); // asume 1 si no se especifica la cantidad
        // verifica si el producto está disponible en stock
        if ($product->stock < $quantity) {
            return back()->withErrors(['message' => 'No hay suficiente stock para el producto.']);
        }

        // crea o actualizar el carrito del usuario actual
        $cart = Cart::firstOrCreate(['users_id' => auth()->id()]);

        // Comprueba si el producto ya está en el carrito
        $existingProduct = $cart->products()->where('products.id', $productId)->first();

        if ($existingProduct) {
            // El producto ya está en el carrito, incrementa la cantidad
            $newQuantity = $existingProduct->pivot->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                return back()->withErrors(['message' => 'No hay suficiente stock para el producto.']);
            }
            $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            // El producto no está en el carrito, lo añade con la cantidad especificada
            $cart->products()->attach($productId, ['quantity' => $quantity]);
        }

        return back()->with('success', 'Producto añadido al carrito con éxito.');
    }

    public function updateProductQuantity(Request $request, $productId)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($productId);
            $action = $request->input('action');

            // Crea o actualiza el carrito del usuario actual
            $cart = Cart::firstOrCreate(['users_id' => auth()->id()]);

            // Verifica si el producto ya está en el carrito
            $productInCart = $cart->products()->where('products_id', $productId)->first();
            // dd($productInCart);
            if ($action === 'increment') {
                // Verifica que haya suficiente stock para añadir el producto
                if ($product->stock <=   0) {
                    return back()->withErrors(['message' => 'No hay suficiente stock para el producto.']);
                }

                // Verifica que la cantidad del producto en el carrito no supere el stock disponible
                if ($productInCart->pivot->quantity >= $product->stock) {
                    return back()->withErrors(['message' => 'No puedes añadir más de la cantidad disponible en stock.']);
                }

                // añadimos 1 a los productos del carrito
                $newQuantity = $productInCart->pivot->quantity +   1;
                $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
            } elseif ($action === 'decrement') {
                // Verifica que haya al menos un producto en el carrito para retirar
                if ($productInCart->pivot->quantity <=   1) {
                    // Llama a la función deleteProducts para eliminar el producto del carrito
                    return redirect()->route('cart.delete', ['id' => $productId]);
                }

                // Retira un producto del carrito
                $newQuantity = $productInCart->pivot->quantity -   1;
                $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
            }

            DB::commit();

            return back()->with('success', 'Cantidad de producto actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['message' => 'Eror al eliminar un producto' . $e->getMessage()]);
        }
    }


    //todo test
    public function deleteProducts($productId)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $cart = $user->cart;
            $cart->products()->detach($productId);
            DB::commit();

            return back()->with('success', 'Producto eliminado del carrito con éxito.');
        } catch (\exception $e) {
            DB::rollBack();

            return back()->withErrors(['message' => 'Error al eliminar el producto']);
        }
    }

    // cogemos los productos del cart de los users
    public function listProducts()
    {
        try {
            $user = auth()->user();
            $cart = $user->cart;
            $products = $cart->products;

            return view('auth.cart', compact('products'));
        } catch (\exception $e) {
            return back()->withErrors(['message' => 'No hay productos en el carrito']);
        }
    }



    public function proceedToPayment(Request $request)
    {
        // Obtén el carrito del usuario actual
        $cart = Cart::where('users_id', auth()->id())->first();

        // Busca una orden existente para el usuario
        $order = Order::where('users_id', auth()->id())->first();

        // Si no hay una orden existente, crea una nueva
        if (!$order) {
            $order = Order::create([
                'users_id' => auth()->id(),
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

        // Limpia el carrito
        $cart->products()->detach();

        // Redirige al usuario a la vista de confirmación de pago
        return redirect()->route('payment.confirmation', ['order' => $order->id]);
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
