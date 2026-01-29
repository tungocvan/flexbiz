<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Gắn cấp độ cho User
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('affiliate_level_id')->nullable()->constrained('affiliate_levels')->nullOnDelete();
        });

        // Lưu Snapshot hoa hồng Hybrid vào chi tiết đơn hàng
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('commission_fixed_amount', 15, 2)->default(0)->after('commission_amount');
            $table->string('affiliate_level_snapshot')->nullable()->after('commission_fixed_amount'); // Lưu tên cấp độ lúc mua
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('affiliate_level_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['commission_fixed_amount', 'affiliate_level_snapshot']);
        });
    }
};