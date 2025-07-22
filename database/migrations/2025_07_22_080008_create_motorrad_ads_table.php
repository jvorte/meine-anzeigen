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
        Schema::create('motorrad_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming ads are linked to users
            $table->string('title');
            $table->text('description');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade'); // Assuming you have a 'brands' table
            $table->foreignId('car_model_id')->constrained('car_models')->onDelete('cascade'); // Assuming you have a 'car_models' table (even for motorcycles, name it consistently if needed)
            $table->date('first_registration');
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('power');
            $table->string('color');
            $table->string('condition'); // e.g., 'neu', 'gebraucht'
            $table->timestamps();
        });

        // If you want a separate table for images associated with motorrad ads
        Schema::create('motorrad_ad_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorrad_ad_id')->constrained('motorrad_ads')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorrad_ad_images');
        Schema::dropIfExists('motorrad_ads');
    }
};