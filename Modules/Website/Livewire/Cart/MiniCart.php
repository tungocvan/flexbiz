<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\Website\Livewire\Concerns\InteractsWithCart;

class MiniCart extends Component
{
    use InteractsWithCart;

    public array $items = [];
    public int $total = 0;

    public function mount(): void
    {
        $this->reload();
    }

    #[On('cart-updated')]
    public function reload(): void
    {
        $this->items = $this->getCart();
        $this->total = $this->cartTotal();
    }

    public function render()
    {
        return view('Website::livewire.cart.mini-cart');
    }
}
