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
        Schema::create('transportation_pages', function (Blueprint $table) {
            $table->id();
            $table->string('main_title')->nullable();
            $table->string('main_subtitle')->nullable();
            $table->string('image_01')->nullable();
            $table->string('image_02')->nullable();
            $table->json('faqs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_pages');
    }
};
