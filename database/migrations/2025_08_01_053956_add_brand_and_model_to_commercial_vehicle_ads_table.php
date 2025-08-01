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
        Schema::table('commercial_vehicles', function (Blueprint $table) {
            // Add foreign key for brand
            $table->foreignId('commercial_brand_id')
                  ->nullable() // Make nullable if existing ads might not have this yet, otherwise non-nullable
                  ->after('id') // Adjust position as needed
                  ->constrained('commercial_brands')
                  ->onDelete('set null'); // Or 'restrict' if you prefer

            // Add foreign key for model
            $table->foreignId('commercial_model_id')
                  ->nullable() // Make nullable if existing ads might not have this yet
                  ->after('commercial_brand_id') // Adjust position as needed
                  ->constrained('commercial_models')
                  ->onDelete('set null'); // Or 'restrict' if you prefer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commercial_vehicle_ads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('commercial_brand_id');
            $table->dropConstrainedForeignId('commercial_model_id');
        });
    }
};