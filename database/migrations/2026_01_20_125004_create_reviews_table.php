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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_image')->nullable();
            $table->integer('rating')->default(5);
            $table->text('description')->nullable();
            $table->date('date');
            $table->enum('source', ['Tripadvisor', 'Google', 'Facebook', 'Instagram', 'Website', 'Others']);
            $table->string('added_by')->nullable();
            $table->string('user_location')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
