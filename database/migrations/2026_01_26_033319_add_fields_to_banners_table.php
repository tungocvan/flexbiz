<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wp_banners', function (Blueprint $table) {
            $table->string('sub_title')->nullable()->after('title')->comment('Mô tả phụ dưới tiêu đề');
            $table->string('btn_text')->nullable()->after('link')->comment('Chữ trên nút bấm (VD: Mua ngay)');
        });
    }

    public function down(): void
    {
        Schema::table('wp_banners', function (Blueprint $table) {
            $table->dropColumn(['sub_title', 'btn_text']);
        });
    }
};
