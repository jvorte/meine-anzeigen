<?php

// database/migrations/xxxx_xx_xx_create_favorites_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('favoriteable');
            $table->timestamps();
            $table->unique(['user_id', 'favoriteable_id', 'favoriteable_type'], 'user_favoriteable_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};