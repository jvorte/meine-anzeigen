<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceImage; // Importieren Sie das ServiceImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Importieren Sie Arr helper for data manipulation
use Illuminate\Validation\Rule; // Importieren Sie Rule for advanced validation
use Illuminate\View\View;
class ServiceController extends Controller
{


    
// public function index()
// {
//     $serviceAds = Service::with('images')->latest()->paginate(12);

//     return view('ads.services.index', [
//         'serviceAds' => $serviceAds,
//     ]);
// }


    /**
     * Show the form for creating a new service ad.
     * This method prepares data needed for the form.
     */


public function index(Request $request): View
    {
        // Start with a base query
        $query = Service::query();

        // Apply filters if they exist in the request
        if ($request->has('title') && $request->input('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('service_type') && $request->input('service_type')) {
            $query->where('service_type', $request->input('service_type'));
        }

        if ($request->has('location') && $request->input('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        
        if ($request->has('price') && $request->input('price')) {
            $priceRange = explode('-', $request->input('price'));
            $query->whereBetween('price', [(int)$priceRange[0], (int)$priceRange[1]]);
        }
        
        // Apply sorting based on the request, or default to latest
        $sortBy = $request->input('sort_by', 'latest');
        
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $serviceAds = $query->paginate(12);
        
        // Fetch unique values for filter dropdowns
        $serviceTypes = Service::distinct()->pluck('service_type')->filter()->toArray();
        $locations = Service::distinct()->pluck('location')->filter()->toArray();

        return view('ads.services.index', compact('serviceAds', 'serviceTypes', 'locations'));
    }
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
            'service_type' => ['required', 'string', 'max:255', Rule::in(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'])],
            'title' => ['required', 'string', 'max:255'], // Titel der Dienstleistung
            'description' => ['required', 'string'], // Beschreibung
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images[]' validates each file in the array (max 2MB per image)
            'location' => ['required', 'string', 'max:255'], // Region / Ort
            'price' => ['nullable', 'numeric', 'min:0'], // Preis
            'availability' => ['nullable', 'string', Rule::in(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'])], // Verfügbarkeit

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
            'title' => $validatedData['title'],
            // Map 'beschreibung' from form to 'description' in DB
            'description' => $validatedData['description'],
            // Map 'preis' from form to 'price' in DB
            'price' => $validatedData['price'],
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

   public function edit(Service $service)
{
    return view('ads.services.edit', compact('service'));
}


 // ... (previous code)

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, Service $service) // Using route model binding
    {
    //    dd($request->all(), $request->file('images'));


        $validated = $request->validate([
            'service_type' => ['required', 'string', Rule::in(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'])],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'availability' => ['nullable', 'string', Rule::in(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'])],
            'description' => ['required', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'], // Max 2MB per image
            'images_to_delete' => ['nullable', 'array'],
            'images_to_delete.*' => ['integer', 'exists:service_images,id'], 
        ]);
  
        // Update the basic ad details
        $service->update([
            'service_type' => $validated['service_type'],
            'title' => $validated['title'], // Use 'title' if that's your DB column
            'location' => $validated['location'],
            'price' => $validated['price'], // Use 'price' if that's your DB column
            'availability' => $validated['availability'],
            'description' => $validated['description'], // Use 'description' if that's your DB column
        ]);
     
// dd($validated);
        // Handle image deletions
        if (isset($validated['images_to_delete'])) {
            foreach ($validated['images_to_delete'] as $imageId) {
                $image = ServiceImage::find($imageId);
                // Ensure the image exists and belongs to this ad (using service_id)
                if ($image && $image->service_id === $ad->id) { 
                    Storage::disk('public')->delete($image->image_path); 
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('service_images', 'public'); 
                // Use the correct relationship method from the Service model
                $service->images()->create([ 
                    'image_path' => $path, 
                    'is_thumbnail' => false, 
                ]);
            }

           

        }

        return redirect()->route('ads.services.show', $service)->with('success', 'Dienstleistung Anzeige erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service) // Using route model binding
    {
        
        // Delete associated images from storage
        foreach ($service->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete the ad and its associated images from the database
        $service->delete();

        return redirect()->route('dashboard')->with('success', 'Dienstleistung Anzeige erfolgreich gelöscht.'); // Redirect to user's dashboard or ad list
    }
}
