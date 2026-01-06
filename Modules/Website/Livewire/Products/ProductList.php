<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Website\Models\WpProduct;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $products = WpProduct::query()
            ->latest()
            ->paginate(12);



        return view('Website::livewire.products.product-list', [
            'products' => $products,
        ]);
    }
}
