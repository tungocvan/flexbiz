<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');

            // Thông tin định danh Guest (Enterprise Grade)
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('guest_email')->nullable();

            $table->enum('status', ['open', 'closed', 'pending'])->default('open')->index();
            $table->timestamp('last_message_at')->nullable()->index(); // Dùng để sắp xếp Sidebar nhanh
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('sender_id')->nullable()->index(); // ID của User hoặc Admin
            $table->enum('sender_type', ['guest', 'user', 'admin'])->index();
            $table->text('message');
            $table->boolean('is_read')->default(false)->index();
            $table->json('metadata')->nullable(); // Mở rộng cho gửi ảnh/icon sau này
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};
