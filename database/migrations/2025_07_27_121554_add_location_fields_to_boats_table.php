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
        Schema::table('boats', function (Blueprint $table) {
            // Add the new location columns
            $table->string('country')->after('last_service'); // Or choose another logical position
            $table->string('zip_code', 20)->after('country');
            $table->string('city')->after('zip_code');
            $table->string('street')->nullable()->after('city'); // 'street' is nullable as per your validation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            // Drop the columns in the reverse order they were added
            $table->dropColumn(['country', 'zip_code', 'city', 'street']);
        });
    }
};