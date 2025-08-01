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
        Schema::create('camper_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_brand_id')->constrained('camper_brands')->onDelete('cascade'); // Foreign key to brands
            $table->string('name'); // Model name
            $table->string('slug')->unique(); // Optional: for clean URLs, ensure uniqueness with brand_id if needed
            $table->integer('year_from')->nullable(); // Optional: if you store year ranges
            $table->integer('year_to')->nullable();   // Optional: if you store year ranges
            $table->timestamps();

            // Add a unique constraint for name and brand_id if a model name can be repeated across brands
            $table->unique(['name', 'camper_brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camper_models');
    }
};