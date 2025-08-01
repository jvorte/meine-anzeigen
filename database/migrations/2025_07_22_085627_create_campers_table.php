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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('camper_brand_id')->constrained('camper_brands')->onDelete('cascade');
            $table->foreignId('camper_model_id')->nullable()->constrained('camper_models')->onDelete('set null'); // Model can be null initially
            $table->decimal('price', 10, 2);
            $table->date('first_registration');
            $table->integer('mileage');
            $table->integer('power');
            $table->string('color');
            $table->string('condition');
            $table->string('camper_type');
            $table->integer('berths');
            $table->decimal('total_length', 4, 1);
            $table->decimal('total_width', 4, 1);
            $table->decimal('total_height', 4, 1);
            $table->integer('gross_vehicle_weight');
            $table->string('fuel_type');
            $table->string('transmission');
            $table->string('emission_class');
            $table->string('title');
            $table->text('description');  
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::create('camper_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
              $table->boolean('is_thumbnail')->default(false);
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
