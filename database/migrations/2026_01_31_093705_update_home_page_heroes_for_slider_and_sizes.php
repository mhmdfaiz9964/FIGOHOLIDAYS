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
        Schema::table('home_page_heroes', function (Blueprint $table) {
            $table->string('tag_size')->nullable()->default('14');
            $table->string('title_size')->nullable()->default('45');
            $table->string('highlight_size')->nullable()->default('45');
            $table->string('description_size')->nullable()->default('16');
            $table->integer('order_index')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_heroes', function (Blueprint $table) {
            $table->dropColumn(['tag_size', 'title_size', 'highlight_size', 'description_size', 'order_index', 'status']);
        });
    }
};
