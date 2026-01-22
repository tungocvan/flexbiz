<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;

class TrustBadges extends Component
{
    public array $badges = [];

    public function mount()
    {
        // Dữ liệu tĩnh (Static Data) - Chuẩn Master UI
        $this->badges = [
            [
                'icon' => '<svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>',
                'title' => 'Miễn Phí Vận Chuyển',
                'desc' => 'Cho đơn hàng từ 500k',
            ],
            [
                'icon' => '<svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>',
                'title' => 'Thanh Toán An Toàn',
                'desc' => 'Bảo mật 100% chuẩn SSL',
            ],
            [
                'icon' => '<svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>',
                'title' => 'Đổi Trả Dễ Dàng',
                'desc' => 'Trong vòng 30 ngày',
            ],
            [
                'icon' => '<svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>',
                'title' => 'Hỗ Trợ 24/7',
                'desc' => 'Hotline & Chat trực tuyến',
            ],
        ];
    }

    public function placeholder()
    {
        return <<<'blade'
        <div class="py-12 border-t border-gray-100">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    @foreach(range(1,4) as $i)
                        <div class="flex items-center gap-4 animate-pulse">
                            <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                            <div class="flex-1 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-24"></div>
                                <div class="h-3 bg-gray-200 rounded w-32"></div>
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
        return view('Website::livewire.home.trust-badges');
    }
}
