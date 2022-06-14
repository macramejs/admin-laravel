<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

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
            Route::middleware('api')
                ->prefix('admin/api')
                ->as('admin.api.')
                ->namespace($this->namespace)
                ->group(__DIR__.'/../publishes/routes/admin.php');
        });
    }
}