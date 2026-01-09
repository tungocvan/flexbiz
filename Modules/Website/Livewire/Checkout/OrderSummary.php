<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Modules\Website\Models\Cart;

class OrderSummary extends Component
{
    public $cart;

    public function mount()
    {
        $this->cart = Cart::with('items.product')
            ->where('session_id', session()->getId())
            ->first();
    }

    public function render()
    {
        return view('Website::livewire.checkout.order-summary');
    }
}
