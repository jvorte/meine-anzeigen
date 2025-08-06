<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConversationsUniqueIndex extends Migration
{
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique('conversations_ad_id_sender_id_receiver_id_unique');
            $table->unique(['ad_id', 'sender_id', 'receiver_id', 'ad_category'], 'conversations_unique_ad_sender_receiver_category');
        });
    }

    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique('conversations_unique_ad_sender_receiver_category');
            $table->unique(['ad_id', 'sender_id', 'receiver_id'], 'conversations_ad_id_sender_id_receiver_id_unique');
        });
    }
}
