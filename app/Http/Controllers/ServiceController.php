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
        // dd('dsdsds');
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['dienstleistungen'])],
            'dienstleistung_kategorie' => ['required', 'string', 'max:255', Rule::in(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'])],
            'titel' => ['required', 'string', 'max:255'], // Titel der Dienstleistung
            'beschreibung' => ['required', 'string'], // Beschreibung
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images[]' validates each file in the array (max 2MB per image)
            'region' => ['required', 'string', 'max:255'], // Region / Ort
            'preis' => ['nullable', 'numeric', 'min:0'], // Preis
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'])], // Verfügbarkeit

        ]);
// dd($validatedData);
        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'bilder' (the file objects) from $validatedData before creating the Service record
        $dataToCreateService = Arr::except($validatedData, ['images']); // Changed from 'images' to 'bilder'

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

    public function edit(Service $ad) // Using route model binding
    {
        // Ensure the authenticated user owns this ad before allowing edit
        // if (auth()->user()->id !== $ad->user_id) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('ads.services.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $ad) // Using route model binding
    {
        // Ensure the authenticated user owns this ad before allowing update
        // if (auth()->user()->id !== $ad->user_id) {
        //     abort(403, 'Unauthorized action.');
        // }

        $validated = $request->validate([
            'dienstleistung_kategorie' => ['required', 'string', Rule::in(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'])],
            'titel' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'preis' => ['nullable', 'numeric', 'min:0'],
            'verfugbarkeit' => ['nullable', 'string', Rule::in(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'])],
            'beschreibung' => ['required', 'string'],
            'new_images.*' => ['nullable', 'image', 'max:2048'], // Max 2MB per image
            'images_to_delete' => ['nullable', 'array'],
            'images_to_delete.*' => ['integer', 'exists:images,id'], // Ensure IDs exist in the images table
        ]);

        // Update the basic ad details
        $ad->update([
            'dienstleistung_kategorie' => $validated['dienstleistung_kategorie'],
            'titel' => $validated['titel'],
            'region' => $validated['region'],
            'preis' => $validated['preis'],
            'verfugbarkeit' => $validated['verfugbarkeit'],
            'beschreibung' => $validated['beschreibung'],
        ]);

        // Handle image deletions
        if (isset($validated['images_to_delete'])) {
            foreach ($validated['images_to_delete'] as $imageId) {
                $image = ServiceImage::find($imageId);
                if ($image && $image->service_ad_id === $ad->id) { // Ensure the image belongs to this ad
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $imageFile) {
                $path = $imageFile->store('ads/images', 'public'); // Store in 'storage/app/public/ads/images'
                $ad->images()->create([
                    'path' => $path,
                    // 'name' => $imageFile->getClientOriginalName(), // Optional: store original name
                    // 'size' => $imageFile->getSize(), // Optional: store size
                ]);
            }
        }

        return redirect()->route('ads.services.show', $ad)->with('success', 'Dienstleistung Anzeige erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $ad) // Using route model binding
    {
        // Ensure the authenticated user owns this ad before allowing deletion
        // if (auth()->user()->id !== $ad->user_id) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Delete associated images from storage
        foreach ($ad->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete the ad and its associated images from the database
        $ad->delete();

        return redirect()->route('dashboard')->with('success', 'Dienstleistung Anzeige erfolgreich gelöscht.'); // Redirect to user's dashboard or ad list
    }
}
