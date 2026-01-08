<?php

namespace Modules\Website\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Website\Models\WpProduct;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function addQuickToCart(int $productId): void
    {
        $product = WpProduct::query()
            ->where('is_active', true)
            ->find($productId);

        if (! $product) {
            return;
        }

        // ✅ SESSION CART (KHÔNG SERVICE)
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty']++;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->title,
                'price' => $product->sale_price ?: $product->regular_price,
                'qty'   => 1,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        // ✅ EVENT CHUẨN – đồng bộ toàn Cart
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('Website::livewire.products.product-list', [
            'products' => WpProduct::query()
                ->where('is_active', true)
                ->latest()
                ->paginate(12),
        ]);
    }
}
