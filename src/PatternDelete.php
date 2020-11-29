<?php

namespace Asseco\RedisCacheExtension;

interface PatternDelete
{
    /**
     * Return keys by pattern.
     *
     * @param string $pattern
     * @return mixed
     */
    public function keys(string $pattern = '*'): array;

    /**
     * Forget keys by pattern.
     *
     * @param string $pattern
     * @return mixed
     */
    public function forgetByPattern(string $pattern): bool;
}
