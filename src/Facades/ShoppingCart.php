<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Facades;

use Ankurk91\LaravelShoppingCart\ShoppingCartManager;
use Illuminate\Support\Facades\Facade;

class ShoppingCart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ShoppingCartManager::class;
    }
}