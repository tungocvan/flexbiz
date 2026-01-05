<?php

namespace Modules\Website\Livewire;

use Livewire\Component;
use Modules\Website\Models\WpProduct;

class Product extends Component
{
    public function render()
    {
        return view('Website::livewire.product', [
            'products' => WpProduct::active()->latest()->take(8)->get()
        ])->layout('Website::layouts.website');
    }
}
