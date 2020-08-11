<?php

namespace Voice\RedisCacheExtension;

use Illuminate\Cache\CacheManager as LaravelCacheManager;

class CacheManager extends LaravelCacheManager
{
    protected function createRedisDriver(array $config)
    {
        $redis = $this->app['redis'];

        $connection = $config['connection'] ?? 'default';

        return $this->repository(new RedisStore($redis, $this->getPrefix($config), $connection));
    }
}
