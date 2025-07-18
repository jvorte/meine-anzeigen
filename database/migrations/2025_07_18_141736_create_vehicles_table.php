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
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('brand_id')->nullable()->constrained();
    $table->foreignId('car_model_id')->nullable()->constrained('car_models');
    $table->string('title');
    $table->text('description')->nullable();
    $table->integer('price')->nullable();
    $table->integer('mileage')->nullable();
    $table->string('fuel_type')->nullable();
    $table->string('transmission')->nullable();
    $table->string('location')->nullable();
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
