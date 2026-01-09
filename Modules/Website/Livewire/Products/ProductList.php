<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Category;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public ?string $categorySlug = null;

    public function render()
    {

        if ($this->categorySlug) {

            $category = Category::active()
                ->ofType('product')
                ->where('slug', $this->categorySlug)
                ->firstOrFail();

            $category->load('childrenRecursive');
            $categoryIds = $category->getAllChildrenIds();

            $products = WpProduct::query()
                ->whereHas('categories', fn ($q) =>
                    $q->whereIn('categories.id', $categoryIds)
                )
                ->where('is_active', true)
                ->paginate(12);
        } else {
            $products = WpProduct::where('is_active', true)
                ->paginate(12);
        }

        return view('Website::livewire.products.product-list', [
            'products' => $products,
        ]);
    }
}
