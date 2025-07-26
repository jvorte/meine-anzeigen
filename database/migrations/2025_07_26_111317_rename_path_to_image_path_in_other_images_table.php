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
        Schema::table('other_images', function (Blueprint $table) {
            // Überprüfen Sie, ob die Spalte 'path' existiert, bevor Sie sie umbenennen
            if (Schema::hasColumn('other_images', 'path')) {
                $table->renameColumn('path', 'image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_images', function (Blueprint $table) {
            // Überprüfen Sie, ob die Spalte 'image_path' existiert, bevor Sie sie zurückbenennen
            if (Schema::hasColumn('other_images', 'image_path')) {
                $table->renameColumn('image_path', 'path');
            }
        });
    }
};
