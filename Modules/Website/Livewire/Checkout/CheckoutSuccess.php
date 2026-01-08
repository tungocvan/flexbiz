<?php

namespace Modules\Website\Livewire\Checkout;

use Livewire\Component;
use Modules\Website\Models\Order;

class CheckoutSuccess extends Component
{
    public Order $order;

    public function mount(string $code)
    {
        $this->order = Order::where('code', $code)->firstOrFail();
    }

    public function render()
    {
        return view('Website::livewire.checkout.checkout-success')
            ->layout('Website::layouts.website');
    }
}
