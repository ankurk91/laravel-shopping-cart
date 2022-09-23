<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Item implements Arrayable, Jsonable
{
    public function __construct(
        public string|int $id,
        public string $name,
        public int $quantity,
        public int|float $unitPrice,
    ) {
        //
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function subtotal(): float|int
    {
        return $this->quantity * $this->unitPrice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unit_price' => $this->unitPrice,
            'subtotal' => $this->subtotal(),
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}