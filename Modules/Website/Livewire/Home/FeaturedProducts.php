<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\ProductService;
use Modules\Website\Models\Cart;
use Modules\Website\Models\CartItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

class FeaturedProducts extends Component
{
    public Collection $products;

    public function mount(ProductService $service)
    {
        $this->products = $service->getFeaturedProducts(8); // Lấy 8 sản phẩm (2 hàng trên desktop)
    }

    // Logic thêm vào giỏ hàng (Copy từ ProductList sang hoặc dùng Service/Trait chung)
    public function addToCart($productId)
    {
        // 1. Logic thêm giỏ hàng (Tối giản cho Home)
        // ... (Bạn có thể tái sử dụng logic từ ProductList đã gửi trước đó)
        // Hoặc đơn giản là emit sự kiện để Global Cart xử lý
        $this->dispatch('add-to-cart', productId: $productId);

        // Show thông báo nhanh
        $this->dispatch('cart-updated');
    }

    // UI Skeleton: Hiển thị khi đang tải (Lazy Load)
    public function placeholder()
    {
        return <<<'blade'
        <div class="mb-16 container mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <div class="h-8 bg-gray-200 rounded w-48"></div>
                <div class="h-4 bg-gray-200 rounded w-24"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach(range(1, 10) as $i)
                    <div class="animate-pulse">
                        <div class="bg-gray-200 rounded-xl aspect-[3/4] mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                @endforeach
            </div>
        </div>
        blade;
    }

    public function render()
    {
        return view('Website::livewire.home.featured-products');
    }
}
