<?php
declare(strict_types=1);

namespace Ankurk91\LaravelShoppingCart\Tests;

use Ankurk91\LaravelShoppingCart\Entities\Item;
use Ankurk91\LaravelShoppingCart\Entities\ItemCollection;
use Ankurk91\LaravelShoppingCart\Exceptions\ItemNotFoundException;
use Ankurk91\LaravelShoppingCart\Exceptions\ShoppingCartException;
use Ankurk91\LaravelShoppingCart\Facades\ShoppingCart;

class CartManagerTest extends TestCase
{
    public function test_add_item()
    {
        $item = ShoppingCart::add(11, 'Choco', 10, 2);
        $this->assertInstanceOf(Item::class, $item);
        $this->assertSame($item->name, 'Choco');
        $this->assertTrue(ShoppingCart::has(11));

        $savedItem = ShoppingCart::find(11);
        $this->assertInstanceOf(Item::class, $savedItem);
        $this->assertEquals($savedItem->id, 11);

        $this->assertEquals($item->toArray(), $savedItem->toArray());
    }

    public function test_add_duplicate_item()
    {
        ShoppingCart::add(11, 'Choco', 10, 2);
        $savedItem = ShoppingCart::find(11);
        $this->assertEquals($savedItem->unitPrice, 10);

        ShoppingCart::add(11, 'Choco', 20, 2);
        $savedItem = ShoppingCart::find(11);
        $this->assertEquals($savedItem->unitPrice, 20);
        $this->assertEquals(1, ShoppingCart::count(), 'Duplicates are not allowed.');
    }

    public function test_update_quantity()
    {
        ShoppingCart::add(110, 'Choco', 10, 2);
        ShoppingCart::update(110, 20);
        $savedItem = ShoppingCart::find(110);
        $this->assertEquals($savedItem->quantity, 20);
    }

    public function test_remove_single_item()
    {
        $item1 = ShoppingCart::add(1, 'Choco', 10, 2);
        $item2 = ShoppingCart::add(2, 'Bar', 20, 4);

        ShoppingCart::remove(1);
        $this->assertEquals(1, ShoppingCart::count());
        $this->assertSame(null, ShoppingCart::find(1));
    }

    public function test_add_multiple_items()
    {
        $item1 = ShoppingCart::add(11, 'Choco', 10, 2);
        $item2 = ShoppingCart::add(22, 'Bar', 20, 4);

        $this->assertEquals(2, ShoppingCart::count());
        $this->assertEquals(100, ShoppingCart::subtotal());
        $this->assertInstanceOf(ItemCollection::class, ShoppingCart::all());

        ShoppingCart::clear();
        $this->assertEquals(0, ShoppingCart::subtotal());
    }

    public function test_updating_unknown_item()
    {
        $this->expectException(ItemNotFoundException::class);
        ShoppingCart::update('unknown_id', 20);
    }

    public function test_invalid_quantity()
    {
        $this->expectException(ShoppingCartException::class);
        ShoppingCart::add(1, 'Name', 0, 0);
    }

    public function test_clear_cart()
    {
        ShoppingCart::add(156, 'Choco', 10, 2);
        ShoppingCart::clear();

        $this->assertTrue(ShoppingCart::isEmpty());
    }

    public function test_custom_session_name()
    {
        ShoppingCart::setName('electronics');

        $this->assertStringContainsString('electronics', ShoppingCart::getName());
    }

}