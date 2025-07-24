<?php

// database/migrations/xxxx_xx_xx_create_other_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('other_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('other_id')->constrained()->onDelete('cascade'); // Singular: other_id
            $table->string('path');
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('other_images');
    }
};