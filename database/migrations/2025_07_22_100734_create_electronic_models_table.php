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
        Schema::create('electronic_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name'); // e.g., "iPhone 15 Pro", "QLED QN90C", "Side-by-Side RS68A"
            $table->string('category_hint')->nullable(); // Optional: e.g., 'Mobile Phone', 'TV', 'Refrigerator' for filtering
            $table->timestamps();

            $table->unique(['brand_id', 'name']); // Prevent duplicate models for the same brand
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronic_models');
    }
};
