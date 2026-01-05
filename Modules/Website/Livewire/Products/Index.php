<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Category;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $categorySlug = null;

    public function mount($slug = null)
    {
        $this->categorySlug = $slug;
    }

    public function render()
    {
        $query = WpProduct::active()->with('categories');

        $categoryName = 'Tất cả sản phẩm';

        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)->active()->firstOrFail();
            $categoryName = $category->name;
            
            // Lấy ID của category hiện tại và tất cả con của nó
            $categoryIds = $category->getAllChildrenIds();
            
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        return view('Website::livewire.products.index', [
            'products' => $query->latest()->paginate(12),
            'categoryName' => $categoryName
        ])->layout('Website::layouts.website');
    }
}