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
        Schema::create('camper_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Brand name, should be unique
            $table->string('slug')->unique(); // Optional: for clean URLs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camper_brands');
    }
};