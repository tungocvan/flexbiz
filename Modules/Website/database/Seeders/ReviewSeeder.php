<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Review; // Tạo model này nếu chưa có
use Modules\Website\Models\WpProduct;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Review::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = WpProduct::all();
        $comments = [
            'Sản phẩm quá tuyệt vời, đóng gói cẩn thận!',
            'Giao hàng hơi chậm nhưng chất lượng tốt.',
            'Đúng như mô tả, sẽ ủng hộ shop tiếp.',
            'Vải đẹp, mặc mát, 5 sao nhé!',
            'Màu sắc bên ngoài đẹp hơn trong ảnh.'
        ];

        foreach ($products as $product) {
            // Mỗi sản phẩm tạo 3-5 đánh giá
            for ($i = 0; $i < rand(3, 5); $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => 1, // Admin hoặc random user
                    'rating' => rand(4, 5), // Chủ yếu cho 4-5 sao cho đẹp
                    'comment' => $comments[array_rand($comments)],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
        $this->command->info('✅ ReviewSeeder: Đã tạo đánh giá mẫu.');
    }
}
