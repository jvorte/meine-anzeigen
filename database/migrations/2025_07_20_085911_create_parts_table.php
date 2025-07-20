<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug'); // Added for general category tracking
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->onDelete('set null');
            $table->string('condition')->nullable(); // Zustand
            $table->decimal('price_from', 10, 2)->nullable(); // Preis
            $table->string('registration_to')->nullable(); // Jahre (e.g., "Baujahr")
            $table->string('title'); // Titel
            $table->text('description')->nullable(); // Beschreibung
            $table->json('images')->nullable(); // To store multiple image paths as JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
