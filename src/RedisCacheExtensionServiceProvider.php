<?php

namespace Voice\RedisCacheExtension;

use Illuminate\Support\ServiceProvider;
use Voice\RedisCacheExtension\App\Console\Commands\FlushRedis;

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
