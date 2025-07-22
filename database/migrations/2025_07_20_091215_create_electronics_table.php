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
        Schema::create('electronics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('condition');

            $table->string('category');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            // This column will be dropped and replaced by 'electronic_model_id' in a later migration
            $table->string('model_name')->nullable(); // This is the original column
            $table->year('year_of_purchase')->nullable();
            $table->string('warranty_status')->nullable();
            $table->text('accessories')->nullable();

            $table->timestamps();
        });

        Schema::create('electronic_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electronic_id')->constrained('electronics')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronic_images');
        Schema::dropIfExists('electronics');
    }
};
