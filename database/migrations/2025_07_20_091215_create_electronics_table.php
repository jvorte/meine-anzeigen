<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Create 'brands' table (this is the one that was duplicated)
        // Schema::create('brands', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique();
        //     $table->timestamps();
        // });

        // 2. Create 'electronic_models' table
        Schema::create('electronic_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
            $table->unique(['brand_id', 'name']);
        });

        // 3. Create 'electronics' table
        Schema::create('electronics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('electronic_model_id')->nullable()->constrained('electronic_models')->onDelete('set null');
            $table->string('condition');
            $table->integer('year_of_purchase')->nullable();
            $table->string('warranty_status')->nullable();
            $table->text('accessories')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Create 'images' table
   Schema::create('electronic_images', function (Blueprint $table) {
    $table->id();
    $table->foreignId('electronic_id')->constrained('electronics')->onDelete('cascade');
    $table->string('image_path');
    $table->string('filename')->nullable();
    $table->boolean('is_thumbnail')->default(false); // <-- Change 'is_primary' to 'is_thumbnail'
    $table->integer('order')->nullable();
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('electronics');
        Schema::dropIfExists('electronic_models');
        Schema::dropIfExists('brands');
    }
};