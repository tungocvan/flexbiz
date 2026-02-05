<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // File migration mới
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('wp_orders')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable(); // ID của Admin thực hiện (nếu có)
            $table->string('action'); // Ví dụ: 'Đổi trạng thái', 'Thêm ghi chú'
            $table->string('description')->nullable(); // Chi tiết: 'Từ Pending -> Processing'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
