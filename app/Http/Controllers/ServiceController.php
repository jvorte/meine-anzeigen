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

        // Price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
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


       $serviceCategoryOptions = [
    'cleaning',
    'crafts',
    'it',
    'consulting',
    'transport',
    'other',
    'home_services',
    'health_and_wellness',
    'education',
    'events',
    'creative_services',
    'legal_and_finance',
    'add',
    'project_management',
    'software_development',
    'sales_and_customer_relations',
    'design_and_diagramming',
    'security_and_compliance',
    'it_support_and_service',
    'data_and_analytics',
    'hr_and_team_building',
    'content_and_communication',
    'administrative_tools'
];
        $availabilityOptions = ['immediately', 'by appointment', 'during weekdays', 'weekends'];

        return view('ads.services.create', compact(
            'serviceCategoryOptions',
            'availabilityOptions'
        ));
    }


    public function store(Request $request)
    {
        // dd('dsdsds');
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images.*' => ['nullable', 'image'],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'availability' => ['nullable', 'string'],

        ]);

        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'bilder' (the file objects) from $validatedData before creating the Service record
        $dataToCreateService = Arr::except($validatedData, ['images']); 
        

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

        $service->show_phone = $request->has('show_phone') ? 1 : 0;
        $service->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $service->show_email = $request->has('show_email') ? 1 : 0;
        $service->save();

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


    public function show(Service $service)
    {
        return view('ads.services.show', compact('service'));
    }

    public function edit(Service $service)
    {

        if (Auth::id() !== $service->user_id) {
            abort(403, 'Unauthorized action.');
        }

    $serviceCategoryOptions = [
    'cleaning',
    'crafts',
    'it',
    'consulting',
    'transport',
    'other',
    'home_services',
    'health_and_wellness',
    'education',
    'events',
    'creative_services',
    'legal_and_finance',
    'add',
    'project_management',
    'software_development',
    'sales_and_customer_relations',
    'design_and_diagramming',
    'security_and_compliance',
    'it_support_and_service',
    'data_and_analytics',
    'hr_and_team_building',
    'content_and_communication',
    'administrative_tools'
];
        $availabilityOptions = ['immediately', 'by appointment', 'during weekdays', 'weekends'];

        return view('ads.services.edit', compact('service', 'serviceCategoryOptions', 'availabilityOptions'));
    }


    public function update(Request $request, Service $service) // Using route model binding
    {

        $validated = $request->validate([
            'service_type' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'availability' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'images.*' => ['nullable', 'image'],
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
      $service->show_phone = $request->has('show_phone') ? 1 : 0;
        $service->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $service->show_email = $request->has('show_email') ? 1 : 0;
        $service->save();
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
