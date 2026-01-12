<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Website\Models\Cart;

class OrderSummary extends Component
{
    public function render()
    {
        $sessionId = Session::getId();
        $cart = Cart::with('items.product')->where('session_id', $sessionId)->first();

        return view('Website::livewire.checkout.order-summary', [
            'items' => $cart ? $cart->items : collect([]),
            'total' => $cart ? $cart->items->sum('total') : 0
        ]);
    }
}
