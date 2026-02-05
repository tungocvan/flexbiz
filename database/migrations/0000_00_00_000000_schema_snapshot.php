<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_levels', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('slug', 255);
                $table->string('min_revenue_required')->default('0.00');
                $table->integer('is_default')->default('0');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['slug'], 'affiliate_levels_slug_unique');
        });
        
        Schema::create('cache', function (Blueprint $table) {
                $table->string('key', 255);
                $table->string('value');
                $table->integer('expiration');
        });
        
        Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key', 255);
                $table->string('owner', 255);
                $table->integer('expiration');
        });
        
        Schema::create('cart_items', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('cart_id');
                $table->bigInteger('product_id')->nullable();
                $table->string('price');
                $table->integer('quantity');
                $table->string('total');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['cart_id'], 'cart_items_cart_id_foreign');
                $table->index(['product_id'], 'cart_items_product_id_foreign');
        });
        
        Schema::create('carts', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('session_id', 255);
                $table->bigInteger('user_id')->nullable();
                $table->bigInteger('coupon_id')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['user_id'], 'carts_user_id_foreign');
                $table->index(['coupon_id'], 'carts_coupon_id_foreign');
                $table->index(['session_id'], 'carts_session_id_index');
        });
        
        Schema::create('categories', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('slug', 255)->nullable();
                $table->string('url', 255)->nullable();
                $table->text('icon')->nullable();
                $table->string('can', 255)->nullable();
                $table->string('type', 255)->nullable();
                $table->bigInteger('parent_id')->nullable();
                $table->text('description')->nullable();
                $table->string('image', 255)->nullable();
                $table->integer('is_active')->default('1');
                $table->integer('sort_order')->default('0');
                $table->string('meta_title', 255)->nullable();
                $table->string('meta_description', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['slug'], 'categories_slug_unique');
                $table->index(['parent_id'], 'categories_parent_id_foreign');
                $table->index(['type'], 'categories_type_index');
                $table->index(['is_active'], 'categories_is_active_index');
        });
        
        Schema::create('category_post', function (Blueprint $table) {
                $table->bigInteger('category_id');
                $table->bigInteger('post_id');
                $table->index(['post_id'], 'category_post_post_id_foreign');
        });
        
        Schema::create('category_product', function (Blueprint $table) {
                $table->bigInteger('category_id');
                $table->bigInteger('product_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['product_id'], 'category_product_product_id_foreign');
        });
        
        Schema::create('chat_messages', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('chat_session_id');
                $table->bigInteger('sender_id')->nullable();
                $table->string('sender_type');
                $table->text('message');
                $table->integer('is_read')->default('0');
                $table->string('metadata')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['chat_session_id'], 'chat_messages_chat_session_id_foreign');
                $table->index(['sender_id'], 'chat_messages_sender_id_index');
                $table->index(['sender_type'], 'chat_messages_sender_type_index');
                $table->index(['is_read'], 'chat_messages_is_read_index');
        });
        
        Schema::create('chat_sessions', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('session_token', 255);
                $table->bigInteger('user_id')->nullable();
                $table->bigInteger('admin_id')->nullable();
                $table->string('guest_name', 255)->nullable();
                $table->string('guest_phone', 255)->nullable();
                $table->string('guest_email', 255)->nullable();
                $table->string('status')->default('open');
                $table->timestamp('last_message_at')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['session_token'], 'chat_sessions_session_token_unique');
                $table->index(['user_id'], 'chat_sessions_user_id_foreign');
                $table->index(['admin_id'], 'chat_sessions_admin_id_foreign');
                $table->index(['status'], 'chat_sessions_status_index');
                $table->index(['last_message_at'], 'chat_sessions_last_message_at_index');
        });
        
        Schema::create('coupons', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('code', 255);
                $table->string('description', 255)->nullable();
                $table->string('type')->default('fixed');
                $table->string('value');
                $table->string('min_order_value')->default('0.00');
                $table->integer('usage_limit')->nullable();
                $table->integer('usage_count')->default('0');
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['code'], 'coupons_code_unique');
        });
        
        Schema::create('failed_jobs', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('uuid', 255);
                $table->text('connection');
                $table->text('queue');
                $table->string('payload');
                $table->string('exception');
                $table->timestamp('failed_at')->default('CURRENT_TIMESTAMP');
                $table->unique(['uuid'], 'failed_jobs_uuid_unique');
        });
        
        Schema::create('footer_columns', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->integer('sort_order')->default('0');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['slug'], 'footer_columns_slug_unique');
        });
        
        Schema::create('footer_links', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('footer_column_id');
                $table->string('label', 255);
                $table->string('url', 255)->nullable();
                $table->string('route_name', 255)->nullable();
                $table->integer('new_tab')->default('0');
                $table->integer('sort_order')->default('0');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['footer_column_id'], 'footer_links_footer_column_id_foreign');
        });
        
        Schema::create('header_menu_items', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('header_menu_id');
                $table->bigInteger('parent_id')->nullable();
                $table->string('title', 255);
                $table->string('url', 255)->nullable();
                $table->string('route_name', 255)->nullable();
                $table->string('params')->nullable();
                $table->string('icon', 255)->nullable();
                $table->string('target', 255)->default('_self');
                $table->integer('sort_order')->default('0');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['header_menu_id'], 'header_menu_items_header_menu_id_foreign');
                $table->index(['parent_id'], 'header_menu_items_parent_id_foreign');
        });
        
        Schema::create('header_menus', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('location', 255);
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['location'], 'header_menus_location_unique');
        });
        
        Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id', 255);
                $table->string('name', 255);
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->string('failed_job_ids');
                $table->string('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
        });
        
        Schema::create('jobs', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('queue', 255);
                $table->string('payload');
                $table->integer('attempts');
                $table->integer('reserved_at')->nullable();
                $table->integer('available_at');
                $table->integer('created_at');
                $table->index(['queue'], 'jobs_queue_index');
        });
        
        Schema::create('migrations', function (Blueprint $table) {
                $table->integer('id');
                $table->string('migration', 255);
                $table->integer('batch');
        });
        
        Schema::create('model_has_permissions', function (Blueprint $table) {
                $table->bigInteger('permission_id');
                $table->string('model_type', 255);
                $table->bigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');
        });
        
        Schema::create('model_has_roles', function (Blueprint $table) {
                $table->bigInteger('role_id');
                $table->string('model_type', 255);
                $table->bigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
        });
        
        Schema::create('newsletters', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('email', 255);
                $table->integer('is_subscribed')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['email'], 'newsletters_email_unique');
        });
        
        Schema::create('order_histories', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('order_id');
                $table->bigInteger('user_id')->nullable();
                $table->string('action', 255);
                $table->string('description', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['order_id'], 'order_histories_order_id_foreign');
        });
        
        Schema::create('order_items', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('order_id');
                $table->bigInteger('product_id')->nullable();
                $table->string('product_name', 255);
                $table->string('price');
                $table->integer('quantity');
                $table->string('total');
                $table->string('commission_rate')->nullable();
                $table->string('commission_amount')->default('0.00');
                $table->string('commission_fixed_amount')->default('0.00');
                $table->string('affiliate_level_snapshot', 255)->nullable();
                $table->string('options')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['order_id'], 'order_items_order_id_foreign');
                $table->index(['product_id'], 'order_items_product_id_foreign');
        });
        
        Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email', 255);
                $table->string('token', 255);
                $table->timestamp('created_at')->nullable();
        });
        
        Schema::create('permissions', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('guard_name', 255);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['name', 'guard_name'], 'permissions_name_guard_name_unique');
        });
        
        Schema::create('reviews', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('user_id');
                $table->bigInteger('product_id');
                $table->integer('rating')->default('5');
                $table->text('comment')->nullable();
                $table->string('images')->nullable();
                $table->integer('is_approved')->default('1');
                $table->integer('is_verified_purchase')->default('0');
                $table->integer('likes')->default('0');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['user_id'], 'reviews_user_id_foreign');
                $table->index(['product_id', 'is_approved'], 'reviews_product_id_is_approved_index');
        });
        
        Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->bigInteger('permission_id');
                $table->bigInteger('role_id');
                $table->index(['role_id'], 'role_has_permissions_role_id_foreign');
        });
        
        Schema::create('roles', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('guard_name', 255);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['name', 'guard_name'], 'roles_name_guard_name_unique');
        });
        
        Schema::create('sessions', function (Blueprint $table) {
                $table->string('id', 255);
                $table->bigInteger('user_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('payload');
                $table->integer('last_activity');
                $table->index(['user_id'], 'sessions_user_id_index');
                $table->index(['last_activity'], 'sessions_last_activity_index');
        });
        
        Schema::create('social_links', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('platform', 255);
                $table->string('name', 255);
                $table->string('url', 255);
                $table->string('icon_class', 255)->nullable();
                $table->string('bg_color', 255)->nullable();
                $table->integer('sort_order')->default('0');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
        });
        
        Schema::create('user_addresses', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('user_id');
                $table->string('name', 255);
                $table->string('phone', 255);
                $table->string('address', 255)->nullable();
                $table->string('city', 255)->nullable();
                $table->string('district', 255)->nullable();
                $table->string('ward', 255)->nullable();
                $table->integer('is_default')->default('0');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['user_id'], 'user_addresses_user_id_foreign');
        });
        
        Schema::create('users', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('email', 255);
                $table->string('google_id', 255)->nullable();
                $table->text('google_token')->nullable();
                $table->string('google_refresh_token', 255)->nullable();
                $table->string('phone', 255)->nullable();
                $table->string('avatar', 255)->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 255)->nullable();
                $table->integer('is_active')->default('1');
                $table->timestamp('last_login_at')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->bigInteger('affiliate_level_id')->nullable();
                $table->unique(['email'], 'users_email_unique');
                $table->unique(['google_id'], 'users_google_id_unique');
                $table->index(['affiliate_level_id'], 'users_affiliate_level_id_foreign');
        });
        
        Schema::create('wishlists', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('user_id');
                $table->bigInteger('product_id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['user_id', 'product_id'], 'wishlists_user_id_product_id_unique');
                $table->index(['product_id'], 'wishlists_product_id_foreign');
        });
        
        Schema::create('wp_affiliate_schemes', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('product_id');
                $table->bigInteger('level_id')->nullable();
                $table->bigInteger('user_id')->nullable();
                $table->string('commission_type')->default('percentage');
                $table->string('percent_value')->default('0.00');
                $table->string('fixed_value')->default('0.00');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['product_id', 'level_id', 'user_id'], 'unique_scheme_index');
                $table->index(['level_id'], 'wp_affiliate_schemes_level_id_foreign');
                $table->index(['user_id'], 'wp_affiliate_schemes_user_id_foreign');
        });
        
        Schema::create('wp_banners', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('title', 255)->nullable();
                $table->string('sub_title', 255)->nullable();
                $table->string('image_desktop', 255);
                $table->string('image_mobile', 255)->nullable();
                $table->string('link', 255)->nullable();
                $table->string('btn_text', 255)->nullable();
                $table->string('position', 255)->default('hero');
                $table->integer('order')->default('0');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->index(['position'], 'wp_banners_position_index');
        });
        
        Schema::create('wp_flash_sale_items', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('flash_sale_id');
                $table->bigInteger('product_id');
                $table->string('price');
                $table->integer('quantity')->default('0');
                $table->integer('sold')->default('0');
                $table->unique(['flash_sale_id', 'product_id'], 'unique_flash_product');
                $table->index(['product_id'], 'wp_flash_sale_items_product_id_foreign');
        });
        
        Schema::create('wp_flash_sales', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('title', 255);
                $table->string('start_time');
                $table->string('end_time');
                $table->integer('is_active')->default('1');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
        });
        
        Schema::create('wp_orders', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->bigInteger('user_id')->nullable();
                $table->bigInteger('affiliate_id')->nullable();
                $table->string('commission_status', 255)->default('pending');
                $table->text('rejection_reason')->nullable();
                $table->string('commission_amount')->default('0.00');
                $table->string('order_code', 255);
                $table->string('customer_name', 255);
                $table->string('customer_phone', 255);
                $table->string('customer_email', 255)->nullable();
                $table->string('customer_address', 255);
                $table->text('note')->nullable();
                $table->string('subtotal');
                $table->string('shipping_fee')->default('0.00');
                $table->string('discount')->default('0.00');
                $table->string('total');
                $table->string('payment_method', 255)->default('cod');
                $table->string('status', 255)->default('pending');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['order_code'], 'wp_orders_order_code_unique');
                $table->index(['user_id'], 'wp_orders_user_id_foreign');
                $table->index(['affiliate_id'], 'wp_orders_affiliate_id_foreign');
                $table->index(['commission_status'], 'wp_orders_commission_status_index');
                $table->index(['status'], 'wp_orders_status_index');
        });
        
        Schema::create('wp_post_tag', function (Blueprint $table) {
                $table->bigInteger('post_id');
                $table->bigInteger('tag_id');
                $table->index(['tag_id'], 'wp_post_tag_tag_id_foreign');
        });
        
        Schema::create('wp_posts', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('slug', 255);
                $table->text('summary')->nullable();
                $table->string('content')->nullable();
                $table->string('thumbnail', 255)->nullable();
                $table->integer('is_featured')->default('0');
                $table->string('status', 255)->default('published');
                $table->integer('views')->default('0');
                $table->bigInteger('user_id')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->string('meta_title', 255)->nullable();
                $table->string('meta_description', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->unique(['slug'], 'wp_posts_slug_unique');
                $table->index(['user_id'], 'wp_posts_user_id_foreign');
        });
        
        Schema::create('wp_products', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->text('short_description')->nullable();
                $table->string('description')->nullable();
                $table->string('regular_price')->nullable();
                $table->string('sale_price')->nullable();
                $table->integer('quantity')->default('0');
                $table->integer('sold_count')->default('0');
                $table->string('image', 255)->nullable();
                $table->string('gallery')->nullable();
                $table->string('tags')->nullable();
                $table->integer('is_active')->default('1');
                $table->integer('is_featured')->default('0');
                $table->bigInteger('user_id')->nullable();
                $table->integer('views')->default('0');
                $table->string('affiliate_commission_rate')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['slug'], 'wp_products_slug_unique');
                $table->index(['user_id'], 'wp_products_user_id_foreign');
                $table->index(['title'], 'wp_products_title_index');
                $table->index(['is_active'], 'wp_products_is_active_index');
        });
        
        Schema::create('wp_settings', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('key', 255);
                $table->text('value')->nullable();
                $table->string('group_name', 255)->default('general');
                $table->string('type', 255)->default('text');
                $table->string('label', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['key'], 'wp_settings_key_unique');
        });
        
        Schema::create('wp_tags', function (Blueprint $table) {
                $table->bigInteger('id');
                $table->string('name', 255);
                $table->string('slug', 255);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->unique(['slug'], 'wp_tags_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('wp_tags');
        Schema::dropIfExists('wp_settings');
        Schema::dropIfExists('wp_products');
        Schema::dropIfExists('wp_posts');
        Schema::dropIfExists('wp_post_tag');
        Schema::dropIfExists('wp_orders');
        Schema::dropIfExists('wp_flash_sales');
        Schema::dropIfExists('wp_flash_sale_items');
        Schema::dropIfExists('wp_banners');
        Schema::dropIfExists('wp_affiliate_schemes');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_histories');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('header_menus');
        Schema::dropIfExists('header_menu_items');
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_columns');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('chat_sessions');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('affiliate_levels');

        Schema::enableForeignKeyConstraints();
    }
};