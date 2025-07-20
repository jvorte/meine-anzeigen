<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug')->default('haushalt'); // To store the category slug
            $table->string('subcategory')->nullable(); // e.g., waschmaschine, staubsauger  $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('condition')->nullable(); // Zustand
            $table->json('images')->nullable(); // To store multiple image paths as JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
