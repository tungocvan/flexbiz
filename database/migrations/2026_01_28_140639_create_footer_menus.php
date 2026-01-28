<?php

// database/migrations/2026_01_28_000002_create_footer_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Các cột footer (VD: Về FlexBiz, Hỗ trợ khách hàng)
        Schema::create('footer_columns', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề cột
            $table->string('slug')->unique(); // Định danh để query
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Các link trong cột
        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_column_id')->constrained()->cascadeOnDelete();

            $table->string('label');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->boolean('new_tab')->default(false);

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_columns');
    }
};
