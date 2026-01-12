<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Modules\Website\Models\WpProduct;

class ProductDetail extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $product = WpProduct::active()
            ->where('slug', $this->slug)
            ->firstOrFail();

        return view('Website::livewire.products.product-detail', [
            'product' => $product
        ]);
    }
}
