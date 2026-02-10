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
        Schema::table('offers', function (Blueprint $table) {
            $table->json('inclusions')->nullable()->after('gallery_images');
            $table->json('exclusions')->nullable()->after('inclusions');
            $table->text('cancellation_policy')->nullable()->after('exclusions');
            $table->text('more_details')->nullable()->after('cancellation_policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['inclusions', 'exclusions', 'cancellation_policy', 'more_details']);
        });
    }
};
