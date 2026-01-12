<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;

class CartIcon extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount()
    {
        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->first();

        $this->count = $cart ? $cart->items()->sum('quantity') : 0;
    }

    public function render()
    {
        return view('Website::livewire.cart.cart-icon');
    }
}
