<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Collector\CollectorController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

Route::controller(CollectorController::class)->group(function () {
    // Halaman Home/Landing Page
    Route::get('/', 'index')->name('collector.home');

    // Halaman Gallery/Koleksi (Daftar 50+ karya seni)
    Route::get('/collections', 'collection')->name('collection.index');

    // Halaman Detail Lukisan (Berdasarkan Slug)
    Route::get('/collections/{slug}', 'show')->name('collector.collections.show');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Grouping untuk aktor Collector
    Route::prefix('collector')->name('collector.')->group(function () {
        // Dashboard Pribadi Collector
        Route::get('/dashboard', [CollectorController::class, 'index'])->name('dashboard');
        
        // Lu bisa tambah route seperti 'my-orders' di sini nanti sesuai diagram
    });

    // Grouping untuk aktor Curator (Admin)
    Route::prefix('curator')->name('curator.')->group(function () {
        Route::get('/dashboard', function () {
            return view('curator.dashboard.index');
        })->name('dashboard');
    });
});