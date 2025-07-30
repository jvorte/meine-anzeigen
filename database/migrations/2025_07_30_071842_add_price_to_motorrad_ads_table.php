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
    Schema::table('motorrad_ads', function (Blueprint $table) {
        $table->decimal('price', 10, 2)->after('power')->nullable(); // Or ->default(0); or ->unsigned();
    });
}

public function down(): void
{
    Schema::table('motorrad_ads', function (Blueprint $table) {
        $table->dropColumn('price');
    });
}
};
