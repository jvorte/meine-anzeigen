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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Assuming 'users' table exists
            $table->string('title');
            $table->text('description');
            // Changed to link directly to motorcycle_brands table
            $table->foreignId('motorcycle_brand_id')->nullable()->constrained('motorcycle_brands')->onDelete('set null');
            // Changed to link directly to motorcycle_models table
            $table->foreignId('motorcycle_model_id')->nullable()->constrained('motorcycle_models')->onDelete('set null');
            $table->date('first_registration');
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('power');
            $table->string('color');
            $table->string('condition'); // e.g., 'neu', 'gebraucht'
            $table->timestamps();
            // Add soft deletes if you want to be able to "archive" ads instead of permanently deleting
            // $table->softDeletes();
        });

        // This table definition for images is correct as you provided it
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
