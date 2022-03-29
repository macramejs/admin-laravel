<?php

namespace Macrame\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Providers to be registered.
     *
     * @var array
     */
    protected $providers = [
        Foundation\FoundationServiceProvider::class,
        Media\MediaServiceProvider::class,
        Pages\PagesServiceProvider::class,
        Nav\NavServiceProvider::class,
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
