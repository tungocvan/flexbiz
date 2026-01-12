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
        $count = 20; // Số lượng sản phẩm mẫu

        // Ảnh placeholder để test giao diện
        $imageUrl = 'https://placehold.co/600x600/png?text=Product+Img';

        $gallery = [
            'https://placehold.co/600x600/png?text=Gallery+1',
            'https://placehold.co/600x600/png?text=Gallery+2',
            'https://placehold.co/600x600/png?text=Gallery+3',
        ];

        // Lấy danh sách ID danh mục để random
        $categoryIds = Category::pluck('id');

        if ($categoryIds->isEmpty()) {
            $this->command->error('Vui lòng chạy CategorySeeder trước!');
            return;
        }

        for ($i = 1; $i <= $count; $i++) {
            $title = "Sản phẩm Demo " . $i;
            $regularPrice = rand(100, 5000) * 1000; // 100k -> 5tr

            // 50% sản phẩm có giá khuyến mãi
            $salePrice = ($i % 2 == 0) ? $regularPrice * 0.8 : null;

            $product = WpProduct::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . time() . '-' . $i,
                'short_description' => "Mô tả ngắn gọn cho sản phẩm $title. Sản phẩm chất lượng cao.",
                'description' => "<h2>Chi tiết sản phẩm $title</h2><p>Đây là nội dung mô tả chi tiết mẫu. Được tạo tự động để test giao diện Frontend.</p><ul><li>Tính năng 1</li><li>Tính năng 2</li></ul>",
                'regular_price' => $regularPrice,
                'sale_price' => $salePrice,
                'image' => $imageUrl,
                'gallery' => $gallery, // Tự động cast sang JSON
                'tags' => ['Hot', 'New', 'Best Seller'],
                'is_active' => true,
            ]);

            // Gán sản phẩm vào 1-2 danh mục ngẫu nhiên
            $randomCats = $categoryIds->random(rand(1, 2));
            $product->categories()->attach($randomCats);
        }
    }
}
