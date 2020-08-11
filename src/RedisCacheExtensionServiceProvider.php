<?php

namespace Voice\RedisCacheExtension;

use Illuminate\Cache\CacheManager;
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
        $this->app->singleton('cache', function ($app) {
            return new CacheManager($app);
        });

        $this->commands([
            FlushRedis::class,
        ]);
    }
}
