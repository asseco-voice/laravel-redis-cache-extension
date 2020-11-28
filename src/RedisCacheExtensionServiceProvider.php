<?php

namespace Asseco\RedisCacheExtension;

use Asseco\RedisCacheExtension\App\Console\Commands\FlushRedis;
use Illuminate\Support\ServiceProvider;

class RedisCacheExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->extend('cache', function ($service, $app) {
            return new CacheManager($app);
        });

        $this->commands([
            FlushRedis::class,
        ]);
    }
}
