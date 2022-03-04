<?php

namespace Macrame\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    protected $providers = [
        Foundation\FoundationServiceProvider::class,
    ];

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}