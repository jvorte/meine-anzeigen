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
  Schema::table('real_estates', function (Blueprint $table) {
    if (Schema::hasColumn('real_estates', 'images')) {
        $table->dropColumn('images');
    }
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_estates', function (Blueprint $table) {
            //
        });
    }
};
