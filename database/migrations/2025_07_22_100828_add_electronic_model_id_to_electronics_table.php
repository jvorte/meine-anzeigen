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
            // Add the new foreign key column
            $table->foreignId('electronic_model_id')->nullable()->constrained('electronic_models')->onDelete('set null')->after('brand_id');

            // Drop the old 'model_name' column if it exists
            if (Schema::hasColumn('electronics', 'model_name')) {
                $table->dropColumn('model_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electronics', function (Blueprint $table) {
            // Re-add the old 'model_name' column if rolling back
            $table->string('model_name')->nullable()->after('electronic_model_id');

            // Drop the new foreign key column
            $table->dropForeign(['electronic_model_id']);
            $table->dropColumn('electronic_model_id');
        });
    }
};
