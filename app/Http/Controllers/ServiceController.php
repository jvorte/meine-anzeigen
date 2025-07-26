<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceImage; // Importieren Sie das ServiceImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Importieren Sie Arr helper for data manipulation
use Illuminate\Validation\Rule; // Importieren Sie Rule for advanced validation

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

        // Separate image files from other validated data
        $imageFiles = $request->file('bilder'); // Get the uploaded image files
        // Remove 'bilder' (the file objects) from $validatedData before creating the Service record
        $dataToCreateService = Arr::except($validatedData, ['bilder']); // Changed from 'images' to 'bilder'

        // 2. Create the Service record first
        $service = Service::create(array_merge($dataToCreateService, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
            // Map 'titel' from form to 'title' in DB
            'title' => $validatedData['titel'],
            // Map 'beschreibung' from form to 'description' in DB
            'description' => $validatedData['beschreibung'],
            // Map 'preis' from form to 'price' in DB
            'price' => $validatedData['preis'],
            // Map 'kontakt_name' from form to 'contact_name' in DB
            'contact_name' => $validatedData['kontakt_name'],
            // Map 'kontakt_tel' from form to 'contact_tel' in DB
            'contact_tel' => $validatedData['kontakt_tel'],
            // Map 'kontakt_email' from form to 'contact_email' in DB
            'contact_email' => $validatedData['kontakt_email'],
        ]));

        // 3. Handle image uploads and save to ServiceImage model
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                // Store image in 'public/service_images' directory
                $path = $image->store('service_images', 'public');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $path, // Use 'image_path' as per your schema
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                ]);
            }
        }

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
