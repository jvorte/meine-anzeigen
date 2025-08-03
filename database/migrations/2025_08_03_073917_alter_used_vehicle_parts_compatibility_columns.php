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
        Schema::table('used_vehicle_parts', function (Blueprint $table) {
            // Drop foreign keys first, as we are changing the columns
            // Ensure the foreign keys exist before trying to drop them
            if (Schema::hasColumn('used_vehicle_parts', 'compatible_brand_id')) {
                $table->dropForeign(['compatible_brand_id']);
            }
            if (Schema::hasColumn('used_vehicle_parts', 'compatible_car_model_id')) {
                $table->dropForeign(['compatible_car_model_id']);
            }

            // Rename and change type of compatible_brand_id to compatible_brand (string)
            $table->string('compatible_brand')->nullable()->after('price');
            // Populate new column with old data if possible, or handle separately if needed
            // For example: DB::table('used_vehicle_parts')->update(['compatible_brand' => DB::raw('(SELECT name FROM brands WHERE id = compatible_brand_id)')]);
            $table->dropColumn('compatible_brand_id');

            // Rename and change type of compatible_car_model_id to compatible_model (string)
            $table->string('compatible_model')->nullable()->after('compatible_brand');
            // Populate new column with old data if possible
            // For example: DB::table('used_vehicle_parts')->update(['compatible_model' => DB::raw('(SELECT name FROM car_models WHERE id = compatible_car_model_id)')]);
            $table->dropColumn('compatible_car_model_id');


            // Add the new vehicle_type column
            $table->string('vehicle_type', 50)->nullable()->after('compatible_model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('used_vehicle_parts', function (Blueprint $table) {
            // Revert vehicle_type
            $table->dropColumn('vehicle_type');

            // Revert compatible_model to compatible_car_model_id (if you want to go back to IDs)
            // Note: You would lose the string data entered in the 'compatible_model' field.
            // If you truly need to roll back, you'd re-create the columns as bigInt and re-add foreign keys.
            // For a simple revert, we'll just drop the string columns.
            // If you intend to fully reverse, you would need to run a migration to add back `compatible_brand_id` and `compatible_car_model_id`
            // with foreign keys, and potentially try to map back some data if you kept a backup.
            $table->bigInteger('compatible_brand_id')->unsigned()->nullable()->after('price');
            $table->bigInteger('compatible_car_model_id')->unsigned()->nullable()->after('compatible_brand_id');

            // Re-add foreign key constraints if they existed and you want to truly revert
            // $table->foreign('compatible_brand_id')->references('id')->on('brands')->onDelete('set null');
            // $table->foreign('compatible_car_model_id')->references('id')->on('car_models')->onDelete('set null');

            $table->dropColumn(['compatible_brand', 'compatible_model']); // Drop the new string columns
        });
    }
};