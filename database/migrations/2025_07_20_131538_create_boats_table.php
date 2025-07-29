<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('brand');
            $table->string('model');
            $table->year('year_of_construction');
            $table->string('condition');
            $table->decimal('price', 10, 2)->nullable();

            // Boat-specific fields
            $table->string('boat_type');
            $table->string('material')->nullable();
            $table->decimal('total_length', 5, 2)->nullable();
            $table->decimal('total_width', 5, 2)->nullable();
            $table->unsignedTinyInteger('berths')->nullable();
            $table->string('engine_type')->nullable();
            $table->unsignedInteger('engine_power')->nullable();
            $table->unsignedInteger('operating_hours')->nullable();
            $table->date('last_service')->nullable();


            $table->timestamps();
        });

        Schema::create('boat_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_id')->constrained('boats')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boat_images');
        Schema::dropIfExists('boats');
    }
};
