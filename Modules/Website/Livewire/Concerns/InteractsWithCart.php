<?php

namespace Modules\Website\Livewire\Concerns;

trait InteractsWithCart
{
    protected function getCart(): array
    {
        return session()->get('cart', []);
    }

    protected function putCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    protected function cartCount(): int
    {
        return collect($this->getCart())->sum('qty');
    }

    protected function cartTotal(): int
    {
        return collect($this->getCart())
            ->sum(fn ($item) => $item['price'] * $item['qty']);
    }
}
