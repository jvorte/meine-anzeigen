<?php

// database/migrations/xxxx_xx_xx_xxxxxx_rename_vehicle_id_to_car_id_in_car_images_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_images', function (Blueprint $table) { // Or 'car_images' if already renamed
            $table->renameColumn('vehicle_id', 'car_id');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_images', function (Blueprint $table) { // Or 'car_images'
            $table->renameColumn('car_id', 'vehicle_id');
        });
    }
};