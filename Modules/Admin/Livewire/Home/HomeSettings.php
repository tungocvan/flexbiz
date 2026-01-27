<?php

namespace Modules\Admin\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Setting; // Import Model Setting
use Modules\Website\Models\Category;
use Modules\Website\Models\Product;

class HomeSettings extends Component
{
    // 1. PROPERTIES
    public $activeTab = 'layout'; // layout, data, trust_badges

    // Cấu hình hiển thị (Bật/Tắt các khối)
    public $layout = [
        'show_hero'         => 'all',
        'show_categories'   => 'all',
        'show_flash_sale'   => 'all',
        'show_featured'     => 'all',
        'show_new_arrivals' => 'all',
        'show_blog'         => 'all',
    ];

    // Dữ liệu chính (Lưu tất cả vào đây để wire:model cho gọn)
    public $data = [
        'category_ids' => [], // Mảng ID danh mục
        'featured_ids' => [], // Mảng ID sản phẩm nổi bật
        'trust_badges' => [], // Mảng Repeater: [['icon' => '', 'title' => '', ...]]
    ];

    // Search & Picker States
    public $productSearchQuery = '';
    public $showProductPicker = false;

    // 2. LIFECYCLE HOOKS
    public function mount()
    {
        // 2.1. LOAD LAYOUT SETTINGS
        // Lấy các key bắt đầu bằng 'show_'
        $settings = Setting::where('key', 'like', 'show_%')->pluck('value', 'key')->toArray();
        $this->layout = array_merge($this->layout, $settings);

        // 2.2. LOAD DATA IDs (JSON -> Array)
        $catIds = Setting::where('key', 'home_category_ids')->value('value');
        $this->data['category_ids'] = $catIds ? json_decode($catIds, true) : [];

        $featIds = Setting::where('key', 'home_featured_ids')->value('value');
        $this->data['featured_ids'] = $featIds ? json_decode($featIds, true) : [];

        // 2.3. LOAD TRUST BADGES (Quan trọng: Decode JSON)
        $badgesJson = Setting::where('key', 'home_trust_badges')->value('value');

        if ($badgesJson) {
            $this->data['trust_badges'] = json_decode($badgesJson, true);
        } else {
            // Nếu chưa có thì khởi tạo mảng rỗng
            $this->data['trust_badges'] = [];
        }
    }

    public function render()
    {
        // 1. Lấy danh mục (Dùng DB query cho nhẹ hoặc Model nếu cần quan hệ)

        $allCategories = DB::table('categories')->select('id', 'name')->get();

        // 2. Lấy danh sách sản phẩm tìm kiếm (cho Modal Picker)
        $searchProducts = [];
        if ($this->showProductPicker) {
            $query = DB::table('wp_products')->select('id', 'title', 'image', 'regular_price');
            if (!empty($this->productSearchQuery)) {
                $query->where('title', 'like', '%' . $this->productSearchQuery . '%');
            }
            $searchProducts = $query->limit(10)->get();
        }

        // 3. Lấy danh sách sản phẩm ĐÃ CHỌN (để hiển thị preview)
        $selectedProducts = [];
        if (!empty($this->data['featured_ids'])) {
            // Dùng whereIn và FIELD để giữ đúng thứ tự đã chọn
            $idsStr = implode(',', $this->data['featured_ids']);
            if($idsStr) {
                $selectedProducts = DB::table('wp_products')
                    ->whereIn('id', $this->data['featured_ids'])
                    ->orderByRaw("FIELD(id, $idsStr)")
                    ->select('id', 'title', 'image')
                    ->get();
            }
        }

        return view('Admin::livewire.home.home-settings', [
            'allCategories'    => $allCategories,
            'searchProducts'   => $searchProducts,
            'selectedProducts' => $selectedProducts
        ]);
    }

    // 3. ACTION METHODS

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- TRUST BADGES REPEATER ---

    public function addBadge()
    {
        $this->data['trust_badges'][] = [
            'icon'      => 'fa-solid fa-check',
            'title'     => '',
            'sub_title' => ''
        ];
    }

    public function removeBadge($index)
    {
        unset($this->data['trust_badges'][$index]);
        // Re-index mảng để tránh lỗi khi encode JSON
        $this->data['trust_badges'] = array_values($this->data['trust_badges']);
    }

    // --- PRODUCT PICKER ---

    public function openProductPicker()
    {
        $this->showProductPicker = true;
        $this->productSearchQuery = '';
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
        // Re-index
        $this->data['featured_ids'] = array_values($this->data['featured_ids']);
    }

    // --- SAVE DATA (CORE LOGIC) ---

    public function save()
    {
        // 1. Lưu cấu hình Layout (Show/Hide)
        foreach ($this->layout as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Lưu Data IDs (Encode Array -> JSON String)
        Setting::updateOrCreate(
            ['key' => 'home_category_ids'],
            ['value' => json_encode($this->data['category_ids'])]
        );

        Setting::updateOrCreate(
            ['key' => 'home_featured_ids'],
            ['value' => json_encode($this->data['featured_ids'])]
        );

        // 3. Lưu Trust Badges (Xử lý kỹ phần này)
        if (isset($this->data['trust_badges']) && is_array($this->data['trust_badges'])) {
            // Lọc bỏ các item rỗng title để tránh rác
            $cleanBadges = array_filter($this->data['trust_badges'], function($item) {
                return !empty($item['title']);
            });

            Setting::updateOrCreate(
                ['key' => 'home_trust_badges'],
                ['value' => json_encode(array_values($cleanBadges))] // array_values để reset key về 0,1,2...
            );
        }

        // 4. Thông báo
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Đã lưu cấu hình thành công!'
        ]);

        // Nếu bạn dùng Toast library khác thì đổi dòng trên, ví dụ:
        // session()->flash('success', 'Đã lưu thành công');
    }
}
