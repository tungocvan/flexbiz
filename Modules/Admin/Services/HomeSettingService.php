<?php

namespace Modules\Admin\Services;

use Modules\Admin\Models\Setting;
use Illuminate\Support\Facades\Cache;

class HomeSettingService
{
    // 5. KHOI_TAO_SERVICE_HOMEPAGE

    /**
     * Lấy toàn bộ cấu hình trang chủ để hiển thị lên Form Admin
     * Hoặc trả về cho Frontend
     */
    public function getHomeSettings()
    {
        $settings = Setting::where('group_name', 'homepage')->get()->keyBy('key');

        return [
            // 1. UPDATE_LOGIC_HIEN_THI (Thay vì bool, ta lấy string mặc định là 'all')
            'show_hero'         => $settings['home_show_hero']->value ?? 'all',
            'show_categories'   => $settings['home_show_categories']->value ?? 'all',
            'show_flash_sale'   => $settings['home_show_flash_sale']->value ?? 'all',
            'show_featured'     => $settings['home_show_featured']->value ?? 'all',
            'show_new_arrivals' => $settings['home_show_new_arrivals']->value ?? 'all',
            'show_blog'         => $settings['home_show_blog']->value ?? 'all',
            // End 1.

            'category_ids'      => $this->parseJson($settings['home_category_ids'] ?? null),
            'featured_ids'      => $this->parseJson($settings['home_featured_ids'] ?? null),
            'trust_badges'      => $this->parseJson($settings['home_trust_badges'] ?? null),
        ];
    }

    /**
     * Lưu cấu hình từ Admin Form gửi xuống
     */
    public function updateHomeSettings(array $data)
    {
        foreach ($data as $key => $value) {
            $type = 'text';
            if (is_array($value)) {
                $value = json_encode($value);
                $type = 'json';
            }
            // 2. BO_LOGIC_BOOL (Vì layout giờ là string: 'all', 'desktop'...)
            // elseif (is_bool($value)) { ... } -> Xóa đoạn này đi
            // End 2.

            Setting::updateOrCreate(
                ['key' => 'home_' . $key],
                [
                    'value' => $value,
                    'group_name' => 'homepage',
                    'type' => $type
                ]
            );
        }
        Cache::forget('homepage_settings');
    }

    // --- Helpers ---

    private function parseBool($setting, $default = false)
    {
        if (!$setting) return $default;
        return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
    }

    private function parseJson($setting, $default = [])
    {
        if (!$setting || empty($setting->value)) return $default;
        $data = json_decode($setting->value, true);
        return is_array($data) ? $data : $default;
    }
    // End 5.
}
