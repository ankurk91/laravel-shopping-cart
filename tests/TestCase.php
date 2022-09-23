<?php

declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Tests;

use Ankurk91\LaravelShoppingCart\ShoppingCartServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ShoppingCartServiceProvider::class,
        ];
    }
}