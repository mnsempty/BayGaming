<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    // Create Read Update Delete
    // crear producto mediante una transacción
    // 
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validate([
            'name' => 'required', 
            'description' => 'required',    
            'price' => 'required',
            'stock' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'platform' => 'required',
            'launcher' => 'nullable',
            'image' => 'required|image|max:2048'
        ]);
        $product = Product::create($validatedData); //Uso de Mass Assignment con método create de Eloquent en vez de asignar uno a uno cada producto

          // Guarda la imagen en el servidor y obtén la URL de la imagen
          $imagePath = $request->file('image')->store('product_images', 'public');
          $imageUrl = Storage::url($imagePath);
  
          // Crea una nueva instancia de Image y guárdala
          $image = new Image;
          $image->url = $imageUrl;
          $image->save();
  
          // Asocia la imagen con el producto
          $product->images()->attach($image);

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
            return back()->with('mensaje', __('Product created successfully'))->with('product', $product);
    //*Si la validación de datos falla se ejecuta el rollBack para  que no quede registro en BD.
    } catch (ValidationException $e) { 
        DB::rollBack();
        return back()->withErrors($e->errors())->withInput(); //*Pasa los errores de validación por la vista y los datos introducidos de entrada
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('mensaje', __('Error creating product'));
    }
}

    // Método para borrar productos
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $productDelete = Product::findOrFail($id);

            // Delete associated ids with images
            //pluck selecciona solo la columna image_id
            $productImages = DB::table('products_has_images')->where('product_id', $id)->pluck('image_id');
            foreach ($productImages as $imageId) {
                Image::findOrFail($imageId)->delete(); //eliminamos las imagenes de la tabla imagenes
            }

            // Delete associations with pivot
            DB::table('products_has_images')->where('product_id', $id)->delete();
            
            //delete associated discounts
            $productDelete->discounts()->delete();
            //delete associated wishlish 
            $productDelete->wishlists()->detach();

            $productDelete->delete();

            DB::commit();
            return back()->with('mensaje', 'Producto eliminado');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', 'Error al eliminar el producto');
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
        $product = Product::finOrfail($id);
        return view('auth.dashboard', @compact('products'));
    }

    // Método para editar dettalles de productos
    public function edit()
    {
        return view('auth.dashboard', @compact('products'));
    }
}
