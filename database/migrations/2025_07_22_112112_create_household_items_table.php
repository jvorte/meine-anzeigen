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
        Schema::create('household_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable(); // Price in Euros
            $table->string('condition'); // e.g., 'neu', 'gebraucht', 'stark gebraucht', 'defekt'

            // Household Item-specific fields
            $table->string('category'); // e.g., 'Möbel', 'Küchengeräte', 'Dekoration', 'Garten'
      $table->string('brand')->nullable();

            $table->string('model_name')->nullable(); // Free text for specific model/series
            $table->string('material')->nullable(); // e.g., 'Holz', 'Stoff', 'Metall', 'Kunststoff'
            $table->string('color')->nullable();
            $table->string('dimensions')->nullable(); // e.g., "200x90x75 cm (LxBxH)"
            $table->json('image_paths')->nullable(); // Store image paths as JSON array

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_items');
    }
};
