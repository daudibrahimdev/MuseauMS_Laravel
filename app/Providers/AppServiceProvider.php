<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// some AI chatbot(gemini) recommend me to use this, in order to fix pagination styles -_-
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa Laravel pake gaya Bootstrap yang simpel dan clean <-- from gemini
        Paginator::useBootstrapFive(); 
    }
}
