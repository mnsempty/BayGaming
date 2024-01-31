<?php

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

Route::get( 'home',[ProductsController::class, 'listAll'])->middleware(['auth', 'verified']);

//Route::put('edit_note/{id}', [ NotesController::class, 'update' ]) -> name('notes.update'); 

//https://codersfree.com/courses-status/aprende-laravel-desde-cero/relacion-muchos-a-muchos
// Route::get('/check-relationship', function () {
//     $product = Product::find(1); // Obtiene el primer producto
//     // $product->categories()->attach(1);
//     // $product->categories()->detach(1);
//     $product->categories()->sync(2);
//     echo "products"."</br>";
//     echo $product;
//     $categories = $product->categories; // Obtiene las categorías del producto
//     echo "</br>"."datos de la tabla pivote asociadas a ese producto"."</br>";
//     echo $categories;
//     echo "</br>";
//     echo "nombres de las categorias asociadas a ese producto"."</br>";
//     foreach ($categories as $category) {
//         echo $category->name;
//     }
// });
// Route::group(['middleware' => 'admin'], function () {
//     Route::get('/admin_test', function () {
//         echo 'hola admin';
//     });
//     Route::get('/admin_test2', function () {
//         echo 'hola admin 2';
//     });
// });
// Route::get('/forbidden', function () {
//     abort(403, 'Acceso no autorizado.');
// });

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
