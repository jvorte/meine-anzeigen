<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug')->default('immobilien'); // To store the category slug

            // Basisdaten
            $table->string('immobilientyp');
            $table->string('title');
            $table->string('objekttyp')->nullable();
            $table->string('zustand')->nullable();
            $table->integer('anzahl_zimmer')->nullable();
            $table->string('bautyp')->nullable(); // Note: Seems redundant with objekttyp, but included as per HTML
            $table->string('verfugbarkeit')->nullable();
            $table->string('befristung')->nullable();
            $table->date('befristung_ende')->nullable();

            // Beschreibung
            $table->text('description'); // Hauptbeschreibung
            $table->text('objektbeschreibung')->nullable();
            $table->text('lage')->nullable();
            $table->text('sonstiges')->nullable();
            $table->text('zusatzinformation')->nullable();

            // Standort
            $table->string('land')->default('Österreich');
            $table->string('plz');
            $table->string('ort');
            $table->string('strasse')->nullable();

            // Preise & Flächen
            $table->decimal('gesamtmiete', 10, 2)->nullable();
            $table->decimal('wohnflaeche', 10, 2)->nullable();
            $table->decimal('grundflaeche', 10, 2)->nullable();
            $table->decimal('kaution', 10, 2)->nullable();
            $table->decimal('maklerprovision', 10, 2)->nullable();
            $table->decimal('abloese', 10, 2)->nullable();

            // Ausstattung & Heizung
            $table->json('ausstattung')->nullable(); // Store selected checkboxes as JSON array
            $table->string('heizung')->nullable();

            // Fotos & Dokumente
            $table->json('images')->nullable(); // Multiple images
            $table->string('grundriss_path')->nullable(); // Path to single grundriss file
            $table->string('energieausweis_path')->nullable(); // Path to single energieausweis file
            $table->string('rundgang_link')->nullable();
            $table->string('objektinformationen_link')->nullable();
            $table->string('zustandsbericht_link')->nullable();
            $table->string('verkaufsbericht_link')->nullable();

            // Kontakt
            $table->string('contact_name');
            $table->string('contact_tel')->nullable();
            $table->string('contact_email');
            $table->string('firmenname')->nullable();
            $table->string('homepage')->nullable();
            $table->string('telefon2')->nullable();
            $table->string('fax')->nullable();
            $table->string('immocard_id')->nullable();
            $table->string('immocard_firma_id')->nullable();
            $table->boolean('zusatzkontakt')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('real_estates');
    }
};