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
        Schema::create('campers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('title');
            $table->text('description');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('car_model_id')->constrained('car_models')->onDelete('cascade'); // Assuming CarModel covers camper models
            $table->date('first_registration');
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('power')->nullable(); // Horsepower, can be null
            $table->string('color')->nullable();
            $table->string('condition'); // e.g., 'neu', 'gebraucht', 'unfallfahrzeug'
            $table->decimal('price', 10, 2)->nullable(); // Price in Euros

            // Camper-specific fields
            $table->string('camper_type'); // e.g., 'Alkoven', 'Teilintegriert', 'Vollintegriert', 'Kastenwagen'
            $table->unsignedTinyInteger('berths')->nullable(); // Number of sleeping berths
            $table->decimal('total_length', 4, 1)->nullable(); // in meters (e.g., 6.5)
            $table->decimal('total_width', 4, 1)->nullable(); // in meters (e.g., 2.3)
            $table->decimal('total_height', 4, 1)->nullable(); // in meters (e.g., 2.9)
            $table->unsignedInteger('gross_vehicle_weight')->nullable(); // in kg
            $table->string('fuel_type')->nullable(); // e.g., 'Diesel', 'Gasoline'
            $table->string('transmission')->nullable(); // e.g., 'Manuell', 'Automatik'
            $table->string('emission_class')->nullable(); // e.g., 'Euro 6'

            $table->timestamps();
        });

        Schema::create('camper_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained('campers')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camper_images');
        Schema::dropIfExists('campers');
    }
};
