<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dọn dẹp dữ liệu cũ (Tắt check khóa ngoại để xóa không lỗi)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::where('type', 'product')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🧹 Đã dọn dẹp danh mục cũ.');

        // 2. Danh sách 8 Danh mục với ảnh Demo đẹp (Unsplash)
        $categories = [
            [
                'name' => 'Thời Trang Nam',
                'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Thời Trang Nữ',
                'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Giày Sneaker',
                'image' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Phụ Kiện & Đồng Hồ',
                'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Túi Xách & Balo',
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Công Nghệ',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Mỹ Phẩm',
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
            [
                'name' => 'Thể Thao',
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=400&q=80',
                'icon' => null
            ],
        ];

        foreach ($categories as $index => $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'type' => 'product',
                'image' => $cat['image'],
                'is_active' => true,
                'sort_order' => $index + 1,
                'parent_id' => null
            ]);
        }

        $this->command->info('✅ Đã tạo 8 danh mục mẫu thành công!');
    }
}
