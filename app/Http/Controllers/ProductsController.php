<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // Create Read Update Delete
    // crear producto mediante una transacción
    // 
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'name' => 'required', 'description' => 'required',    'price' => 'required',
                'stock' => 'required',
                'developer' => 'required',
                'publisher' => 'required',
                'platform' => 'required',
                'launcher' => 'nullable'
            ]);

            $product = new Product;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->stock = $request->stock;
            $product->developer = $request->developer;
            $product->publisher = $request->publisher;
            $product->platform = $request->platform;
            $product->launcher = $request->launcher;
            $product->save();

            // probablemente por nombre de las cat ask team
            // if ($request->has('category_ids')) {
            //     foreach ($request->category_ids as $category_id) {
            //         DB::table('categories_has_products')->insert([
            //             'categories_id' => $category_id,
            //             'products_id' => $product->id,
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ]);
            //     }


            DB::commit();
            return back()->with('mensaje', 'Producto creado exitosamente')->with('product', $product);
            //! para recogerlo en view {{ session('message') }} {{ session('product') }}   

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', 'Error al crear el producto');
        }
    }
    //todo test
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'developer' => 'required',
                'publisher' => 'required',
                'platform' => 'required',
                'launcher' => 'nullable',
                'images.*' => 'required',
                'discounts.*' => 'required',
            ]);

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->developer = $request->developer;
            $product->publisher = $request->publisher;
            $product->platform = $request->platform;
            $product->launcher = $request->launcher;
            $product->save();

            // Update associated images
            foreach ($request->images as $imageData) {
                $image = Image::findOrFail($imageData['id']);
                $image->url = $imageData['url'];
                $image->save();
            }

            // Update associated discounts
            foreach ($request->discounts as $discountData) {
                $discount = Discount::findOrFail($discountData['id']);
                $discount->percent = $discountData['percent'];
                $discount->save();
            }

            DB::commit();
            return back()->with('mensaje', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', 'Error al actualizar el producto');
        }
    }
    //todo test
    // Método para borrar productos
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $productDelete = Product::findOrFail($id);

            // Delete associations with pivot
            DB::table('products_has_images')->where('products_id', $id)->delete();

            // Delete associated ids with images
            //pluck selecciona solo la columna image_id
            $productImages = DB::table('products_has_images')->where('products_id', $id)->pluck('images_id');
            foreach ($productImages as $imageId) {
                Image::findOrFail($imageId)->delete(); //eliminamos las imagenes de la tabla imagenes
            }


            //delete associated discounts
            $productDelete->discounts()->delete();

            //delete associated products in wishlists
            $productDelete->wishlists()->detach();

            //!delete associated products in categories
            $productDelete->categories()->detach();

            //!delete associated products in orders
            $productDelete->orders()->detach();

            //delete associated products in carts
            $productDelete->carts()->detach();

            $productDelete->delete();

            DB::commit();
            return back()->with('mensaje', 'Producto eliminado');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    // Método para listar los productos
    // Falta trabajar mas la paginacion en la vista
    public function listAll()
    {
        $products = Product::paginate(5);
        return view('auth.dashboard', @compact('products'));
    }

    // Método para mostrat dettalles de productos
    public function show($id)
    {
        $product = Product::findOrfail($id);
        return view('product.product', @compact('products'));
    }

    // Método para editar dettalles de productos
    public function edit()
    {
        return view('auth.dashboard', @compact('products'));
    }
}
