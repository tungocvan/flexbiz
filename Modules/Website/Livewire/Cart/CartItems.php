<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\Website\Livewire\Concerns\InteractsWithCart;

class CartItems extends Component
{
    use InteractsWithCart;

    public array $items = [];

    public function mount(): void
    {
        $this->items = $this->getCart();
    }

    #[On('cart-updated')]
    public function reload(): void
    {
        $this->items = $this->getCart();
    }

    public function increase(int $id): void
    {
        $cart = $this->getCart();
        $cart[$id]['qty']++;

        $this->putCart($cart);
        $this->dispatch('cart-updated');
    }

    public function decrease(int $id): void
    {
        $cart = $this->getCart();

        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty']--;
        } else {
            unset($cart[$id]);
        }

        $this->putCart($cart);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-items');
    }
}
