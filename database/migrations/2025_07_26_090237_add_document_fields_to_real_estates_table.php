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
        Schema::table('real_estates', function (Blueprint $table) {
            // Add grundriss_path and energieausweis_path (string for file paths)
            $table->string('grundriss_path')->nullable()->after('heizung'); // Add after 'heizung' or relevant column
            $table->string('energieausweis_path')->nullable()->after('grundriss_path');

            // Add link fields (string for URLs)
            $table->string('rundgang_link')->nullable()->after('energieausweis_path');
            $table->string('objektinformationen_link')->nullable()->after('rundgang_link');
            $table->string('zustandsbericht_link')->nullable()->after('objektinformationen_link');
            $table->string('verkaufsbericht_link')->nullable()->after('zustandsbericht_link');

            // Also ensure these contact fields are present, as they were in your fillable
            // Add after the last document link or a logical place
            $table->string('contact_name')->after('verkaufsbericht_link');
            $table->string('contact_tel')->nullable()->after('contact_name');
            $table->string('contact_email')->after('contact_tel');
            $table->string('firmenname')->nullable()->after('contact_email');
            $table->string('homepage')->nullable()->after('firmenname');
            $table->string('telefon2')->nullable()->after('homepage');
            $table->string('fax')->nullable()->after('telefon2');
            $table->string('immocard_id')->nullable()->after('fax');
            $table->string('immocard_firma_id')->nullable()->after('immocard_id');
            $table->boolean('zusatzkontakt')->default(false)->after('immocard_firma_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_estates', function (Blueprint $table) {
            // Drop the columns in reverse order of their addition or simply list them
            $table->dropColumn([
                'grundriss_path',
                'energieausweis_path',
                'rundgang_link',
                'objektinformationen_link',
                'zustandsbericht_link',
                'verkaufsbericht_link',
                'contact_name',
                'contact_tel',
                'contact_email',
                'firmenname',
                'homepage',
                'telefon2',
                'fax',
                'immocard_id',
                'immocard_firma_id',
                'zusatzkontakt',
            ]);
        });
    }
};