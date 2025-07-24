<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electronic_images', function (Blueprint $table) {
            $table->id();
            // Βεβαιώσου ότι αυτό το electronic_id συνδέεται σωστά
            // με τον κύριο πίνακά σου (π.χ., 'electronics')
            $table->foreignId('electronic_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_main')->default(false); // Προαιρετικό
            $table->string('description')->nullable();   // Προαιρετικό
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electronic_images');
    }
};