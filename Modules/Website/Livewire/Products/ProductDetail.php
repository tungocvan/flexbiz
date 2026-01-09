<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Modules\Website\Models\WpProduct;

class ProductDetail extends Component
{
    public string $slug;
    public WpProduct $product;

    public function mount()
    {
        $this->product = WpProduct::where('slug', $this->slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('Website::livewire.products.product-detail');
    }
}
