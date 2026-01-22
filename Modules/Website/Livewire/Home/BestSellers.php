<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;

class BestSellers extends Component
{
    public Collection $products;

    public function mount(ProductService $service)
    {
        // Lấy Top 5 hoặc 10 sản phẩm bán chạy nhất
        $this->products = $service->getBestSellingProducts(5);
    }

    // UI Skeleton: Mô phỏng Bảng xếp hạng
    public function placeholder()
    {
        return <<<'blade'
        <div class="mb-20 container mx-auto px-4">
            <div class="h-8 bg-gray-200 rounded w-48 mb-8 mx-auto"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                {{-- Top 1 to (bên trái) --}}
                <div class="md:col-span-2 lg:col-span-2 bg-gray-200 rounded-xl aspect-square animate-pulse"></div>
                {{-- List Top 2-4 (bên phải) --}}
                <div class="md:col-span-2 lg:col-span-3 grid grid-cols-1 gap-4">
                    @foreach(range(1, 3) as $i)
                        <div class="flex gap-4 p-4 border border-gray-100 rounded-xl">
                            <div class="w-24 h-24 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1 space-y-2 py-2">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        blade;
    }

    public function render()
    {
        return view('Website::livewire.home.best-sellers');
    }
}
