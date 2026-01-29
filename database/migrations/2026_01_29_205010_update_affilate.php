<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Bổ sung cấu hình % hoa hồng vào bảng Sản phẩm
        Schema::table('wp_products', function (Blueprint $table) {
            // Tỷ lệ hoa hồng riêng cho sản phẩm này (null = dùng mặc định hệ thống)
            $table->decimal('affiliate_commission_rate', 5, 2)->nullable()->after('views');
        });

        // 2. Bổ sung Snapshot hoa hồng vào bảng Chi tiết đơn hàng
        Schema::table('order_items', function (Blueprint $table) {
            // Tỷ lệ % tại thời điểm mua
            $table->decimal('commission_rate', 5, 2)->nullable()->after('total');
            // Số tiền hoa hồng thực tế cho item này
            $table->decimal('commission_amount', 15, 2)->default(0)->after('commission_rate');
        });
    } 

    public function down(): void
    {
        Schema::table('wp_products', function (Blueprint $table) {
            $table->dropColumn('affiliate_commission_rate');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'commission_amount']);
        });
    }
};