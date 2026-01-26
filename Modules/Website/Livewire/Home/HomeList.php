<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Admin\Services\HomeSettingService;

class HomeList extends Component
{
    public $settings = [];

    public function mount(HomeSettingService $service)
    {
        // 1. Lấy toàn bộ cấu hình từ Admin (đã cache hoặc query nhẹ)
        $this->settings = $service->getHomeSettings();
    }

    /**
     * Helper chuyển đổi trạng thái config sang class Tailwind
     */
    public function getVisibilityClass($key)
    {
        $state = $this->settings[$key] ?? 'all';

        return match ($state) {
            'desktop' => 'hidden md:block', // Ẩn mobile, hiện từ tablet/pc trở lên
            'mobile'  => 'block md:hidden', // Hiện mobile, ẩn từ tablet/pc trở lên
            'none'    => 'hidden',          // Ẩn hoàn toàn
            default   => 'block'            // Hiện tất cả ('all')
        };
    }

    public function render()
    {
        return view('Website::livewire.home.home-list');
    }
}
