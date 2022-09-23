<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Entities;

use Illuminate\Support\Collection;

/**
 * @method Item|null get(int|string $id, $default = null)
 */
class ItemCollection extends Collection
{
    public function addRow(Item $item): self
    {
        $this->put($item->id, $item);

        return $this;
    }

    public function updateQuantity(string|int $id, int $quantity): Item
    {
        $item = $this->get($id)->setQuantity($quantity);
        $this->put($item->id, $item);

        return $item;
    }

    public function subtotal(): float|int
    {
        return $this->sum(fn(Item $item) => $item->subtotal());
    }
}