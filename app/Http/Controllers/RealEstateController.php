<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealEstate; // Make sure this path is correct
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RealEstateController extends Controller
{
    /**
     * Store a newly created real estate ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'],

            // Basisdaten
            'immobilientyp' => ['required', 'string', 'in:wohnung,haus,grundstück,büro,gewerbe,garage'],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string', 'in:altbau,neubau'],
            'zustand' => ['nullable', 'string', 'in:neu,renoviert,gebraucht,sanierungsbeduerftig'],
            'anzahl_zimmer' => ['nullable', 'integer', 'min:0'],
            'bautyp' => ['nullable', 'string', 'in:altbau_vor_1945,neubau'], // Note: Redundant with objekttyp
            'verfugbarkeit' => ['nullable', 'string', 'in:ab_sofort,nach_vereinbarung,ab_datum'],
            'befristung' => ['nullable', 'string', 'in:keine,1_jahr,2_jahre,3_jahre'],
            'befristung_ende' => ['nullable', 'date'],

            // Beschreibung
            'description' => ['required', 'string'], // Hauptbeschreibung
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],

            // Standort
            'land' => ['required', 'string', 'max:255'], // Readonly in frontend, but still validated
            'plz' => ['required', 'string', 'max:10'],
            'ort' => ['required', 'string', 'max:255'],
            'straße' => ['nullable', 'string', 'max:255'],

            // Preise & Flächen
            'gesamtmiete' => ['nullable', 'numeric', 'min:0'],
            'wohnfläche' => ['nullable', 'numeric', 'min:0'],
            'grundfläche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Ausstattung & Heizung
            'ausstattung' => ['nullable', 'array'], // Array of selected checkbox values
            'ausstattung.*' => ['string', Rule::in(['balkon', 'garten', 'keller', 'garage', 'aufzug', 'barrierefrei'])],
            'heizung' => ['nullable', 'string', 'in:zentral,fern,gas,strom,pellets,holz,keine'],

            // Fotos & Dokumente
            'images.*' => ['nullable', 'image', 'max:2048'], // Multiple images
            'grundriss' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Single file, max 5MB (5120 KB)
            'energieausweis' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Single file, max 5MB
            'rundgang' => ['nullable', 'url', 'max:2048'],
            'objektinformationen' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht' => ['nullable', 'url', 'max:2048'],

            // Kontakt
            'kontakt_name' => ['required', 'string', 'max:255'],
            'kontakt_tel' => ['nullable', 'string', 'max:255'],
            'kontakt_email' => ['required', 'email', 'max:255'],
            'firmenname' => ['nullable', 'string', 'max:255'],
            'homepage' => ['nullable', 'url', 'max:2048'],
            'telefon2' => ['nullable', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'immocard_id' => ['nullable', 'string', 'max:255'],
            'immocard_firma_id' => ['nullable', 'string', 'max:255'],
            'zusatzkontakt' => ['boolean'], // For the checkbox
        ]);

        // 2. Handle File Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('real_estate_images', 'public');
                $imagePaths[] = $path;
            }
        }

        $grundrissPath = null;
        if ($request->hasFile('grundriss')) {
            $grundrissPath = $request->file('grundriss')->store('real_estate_documents', 'public');
        }

        $energieausweisPath = null;
        if ($request->hasFile('energieausweis')) {
            $energieausweisPath = $request->file('energieausweis')->store('real_estate_documents', 'public');
        }

        // 3. Create the RealEstate record
        $realEstate = RealEstate::create([
            'category_slug' => $validatedData['category_slug'],
            'immobilientyp' => $validatedData['immobilientyp'],
            'title' => $validatedData['title'],
            'objekttyp' => $validatedData['objekttyp'],
            'zustand' => $validatedData['zustand'],
            'anzahl_zimmer' => $validatedData['anzahl_zimmer'],
            'bautyp' => $validatedData['bautyp'],
            'verfugbarkeit' => $validatedData['verfugbarkeit'],
            'befristung' => $validatedData['befristung'],
            'befristung_ende' => $validatedData['befristung_ende'],
            'description' => $validatedData['description'],
            'objektbeschreibung' => $validatedData['objektbeschreibung'],
            'lage' => $validatedData['lage'],
            'sonstiges' => $validatedData['sonstiges'],
            'zusatzinformation' => $validatedData['zusatzinformation'],
            'land' => $validatedData['land'],
            'plz' => $validatedData['plz'],
            'ort' => $validatedData['ort'],
            'strasse' => $validatedData['straße'],
            'gesamtmiete' => $validatedData['gesamtmiete'],
            'wohnflaeche' => $validatedData['wohnfläche'],
            'grundflaeche' => $validatedData['grundfläche'],
            'kaution' => $validatedData['kaution'],
            'maklerprovision' => $validatedData['maklerprovision'],
            'abloese' => $validatedData['abloese'],
            'ausstattung' => $validatedData['ausstattung'] ?? [], // Ensure it's an array, even if null
            'heizung' => $validatedData['heizung'],
            'images' => $imagePaths,
            'grundriss_path' => $grundrissPath,
            'energieausweis_path' => $energieausweisPath,
            'rundgang_link' => $validatedData['rundgang'],
            'objektinformationen_link' => $validatedData['objektinformationen'],
            'zustandsbericht_link' => $validatedData['zustandsbericht'],
            'verkaufsbericht_link' => $validatedData['verkaufsbericht'],
            'contact_name' => $validatedData['kontakt_name'],
            'contact_tel' => $validatedData['kontakt_tel'],
            'contact_email' => $validatedData['kontakt_email'],
            'firmenname' => $validatedData['firmenname'],
            'homepage' => $validatedData['homepage'],
            'telefon2' => $validatedData['telefon2'],
            'fax' => $validatedData['fax'],
            'immocard_id' => $validatedData['immocard_id'],
            'immocard_firma_id' => $validatedData['immocard_firma_id'],
            'zusatzkontakt' => $validatedData['zusatzkontakt'] ?? false, // Checkbox value
        ]);

        // 4. Redirect with a success message
            return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
        // Or redirect to a specific page, e.g., return redirect()->route('dashboard');
    }
}
