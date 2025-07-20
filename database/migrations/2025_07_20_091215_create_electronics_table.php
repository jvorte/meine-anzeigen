<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electronics', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug')->default('elektronik'); // Store the category for consistency
            $table->string('subcategory')->nullable();
            $table->string('brand')->nullable(); // Free-text brand input
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('condition')->nullable();
            $table->json('images')->nullable(); // To store multiple image paths as JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electronics');
    }
};