<?php

namespace Tests;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class TestServiceProvider extends RouteServiceProvider
{
    /**
     * Boot test services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../publishes/migrations');

        $this->routes(function () {
            Route::prefix('admin')
                ->as('admin')
                ->group(__DIR__.'/../publishes/routes/admin.php');
        });
    }
}
