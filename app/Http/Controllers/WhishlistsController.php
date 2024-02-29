<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WhishlistsController extends Controller
{
    public function addToWishlist(Request $request, $product_id)
    {
        try {
            DB::beginTransaction();
            // Get the authenticated user's wishlist or create a new one if it doesn't exist
            $wishlist = Auth::user()->wishlist ?? new Wishlist(['users_id' => Auth::id()]);

            // Save the wishlist if it's new
            if (!Auth::user()->wishlist) {
                $wishlist->save();
            }

            // Attach the product to the wishlist
            $wishlist->products()->attach($product_id);

            DB::commit();

            return back()->with('success', 'El producto se ha añadido a tu lista de deseos');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log the error, etc.
            return back()->withErrors(['message' => 'Hubo un problema al agregar el producto a tu lista de deseos.'. $e->getMessage()]);
        }
    }

    public function removeFromWishlist(Request $request, $product_id)
    {
        try {
            DB::beginTransaction();

            // Get the authenticated user's wishlist
            $wishlist = Auth::user()->wishlist;

            // Detach the product from the wishlist
            $wishlist->products()->detach($product_id);

            DB::commit();

            return back()->with('success', 'El producto se ha eliminado de tu lista de deseos');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log the error, etc.
            return back()->withErrors(['message' => 'Hubo un problema al eliminar el producto de tu lista de deseos.'. $e->getMessage()]);
        }
    }

    public function toggleWishlist(Request $request, $product_id)
    {

        try {
            DB::beginTransaction();

            // Get the authenticated user's wishlist or create a new one if it doesn't exist
            $wishlist = Auth::user()->wishlist ?? new Wishlist(['users_id' => Auth::id()]);

            // Save the wishlist if it's new
            if (!Auth::user()->wishlist) {
                $wishlist->save();
            }

            if ($wishlist->products()->where('products_id', $product_id)->exists()) {
                // Si el producto ya está en la wishlist, lo quitamos
                $wishlist->products()->detach($product_id);
                $message = 'El producto se ha eliminado de tu lista de deseos';
            } else {
                // Si el producto no está en la wishlist, lo añadimos
                $wishlist->products()->attach($product_id);
                $message = 'El producto se ha añadido a tu lista de deseos';
            }

            DB::commit();

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            // Handle the exception, log the error, etc.
            return back()->withErrors(['message' => 'Hubo un problema al agregar el producto a tu lista de deseos.' . $e->getMessage()]);
        }
    }

    public function showWishlist()
    {
        $wishlist = Auth::user()->wishlist->load('products');
        return response()->json(['wishlist' => $wishlist]);
    }


    public function getMostFavoritedProducts()
    {
        // Get all the products sorted in descending order
        return Product::whereHas('wishlists')->withCount('wishlists')->orderByDesc('wishlists_count')->take(10)->get();
    }
}
