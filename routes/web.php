<?php

use App\Http\Controllers\ProductsController;//delete
use App\Models\Product;
use Illuminate\Support\Facades\Route;

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


/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('auth.dashboard');
})->middleware('auth');

Route::get('/home', function () {
    return view('auth.dashboard');
})->middleware(['auth', 'verified']);

*/

Route::get('/', function () {
    return view('templates.template');
});


//https://codersfree.com/courses-status/aprende-laravel-desde-cero/relacion-muchos-a-muchos
Route::get('/check-relationship', function () {
    $product = Product::find(1); // Obtiene el primer producto
    // $product->categories()->attach(1);
    // $product->categories()->detach(1);
    $product->categories()->sync(2);
    echo $product;
    $categories = $product->categories; // Obtiene las categorías del producto
    echo "</br>";
    echo $categories;

    foreach ($categories as $category) {
        echo $category->name;
    }
});
