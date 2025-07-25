<?php

// database/migrations/xxxx_xx_xx_xxxxxx_rename_vehicle_images_table_to_car_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('vehicle_images', 'car_images');
    }

    public function down(): void
    {
        Schema::rename('car_images', 'vehicle_images');
    }
};