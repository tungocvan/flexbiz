<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\ProductService;
use Modules\Website\Services\MarketingService;
use Illuminate\Database\Eloquent\Collection;

class FlashSale extends Component
{
    public Collection $products;
    public array $config;

    public function mount(ProductService $productService, MarketingService $marketingService)
    {
        $this->config = $marketingService->getFlashSaleConfig();

        // Chỉ query sản phẩm nếu chương trình còn active
        if ($this->config['is_active']) {
            $this->products = $productService->getFlashSaleProducts(6);
        } else {
            $this->products = new Collection(); // Rỗng
        }
    }

    // UI Khung xương (Skeleton) hiển thị trong lúc chờ tải dữ liệu
    public function placeholder()
    {
        return <<<'blade'
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6 mb-8 animate-pulse">
            <div class="flex items-center justify-between mb-6">
                <div class="h-8 bg-gray-200 rounded w-1/3"></div>
                <div class="h-4 bg-gray-200 rounded w-20"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @foreach(range(1, 6) as $i)
                    <div class="bg-gray-100 rounded-lg aspect-square"></div>
                @endforeach
            </div>
        </div>
        blade;
    }

    public function render()
    {
        // Nếu hết giờ hoặc không có sản phẩm -> Ẩn block
        if (!$this->config['is_active'] || $this->products->isEmpty()) {
            return <<<'blade'
                <div></div>
            blade;
        }

        return view('Website::livewire.home.flash-sale');
    }
}
