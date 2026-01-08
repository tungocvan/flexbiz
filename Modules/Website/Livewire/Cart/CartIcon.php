<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\Website\Livewire\Concerns\InteractsWithCart;

class CartIcon extends Component
{
    use InteractsWithCart;

    public int $count = 0;

    public function mount(): void
    {
        $this->count = $this->cartCount();
    }

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        $this->count = $this->cartCount();
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-icon');
    }
}
