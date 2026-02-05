<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_create_wp_tags_tables.php

    public function up()
    {
        // 1. Bảng lưu tên Tags
        Schema::create('wp_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Bảng trung gian (Pivot) giữa Post và Tag
        Schema::create('wp_post_tag', function (Blueprint $table) {
            $table->primary(['post_id', 'tag_id']);
            $table->foreignId('post_id')->constrained('wp_posts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('wp_tags')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wp_post_tag');
        Schema::dropIfExists('wp_tags');
    }
};
