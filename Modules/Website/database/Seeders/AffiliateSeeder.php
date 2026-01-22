<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class AffiliateSeeder extends Seeder
{
    public function run()
    {
        // 1. Tạo 1 User mẫu để test Affiliate (Nếu chưa có)
        // Login bằng: affiliate@demo.com / password
        // $affiliateUser = User::firstOrCreate(
        //     ['email' => 'affiliate@demo.com'],
        //     [
        //         'name' => 'Demo Affiliate Partner',
        //         'password' => bcrypt('password'), // Mật khẩu mặc định
        //     ]
        // );
        $affiliateUser = User::where('email', 'tungocvan@gmail.com')->first();

        $this->command->info('👤 User Affiliate mẫu: affiliate@demo.com (ID: ' . $affiliateUser->id . ')');

        // 2. Tạo 10 đơn hàng được giới thiệu bởi User này
        $statuses = ['pending', 'approved', 'rejected'];

        for ($i = 1; $i <= 10; $i++) {
            $total = rand(5, 50) * 100000; // Đơn hàng từ 500k - 5tr
            $commission = $total * 0.10;   // Hoa hồng 10%
            $status = $statuses[array_rand($statuses)]; // Random trạng thái

            Order::create([
                'user_id'           => null, // Khách vãng lai
                'affiliate_id'      => $affiliateUser->id, // <--- Gán cho Affiliate User
                'commission_status' => $status,
                'commission_amount' => $commission,
                
                'order_code'        => 'ORD-AFF-' . Str::upper(Str::random(6)),
                'customer_name'     => 'Khách hàng #' . $i,
                'customer_phone'    => '09000000' . $i,
                'customer_email'    => 'guest' . $i . '@gmail.com',
                'customer_address'  => '123 Đường Demo, TP.HCM',
                
                'subtotal'          => $total,
                'total'             => $total,
                'status'            => 'completed',
                'payment_method'    => 'cod',
            ]);
        }

        $this->command->info('✅ Đã tạo 10 đơn hàng mẫu cho Affiliate ID: ' . $affiliateUser->id);
    }
}