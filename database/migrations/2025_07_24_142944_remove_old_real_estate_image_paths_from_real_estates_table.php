<?php

// database/migrations/xxxx_xx_xx_remove_old_real_estate_image_paths_from_real_estates_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('real_estates', function (Blueprint $table) {
            if (Schema::hasColumn('real_estates', 'grundriss_path')) { // Check if column exists before dropping
                $table->dropColumn('grundriss_path');
            }
            if (Schema::hasColumn('real_estates', 'energieausweis_path')) {
                $table->dropColumn('energieausweis_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('real_estates', function (Blueprint $table) {
            // If you ever need to roll back, add them back here
            $table->string('grundriss_path')->nullable();
            $table->string('energieausweis_path')->nullable();
        });
    }
};