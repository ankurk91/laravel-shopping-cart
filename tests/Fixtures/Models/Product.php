<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getKey(): int
    {
        return 99;
    }
}
