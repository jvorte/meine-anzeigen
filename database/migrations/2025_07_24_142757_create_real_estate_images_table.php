<?php

// database/migrations/xxxx_xx_xx_create_real_estate_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('real_estate_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_estate_id')->constrained()->onDelete('cascade'); // Singular: real_estate_id
            $table->string('path');
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('real_estate_images');
    }
};