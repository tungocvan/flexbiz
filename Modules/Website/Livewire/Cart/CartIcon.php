<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Modules\Website\Models\Cart;

class CartIcon extends Component
{
    public int $count = 0;

    protected $listeners = ['cartUpdated' => 'loadCount'];

    public function mount()
    {
        $this->loadCount();
    }

    public function loadCount()
    {
        $cart = Cart::with('items')
            ->where('session_id', session()->getId())
            ->first();

        $this->count = $cart
            ? $cart->items->sum('quantity')
            : 0;
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-icon');
    }
}
