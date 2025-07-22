<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealEstate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Arr; // Import Arr helper for data manipulation
use Illuminate\Validation\Rule; // Import Rule for advanced validation

class RealEstateController extends Controller
{
    /**
     * Show the form for creating a new real estate ad.
     * This method prepares data needed for the form.
     */
    public function create()
    {
        // Define options for dropdowns and checkboxes, matching the Blade form
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
            'ausstattungOptions' // Pass these to the view
        ));
    }

    /**
     * Store a newly created real estate ad in storage.
     * This method handles the form submission and saves data.
     */
    public function store(Request $request)
    {
        // Define validation rules, ensuring they match the Blade form's 'name' attributes
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['immobilien'])],

            // Basisdaten
            'immobilientyp' => ['required', 'string', Rule::in(['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'])],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string', Rule::in(['Kauf', 'Miete'])],
            'zustand' => ['nullable', 'string', Rule::in(['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'])],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'], // Changed to numeric for 0.5 steps
            'bautyp' => ['nullable', 'string', Rule::in(['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'])],
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'])],
            'befristung' => ['nullable', 'string', Rule::in(['Unbefristet', 'Befristet'])],
            'befristung_ende' => ['nullable', 'date'],

            // Beschreibung
            'description' => ['required', 'string'], // Hauptbeschreibung
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],
            // Standort
            'land' => ['required', 'string', 'max:255'],
            'plz' => ['required', 'string', 'max:10'],
            'ort' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'], // Using 'strasse' as in Blade/Migration

            // Preise & Flächen
            'gesamtmiete' => ['nullable', 'numeric', 'min:0'],
            'wohnflaeche' => ['nullable', 'numeric', 'min:0'], // Using 'wohnflaeche' as in Blade/Migration
            'grundflaeche' => ['nullable', 'numeric', 'min:0'], // Using 'grundflaeche' as in Blade/Migration
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Ausstattung & Heizung
            'ausstattung' => ['nullable', 'array'], // Array of selected checkbox values
            // Validate each selected option against the allowed list from the Blade form
            'ausstattung.*' => ['string', Rule::in([
                'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
                'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
                'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
                'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
            ])],
            'heizung' => ['nullable', 'string', Rule::in(['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'])],

            // Fotos & Dokumente
            'images.*' => ['nullable', 'image', 'max:2048'], // Multiple images
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Single file, max 5MB (5120 KB)
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Single file, max 5MB
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
        if ($request->hasFile('grundriss_path')) { // Use 'grundriss_path' matching Blade
            $grundrissPath = $request->file('grundriss_path')->store('real_estate_documents', 'public');
        }

        $energieausweisPath = null;
        if ($request->hasFile('energieausweis_path')) { // Use 'energieausweis_path' matching Blade
            $energieausweisPath = $request->file('energieausweis_path')->store('real_estate_documents', 'public');
        }

        // 3. Create the RealEstate record
        $realEstate = RealEstate::create([
            'user_id' => Auth::id(), // Assign the authenticated user's ID
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
            'strasse' => $validatedData['strasse'], // Corrected field name
            'gesamtmiete' => $validatedData['gesamtmiete'],
            'wohnflaeche' => $validatedData['wohnflaeche'], // Corrected field name
            'grundflaeche' => $validatedData['grundflaeche'], // Corrected field name
            'kaution' => $validatedData['kaution'],
            'maklerprovision' => $validatedData['maklerprovision'],
            'abloese' => $validatedData['abloese'],
            'ausstattung' => $validatedData['ausstattung'] ?? [], // Ensure it's an array, even if null
            'heizung' => $validatedData['heizung'],
            'images' => $imagePaths,
            'grundriss_path' => $grundrissPath,
            'energieausweis_path' => $energieausweisPath,
            'rundgang_link' => $validatedData['rundgang_link'], // Corrected field name
            'objektinformationen_link' => $validatedData['objektinformationen_link'], // Corrected field name
            'zustandsbericht_link' => $validatedData['zustandsbericht_link'], // Corrected field name
            'verkaufsbericht_link' => $validatedData['verkaufsbericht_link'], // Corrected field name
            'contact_name' => $validatedData['contact_name'], // Corrected field name
            'contact_tel' => $validatedData['contact_tel'], // Corrected field name
            'contact_email' => $validatedData['contact_email'], // Corrected field name
            'firmenname' => $validatedData['firmenname'],
            'homepage' => $validatedData['homepage'],
            'telefon2' => $validatedData['telefon2'],
            'fax' => $validatedData['fax'],
            'immocard_id' => $validatedData['immocard_id'],
            'immocard_firma_id' => $validatedData['immocard_firma_id'],
            'zusatzkontakt' => $validatedData['zusatzkontakt'] ?? false, // Checkbox value
        ]);

        // 4. Redirect with a success message
        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     * This method is for showing a single real estate ad.
     */
    public function show(RealEstate $realEstate)
    {
        return view('ads.real-estate.show', compact('realEstate'));
    }

    // You can add edit, update, destroy methods as needed
}
