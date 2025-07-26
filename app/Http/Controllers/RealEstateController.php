<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealEstate;
use App\Models\RealEstateImage; // Importieren Sie das RealEstateImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class RealEstateController extends Controller
{
    /**
     * Zeigt das Formular zum Erstellen einer neuen Immobilienanzeige an.
     * Diese Methode bereitet die für das Formular benötigten Daten vor.
     */
    public function create()
    {
        // Definieren Sie Optionen für Dropdowns und Checkboxen, passend zum Blade-Formular
        $immobilientypOptions = ['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'];
        $objekttypOptions = ['Kauf', 'Miete'];
        $zustandOptions = ['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'];
        $bautypOptions = ['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'];
        $verfugbarkeitOptions = ['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'];
        $befristungOptions = ['Unbefristet', 'Befristet'];
        $heizungOptions = ['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'];
        $ausstattungOptions = [
            'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
            'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
            'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
            'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
        ];

        return view('ads.real-estate.create', compact(
            'immobilientypOptions',
            'objekttypOptions',
            'zustandOptions',
            'bautypOptions',
            'verfugbarkeitOptions',
            'befristungOptions',
            'heizungOptions',
            'ausstattungOptions' // Übergeben Sie diese an die View
        ));
    }

    /**
     * Speichert eine neu erstellte Immobilienanzeige im Speicher.
     * Diese Methode verarbeitet die Formularübermittlung und speichert Daten.
     */
    public function store(Request $request)
    {
        // Definieren Sie Validierungsregeln, stellen Sie sicher, dass sie mit den 'name'-Attributen des Blade-Formulars übereinstimmen
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['immobilien'])],

            // Basisdaten
            'immobilientyp' => ['required', 'string', Rule::in(['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'])],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string', Rule::in(['Kauf', 'Miete'])],
            'zustand' => ['nullable', 'string', Rule::in(['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'])],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'],
            'bautyp' => ['nullable', 'string', Rule::in(['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'])],
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'])],
            'befristung' => ['nullable', 'string', Rule::in(['Unbefristet', 'Befristet'])],
            'befristung_ende' => ['nullable', 'date'],

            // Beschreibung
            'description' => ['required', 'string'],
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],
            // Standort
            'land' => ['required', 'string', 'max:255'],
            'plz' => ['required', 'string', 'max:10'],
            'ort' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'],

            // Preise & Flächen
            'gesamtmiete' => ['nullable', 'numeric', 'min:0'],
            'wohnflaeche' => ['nullable', 'numeric', 'min:0'],
            'grundflaeche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Ausstattung & Heizung
            'ausstattung' => ['nullable', 'array'],
            'ausstattung.*' => ['string', Rule::in([
                'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
                'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
                'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
                'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
            ])],
            'heizung' => ['nullable', 'string', Rule::in(['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'])],

            // Fotos & Dokumente
            'images.*' => ['nullable', 'image', 'max:2048'], // Mehrere Bilder
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'rundgang_link' => ['nullable', 'url', 'max:2048'],
            'objektinformationen_link' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht_link' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht_link' => ['nullable', 'url', 'max:2048'],

            // Kontakt
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_tel' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'firmenname' => ['nullable', 'string', 'max:255'],
            'homepage' => ['nullable', 'url', 'max:2048'],
            'telefon2' => ['nullable', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'immocard_id' => ['nullable', 'string', 'max:255'],
            'immocard_firma_id' => ['nullable', 'string', 'max:255'],
            'zusatzkontakt' => ['boolean'],
        ]);

        // Separate die Bilddateien von den anderen Validierungsdaten
        $imageFiles = $request->file('images'); // Holen Sie sich die hochgeladenen Bilddateien
        $dataToCreateRealEstate = Arr::except($validatedData, ['images']); // Entfernen Sie 'images' aus den Daten für die Erstellung des RealEstate-Objekts

        // 2. Dateiuploads für Dokumente
        $grundrissPath = null;
        if ($request->hasFile('grundriss_path')) {
            $grundrissPath = $request->file('grundriss_path')->store('real_estate_documents', 'public');
        }

        $energieausweisPath = null;
        if ($request->hasFile('energieausweis_path')) {
            $energieausweisPath = $request->file('energieausweis_path')->store('real_estate_documents', 'public');
        }

        // 3. Erstellen Sie den RealEstate-Datensatz
        // Übergeben Sie nur die Daten, die direkt in der RealEstate-Tabelle gespeichert werden
        $realEstate = RealEstate::create(array_merge($dataToCreateRealEstate, [
            'user_id' => Auth::id(), // Weisen Sie die ID des authentifizierten Benutzers zu
            'grundriss_path' => $grundrissPath,
            'energieausweis_path' => $energieausweisPath,
            'zusatzkontakt' => $validatedData['zusatzkontakt'] ?? false,
        ]));

        // 4. Speichern Sie die Bilder in der separaten RealEstateImage-Tabelle
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('real_estate_images', 'public');
                RealEstateImage::create([
                    'real_estate_id' => $realEstate->id,
                    'image_path' => $path, // Stellen Sie sicher, dass dies mit Ihrer DB-Spalte übereinstimmt
                    'is_thumbnail' => ($index === 0), // Setzen Sie das erste Bild als Thumbnail
                ]);
            }
        }

        // 5. Weiterleiten mit einer Erfolgsmeldung
        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich erstellt!');
    }

    /**
     * Zeigt die angegebene Ressource an.
     * Diese Methode dient zum Anzeigen einer einzelnen Immobilienanzeige.
     */
    public function show(RealEstate $realEstate)
    {
        return view('ads.real-estate.show', compact('realEstate'));
    }

    // Sie können bei Bedarf Edit-, Update- und Destroy-Methoden hinzufügen
}
