<?php

namespace Modules\Website\Services\Cart;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected array $items = [];

    public function __construct()
    {
        $stored = Session::get(CartStorage::SESSION_KEY, []);
        foreach ($stored as $id => $item) {
            $this->items[$id] = CartItem::fromArray($item);
        }
    }

    public function add(CartItem $item): void
    {
        if (isset($this->items[$item->productId])) {
            $this->items[$item->productId]->increase($item->qty);
        } else {
            $this->items[$item->productId] = $item;
        }

        $this->persist();
    }

    public function increase(int $productId): void
    {
        $this->items[$productId]?->increase();
        $this->persist();
    }

    public function decrease(int $productId): void
    {
        $this->items[$productId]?->decrease();
        $this->persist();
    }

    public function remove(int $productId): void
    {
        unset($this->items[$productId]);
        $this->persist();
    }

    public function items(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return array_sum(
            array_map(fn($item) => $item->qty, $this->items)
        );
    }

    public function total(): float
    {
        return array_sum(
            array_map(fn($item) => $item->subtotal(), $this->items)
        );
    }

    public function clear(): void
    {
        $this->items = [];
        Session::forget(CartStorage::SESSION_KEY);
    }

    protected function persist(): void
    {
        Session::put(
            CartStorage::SESSION_KEY,
            array_map(fn($item) => $item->toArray(), $this->items)
        );
    }
}

