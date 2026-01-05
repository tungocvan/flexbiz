<?php

namespace Modules\Website\Livewire;

use Livewire\Component;
use Modules\Website\Models\WpProduct;

class Home extends Component
{
    public function render()
    {
        return view('Website::livewire.home', [
            'products' => WpProduct::active()->latest()->take(8)->get()
        ])->layout('Website::layouts.website');
    }
}
