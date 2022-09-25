# Laravel Shopping Cart

[![Packagist](https://badgen.net/packagist/v/ankurk91/laravel-shopping-cart)](https://packagist.org/packages/ankurk91/laravel-shopping-cart)
[![GitHub-tag](https://badgen.net/github/tag/ankurk91/laravel-shopping-cart)](https://github.com/ankurk91/laravel-shopping-cart/releases)
[![License](https://badgen.net/packagist/license/ankurk91/laravel-shopping-cart)](LICENSE.txt)
[![Downloads](https://badgen.net/packagist/dt/ankurk91/laravel-shopping-cart)](https://packagist.org/packages/ankurk91/laravel-shopping-cart/stats)
[![GH-Actions](https://github.com/ankurk91/laravel-shopping-cart/workflows/tests/badge.svg)](https://github.com/ankurk91/laravel-shopping-cart/actions)
[![codecov](https://codecov.io/gh/ankurk91/laravel-shopping-cart/branch/main/graph/badge.svg)](https://codecov.io/gh/ankurk91/laravel-shopping-cart)

Shopping cart manager for Laravel.

## Installation

You can install the package via composer:

```bash
composer require "ankurk91/laravel-shopping-cart"
```

## Usage

You can use Facade

```php
<?php
use Ankurk91\LaravelShoppingCart\Facades\ShoppingCart;
use App\Models\Product;

$product = Product::find(1);
$quantity = request('quantity');
$attributes = [
    'image_url' => 'https://example.com/image.webp',
];
$item = ShoppingCart::add(
    $product->id, 
    $product->name,
    $product->unit_price,
    $quantity, 
    $attributes,
);

ShoppingCart::find(1);
ShoppingCart::update($product->id, 3);
ShoppingCart::all();
ShoppingCart::count();
ShoppingCart::has(1);
ShoppingCart::isEmpty();
ShoppingCart::subtotal();
ShoppingCart::remove($product->id);
ShoppingCart::clear();
```

> **Note**
> The cart items will be stored in default session storage.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security issues, please email `pro.ankurk1[at]gmail[dot]com` instead of using the issue tracker.

## Attribution

This package is highly inspired by [overtrue/laravel-shopping-cart](https://github.com/overtrue/laravel-shopping-cart)

## License

The [MIT](https://opensource.org/licenses/MIT) License.