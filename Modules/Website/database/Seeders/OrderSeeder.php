<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Order;
use Modules\Website\Models\OrderItem;
use Modules\Website\Models\WpProduct;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Lấy dữ liệu sản phẩm và user đã seed trước đó
        $products = WpProduct::all();
        $users = User::all();

        if ($products->isEmpty()) {
            $this->command->error('Cần chạy ProductSeeder trước!');
            return;
        }

        // Tạo 20 đơn hàng mẫu
        for ($i = 1; $i <= 20; $i++) {

            // 1. Random Người mua (Có thể là User hoặc Khách vãng lai - null)
            $user = ($i % 3 == 0) ? null : $users->random(); // 30% là khách vãng lai

            // Thông tin khách hàng (Snapshot)
            $customerName = $user ? $user->name : $faker->name;
            $customerEmail = $user ? $user->email : $faker->safeEmail;
            $customerPhone = $faker->phoneNumber;
            $customerAddress = $faker->address;

            // 2. Chọn ngẫu nhiên 1 đến 4 sản phẩm cho đơn hàng này
            $orderItemsData = [];
            $subtotal = 0;

            $randomProducts = $products->random(rand(1, 4));

            foreach ($randomProducts as $product) {
                // Xác định giá bán (Ưu tiên giá sale nếu có)
                $price = $product->sale_price > 0 ? $product->sale_price : $product->regular_price;
                $qty = rand(1, 3);
                $lineTotal = $price * $qty;

                $subtotal += $lineTotal;

                // Chuẩn bị dữ liệu để insert vào order_items sau
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->title, // Snapshot tên
                    'price' => $price,                 // Snapshot giá
                    'quantity' => $qty,
                    'total' => $lineTotal,
                    'options' => json_encode([ // Random options giả
                        'Màu sắc' => $faker->randomElement(['Đen', 'Trắng', 'Xanh', 'Đỏ']),
                        'Size' => $faker->randomElement(['S', 'M', 'L', 'XL'])
                    ]),
                ];
            }

            // 3. Tính toán tổng đơn hàng
            $shippingFee = $subtotal > 2000000 ? 0 : 30000; // Freeship nếu > 2tr
            $discount = rand(0, 1) ? rand(10, 50) * 1000 : 0; // Random giảm giá

            // Đảm bảo không giảm giá quá tổng tiền
            if ($discount > $subtotal) $discount = 0;

            $total = $subtotal + $shippingFee - $discount;

            // 4. Random Trạng thái
            $status = $faker->randomElement(['pending', 'processing', 'shipping', 'completed', 'cancelled']);
            $paymentMethod = $faker->randomElement(['cod', 'bank_transfer', 'vnpay']);

            // 5. Tạo Order (wp_orders)
            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'order_code' => 'ORD-' . strtoupper(Str::random(5)) . $i, // Mã đơn unique
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'customer_email' => $customerEmail,
                'customer_address' => $customerAddress,
                'note' => $faker->sentence,

                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount' => $discount,
                'total' => $total,

                'payment_method' => $paymentMethod,
                'status' => $status,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'), // Random ngày trong tháng qua
            ]);

            // 6. Tạo Order Items (order_items)
            foreach ($orderItemsData as $itemData) {
                // Gán order_id vừa tạo vào item
                $order->items()->create($itemData);
            }
        }
    }
}
