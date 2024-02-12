<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Models\Cart;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrdersController;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\ProductsController; //delete
use App\Http\Controllers\WhishlistsController;
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
Route::get('home', [HomeController::class, 'roleRedirect'])->middleware(['auth', 'verified']);

//! RUTA PARA VER PRODUCTOS USER
Route::get('homepage', [ProductsController::class, 'listFew'])->name('landing');

//! RUTA PARA AÑADIR PRODUCTOS CART
Route::post('/cart/add/{product}', [CartsController::class, 'addToCart'])->name('cart.add');

//! RUTA PARA IR AL CARRITO
Route::get('/cart', [CartsController::class, 'listProducts'])->name('cart.list');

//! RUTA PARA BORRAR PRODUCTOS CARRITO
Route::get('/delete/{id}', [CartsController::class, 'deleteProducts'])->name('cart.delete');

// Ruta para actualizar la cantidad de un producto en el carrito
Route::put('/cart/update/{product}', [CartsController::class, 'updateProductQuantity'])->name('cart.update');

// Rutas para controlar la lista de favoritos
Route::post('/wishlist/add/{product_id}', [WhishlistsController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove/{product_id}', [WhishlistsController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist/load', [WhishlistsController::class, 'showWishlist'])->name('wishlist.load');
Route::post('/wishlist/toggle/{product_id}', [WhishlistsController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::get('/payment-confirmation/{order}', [OrdersController::class, 'showPaymentConfirmation'])->name('payment.confirmation');
// Lleva a la vista de pagar/checkout
Route::post('/proceed-to-payment', [OrdersController::class, 'proceedToPayment'])->middleware('auth')->name('cart.proceedToPayment');
//todo rutas de direcciones
// ruta para guardar datos o no de dirección y además crear order y factura
Route::post('/saveAddress', [AddressesController::class, 'createAddress'])->name('address.create');
// idem anterior pero sin la parte de crear address, dado un address actualiza order y factura
Route::post('/order/save/{addressId}', [OrdersController::class, 'saveOrder'])->name('order.save');

Route::get('/addresses/delete/{addressId}', [AddressesController::class, 'deleteAddress'])->name('addresses.delete');
// datos de tabla direcciones dado un id
Route::get('/addresses/{id}', [AddressesController::class, 'showAddress']);
// update dirección dado un id, != a la anterior por miedo a represalias
Route::put('/addresses/update/{addressId}', [AddressesController::class, 'updateAddress'])->name('address.update');
//todo ruta de orders
Route::get('/myOrders', [OrdersController::class, 'showMyOrders'])->name('orders.show');
//todo rutas de invoices
Route::get('/send-invoice/{order}', [InvoicesController::class, 'sendInvoice'])->name('send.invoice');
//Ruta para crear invoices
Route::get('/send-invoice/{order}', [InvoicesController::class, 'createInvoice'])->name('create.invoice');

//Controlador para cambio de idioma
Route::post('/language', [LanguageController::class, 'change'])->name('language.change');
//Route::put('edit_note/{id}', [ NotesController::class, 'update' ]) -> name('notes.update');

//https://codersfree.com/courses-status/aprende-laravel-desde-cero/relacion-muchos-a-muchos
// Route::get('/check-relationship', function () {
//     $product = Product::find(1); // Obtiene el primer producto
//     // $product->categories()->attach(1);
//     // $product->categories()->detach(1);
//     $product->images();
//     echo "products"."</br>";
//     echo $product;
//     $images = $product->images; // Obtiene las categorías del producto
//     echo "</br>"."datos de la tabla pivote asociadas a ese producto"."</br>";
//     echo $images;
//     echo "</br>";
//     echo "nombres de las categorias asociadas a ese producto"."</br>";
//     foreach ($images as $image) {
//         echo $image->id;
//         echo $image->url;
//     }
// });

Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [ProductsController::class, 'listFew'])->name('dashboard');
    // Route::get('home/{id}', [ProductsController::class, 'show'])->name('show');

    //! lleva a pagina de crear products
    Route::post('/products/create', [ProductsController::class, 'create'])->name('products.create');

    //! lleva a pagina de editar products
    Route::get('/products/{id}/edit', [ProductsController::class, 'editView'])->name('products.edit.view');
    Route::post('/products/toggleStatus/{id}', [ProductsController::class, 'toggleStatus'])->name('products.toggleStatus');
    Route::get('/products/fetchDeleted', [ProductsController::class, 'fetchDeleted'])->name('products.fetchDeleted');

    //! update de products
    Route::post('/products/{id}', [ProductsController::class, 'update'])->name('products.edit');
    Route::delete('dashboard/{id}', [ProductsController::class, 'delete'])->name('product.delete');

    //! Ruta de listado de categorias
    Route::get('/categories', [CategoriesController::class, 'listAll'])->name('categories');

    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');

    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');

    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

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
