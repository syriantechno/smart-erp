<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ShiftRepository;
use App\Models\Shift;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(ShiftRepository::class, function ($app) {
            return new ShiftRepository(new Shift());
        });

        // You can bind interfaces to implementations here
        // $this->app->bind(ShiftRepositoryInterface::class, ShiftRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
