<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            if (!Schema::hasColumn('offers', 'rating_id')) {
                $table->unsignedBigInteger('rating_id')->nullable()->after('offer_type_id');
            }
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->foreign('rating_id')->references('id')->on('ratings')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            if (Schema::hasColumn('offers', 'rating_id')) {
                $table->dropColumn('rating_id');
            }
        });
    }
};
