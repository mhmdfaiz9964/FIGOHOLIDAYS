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
        Schema::dropIfExists('general_settings');
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            // Branding
            $table->string('logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->text('footer_description')->nullable();
            
            // Multiple Contact Data
            $table->json('head_offices')->nullable();
            $table->json('whatsapps')->nullable();
            $table->json('landlines')->nullable();
            $table->json('emails')->nullable();
            $table->json('map_urls')->nullable(); // Already json
            
            // Footer
            $table->string('copyright_text')->nullable();
            
            // Home Customization (Numbers/Counters)
            $table->integer('experience_count')->default(0);
            $table->integer('destination_count')->default(0);
            $table->integer('customers_count')->default(0); 
            $table->integer('trip_count')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
