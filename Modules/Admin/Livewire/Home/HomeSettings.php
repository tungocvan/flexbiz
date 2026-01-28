<?php

namespace Modules\Admin\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Setting; // Import Model Setting
use Modules\Website\Models\Category;
use Modules\Website\Models\Product;
use Livewire\WithFileUploads;

class HomeSettings extends Component
{
    use WithFileUploads;
    // 1. PROPERTIES
    public $activeTab = 'layout'; // layout, data, trust_badges

    // Cấu hình hiển thị (Bật/Tắt các khối)
    public $layout = [
        'show_hero'         => 'all',
        'show_categories'   => 'all',
        'show_flash_sale'   => 'all',
        'show_featured'     => 'all',
        'show_new_arrivals' => 'all',
        'show_blog_highlight'  => 'all',
        'show_best_sellers' => 'all', // Thêm best sellers
        'show_promo_banner' => 'all', // Thêm promo banner
        'show_trust_badges' => 'all',
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

    public $newArrivalsCount = 10;
    public $bestSellersCount = 8;
    public $newPromoImage;

    // 1. Khai báo biến cấu hình Blog
    public $blogCount = 3; // Mặc định hiển thị 3 bài

    // 🟡 BIẾN MỚI CHO PROMO BANNER
    public $promoBanner = [
        'show' => true,
        'image' => '',
        'title' => '',
        'sub_title' => '',
        'btn_text' => 'Mua Ngay',
        'link' => '#',
        'details_link' => '',
    ];

    // 🟡 1. THÊM BIẾN CẤU HÌNH NEWSLETTER
    public $newsletter = [
        'show' => true,
        'badge' => 'Tham gia cộng đồng',
        'title' => 'Mở khóa ưu đãi <span class="text-blue-400">10%</span> cho đơn hàng đầu tiên.',
        'description' => 'Đăng ký để nhận tin tức về bộ sưu tập mới, mẹo phối đồ và các ưu đãi độc quyền chỉ dành cho thành viên.',
    ];
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
        // 1. LOAD NEW ARRIVALS COUNT
        $count = Setting::where('key', 'home_new_arrivals_count')->value('value');
        if ($count) {
            $this->newArrivalsCount = (int) $count;
        }

        // 1. LOAD BEST SELLERS COUNT
        $bsCount = Setting::where('key', 'home_best_sellers_count')->value('value');
        if ($bsCount) $this->bestSellersCount = (int) $bsCount;

        // 1. LOAD PROMO BANNER CONFIG
        $promoSettings = Setting::where('key', 'home_promo_banner')->value('value');
        if ($promoSettings) {
            // Merge với mảng mặc định để tránh lỗi thiếu key
            $this->promoBanner = array_merge($this->promoBanner, json_decode($promoSettings, true));
        }

        // 2. Load Blog Count
        $this->blogCount = (int) Setting::where('key', 'home_blog_count')->value('value') ?: 3;

        // 🟡 2. LOAD NEWSLETTER
        $newsletterSettings = Setting::where('key', 'home_newsletter')->value('value');
        if ($newsletterSettings) {
            $this->newsletter = array_merge($this->newsletter, json_decode($newsletterSettings, true));
        }

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
        // --- XỬ LÝ UPLOAD ẢNH PROMO BANNER ---
        if ($this->newPromoImage) {
            // 1. Validate
            $this->validate([
                'newPromoImage' => 'image|max:3072', // Max 3MB
            ]);

            // 2. Lưu ảnh vào folder 'banners' trong disk 'public'
            // Kết quả trả về: banners/ten-file-hash.jpg
            $path = $this->newPromoImage->store('banners', 'public');

            // 3. Cập nhật đường dẫn mới vào mảng settings
            $this->promoBanner['image'] = $path;

            // 4. Reset biến tạm (để UI không hiện ảnh preview nữa)
            $this->newPromoImage = null;
        }
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

        // 2. LƯU NEW ARRIVALS COUNT
        Setting::updateOrCreate(
            ['key' => 'home_new_arrivals_count'],
            ['value' => $this->newArrivalsCount]
        );

        // 2. LƯU BEST SELLERS COUNT
        Setting::updateOrCreate(
            ['key' => 'home_best_sellers_count'],
            ['value' => $this->bestSellersCount]
        );

        // 2. SAVE PROMO BANNER CONFIG
        Setting::updateOrCreate(
            ['key' => 'home_promo_banner'],
            ['value' => json_encode($this->promoBanner)]
        );

        // 3. Lưu Blog Count
        Setting::updateOrCreate(['key' => 'home_blog_count'], ['value' => $this->blogCount]);

        // 🟡 3. LƯU NEWSLETTER
        Setting::updateOrCreate(
            ['key' => 'home_newsletter'],
            ['value' => json_encode($this->newsletter)]
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
