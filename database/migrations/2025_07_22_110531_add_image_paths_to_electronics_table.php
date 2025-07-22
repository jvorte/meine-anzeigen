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
        Schema::table('electronics', function (Blueprint $table) {
            // Add a JSON column to store an array of image paths
            // It's placed after 'accessories' for logical ordering, but 'after' is optional.
            $table->json('image_paths')->nullable()->after('accessories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electronics', function (Blueprint $table) {
            // Drop the column if the migration is rolled back
            $table->dropColumn('image_paths');
        });
    }
};
