<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('others', function (Blueprint $table) {
            $table->boolean('show_phone')->default(false);
            $table->boolean('show_mobile_phone')->default(false);
            $table->boolean('show_email')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('others', function (Blueprint $table) {
            $table->dropColumn(['show_phone', 'show_mobile_phone', 'show_email']);
        });
    }
};

