<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Arr; // Import Arr helper for data manipulation
use Illuminate\Validation\Rule; // Import Rule for advanced validation

class ServiceController extends Controller
{
    /**
     * Show the form for creating a new service ad.
     * This method prepares data needed for the form.
     */
    public function create()
    {
        // Define options for dropdowns, matching the Blade form
        $dienstleistungKategorieOptions = ['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'];
        $verfugbarkeitOptions = ['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'];

        return view('ads.services.create', compact(
            'dienstleistungKategorieOptions',
            'verfugbarkeitOptions'
        ));
    }

    /**
     * Store a newly created service ad in storage.
     * This method handles the form submission and saves data.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['dienstleistungen'])],
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
                $path = $image->store('service_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Service record
        $service = Service::create([
            'user_id' => Auth::id(), // Assign the authenticated user's ID
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
        return redirect()->route('dashboard')->with('success', 'Dienstleistungs-Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     * This method is for showing a single service ad.
     */
    public function show(Service $service)
    {
        return view('ads.services.show', compact('service'));
    }

    // You can add edit, update, destroy methods as needed
}
