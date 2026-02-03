<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm google_id để định danh và google_token để thực hiện các request API nếu cần
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->text('google_token')->nullable()->after('google_id');
            $table->string('google_refresh_token')->nullable()->after('google_token');

            // Password có thể null nếu chỉ dùng social login
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'google_token', 'google_refresh_token']);
            $table->string('password')->nullable(false)->change();
        });
    }
};
