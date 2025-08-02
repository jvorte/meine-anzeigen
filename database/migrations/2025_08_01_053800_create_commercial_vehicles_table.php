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
        Schema::create('commercial_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('title');
            $table->text('description');
            $table->foreignId('commercial_brand_id')->constrained('commercial_brands')->cascadeOnDelete(); 
            $table->foreignId('commercial_model_id')->constrained('commercial_models')->cascadeOnDelete(); 
            $table->date('first_registration');
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('power')->nullable(); // Horsepower, can be null
            $table->string('color')->nullable();
            $table->string('condition'); // e.g., 'neu', 'gebraucht', 'unfallfahrzeug'
            $table->decimal('price', 10, 2)->nullable(); // Price in Euros
            $table->string('commercial_vehicle_type'); // e.g., 'Truck', 'Van', 'Bus', 'Trailer'
            $table->string('fuel_type')->nullable(); // e.g., 'Diesel', 'Gasoline', 'Electric'
            $table->string('transmission')->nullable(); // e.g., 'Manual', 'Automatic'
            $table->unsignedInteger('payload_capacity')->nullable(); // in kg
            $table->unsignedInteger('gross_vehicle_weight')->nullable(); // in kg
            $table->unsignedTinyInteger('number_of_axles')->nullable();
            $table->string('emission_class')->nullable(); // e.g., 'Euro 6'
            $table->unsignedTinyInteger('seats')->nullable(); // Number of seats, especially for vans/buses
            $table->timestamps();
        });

        Schema::create('commercial_vehicle_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_vehicle_id')->constrained('commercial_vehicles')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_vehicle_images');
        Schema::dropIfExists('commercial_vehicles');
    }
};
