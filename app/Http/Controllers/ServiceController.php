<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; // Make sure this path is correct
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import Rule for conditional validation (though not strictly needed for this form)

class ServiceController extends Controller
{
    /**
     * Store a newly created service ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        // This validation is based on the provided 'dienstleistungen' frontend HTML.
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'], // Hidden input
            'dienstleistung_kategorie' => ['required', 'string', 'max:255', Rule::in(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'])],
            'titel' => ['required', 'string', 'max:255'], // Titel der Dienstleistung
            'beschreibung' => ['required', 'string'], // Beschreibung
            'bilder.*' => ['nullable', 'image', 'max:2048'], // 'bilder[]' validates each file in the array (max 2MB per image)
            'region' => ['required', 'string', 'max:255'], // Region / Ort
            'preis' => ['nullable', 'numeric', 'min:0'], // Preis
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'])], // Verfügbarkeit

            // Contact Information
            'kontakt_name' => ['required', 'string', 'max:255'], // Name
            'kontakt_tel' => ['nullable', 'string', 'max:255'], // Telefon
            'kontakt_email' => ['required', 'email', 'max:255'], // E-Mail
        ]);

        // 2. Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('bilder')) { // Frontend input name is 'bilder[]'
            foreach ($request->file('bilder') as $image) {
                // Store image in 'public/service_images' directory
                // This path will be stored in the database.
                $path = $image->store('service_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Service record
        $service = Service::create([
            'category_slug' => $validatedData['category_slug'],
            'dienstleistung_kategorie' => $validatedData['dienstleistung_kategorie'],
            'title' => $validatedData['titel'], // Map 'titel' from form to 'title' in DB
            'description' => $validatedData['beschreibung'], // Map 'beschreibung' from form to 'description' in DB
            'region' => $validatedData['region'],
            'price' => $validatedData['preis'],
            'verfugbarkeit' => $validatedData['verfugbarkeit'],
            'contact_name' => $validatedData['kontakt_name'],
            'contact_tel' => $validatedData['kontakt_tel'],
            'contact_email' => $validatedData['kontakt_email'],
            'images' => $imagePaths, // Save the array of paths (will be JSON-encoded by Eloquent due to $casts)
        ]);

        // 4. Redirect with a success message
      return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
        // Alternatively, redirect to a specific route, e.g.:
        // return redirect()->route('services.show', $service->id)->with('success', 'Dienstleistungs-Anzeige erfolgreich erstellt!');
    }
}
