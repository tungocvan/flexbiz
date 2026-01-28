<?php

// database/migrations/2026_01_28_000001_create_header_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Menu Locations (Vị trí menu: Main Desktop, Topbar, Mobile...)
        Schema::create('header_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // VD: Main Menu, Mobile Menu
            $table->string('location')->unique(); // VD: primary, mobile
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Menu Items (Các link bên trong, hỗ trợ đa cấp)
        Schema::create('header_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('header_menu_items')->cascadeOnDelete();

            $table->string('title');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable(); // Dùng route name cho chuẩn Laravel
            $table->json('params')->nullable(); // Tham số cho route

            $table->string('icon')->nullable(); // Class icon hoặc đường dẫn ảnh
            $table->string('target')->default('_self'); // _blank, _self
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_menu_items');
        Schema::dropIfExists('header_menus');
    }
};
