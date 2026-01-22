<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Collector\CollectorController;
use App\Http\Controllers\Curator\CuratorController;
use App\Http\Controllers\Curator\OrderController;
use App\Http\Controllers\Curator\ArtworkController;
use App\Http\Controllers\Curator\CategoryController;
use App\Http\Controllers\Curator\ArtistController;
use App\Http\Controllers\Collector\CatalogController;
use App\Http\Controllers\Collector\CartController;
use App\Http\Controllers\Collector\CheckoutController;


use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [CollectorController::class, 'index'])->name('collector.home');

// Katalog dipindah ke sini agar bisa diakses tanpa login (Guest)
// Sesuai fungsi viewCatalog() di Class Diagram
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

/*
|--------------------------------------------------------------------------
| Protected Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'curator') {
            return redirect()->route('curator.dashboard');
        }
        return redirect()->route('collector.dashboard');
    })->name('dashboard');

    // Grouping untuk aktor Collector
    Route::prefix('collector')->name('collector.')->group(function () {
        Route::get('/dashboard', [CollectorController::class, 'index'])->name('dashboard');
        
        // --- Transaksi Collector (Wajib Login) ---
        // Masukkan route beli/keranjang di sini nanti
        // cart page
        Route::get('/cart', [App\Http\Controllers\Collector\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [App\Http\Controllers\Collector\CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/remove/{id}', [App\Http\Controllers\Collector\CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
        // checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::post('/orders/{id}/upload-proof', [CheckoutController::class, 'uploadProof'])->name('orders.upload-proof');
        Route::get('/my-acquisitions', [CheckoutController::class, 'myOrders'])->name('orders.index');
        // other routes
    });

    // Grouping untuk aktor Curator 
    Route::prefix('curator')->name('curator.')->group(function () {
        Route::get('/dashboard', [CuratorController::class, 'index'])->name('dashboard');

        // order page
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/verify', [OrderController::class, 'verifyPayment'])->name('orders.verify');
        Route::post('/orders/{id}/shipment', [OrderController::class, 'updateShipment'])->name('orders.updateShipment');

        // CRUD Artwork
        Route::resource('artworks', ArtworkController::class);
        // CRUD Category
        Route::resource('categories', CategoryController::class);
        // CRUD Artist
        Route::resource('artists', ArtistController::class);
    });
});