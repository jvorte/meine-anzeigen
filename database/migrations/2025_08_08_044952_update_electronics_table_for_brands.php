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
        Schema::table('electronics', function (Blueprint $table) {
            // Προσθήκη των νέων πεδίων (ως κείμενο)
            $table->string('brand')->nullable()->after('description');
            $table->string('electronic_model')->nullable()->after('brand');

            // Διαγραφή των παλιών πεδίων (foreign keys)
            $table->dropConstrainedForeignId('brand_id');
            $table->dropConstrainedForeignId('electronic_model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electronics', function (Blueprint $table) {
            // Επαναφορά των παλιών foreign keys
            $table->foreignId('brand_id')->nullable()->constrained('electronic_brands')->cascadeOnDelete();
            $table->foreignId('electronic_model_id')->nullable()->constrained('electronic_models')->cascadeOnDelete();

            // Διαγραφή των νέων πεδίων
            $table->dropColumn('brand');
            $table->dropColumn('electronic_model');
        });
    }
};