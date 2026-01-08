<?php

namespace Modules\Website\Livewire\Cart;

use Livewire\Component;

class CartPage extends Component
{
    public function render()
    {
        return view('Website::livewire.cart.cart-page')->layout('Website::layouts.website');
    }
}
