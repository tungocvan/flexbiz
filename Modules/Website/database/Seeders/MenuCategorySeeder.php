<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Category;

class MenuCategorySeeder extends Seeder
{
    //// Chạy lệnh: php artisan db:seed --class="Modules\Website\database\Seeders\MenuCategorySeeder
    public function run()
    {
        // 1. Xóa cũ (chỉ xóa type menu)
        Category::where('type', 'menu')->delete();

        // 2. JSON Dữ liệu chuẩn
        $json = '[
            { "name": "Dashboard", "url": "/admin", "icon": "home", "can": "view_dashboard" },
            { "name": "QUẢN LÝ BÁN HÀNG", "url": null, "can": null }, 
            { 
                "name": "Sản phẩm", "icon": "shopping-bag", "can": "view_product", 
                "children": [
                    { "name": "Tất cả sản phẩm", "url": "/admin/products", "can": "view_product" },
                    { "name": "Danh mục", "url": "/admin/product-categories", "can": "view_category" }
                ]
            },
            { "name": "Đơn hàng", "url": "/admin/orders", "icon": "shopping-cart", "can": "view_order" },
            { "name": "Khách hàng", "url": "/admin/customers", "icon": "users", "can": "view_customer" },
            { "name": "MARKETING & NỘI DUNG", "url": null, "can": null },
            { "name": "Bài viết (Blog)", "url": "/admin/posts", "icon": "document-text", "can": "view_post" },
            { "name": "Mã giảm giá", "url": "/admin/coupons", "icon": "ticket", "can": "view_coupon" },
            { "name": "HỆ THỐNG", "url": null, "can": null },
            { 
                "name": "Phân quyền & Nhân sự", "icon": "shield-check", "can": "view_staff",
                "children": [
                    { "name": "Vai trò (Roles)", "url": "/admin/system/roles", "can": "view_role" },
                    { "name": "Nhân viên (Staff)", "url": "/admin/system/staff", "can": "view_staff" }
                ]
            },
            { "name": "Cấu hình chung", "url": "/admin/settings", "icon": "cog", "can": "view_setting" }
        ]';

        $items = json_decode($json, true);
        $sort = 0;

        foreach ($items as $item) {
            $this->createItem($item, null, $sort++);
        }
    }

    private function createItem($item, $parentId, $sort)
    {
        $cat = Category::create([
            'name' => $item['name'],
            'url' => $item['url'] ?? null,
            'icon' => $item['icon'] ?? null,
            'can' => $item['can'] ?? null,
            'type' => 'menu', // QUAN TRỌNG: Đánh dấu là menu
            'parent_id' => $parentId,
            'sort_order' => $sort,
            'is_active' => true,
        ]);

        if (!empty($item['children'])) {
            $childSort = 0;
            foreach ($item['children'] as $child) {
                $this->createItem($child, $cat->id, $childSort++);
            }
        }
    }
}