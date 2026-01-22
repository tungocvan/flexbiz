<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WpProduct;
use Modules\Website\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Dọn dẹp dữ liệu cũ
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WpProduct::truncate();
        DB::table('category_product')->truncate(); // Giả sử bảng pivot tên này
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lấy IDs danh mục sản phẩm
        $categoryIds = Category::where('type', 'product')->pluck('id')->toArray();
        if (empty($categoryIds)) {
            $this->command->error('❌ Vui lòng chạy CategorySeeder trước!');
            return;
        }

        // Kho ảnh Demo (Unsplash)
        $images = [
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80',
        ];

        // Tạo 30 sản phẩm
        for ($i = 1; $i <= 30; $i++) {
            $price = rand(2, 50) * 100000; // Giá từ 200k - 5tr
            $hasSale = rand(0, 10) > 6; // 40% cơ hội giảm giá
            $salePrice = $hasSale ? $price * 0.8 : 0;

            // LOGIC HẾT HÀNG:
            // Random số lượng từ 0 đến 50.
            // Nếu rơi vào 0 -> Sản phẩm này sẽ hiện HẾT HÀNG trên web.
            $quantity = rand(0, 50) > 5 ? rand(10, 100) : 0;

            // LOGIC GALLERY:
            // Lấy 3-4 ảnh ngẫu nhiên làm thư viện ảnh
            $gallery = [];
            for($j=0; $j<3; $j++) {
                $gallery[] = $images[array_rand($images)];
            }

            $product = WpProduct::create([
                'title' => 'Sản phẩm cao cấp FlexBiz #' . $i,
                'slug' => 'san-pham-cao-cap-flexbiz-' . $i . '-' . Str::random(5),
                'short_description' => 'Chất liệu thoáng mát, thiết kế hiện đại, phù hợp đi làm và đi chơi. Bảo hành 12 tháng.',
                'description' => $this->generateHtmlContent(), // Nội dung HTML dài
                'regular_price' => $price,
                'sale_price' => $salePrice > 0 ? $salePrice : null,
                'quantity' => $quantity, // <--- Cột này quyết định Hết hàng hay Còn hàng
                'image' => $images[array_rand($images)],
                'gallery' => $gallery, // <--- Lưu mảng JSON (Model phải có casts)
                'is_active' => true,
                'is_featured' => rand(0, 1),
                'user_id' => 1,
                'sold_count' => rand(0, 500), // Để test Top Selling
                'views' => rand(100, 5000),
            ]);

            // Gắn danh mục
            $product->categories()->attach($categoryIds[array_rand($categoryIds)]);
        }

        $this->command->info('✅ ProductSeeder: Đã tạo 30 sản phẩm (Bao gồm cả hàng hết kho & Gallery).');
    }

    // Hàm tạo nội dung HTML giả
    private function generateHtmlContent() {
        return '
            <h2>Đặc điểm nổi bật</h2>
            <p>Sản phẩm này được chế tác từ những nguyên liệu tốt nhất, đảm bảo độ bền và tính thẩm mỹ vượt thời gian.</p>
            <ul>
                <li>Chất liệu: 100% Cotton Organic cao cấp.</li>
                <li>Công nghệ dệt: Thoáng khí, thấm hút mồ hôi.</li>
                <li>Thiết kế: Form Regular Fit tôn dáng.</li>
            </ul>
            <h3>Hướng dẫn bảo quản</h3>
            <p>Để sản phẩm luôn bền đẹp, vui lòng giặt tay hoặc giặt máy ở chế độ nhẹ. Không dùng chất tẩy rửa mạnh.</p>
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80" alt="Demo" />
            <p><em>Sản phẩm được phân phối độc quyền bởi FlexBiz Store.</em></p>
        ';
    }
}
