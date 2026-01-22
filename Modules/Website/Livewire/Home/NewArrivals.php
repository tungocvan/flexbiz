<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;

class NewArrivals extends Component
{
    public Collection $products;

    public function mount(ProductService $service)
    {
        // Lấy 10 sản phẩm mới nhất
        $this->products = $service->getNewArrivals(10);
    }

    // UI Skeleton: Dạng hàng ngang (Horizontal)
    public function placeholder()
    {
        return <<<'blade'
        <div class="mb-16 container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <div class="h-8 bg-gray-200 rounded w-40"></div>
                <div class="h-4 bg-gray-200 rounded w-20"></div>
            </div>
            {{-- Horizontal Scroll Skeleton --}}
            <div class="flex gap-4 overflow-hidden">
                @foreach(range(1, 6) as $i)
                    <div class="min-w-[200px] animate-pulse">
                        <div class="bg-gray-200 rounded-xl aspect-[3/4] mb-3"></div>
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
        return view('Website::livewire.home.new-arrivals');
    }
}
