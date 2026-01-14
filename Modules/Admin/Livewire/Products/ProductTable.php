<?php

namespace Modules\Admin\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Website\Models\WpProduct;

class ProductTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $product = WpProduct::find($id);
        if ($product) {
            $product->is_active = !$product->is_active;
            $product->save();
        }
    }

    public function delete($id)
    {
        WpProduct::destroy($id);
    }

    public function render()
    {
        $products = WpProduct::with('categories') // <--- QUAN TRỌNG: Load trước danh mục
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Admin::livewire.products.product-table', [
            'products' => $products
        ]);
    }
}
