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
        Schema::table('users', function (Blueprint $table) {
            $table->string('country')->nullable()->after('email');
            $table->string('city')->nullable()->after('country');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('street_address')->nullable()->after('postal_code');
            $table->string('mobile_phone')->nullable()->after('street_address');
            $table->string('phone')->nullable()->after('mobile_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'postal_code', 'street_address', 'mobile_phone', 'phone']);
        });
    }
};
