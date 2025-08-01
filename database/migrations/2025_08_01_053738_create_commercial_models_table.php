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
        Schema::create('commercial_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_brand_id')->constrained('commercial_brands')->onDelete('cascade'); // Foreign key to brands
            $table->string('name'); // Model name
            $table->timestamps();

            // Add a unique constraint to prevent duplicate models for the same brand
            $table->unique(['commercial_brand_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_models');
    }
};