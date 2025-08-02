<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug')->default('dienstleistungen'); // To store the category slug

            // Basisdaten
            $table->string('dienstleistung_kategorie'); // e.g., reinigung, handwerk
            $table->string('title'); // Corresponds to 'titel' in frontend
            $table->text('description')->nullable(); // Corresponds to 'beschreibung' in frontend
            $table->string('region')->nullable(); // Region / Ort
            $table->decimal('price', 10, 2)->nullable(); // Corresponds to 'preis' in frontend
            $table->string('verfugbarkeit')->nullable(); // Verfügbarkeit
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Images (from 'bilder[]' in frontend)


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
