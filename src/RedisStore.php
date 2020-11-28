<?php

namespace Asseco\RedisCacheExtension;

use Illuminate\Cache\RedisStore as LaravelRedisStore;

class RedisStore extends LaravelRedisStore implements PatternDelete
{
    public function keys(string $pattern = '*'): array
    {
        return $this->connection()->keys($pattern);
    }

    public function forgetByPattern(string $pattern): bool
    {
        foreach ($this->keys($pattern) as $item) {
            $item = explode(':', $item);

            if (count($item) < 2) {
                continue;
            }

            $this->forget($item[1]);
        }

        return true;
    }
}
