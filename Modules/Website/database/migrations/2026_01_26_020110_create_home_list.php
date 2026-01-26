<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. KHOI_TAO_BANG_BANNERS
        Schema::create('wp_banners', function (Blueprint $table) {
            $table->id();

            // 1.1. Thong tin co ban
            $table->string('title')->nullable()->comment('Tiêu đề banner (để quản lý)');
            $table->string('image_desktop')->comment('Đường dẫn ảnh Desktop');
            $table->string('image_mobile')->nullable()->comment('Đường dẫn ảnh Mobile (nếu có)');
            $table->string('link')->nullable()->comment('Link khi click vào banner');

            // 1.2. Vi tri va Sap xep
            // Enum position giúp ta tái sử dụng bảng này cho nhiều chỗ khác nhau trên trang chủ
            $table->string('position')->default('hero')->index()->comment('Vị trí: hero, promo_1, promo_2...');
            $table->integer('order')->default(0)->comment('Số thứ tự hiển thị (nhỏ xếp trước)');

            // 1.3. Trang thai
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
        // End 1.
        // 1. KHOI_TAO_BANG_FLASH_SALES (CHA)
        Schema::create('wp_flash_sales', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Tên chương trình (vd: Sale 9.9)');
            $table->dateTime('start_time')->comment('Thời gian bắt đầu');
            $table->dateTime('end_time')->comment('Thời gian kết thúc');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
        // End 1.

        // 2. KHOI_TAO_BANG_FLASH_SALE_ITEMS (CON)
        Schema::create('wp_flash_sale_items', function (Blueprint $table) {
            $table->id();

            // 2.1. Khoa ngoai den bang cha (Flash Sale)
            $table->foreignId('flash_sale_id')->constrained('wp_flash_sales')->onDelete('cascade');

            // 2.2. Khoa ngoai den bang Products (UPDATE: Trỏ vào wp_products)
            $table->foreignId('product_id')->constrained('wp_products')->onDelete('cascade');

            // 2.3. Thong tin ban hang
            $table->decimal('price', 15, 2)->comment('Giá sale cố định');
            $table->integer('quantity')->default(0)->comment('Số suất sale');
            $table->integer('sold')->default(0)->comment('Số lượng đã bán');

            // Index composite để query nhanh & đảm bảo 1 sản phẩm chỉ xuất hiện 1 lần trong 1 đợt sale
            $table->unique(['flash_sale_id', 'product_id'], 'unique_flash_product');
        });
    }

    public function down(): void
    {
        // 2. XOA_BANG_BANNERS
        Schema::dropIfExists('wp_banners');
        Schema::dropIfExists('wp_flash_sale_items');
        Schema::dropIfExists('wp_flash_sales');
        // End 2.
    }
};
