<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart;

use Ankurk91\LaravelShoppingCart\Entities\Item;
use Ankurk91\LaravelShoppingCart\Entities\ItemCollection;
use Ankurk91\LaravelShoppingCart\Exceptions\ItemNotFoundException;
use Ankurk91\LaravelShoppingCart\Exceptions\ShoppingCartException;
use Illuminate\Contracts\Session\Session;

class ShoppingCartManager
{
    public const KEY_PREFIX = 'shopping-cart';
    protected string $name = self::KEY_PREFIX.'.default';

    public function __construct(protected Session $session)
    {
        //
    }

    public function setName(string $name): self
    {
        $this->name = self::KEY_PREFIX.'.'.$name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function getCollection(): ItemCollection
    {
        $cart = $this->session->get($this->name);

        return $cart instanceof ItemCollection ? $cart : new ItemCollection();
    }

    public function add(
        int|string $id,
        string $name,
        int|float $unitPrice,
        int $quantity,
        array $attributes = [],
    ): Item {
        $this->validateQuantity($quantity);

        $item = new Item($id, $name, $quantity, $unitPrice);
        $item = $item->setAttributes($attributes);
        $collection = $this->getCollection()->addRow($item);
        $this->save($collection);

        return $item;
    }

    protected function save(?ItemCollection $collection): void
    {
        $this->session->put($this->name, $collection);
    }

    public function update(int|string $id, int $quantity): Item
    {
        $collection = $this->getCollection();

        if (!$this->has($id)) {
            throw new ItemNotFoundException('Item not found in cart with id: '.$id);
        }

        $this->validateQuantity($quantity);

        $item = $collection->updateQuantity($id, $quantity);
        $this->save($collection);

        return $item;
    }

    protected function validateQuantity(int $quantity): void
    {
        if ($quantity < 1) {
            throw new ShoppingCartException('Quantity can not be less than 1.');
        }
    }

    public function remove(int|string $id): void
    {
        $collection = $this->getCollection()->forget($id);
        $this->save($collection);
    }

    public function find(int|string $id): ?Item
    {
        return $this->getCollection()->get($id);
    }

    public function has(int|string $id): bool
    {
        return $this->getCollection()->has($id);
    }

    public function all(): ItemCollection
    {
        return $this->getCollection();
    }

    public function clear(): void
    {
        $this->session->forget($this->name);
    }

    public function isEmpty(): bool
    {
        return $this->getCollection()->isEmpty();
    }

    public function count(): int
    {
        return $this->getCollection()->count();
    }

    public function subtotal(): int|float
    {
        return $this->getCollection()->subtotal();
    }
}