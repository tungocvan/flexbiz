<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_create_category_post_table.php

    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->primary(['category_id', 'post_id']);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('wp_posts')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_post');
    }
};
