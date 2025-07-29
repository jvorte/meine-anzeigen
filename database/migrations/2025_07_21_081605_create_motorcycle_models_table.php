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
        Schema::create('motorcycle_models', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing unsignedBigInteger primary key
            $table->foreignId('motorcycle_brand_id')->constrained('motorcycle_brands')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();

            // Add a unique constraint to prevent duplicate models for the same brand
            $table->unique(['motorcycle_brand_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_models');
    }
};

