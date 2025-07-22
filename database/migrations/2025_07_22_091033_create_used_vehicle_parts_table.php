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
        Schema::create('used_vehicle_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('title');
            $table->text('description');
            $table->string('part_category'); // e.g., 'Motor', 'Getriebe', 'Karosserie'
            $table->string('part_name'); // e.g., 'Frontstoßstange', 'Lichtmaschine'
            $table->string('manufacturer_part_number')->nullable(); // OEM part number
            $table->string('condition'); // e.g., 'neu', 'gebraucht', 'überholt', 'defekt'
            $table->decimal('price', 10, 2)->nullable(); // Price in Euros

            // Compatibility fields (can be null if part is universal or unknown compatibility)
            $table->foreignId('compatible_brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('compatible_car_model_id')->nullable()->constrained('car_models')->onDelete('set null');
            $table->year('compatible_year_from')->nullable();
            $table->year('compatible_year_to')->nullable();

            $table->timestamps();
        });

        Schema::create('used_vehicle_part_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('used_vehicle_part_id')->constrained('used_vehicle_parts')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_vehicle_part_images');
        Schema::dropIfExists('used_vehicle_parts');
    }
};
