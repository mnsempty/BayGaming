<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
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
            // Si el producto ya está en el carrito, incrementa la cantidad
            $newQuantity = $existingProduct->pivot->quantity + $quantity;
            if ($product->stock >= $newQuantity) {
                //syncWithoutDetaching() actualiza los valores de la tabla intermedia
                $cart->products()->syncWithoutDetaching([$productId => ['quantity' => $newQuantity]]);
                return back()->with('success', 'Cantidad del producto actualizada en el carrito.');
            } else {
                return back()->withErrors(['message' => 'No hay suficiente stock para aumentar la cantidad del producto.']);
            }
        } else {
            // Si el producto no está en el carrito, lo añade con la cantidad especificada
            $cart->products()->attach($productId, ['quantity' => $quantity]);
            return back()->with('success', 'Producto añadido al carrito con éxito.');
        }


        return back()->with('success', 'Producto añadido al carrito con éxito.');
    }
    //todo test
    public function deleteProducts($productId)
    {
        $product = Product::findOrFail($productId);
        $user = auth()->user();
        $cart = $user->cart;
        $cart->products()->detach($productId);

        return back()->with('success', 'Producto eliminado del carrito con éxito.');
    }

    // cogemos los productos del cart de los users
    public function listProducts()
    {
        $user = auth()->user();
        $cart = $user->cart;
        $products = $cart->products;

        return view('auth.cart', compact('products'));
    }
}
