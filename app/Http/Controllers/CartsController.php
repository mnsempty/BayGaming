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

            return view('user.cart', compact('products'));
        } catch (\exception $e) {
            return back()->withErrors(['message' => 'No hay productos en el carrito']);
        }
    }

}
