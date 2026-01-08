<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\Website\Livewire\Concerns\InteractsWithCart;

class CartSummary extends Component
{
    use InteractsWithCart;

    public int $total = 0;

    public function mount(): void
    {
        $this->total = $this->cartTotal();
    }

    #[On('cart-updated')]
    public function refresh(): void
    {
        $this->total = $this->cartTotal();
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-summary');
    }
}
