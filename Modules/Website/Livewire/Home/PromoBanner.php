<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Services\MarketingService;

class PromoBanner extends Component
{
    public array $banner = [];

    public function mount(MarketingService $service)
    {
        $this->banner = $service->getPromoBanner();
    }

    // UI Skeleton: Hiển thị khi đang tải
    public function placeholder()
    {
        return <<<'blade'
        <div class="mb-16 w-full aspect-[21/9] md:aspect-[3/1] bg-gray-200 rounded-2xl animate-pulse flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        blade;
    }

    public function render()
    {
        if (empty($this->banner['image'])) {
            return <<<'blade'
                <div></div>
            blade;
        }

        return view('Website::livewire.home.promo-banner');
    }
}
