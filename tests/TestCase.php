<?php

declare(strict_types=1);

namespace Asseco\RedisCacheExtension\Tests;

use Asseco\RedisCacheExtension\RedisCacheExtensionServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [RedisCacheExtensionServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
