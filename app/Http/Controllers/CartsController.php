<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
    
        // añade el producto al carrito con la cantidad especificada
        $cart->products()->attach($productId, ['quantity' => $quantity]);
    
        return back()->with('success', 'Producto añadido al carrito con éxito.');
    }
    
}