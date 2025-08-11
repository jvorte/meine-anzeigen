<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearAndPetfriendlyToRealEstatesTable extends Migration
{
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->integer('year_of_construction')->nullable()->after('title'); 
            $table->boolean('pet_friendly')->default(false)->after('year_of_construction');
        });
    }

    public function down()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('year_of_construction');
            $table->dropColumn('pet_friendly');
        });
    }
}
