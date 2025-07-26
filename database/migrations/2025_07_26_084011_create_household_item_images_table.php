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
        Schema::create('household_item_images', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the 'household_items' table
            // This assumes your 'household_items' table uses 'id' as its primary key.
            $table->foreignId('household_item_id')
                  ->constrained('household_items') // Constrains to the 'household_items' table
                  ->onDelete('cascade');         // If a household item ad is deleted, its images are also deleted

            $table->string('image_path'); // The consistent column name for the image path
            $table->boolean('is_thumbnail')->default(false); // To mark one image as the main thumbnail

            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_item_images');
    }
};