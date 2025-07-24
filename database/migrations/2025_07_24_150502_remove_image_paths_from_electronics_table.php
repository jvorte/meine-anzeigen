<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('electronics', function (Blueprint $table) { // Ή το όνομα του κύριου πίνακα σου
            $table->dropColumn('image_paths');
        });
    }

    public function down(): void
    {
        // Αν χρειαστεί να κάνεις rollback, θα πρέπει να την προσθέσεις ξανά
        Schema::table('electronics', function (Blueprint $table) { // Ή το όνομα του κύριου πίνακα σου
            $table->longText('image_paths')->nullable();
        });
    }
};