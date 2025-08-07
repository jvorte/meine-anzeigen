<?php

namespace App\Http\Controllers;

use App\Models\UsedVehiclePart;
// No longer need these for compatibility lookup, as they'll be text inputs
// use App\Models\Brand;
// use App\Models\CarModel;
use App\Models\UsedVehiclePartImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Still useful for general validation, but specific 'exists' rules will change

class UsedVehiclePartController extends Controller
{

public function index()
{
    $usedVehicleParts = UsedVehiclePart::with(['user', 'images']) // προαιρετικά αν έχεις σχέσεις
        ->latest()
        ->paginate(12);

    return view('ads.used-vehicle-parts.index', [
        'usedVehicleParts' => $usedVehicleParts,
        'category' => (object)[
            'name' => 'usedVehicleParts',
            'slug' => 'usedVehicleParts',
        ]
    ]);
}
    /**
     * Show the form for creating a new used vehicle part ad.
     */
    public function create()
    {
        // No longer need to fetch brands or models from the database for dropdowns
        // $brands = CarBrand::orderBy('name')->pluck('name', 'id');
        // $models = [];

        $partCategories = [
            'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
            'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
            'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
            'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
        ];
        $conditions = ['neu', 'gebraucht', 'überholt', 'defekt'];

        // Define a list of generic vehicle types
        $vehicleTypes = [
            'Auto', 'Motorrad', 'LKW', 'Wohnmobil', 'Bus',
            'Anhänger', 'Boot', 'Baumaschine', 'Landmaschine', 'Sonstiges'
        ];

        return view('ads.used-vehicle-parts.create', compact(
            'partCategories',
            'conditions',
            'vehicleTypes' // Pass the new vehicle types
        ));
    }

    /**
     * Store a newly created used vehicle part ad in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|in:neu,gebraucht,überholt,defekt',
            'price' => 'nullable|numeric|min:0',
            // NEW VALIDATION RULES for generic fields
            'vehicle_type' => 'required|string|max:50', // Validate the selected vehicle type
            'compatible_brand' => 'nullable|string|max:255', // Validate the text input for brand
            'compatible_model' => 'nullable|string|max:255', // Validate the text input for model
            // END NEW VALIDATION RULES
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',
        ]);

        $usedVehiclePart = new UsedVehiclePart();
        $usedVehiclePart->user_id = Auth::id();
        $usedVehiclePart->fill($validatedData);
        $usedVehiclePart->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('used_vehicle_part_images', 'public');
                $usedVehiclePart->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Fahrzeugteil Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UsedVehiclePart $usedVehiclePart)
    {
        // No change needed here typically, as the model will fetch the new string fields.
        return view('ads.used-vehicle-parts.show', compact('usedVehiclePart'));
    }

    /**
     * Show the form for editing the specified used vehicle part ad.
     */
   public function edit(UsedVehiclePart $usedVehiclePart)
    {
        if (Auth::id() !== $usedVehiclePart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Make sure images are loaded for the view
        $usedVehiclePart->load('images');

        $partCategories = [
            'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
            'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
            'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
            'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
        ];
        $conditions = ['neu', 'gebraucht', 'überholt', 'defekt'];
        $vehicleTypes = [
            'Auto', 'Motorrad', 'LKW', 'Wohnmobil', 'Bus',
            'Anhänger', 'Boot', 'Baumaschine', 'Landmaschine', 'Sonstiges'
        ];

        return view('ads.used-vehicle-parts.edit', compact(
            'usedVehiclePart',
            'partCategories',
            'conditions',
            'vehicleTypes'
        ));
    }


    /**
     * Update the specified used vehicle part ad in storage.
     */
    public function update(Request $request, UsedVehiclePart $usedVehiclePart)
    {
        // Policy check: Ensure the authenticated user owns this ad
        if (Auth::id() !== $usedVehiclePart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            // Standard fields validation
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|in:neu,gebraucht,überholt,defekt',
            'price' => 'nullable|numeric|min:0',
            'vehicle_type' => 'required|string|max:50',
            'compatible_brand' => 'nullable|string|max:255',
            'compatible_model' => 'nullable|string|max:255',
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',

            // Validation for new image uploads
         'images.*' => ['nullable', 'image', 'max:2048'], // Allow new images

            // Validation for images to be deleted
            'images_to_delete' => 'nullable|array', // Expects an array of image IDs to delete
            // Ensure each ID in the array belongs to an image associated with THIS usedVehiclePart
            'images_to_delete.*' => [
                'integer',
                Rule::exists('used_vehicle_part_images', 'id')->where(function ($query) use ($usedVehiclePart) {
                    $query->where('used_vehicle_part_id', $usedVehiclePart->id);
                }),
            ],
        ]);

        // Update the main UsedVehiclePart data
        $usedVehiclePart->update($validatedData);

        // --- Handle Image Deletions ---
        if ($request->has('images_to_delete')) {
            foreach ($request->input('images_to_delete') as $imageId) {
                // Find the image record to delete
                $image = UsedVehiclePartImage::find($imageId); // Or $usedVehiclePart->images()->find($imageId);

                // Double check it belongs to this ad and actually exists
                if ($image && $image->used_vehicle_part_id === $usedVehiclePart->id) {
                    // Delete the file from storage
                    Storage::disk('public')->delete($image->image_path);
                    // Delete the record from the database
                    $image->delete();
                }
            }
        }

     // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('service_images', 'public'); 
                // Use the correct relationship method from the Service model
                $usedVehiclePart->images()->create([ 
                    'image_path' => $path, 
                 
                ]);
            }

        }

        return redirect()->route('ads.used-vehicle-parts.show', $usedVehiclePart)
                         ->with('success', 'Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified used vehicle part ad from storage.
     */
    public function destroy(UsedVehiclePart $usedVehiclePart)
    {
        // Policy check: Ensure the authenticated user owns this ad
        if (Auth::id() !== $usedVehiclePart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated images from storage first
        foreach ($usedVehiclePart->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the UsedVehiclePart record
        $usedVehiclePart->delete();

        return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich gelöscht!');
    }
}