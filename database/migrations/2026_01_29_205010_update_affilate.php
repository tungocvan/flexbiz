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

        Schema::create('affiliate_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Vàng, Kim Cương...
            $table->string('slug')->unique();
            $table->decimal('min_revenue_required', 15, 2)->default(0); // Doanh số tối thiểu để đạt cấp
            $table->boolean('is_default')->default(false); // Cấp độ mặc định cho user mới
            $table->timestamps();
        });
        Schema::create('wp_affiliate_schemes', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại liên kết
            $table->foreignId('product_id')->constrained('wp_products')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('affiliate_levels')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Override cho cá nhân

            // Kiểu tính toán
            $table->enum('commission_type', ['percentage', 'fixed', 'hybrid'])->default('percentage');
            
            // Giá trị
            $table->decimal('percent_value', 5, 2)->default(0); // Ví dụ: 10.50 (%)
            $table->decimal('fixed_value', 15, 2)->default(0);  // Ví dụ: 50000 (đ)
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Đảm bảo không trùng lặp cấu hình cho cùng 1 cấp/user trên 1 sản phẩm
            $table->unique(['product_id', 'level_id', 'user_id'], 'unique_scheme_index');
        });
          // Gắn cấp độ cho User
          Schema::table('users', function (Blueprint $table) {
            $table->foreignId('affiliate_level_id')->nullable()->constrained('affiliate_levels')->nullOnDelete();
        });
        // 2. Bổ sung Snapshot hoa hồng vào bảng Chi tiết đơn hàng
        Schema::table('order_items', function (Blueprint $table) {
            // Tỷ lệ % tại thời điểm mua
            $table->decimal('commission_rate', 5, 2)->nullable()->after('total');
            // Số tiền hoa hồng thực tế cho item này
            $table->decimal('commission_amount', 15, 2)->default(0)->after('commission_rate');
            $table->decimal('commission_fixed_amount', 15, 2)->default(0)->after('commission_amount');
            $table->string('affiliate_level_snapshot')->nullable()->after('commission_fixed_amount'); // Lưu tên cấp độ lúc mua
        });       
    } 

    public function down(): void
    {
        Schema::table('wp_products', function (Blueprint $table) {
            $table->dropColumn('affiliate_commission_rate');
        });
        Schema::dropIfExists('affiliate_levels');        
        Schema::dropIfExists('wp_affiliate_schemes');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('affiliate_level_id');
        });       
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'commission_amount','commission_fixed_amount', 'affiliate_level_snapshot']);
        });
        
    }
};