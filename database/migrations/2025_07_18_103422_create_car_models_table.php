<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
   Schema::create('car_models', function (Blueprint $table) {
                $table->id();
                $table->foreignId('car_brand_id')->constrained('car_brands')->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique(); // Assuming you want to keep the slug
                $table->timestamps();

                $table->unique(['car_brand_id', 'name']);
            });



}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
