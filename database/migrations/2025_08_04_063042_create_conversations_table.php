<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
   Schema::create('conversations', function (Blueprint $table) {
    $table->id();

    // ✅ Μόνο αυτή η γραμμή για το ad_id (χωρίς foreign key)
    $table->unsignedBigInteger('ad_id'); 

    $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

    $table->timestamps();

    $table->unique(['ad_id', 'sender_id', 'receiver_id']);
});

}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
