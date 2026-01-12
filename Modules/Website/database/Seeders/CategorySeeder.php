<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách danh mục mẫu
        $categories = [
            'Điện thoại thông minh',
            'Laptop văn phòng',
            'PC Gaming',
            'Tai nghe & Âm thanh',
            'Đồng hồ thông minh',
            'Phụ kiện điện tử'
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'type' => 'product', // Loại danh mục
                'is_active' => true,
                'sort_order' => $index,
                'description' => "Danh mục chuyên về $name chính hãng, giá tốt."
            ]);
        }
    }
}
