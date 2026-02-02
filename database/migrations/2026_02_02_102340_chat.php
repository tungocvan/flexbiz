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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique()->nullable(); // Định danh cho Guest
            $table->foreignId('user_id')->nullable()->constrained('users'); // Nếu là thành viên
            $table->foreignId('admin_id')->nullable()->constrained('users'); // Admin tiếp nhận chat
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained('chat_sessions')->onDelete('cascade');

            // Sửa dòng này: Thêm ->nullable()
            $table->unsignedBigInteger('sender_id')->nullable()->comment('ID của user/admin hoặc null nếu là guest');

            $table->enum('sender_type', ['guest', 'user', 'admin']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
        Schema::dropIfExists('chat_messages');
    }
};
