<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $products = Product::all();
    return view('welcome', compact('products'));
})->name('welcome');



Route::post('/products/{id}/buy-now', [ProductController::class, 'buyNow'])->name('products.buy-now');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

// Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Route::post('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.show');

Route::get('/checkout', [CheckoutController::class, 'showForm'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'finalize'])->name('checkout.finalize');

Route::get('/checkout/form', [CheckoutController::class, 'showForm'])->name('checkout.form');
Route::post('/checkout/finalize', [CheckoutController::class, 'finalize'])->name('checkout.finalize');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/order/{id}/struk', [OrderController::class, 'downloadStruk'])->name('order.struk');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/products', ProductController::class);
    Route::get('/orderan', [OrderController::class, 'index'])->name('orderan');
});





// ROUTE BARU: Menangani POST dari tombol "Beli Sekarang" di halaman detail produk
Route::post('/products/{id}/direct-buy', [ProductController::class, 'handleDirectBuy'])->name('products.handle-direct-buy');

// ROUTE BARU: Menampilkan formulir pembayaran langsung untuk satu produk
// Ini adalah URL yang Anda inginkan: http://127.0.0.1:8000/checkout/process-single
Route::get('/checkout/process-single', [CheckoutController::class, 'processSingleProductCheckout'])->name('checkout.process-single');

// ROUTE BARU: Memproses submit formulir pembayaran langsung
Route::post('/checkout/finalize-single', [CheckoutController::class, 'finalizeSingleProductCheckout'])->name('checkout.finalize-single');


require __DIR__.'/auth.php';
