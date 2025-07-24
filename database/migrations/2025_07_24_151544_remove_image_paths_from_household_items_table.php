<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('household_items', function (Blueprint $table) { // Υποθέτω ότι ο πίνακάς σου λέγεται 'household_items'
            $table->dropColumn('image_paths');
        });
    }

    public function down(): void
    {
        // Αν χρειαστεί να κάνεις rollback, θα την προσθέσει ξανά
        Schema::table('household_items', function (Blueprint $table) { // Υποθέτω ότι ο πίνακάς σου λέγεται 'household_items'
            $table->longText('image_paths')->nullable(); // Επανενεργοποιεί την στήλη
        });
    }
};