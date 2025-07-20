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
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('year_of_manufacture')->nullable();
            $table->decimal('length_meters', 5, 2)->nullable();
            $table->string('engine_type')->nullable(); // e.g., Inboard, Outboard
            $table->string('condition')->nullable(); // e.g., new, used, damaged
            $table->string('location')->nullable();
            $table->json('images')->nullable(); // Store multiple image paths as JSON array
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Link to users table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boats');
    }
};
