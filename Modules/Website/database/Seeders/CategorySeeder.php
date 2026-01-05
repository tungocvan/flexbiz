<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Điện thoại', 'Máy tính bảng', 'Phụ kiện', 'Âm thanh', 'Đồng hồ'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'type' => 'product',
                'is_active' => true,
                'sort_order' => 0
            ]);
        }
    }
}
