<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // Create Read Update Delete
    // crear producto mediante una transacción
    // 
    public function createProduct(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'developer' => $request->developer,
                'publisher' => $request->publisher,
                'platform' => $request->platform,
                'launcher' => $request->launcher,
                //'reviews_id' => $request->reviews_id,
            ]);
            $request->validate(['name' => 'required','description' => 'required',    'price' => 'required',
            'stock' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'platform' => 'required',]);

            $product = new Product;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->stock = $request->stock;
            $product->developer = $request->developer;
            $product->publisher = $request->publisher;
            $product->platform = $request->platform;
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
            //{{ session('message') }} {{ session('product') }}   
   
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear un producto']);
        }

    
    }
    //Route::delete('/products/{id}', 'ProductController@deleteProduct');
    public function readProducts($id){
        try {
            DB::beginTransaction();
            Product::where('id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al eliminar un producto']);
        }
    }

    public function listAll()
    {
        $products = Product::all();
        
        return view('auth.dashboard', @compact('products')) ;
    }
}
 