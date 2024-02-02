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
                'name' => 'sometimes|required',
                'description' => 'sometimes|required',
                'price' => 'sometimes|required',
                'stock' => 'sometimes|required',
                'developer' => 'sometimes|required',
                'publisher' => 'sometimes|required',
                'platform' => 'sometimes|required',
                'launcher' => 'sometimes|nullable',
                'images.*' => 'sometimes|required',
                'discounts.*' => 'sometimes|required',
            ]);

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->developer = $request->developer;
            $product->publisher = $request->publisher;
            $product->show = $request->show;
            $product->platform = $request->platform;
            $product->launcher = $request->launcher;
            $product->save();

            // Update associated images
            // foreach ($request->images as $imageData) {
            //     $image = Image::findOrFail($imageData['id']);
            //     $image->url = $imageData['url'];
            //     $image->save();
            // }

            // Update associated discounts
            // foreach ($request->discounts as $discountData) {
            //     $discount = Discount::findOrFail($discountData['id']);
            //     $discount->percent = $discountData['percent'];
            //     $discount->save();
            // }

            DB::commit();
            //!para volver al dashboard, si lo hacemos modal idk quizá back()
            return redirect()->route('casa', compact('product'))->with('mensaje', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('casa', compact('product'))->with('mensaje', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }
    //todo test
    // Método para borrar productos
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $productDelete = Product::findOrFail($id);
            $productDelete->show = false;
            $productDelete->save();

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
        return view('auth.dashboard', compact('products'));
    }

    public function listFew()
    {
        $products = Product::where('show', true)->paginate(5);
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

    //! llevar a vista de editar
    public function editView($id){
        $product = Product::findOrFail($id);
        return view ('auth.editProducts',@compact('product'));
    }
}
