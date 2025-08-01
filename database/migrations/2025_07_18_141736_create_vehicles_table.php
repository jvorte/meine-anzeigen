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
Schema::create('vehicles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('category_slug');
    $table->foreignId('car_brand_id')->nullable()->constrained('car_brands');
    $table->foreignId('car_model_id')->nullable()->constrained('car_models');
    $table->unsignedInteger('price')->nullable();
    $table->unsignedInteger('mileage')->nullable();
    $table->string('registration')->nullable(); // YYYY-MM
    $table->string('vehicle_type')->nullable();
    $table->string('condition')->nullable();
    $table->string('warranty')->nullable();
    $table->unsignedInteger('power')->nullable();
    $table->string('fuel_type')->nullable();
    $table->string('transmission')->nullable();
    $table->string('drive')->nullable();
    $table->string('color')->nullable();
    $table->unsignedTinyInteger('doors')->nullable();
    $table->unsignedTinyInteger('seats')->nullable();
    $table->string('seller_type')->nullable();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
