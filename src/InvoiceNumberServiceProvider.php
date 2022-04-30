<?php

namespace Helmab\InvoiceNumber;

use Illuminate\Support\ServiceProvider;

class InvoiceNumberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('invoice-number.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'invoice-number');

        // Register the main class to use with the facade
        $this->app->singleton('invoice-number', function () {
            return new InvoiceNumber;
        });
    }
}
