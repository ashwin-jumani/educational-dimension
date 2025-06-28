<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // app()->storagePath('Modules/LMS/storage/app/public');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
