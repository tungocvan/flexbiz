<?php

namespace Modules\Admin\Livewire\Home;

use Livewire\Component;
use Modules\Admin\Services\HomeSettingService;
use Modules\Website\Models\Product; // Giả định bạn đã có Model Product
use Modules\Website\Models\Category; // Giả định bạn đã có Model Category
use Illuminate\Support\Facades\DB;

class HomeSettings extends Component
{
    // 1. PROPERTIES
    // 1.1. Tab Control
    public $activeTab = 'layout'; // layout, data, trust_badges

    // 1.2. Config Data (Mapped from Service)
    public $layout = [
        'show_hero'         => 'all',
        'show_categories'   => 'all',
        'show_flash_sale'   => 'all',
        'show_featured'     => 'all',
        'show_new_arrivals' => 'all',
        'show_blog'         => 'all',
    ];

    public $data = [
        'category_ids' => [], // Array ID danh mục
        'featured_ids' => [], // Array ID sản phẩm nổi bật
    ];

    public $trust_badges = []; // Array Repeater: [['icon' => '', 'title' => '', 'subtitle' => '']]

    // 1.3. Search & Picker States
    public $productSearchQuery = '';
    public $showProductPicker = false;

    // End 1.

    // 2. LIFECYCLE HOOKS
    public function mount(HomeSettingService $service)
    {
        // Load data từ Service
        $settings = $service->getHomeSettings();

        $this->layout = [
            'show_hero'         => $settings['show_hero'],
            'show_categories'   => $settings['show_categories'],
            'show_flash_sale'   => $settings['show_flash_sale'],
            'show_featured'     => $settings['show_featured'],
            'show_new_arrivals' => $settings['show_new_arrivals'],
            'show_blog'         => $settings['show_blog'],
        ];

        $this->data = [
            'category_ids' => $settings['category_ids'],
            'featured_ids' => $settings['featured_ids'],
        ];

        $this->trust_badges = $settings['trust_badges'] ?: [];

        // Init 1 badge nếu trống
        if (empty($this->trust_badges)) {
            $this->addBadge();
        }
    }

    public function render()
    {
        // Lấy danh mục để fill vào Select
        // Lưu ý: Thay đổi namespace Category theo project thực tế của bạn
        $allCategories = DB::table('categories')->select('id', 'name')->get();

        // Lấy danh sách sản phẩm tìm kiếm (cho Modal Picker)
        $searchProducts = [];
        if ($this->showProductPicker) {
            $query = DB::table('wp_products')->select('id', 'title', 'image', 'regular_price');

            if (!empty($this->productSearchQuery)) {
                $query->where('title', 'like', '%' . $this->productSearchQuery . '%');
            }

            $searchProducts = $query->limit(10)->get();
        }

        // Lấy danh sách sản phẩm ĐÃ CHỌN (để hiển thị preview)
        $selectedProducts = [];
        if (!empty($this->data['featured_ids'])) {
            $selectedProducts = DB::table('wp_products')
                ->whereIn('id', $this->data['featured_ids'])
                ->select('id', 'title', 'image')
                ->get();
        }

        return view('Admin::livewire.home.home-settings', [
            'allCategories' => $allCategories,
            'searchProducts' => $searchProducts,
            'selectedProducts' => $selectedProducts
        ]);
    }
    // End 2.

    // 3. ACTION METHODS

    /**
     * Chuyển Tab
     */
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Trust Badges Repeater Logic
     */
    public function addBadge()
    {
        $this->trust_badges[] = ['icon' => '', 'title' => '', 'subtitle' => ''];
    }

    public function removeBadge($index)
    {
        unset($this->trust_badges[$index]);
        $this->trust_badges = array_values($this->trust_badges); // Re-index array
    }

    /**
     * Product Picker Logic
     */
    public function openProductPicker()
    {
        $this->showProductPicker = true;
        $this->productSearchQuery = ''; // Reset search
    }

    public function toggleProduct($id)
    {
        if (in_array($id, $this->data['featured_ids'])) {
            // Remove
            $this->data['featured_ids'] = array_diff($this->data['featured_ids'], [$id]);
        } else {
            // Add
            $this->data['featured_ids'][] = $id;
        }
        // Re-index để tránh lỗi JSON object khi lưu
        $this->data['featured_ids'] = array_values($this->data['featured_ids']);
    }

    /**
     * SAVE DATA
     */
    public function save(HomeSettingService $service)
    {
        // Merge tất cả data lại để gửi sang Service
        $payload = array_merge(
            [
                'show_hero'         => $this->layout['show_hero'],
                'show_categories'   => $this->layout['show_categories'],
                'show_flash_sale'   => $this->layout['show_flash_sale'],
                'show_featured'     => $this->layout['show_featured'],
                'show_new_arrivals' => $this->layout['show_new_arrivals'],
                'show_blog'         => $this->layout['show_blog'],

                'category_ids'      => $this->data['category_ids'],
                'featured_ids'      => $this->data['featured_ids'],

                'trust_badges'      => $this->trust_badges,
            ]
        );

        $service->updateHomeSettings($payload);

        // Hiển thị Toast thông báo
        $this->dispatch('show-toast', type: 'success', message: 'Cập nhật trang chủ thành công!');
    }
    // End 3.
}
