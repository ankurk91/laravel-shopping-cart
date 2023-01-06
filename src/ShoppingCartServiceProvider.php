<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(ShoppingCartManager::class, function (Container $app) {
            return new ShoppingCartManager($app['session.store']);
        });
    }

    public function provides(): array
    {
        return [
            ShoppingCartManager::class,
        ];
    }
}
