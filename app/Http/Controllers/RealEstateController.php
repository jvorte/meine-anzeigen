<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealEstate;
use App\Models\RealEstateImage; // Import the RealEstateImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class RealEstateController extends Controller
{
    /**
     * Display a form to create a new real estate listing.
     * This method prepares the data needed for the form.
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
     * Store a newly created real estate listing in storage.
     * This method processes the form submission and saves data.
     */
    public function store(Request $request)
    {
        // Define validation rules, ensuring they match the 'name' attributes of the Blade form
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['immobilien'])],

            // Basic Data
            'immobilientyp' => ['required', 'string', Rule::in(['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'])],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string', Rule::in(['Kauf', 'Miete'])],
            'zustand' => ['nullable', 'string', Rule::in(['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'])],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'],
            'bautyp' => ['nullable', 'string', Rule::in(['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'])],
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'])],
            'befristung' => ['nullable', 'string', Rule::in(['Unbefristet', 'Befristet'])],
            'befristung_ende' => ['nullable', 'date'],

            // Description
            'description' => ['required', 'string'],
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],
            // Location
            'land' => ['required', 'string', 'max:255'],
            'plz' => ['required', 'string', 'max:10'],
            'ort' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'],

            // Prices & Areas
            'gesamtmiete' => ['nullable', 'numeric', 'min:0'],
            'wohnflaeche' => ['nullable', 'numeric', 'min:0'],
            'grundflaeche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Features & Heating
            'ausstattung' => ['nullable', 'array'],
            'ausstattung.*' => ['string', Rule::in([
                'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
                'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
                'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
                'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
            ])],
            'heizung' => ['nullable', 'string', Rule::in(['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'])],

            // Photos & Documents
            'images.*' => ['nullable', 'image', 'max:2048'], // Multiple images
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'rundgang_link' => ['nullable', 'url', 'max:2048'],
            'objektinformationen_link' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht_link' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht_link' => ['nullable', 'url', 'max:2048'],

            // Contact
            'contact_name' => ['required', 'string', 'max:255'],
            // 'contact_tel' => ['nullable', 'string', 'max:255'],
            // 'contact_email' => ['required', 'email', 'max:255'],
            // 'firmenname' => ['nullable', 'string', 'max:255'],
            'homepage' => ['nullable', 'url', 'max:2048'],
            // 'telefon2' => ['nullable', 'string', 'max:255'],
            // 'fax' => ['nullable', 'string', 'max:255'],
            // 'immocard_id' => ['nullable', 'string', 'max:255'],
            // 'immocard_firma_id' => ['nullable', 'string', 'max:255'],
            'zusatzkontakt' => ['boolean'], // Make sure this is validated if present in the form
        ]);

        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get uploaded image files
        // Remove 'images' and 'zusatzkontakt' from the data for RealEstate creation, as 'zusatzkontakt' might not always be present
        $dataToCreateRealEstate = Arr::except($validatedData, ['images', 'zusatzkontakt']); 

        // Handle 'zusatzkontakt' checkbox explicitly, as it might not be present in $validatedData if unchecked
        $dataToCreateRealEstate['zusatzkontakt'] = $request->has('zusatzkontakt');


        // 2. File uploads for documents
        $grundrissPath = null;
        if ($request->hasFile('grundriss_path')) {
            $grundrissPath = $request->file('grundriss_path')->store('real_estate_documents', 'public');
        }

        $energieausweisPath = null;
        if ($request->hasFile('energieausweis_path')) {
            $energieausweisPath = $request->file('energieausweis_path')->store('real_estate_documents', 'public');
        }

        // 3. Create the RealEstate record
        // Pass only the data that is directly stored in the RealEstate table
        $realEstate = RealEstate::create(array_merge($dataToCreateRealEstate, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
            'grundriss_path' => $grundrissPath,
            'energieausweis_path' => $energieausweisPath,
        ]));

        // 4. Save images to the separate RealEstateImage table
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('real_estate_images', 'public');
                RealEstateImage::create([
                    'real_estate_id' => $realEstate->id,
                    'image_path' => $path, // Make sure this matches your DB column
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                ]);
            }
        }

        // 5. Redirect with a success message
        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     * This method is used to display a single real estate listing.
     */
    public function show(RealEstate $realEstate)
    {
        return view('ads.real-estate.show', compact('realEstate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate)
    {
        // Ensure only the owner can edit the listing
        if ($realEstate->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this listing.');
        }

        // Define options for dropdowns and checkboxes, same as in create method
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

        // Ensure 'ausstattung' is an array for the form
        if (!is_array($realEstate->ausstattung)) {
            $realEstate->ausstattung = json_decode($realEstate->ausstattung, true) ?? [];
        }

        return view('ads.real-estate.edit', compact(
            'realEstate',
            'immobilientypOptions',
            'objekttypOptions',
            'zustandOptions',
            'bautypOptions',
            'verfugbarkeitOptions',
            'befristungOptions',
            'heizungOptions',
            'ausstattungOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate)
    {
        // Ensure only the owner can update the listing
        if ($realEstate->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update this listing.');
        }

        // Define validation rules, similar to store method
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['immobilien'])],

            // Basic Data
            'immobilientyp' => ['required', 'string', Rule::in(['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'])],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string', Rule::in(['Kauf', 'Miete'])],
            'zustand' => ['nullable', 'string', Rule::in(['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'])],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'],
            'bautyp' => ['nullable', 'string', Rule::in(['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'])],
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'])],
            'befristung' => ['nullable', 'string', Rule::in(['Unbefristet', 'Befristet'])],
            'befristung_ende' => ['nullable', 'date'],

            // Description
            'description' => ['required', 'string'],
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],
            // Location
            'land' => ['required', 'string', 'max:255'],
            'plz' => ['required', 'string', 'max:10'],
            'ort' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'],

            // Prices & Areas
            'gesamtmiete' => ['nullable', 'numeric', 'min:0'],
            'wohnflaeche' => ['nullable', 'numeric', 'min:0'],
            'grundflaeche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Features & Heating
            'ausstattung' => ['nullable', 'array'],
            'ausstattung.*' => ['string', Rule::in([
                'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
                'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
                'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
                'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
            ])],
            'heizung' => ['nullable', 'string', Rule::in(['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'])],

            // Photos & Documents (images can be added, existing ones are handled separately)
            'images.*' => ['nullable', 'image', 'max:2048'],
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'rundgang_link' => ['nullable', 'url', 'max:2048'],
            'objektinformationen_link' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht_link' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht_link' => ['nullable', 'url', 'max:2048'],

            // Contact
            'contact_name' => ['required', 'string', 'max:255'],
            // 'contact_tel' => ['nullable', 'string', 'max:255'],
            // 'contact_email' => ['required', 'email', 'max:255'],
            // 'firmenname' => ['nullable', 'string', 'max:255'],
            'homepage' => ['nullable', 'url', 'max:2048'],
            // 'telefon2' => ['nullable', 'string', 'max:255'],
            // 'fax' => ['nullable', 'string', 'max:255'],
            // 'immocard_id' => ['nullable', 'string', 'max:255'],
            // 'immocard_firma_id' => ['nullable', 'string', 'max:255'],
            'zusatzkontakt' => ['boolean'],
        ]);

        $imageFiles = $request->file('images');
        $dataToUpdateRealEstate = Arr::except($validatedData, ['images', 'zusatzkontakt']);
        $dataToUpdateRealEstate['zusatzkontakt'] = $request->has('zusatzkontakt');

        // Handle document updates
        if ($request->hasFile('grundriss_path')) {
            // Delete old file if it exists
            if ($realEstate->grundriss_path) {
                Storage::disk('public')->delete($realEstate->grundriss_path);
            }
            $dataToUpdateRealEstate['grundriss_path'] = $request->file('grundriss_path')->store('real_estate_documents', 'public');
        } elseif ($request->boolean('remove_grundriss_path')) { // Check if checkbox for removal is checked
            if ($realEstate->grundriss_path) {
                Storage::disk('public')->delete($realEstate->grundriss_path);
                $dataToUpdateRealEstate['grundriss_path'] = null;
            }
        }

        if ($request->hasFile('energieausweis_path')) {
            // Delete old file if it exists
            if ($realEstate->energieausweis_path) {
                Storage::disk('public')->delete($realEstate->energieausweis_path);
            }
            $dataToUpdateRealEstate['energieausweis_path'] = $request->file('energieausweis_path')->store('real_estate_documents', 'public');
        } elseif ($request->boolean('remove_energieausweis_path')) { // Check if checkbox for removal is checked
            if ($realEstate->energieausweis_path) {
                Storage::disk('public')->delete($realEstate->energieausweis_path);
                $dataToUpdateRealEstate['energieausweis_path'] = null;
            }
        }

        $realEstate->update($dataToUpdateRealEstate);

        // Handle image updates
        // You might have a mechanism in your edit form to remove existing images
        // For new images, simply add them
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('real_estate_images', 'public');
                RealEstateImage::create([
                    'real_estate_id' => $realEstate->id,
                    'image_path' => $path,
                    // You might want a way to re-assign thumbnails or handle existing thumbnails
                    // For simplicity, new images are not set as thumbnails here.
                    // If you allow reordering/setting new thumbnails, that logic would go here.
                    'is_thumbnail' => false,
                ]);
            }
        }

        // Logic to remove individual images:
        // Assume you have an array of image IDs to be removed in the request, e.g., 'remove_images_ids'
        if ($request->has('remove_images_ids')) {
            $imageIdsToRemove = $request->input('remove_images_ids');
            $imagesToDelete = RealEstateImage::whereIn('id', $imageIdsToRemove)
                                ->where('real_estate_id', $realEstate->id)
                                ->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            // If the thumbnail was deleted, find a new one
            if ($realEstate->images()->where('is_thumbnail', true)->doesntExist() && $realEstate->images()->count() > 0) {
                $realEstate->images()->first()->update(['is_thumbnail' => true]);
            }
        }


        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate)
    {
        // Ensure only the owner can delete the listing
        if ($realEstate->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this listing.');
        }

        // Delete associated images from storage and database
        foreach ($realEstate->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete associated documents from storage
        if ($realEstate->grundriss_path) {
            Storage::disk('public')->delete($realEstate->grundriss_path);
        }
        if ($realEstate->energieausweis_path) {
            Storage::disk('public')->delete($realEstate->energieausweis_path);
        }

        // Delete the real estate listing itself
        $realEstate->delete();

        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich gelöscht!');
    }
}