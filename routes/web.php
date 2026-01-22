<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Collector\CollectorController;
use App\Http\Controllers\Curator\CuratorController;
use App\Http\Controllers\Curator\OrderController;
use App\Http\Controllers\Curator\ArtworkController;
use App\Http\Controllers\Curator\CategoryController;
use App\Http\Controllers\Curator\ArtistController;


use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::controller(CollectorController::class)->group(function () {
    Route::get('/', 'index')->name('collector.home');
    Route::get('/collections', 'collection')->name('collection.index');
    Route::get('/collections/{slug}', 'show')->name('collector.collections.show');
});

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
        
        // route lain
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