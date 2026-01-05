<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Số lượng sản phẩm do bạn yêu cầu
        $count = 20;

        // URL ảnh mẫu tượng trưng (Placeholder)
        $imageUrl = 'https://via.placeholder.com/600x600.png?text=Product+Image';

        // Mảng gallery gồm 3 ảnh mẫu tượng trưng
        $gallery = [
            'https://via.placeholder.com/600x600.png?text=Gallery+1',
            'https://via.placeholder.com/600x600.png?text=Gallery+2',
            'https://via.placeholder.com/600x600.png?text=Gallery+3',
        ];

        $categories = Category::all();

        for ($i = 1; $i <= $count; $i++) {
            $title = "Sản phẩm mẫu số " . $i;
            $regularPrice = rand(100, 1000) * 1000; // Giá từ 100k - 1tr

            $product = WpProduct::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . time() . $i,
                'short_description' => 'Mô tả ngắn cho sản phẩm mẫu thứ ' . $i,
                'description' => 'Đây là nội dung mô tả chi tiết sản phẩm mẫu được tạo tự động để kiểm tra giao diện.',
                'regular_price' => $regularPrice,
                'sale_price' => $regularPrice * 0.8, // Giảm giá 20%
                'image' => $imageUrl,
                'gallery' => $gallery, // Tự động convert sang JSON nhờ Cast ở Model
                'tags' => ['Hot', 'New', 'Sale'],
                'is_active' => true,
            ]);

            // Gán ngẫu nhiên vào 1-2 danh mục
            $randomCats = $categories->random(rand(1, 2))->pluck('id');
            $product->categories()->attach($randomCats);
        }
    }
}
