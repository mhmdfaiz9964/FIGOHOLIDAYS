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
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('vehicle_type'); // e.g., Luxury, Mini Bus, Sedan
            $table->string('vehicle_image')->nullable();
            $table->json('includes')->nullable(); // JSON [{title: string, icon: string}]
            $table->decimal('starting_price', 10, 2);
            $table->string('label_icon')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};
