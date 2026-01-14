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
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true)->index();
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

        // 7. Bảng Orders (Tên bảng là wp_orders để tránh trùng keywords)
        Schema::create('wp_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('customer_address');
            $table->text('note')->nullable();

            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->string('payment_method')->default('code');
            $table->string('status')->default('pending')->index();


            $table->timestamps();
        });

        // 8. Bảng Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('wp_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('wp_products')->nullOnDelete();
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
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
