<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Dọn dẹp bảng cũ theo thứ tự khóa ngoại
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('wp_orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('wp_products');

        // 2. Bảng Products
        Schema::create('wp_products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug')->unique();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Giá cả
            $table->decimal('regular_price', 15, 2)->nullable(); // Nên để 15 số để hỗ trợ tiền VNĐ lớn
            $table->decimal('sale_price', 15, 2)->nullable();

            // Quản lý kho hàng (Cái bạn đang thiếu)
            $table->integer('quantity')->default(0);
            $table->integer('sold_count')->default(0); // Đếm số đã bán (để làm mục Best Sellers)

            // Ảnh
            $table->string('image')->nullable(); // Ảnh đại diện
            $table->json('gallery')->nullable(); // Album ảnh

            // SEO & Phân loại
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false); // Sản phẩm nổi bật

            // Người đăng (Để fix lỗi user relationship trước đó)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Thống kê
            $table->integer('views')->default(0); // Đếm lượt xem

            $table->timestamps();
        });

        // 3. Bảng Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->string('url')->nullable();
            $table->text('icon')->nullable();
            $table->string('can')->nullable();
            $table->string('type')->nullable()->index(); // product, post, etc.

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();
        });

        // 4. Bảng Pivot Category-Product
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('wp_products')
                ->cascadeOnDelete();

            $table->timestamps();
            $table->primary(['category_id', 'product_id']);
        });

        // 5. Bảng Carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // 6. Bảng Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('wp_products')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // 7. Bảng Orders
        Schema::create('wp_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_code')->unique(); // VD: ORD-20231001-001

            // Thông tin khách hàng (Snapshot)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('customer_address');
            $table->text('note')->nullable(); // Ghi chú của khách

            // Tiền tệ
            $table->decimal('subtotal', 15, 2);      // Tổng tiền hàng
            $table->decimal('shipping_fee', 15, 2)->default(0); // <--- MỚI: Phí ship
            $table->decimal('discount', 15, 2)->default(0);     // Giảm giá
            $table->decimal('total', 15, 2);         // Tổng thanh toán

            // Trạng thái
            $table->string('payment_method')->default('cod'); // Sửa 'code' -> 'cod'
            $table->string('status')->default('pending')->index(); // pending, processing, shipping, completed, cancelled

            $table->timestamps();
        });

        // 8. Bảng Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('wp_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('wp_products')->nullOnDelete();

            // Snapshot sản phẩm
            $table->string('product_name');
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->decimal('total', 15, 2); // price * quantity

            $table->json('options')->nullable(); // <--- MỚI: Lưu Size, Màu (JSON)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('wp_orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('wp_products');
    }
};
