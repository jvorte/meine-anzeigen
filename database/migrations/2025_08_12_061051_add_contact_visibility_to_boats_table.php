<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            $table->boolean('show_phone')->default(false)->after('operating_hours');
            $table->boolean('show_email')->default(false)->after('show_phone');
        });
    }

    public function down(): void
    {
        Schema::table('boats', function (Blueprint $table) {
            $table->dropColumn(['show_phone', 'show_email']);
        });
    }
};
