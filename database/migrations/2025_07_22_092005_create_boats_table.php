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
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('title');
            $table->text('description');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // Brand might not always apply to boats
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->onDelete('set null'); // Can be used for boat models
            $table->year('year_of_construction'); // Baujahr
            $table->string('condition'); // e.g., 'neu', 'gebraucht', 'restaurierungsbedürftig'
            $table->decimal('price', 10, 2)->nullable(); // Price in Euros

            // Boat-specific fields
            $table->string('boat_type'); // e.g., 'Segelboot', 'Motorboot', 'Schlauchboot', 'Kajak'
            $table->string('material')->nullable(); // e.g., 'GFK', 'Holz', 'Stahl', 'Aluminium'
            $table->decimal('total_length', 5, 2)->nullable(); // in meters (e.g., 7.50)
            $table->decimal('total_width', 5, 2)->nullable(); // in meters (e.g., 2.50)
            $table->unsignedTinyInteger('berths')->nullable(); // Number of berths/sleeping places
            $table->string('engine_type')->nullable(); // e.g., 'Innenborder', 'Außenborder', 'Segelantrieb'
            $table->unsignedInteger('engine_power')->nullable(); // in PS
            $table->unsignedInteger('operating_hours')->nullable(); // Betriebsstunden
            $table->date('last_service')->nullable(); // Date of last service

            $table->timestamps();
        });

        Schema::create('boat_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_id')->constrained('boats')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boat_images');
        Schema::dropIfExists('boats');
    }
};
