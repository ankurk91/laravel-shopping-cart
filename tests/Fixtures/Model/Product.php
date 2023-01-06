<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Tests\Fixtures\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getKey(): int
    {
        return 99;
    }
}
