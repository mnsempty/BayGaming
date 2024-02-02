<?php

use App\Http\Controllers\HomeCotroller;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\ProductsController; //delete
use Illuminate\Support\Facades\Route;

/* Uso del controlador para asignarle rutas **/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
//! lleva a page de prueba landing
Route::get( 'home',[HomeCotroller::class, 'roleRedirect'])->middleware(['auth', 'verified']);

//Route::put('edit_note/{id}', [ NotesController::class, 'update' ]) -> name('notes.update'); 

//https://codersfree.com/courses-status/aprende-laravel-desde-cero/relacion-muchos-a-muchos
Route::get('/check-relationship', function () {
    $product = Product::find(1); // Obtiene el primer producto
    // $product->categories()->attach(1);
    // $product->categories()->detach(1);
    $product->images();
    echo "products"."</br>";
    echo $product;
    $images = $product->images; // Obtiene las categorías del producto
    echo "</br>"."datos de la tabla pivote asociadas a ese producto"."</br>";
    echo $images;
    echo "</br>";
    echo "nombres de las categorias asociadas a ese producto"."</br>";
    foreach ($images as $image) {
        echo $image->url;
    }
});

 Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [ProductsController::class, 'listFew'])->name('dashboard');
    // Route::get('home/{id}', [ProductsController::class, 'show'])->name('show');
    //! lleva a pagina de editar products
    Route::get('/products/{id}/edit',[ProductsController::class, 'editView'])->name('products.edit.view');
    //! update de products
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.edit');

    Route::delete('dashboard/{id}', [ProductsController::class, 'delete'])->name('product.delete');
 });

Route::get('/forbidden', function () {
    abort(403, 'Acceso no autorizado.');
});

// Route::get('check-relationship2', function () {
//     $product = Product::find(1); // Obtiene el primer producto
//     // $product->categories()->attach(1);
//     // $product->categories()->detach(1);
//     $product->carts()->sync(1);
//     echo "productos" . "</br>";
//     echo $product;
//     $carts = $product->carts; // Obtiene las categorías del producto
//     echo "</br>";
//     echo "cart del usuario" . "</br>";
//     echo $carts;
//     echo "</br>";
//     echo "cart nombre¿?¿?¿?" . "</br>";
//     foreach ($carts as $cart) {
//         echo $cart->id;
//     }
// });

