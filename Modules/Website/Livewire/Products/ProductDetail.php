<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Modules\Website\Models\WpProduct;

class ProductDetail extends Component
{
    public WpProduct $product;

    public function mount(string $slug)
    {
        $this->product = WpProduct::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('Website::livewire.products.product-detail');
    }
}
