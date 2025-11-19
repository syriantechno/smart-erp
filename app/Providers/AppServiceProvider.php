<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Register view composers
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\ThemeComposer::class);
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\LayoutComposer::class);
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\MenuComposer::class);
    }
}
