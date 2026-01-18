<?php

// database/migrations/xxxx_xx_xx_update_users_and_create_addresses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Cập nhật bảng users (Thêm cột)
        Schema::table('users', function (Blueprint $table) {
            // Kiểm tra trước khi thêm để tránh lỗi
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email')->index();
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password'); // True: Hoạt động, False: Khóa
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
            // Soft Delete để không mất lịch sử đơn hàng khi xóa khách
            $table->softDeletes();
        });

        // 2. Tạo bảng địa chỉ (User Addresses)
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('name'); // Tên người nhận
            $table->string('phone'); // SĐT người nhận
            
            // Địa chỉ chi tiết (Tùy project của bạn có tách Xã/Huyện/Tỉnh không, ở đây tôi làm gộp cho gọn, bạn có thể tách nếu cần)
            $table->string('address')->nullable(); 
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_addresses');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'is_active', 'last_login_at', 'deleted_at']);
        });
    }
};