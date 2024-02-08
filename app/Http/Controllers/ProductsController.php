<?php

namespace App\Http\Controllers;

use App\Models\Discount;
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
            // Agrega el ID del usuario autenticado a los datos validados
            $validatedData['users_id'] = auth()->id();

            $product = Product::create($validatedData); //Uso de Mass Assignment con método create de Eloquent en vez de asignar uno a uno cada producto

            // Obtiene el ID del producto recién creado
            $productId = $product->id;
            // Define el nombre de la carpeta basándose en el ID del producto
            $folderName = "Producto_con_id_$productId";

            // Calcula el índice de la nueva imagen basándose en las existentes
            $productImage = Product::with('images')->find($productId); // Busca el producto y carga sus imágenes relacionadas
            $existingImagesCount = $productImage->images->count(); // Cuenta las imágenes a través de la relación

            //todo en un futuro cuando se pueda añadir varias imagenes servirá para renombrarlas y ordenarlas de momento no es muy útil
            $imageName = "imagen_" . ($existingImagesCount + 1);
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageFullName = "$imageName.$imageExtension";

            // Guarda la imagen en la carpeta específica del producto dentro de 'product_images'
            $imagePath = $request->file('image')->storeAs("product_images/$folderName", $imageFullName, 'public');
            $imageUrl = Storage::url($imagePath);

            // Crea una nueva instancia de Image y guárdala
            $image = new Image;
            $image->url = $imageUrl;
            $image->save();

            // Asocia la imagen con el producto
            $product->images()->attach($image);

            DB::commit();
            return back()->with('mensaje', __('Product created successfully'))->with('product', $product);
            //*Si la validación de datos falla se ejecuta el rollBack para  que no quede registro en BD.
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput(); //*Pasa los errores de validación por la vista y los datos introducidos de entrada
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', __('Error creating product ' . $e->getMessage()));
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
                'discount' => 'nullable|integer|min:0|max:100',
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

            //!en caso de que no tenga se hace insert
            $discount = $product->discounts->first();
            $discount->percent = $request['discount'] ?? $discount->percent;
            $discount->save();

            // Todo Update associated images
            $imagesData = $request->input('images');

            // Process each image
            foreach ($imagesData as $imageId => $imageData) {
                // Extract the uploaded files
                $uploadedFiles = $request->file("images.$imageId.file");

                // Loop through each uploaded file for the current image
                foreach ($uploadedFiles as $file) {
                    // Check if the file is valid
                    if ($file && $file->isValid()) {
                        // Find the image by its ID or create a new one if it doesn't exist
                        $image = Image::find($imageId) ?? new Image;

                        // Define the folder name based on the product ID
                        $folderName = "Producto_con_id_{$product->id}";

                        // Calculate the index of the new image based on existing ones
                        $existingImagesCount = $product->images()->count();
                        $imageName = "imagen_" . ($existingImagesCount +   1);
                        $imageExtension = $file->getClientOriginalExtension();
                        $imageFullName = "$imageName.$imageExtension";

                        // Store the file and get the path
                        $imagePath = $file->storeAs("product_images/$folderName", $imageFullName, 'public');
                        
                        // Set the image URL to the stored file path
                        $image->url = '/storage/' . $imagePath;

                        // Save the image
                        $image->save();

                        // Attach the image to the product using the pivot table
                        $product->images()->sync([$image->id]);
                    }
                }
            }


            // Update associated discounts


            DB::commit();
            //!para volver al dashboard, si lo hacemos modal idk quizá back()
            return redirect()->route('dashboard', compact('product'))->with('mensaje', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard', compact('product'))->with('mensaje', 'Error al actualizar el producto: ' . $e->getMessage());
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

    public function listFew()
    {
        $products = Product::where('show', true)->paginate(10);
        return view('auth.dashboard', @compact('products'));
    }

    // Método para mostrat dettalles de productos
    public function show($id)
    {
        //! HAY QUE USAR ESTE COMANDO ANTES PARA QUE SE ENLACE EL STORAGE Y SE MUESTEN IMAGENES:
        //! php artisan storage:link
        $products = Product::where('show', true)->with('images')->get();
        return view('landing', compact('products'));
    }




    //! llevar a vista de editar productos
    public function editView($id)
    {
        $product = Product::findOrFail($id);
        $images = $product->images;
        $discounts = $product->discounts;
        return view('auth.editProducts', ['product' => $product, 'images' => $images, 'discounts' => $discounts]);
    }
}
