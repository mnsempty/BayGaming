<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DiscountsController;
use App\Models\Cart;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PDFController;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\ProductsController; //delete
use App\Http\Controllers\UsersController;
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
Route::get('homepage', [ProductsController::class, 'listFewL'])->name('landing');
Route::get('homepage/{category?}/{platform?}', [ProductsController::class, 'listFewL'])->name('landing');

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
// Lleva a la vista de pagar/checkout
Route::post('/proceed-to-payment', [OrdersController::class, 'proceedToPayment'])->middleware('auth')->name('cart.proceedToPayment');
// lleva del controlador del carrito a la vista del pedido
Route::get('/payment-confirmation/{order}/{discount?}', [OrdersController::class, 'showPaymentConfirmation'])->name('payment.confirmation');
//todo rutas de descuentos
// aplicar descuento en payment-confirmation view
Route::post('/apply-discount/{order}', [OrdersController::class, 'applyDiscount'])->name('apply.discount');
//todo ruta de direcciones
// ruta para guardar datos o no de dirección y además crear order y factura
Route::post('/saveAddress/{discount?}', [AddressesController::class, 'createAddress'])->name('address.create');
// idem anterior pero sin la parte de crear address, dado un address actualiza order y factura
Route::post('/order/save/{addressId}/{discount?}', [OrdersController::class, 'saveOrder'])->name('order.save');
Route::get('/addresses/delete/{addressId}', [AddressesController::class, 'deleteAddress'])->name('addresses.delete');
// datos de tabla de direcciones dada el id de una dirección para el modal de update (.value)
Route::get('/addresses/{id}', [AddressesController::class, 'showAddress']);
// update dirección dado un id, (envia datos)
Route::put('/addresses/update/{addressId}', [AddressesController::class, 'updateAddress'])->name('address.update');
//todo ruta de orders
// ver orders de un user
Route::get('/myOrders', [OrdersController::class, 'showMyOrders'])->name('orders.show');
//todo rutas de invoices
Route::get('/send-invoice/{order}', [InvoicesController::class, 'sendInvoice'])->name('send.invoice');
//Ruta para crear invoices
//! cambiado check errors
Route::get('/create-invoice/{order}', [InvoicesController::class, 'createInvoice'])->name('create.invoice');
//todo ruta provisional edit profile
//! address for profile view 
Route::get('/profile', [AddressesController::class, 'showAddressProfile'])->name('show.addresses');
//eliminar address desde profile
Route::get('/profile/addresses/delete/{addressId}', [AddressesController::class, 'deleteAddressProfile'])->name('addressProfile.delete');
// crear address sin crear order simpleCreateAddress
Route::post('/addresses/create', [AddressesController::class, 'simpleCreateAddress'])->name('addressProfile.create');
// Ruta para actualizar la contraseña
Route::post('/profile/update-password', [UsersController::class, 'updatePassword'])->name('PasswordProfile.update');
// Ruta para actualizar los datos del perfil
Route::post('/profile/update-data', [UsersController::class, 'updateProfileData'])->name('dataProfile.update');

//*ruta para generar el pdf
Route::get('/generate-pdf/{orderId}', [PDFController::class, 'generatePDF'])->name('generate.pdf');

//Controlador para cambio de idioma
Route::post('/language', [LanguageController::class, 'change'])->name('language.change');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [ProductsController::class, 'listFew'])->name('dashboard');

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

    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');

    Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');

    //!vista de todas las orders si funciona move a dashboard
    Route::get('/admin/orders', [OrdersController::class, 'showAllOrders'])->name('showAll.admin');

    //aceptar/cancelar pedidos, al aceptar se reduce el stock del producto
    Route::put('/order/accept/{order}', [OrdersController::class, 'acceptOrder'])->name('order.accept');
    Route::put('/order/cancel/{order}', [OrdersController::class, 'cancelOrder'])->name('order.cancel');

    //! descuentos mostrar, crear, actualizar, eliminar y activar
    // Ruta para listar todos los descuentos
    Route::get('/discounts', [DiscountsController::class, 'showDiscounts'])->name('discounts.show');
    // Ruta para crear un nuevo descuento
    Route::post('/discounts/create', [DiscountsController::class, 'create'])->name('discounts.create');
    // Ruta para editar un descuento existente
    Route::put('/discounts/{discount}', [DiscountsController::class, 'update'])->name('discounts.update');
    // Ruta para eliminar un descuento
    Route::delete('/discounts/{discount}', [DiscountsController::class, 'deleteDiscount'])->name('discounts.delete');
    // Ruta para activar un descuento
    Route::post('/discounts/{discount}/activate', [DiscountsController::class, 'activate'])->name('discounts.activate');
});
//! error de acesso si no eres admin
Route::get('/forbidden', function () {
    abort(403, 'Acceso no autorizado.');
});
