<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Modules\Products\Models\WpProduct;

class ProductDetail extends Component
{
    public string $slug;
    public WpProduct $product;
    public int $qty = 1;

    public function mount(string $slug)
    {
        $this->slug = $slug;

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
