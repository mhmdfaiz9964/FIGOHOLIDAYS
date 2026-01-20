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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('meta_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->string('video')->nullable();
            $table->string('thumbnail_image');
            $table->json('gallery_images')->nullable();
            $table->integer('nights')->default(0);
            $table->integer('days')->default(0);
            $table->integer('star_rating')->default(5);
            
            // Sidebar Banner
            $table->string('sidebar_banner_image')->nullable();
            $table->string('sidebar_banner_title')->nullable();
            $table->string('sidebar_banner_label')->nullable();
            $table->text('sidebar_banner_description')->nullable();
            $table->string('sidebar_banner_url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
