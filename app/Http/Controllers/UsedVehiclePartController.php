<?php

namespace App\Http\Controllers;

use App\Models\UsedVehiclePart;
use App\Models\Brand; // This might be redundant if you're using CarBrand
use App\Models\CarModel;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsedVehiclePartController extends Controller
{
    /**
     * Show the form for creating a new used vehicle part ad.
     */
    public function create()
    {
        $brands = CarBrand::orderBy('name')->pluck('name', 'id');
        $models = []; // No models initially selected for create form

        $partCategories = [
            'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
            'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
            'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
            'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
        ];
        $conditions = ['neu', 'gebraucht', 'überholt', 'defekt'];

        return view('ads.used-vehicle-parts.create', compact(
            'brands',
            'models', // Still pass this, even if empty, for Alpine.js init
            'partCategories',
            'conditions'
        ));
    }

    /**
     * Store a newly created used vehicle part ad in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Added webp for modern browsers
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|in:neu,gebraucht,überholt,defekt',
            'price' => 'nullable|numeric|min:0',
            'car_brand_id' => ['required', 'exists:car_brands,id'],
            'car_model_id' => [
                'nullable',
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('car_brand_id', $request->car_brand_id);
                }),
            ],
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

    // ✅ Φόρτωσε τις εικόνες
    $usedVehiclePart->load('images');

    $partCategories = [
        'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
        'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
        'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
        'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
    ];
    $conditions = ['neu', 'gebraucht', 'überholt', 'defekt'];

    $brands = CarBrand::orderBy('name')->pluck('name', 'id');

    $initialModels = [];
    if ($usedVehiclePart->car_brand_id) {
        $initialModels = CarModel::where('car_brand_id', $usedVehiclePart->car_brand_id)
                                 ->pluck('name', 'id')
                                 ->toArray();
    }

    return view('ads.used-vehicle-parts.edit', compact(
        'usedVehiclePart',
        'partCategories',
        'conditions',
        'brands',
        'initialModels'
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // New images being uploaded
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|in:neu,gebraucht,überholt,defekt',
            'price' => 'nullable|numeric|min:0',
            'car_brand_id' => ['required', 'exists:car_brands,id'],
            'car_model_id' => [
                'nullable',
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('car_brand_id', $request->car_brand_id);
                }),
            ],
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',
            'images_to_delete' => 'nullable|array', // Array of image IDs to delete
            'images_to_delete.*' => 'exists:used_vehicle_part_images,id', // Validate each ID exists in the images table
        ]);

        $usedVehiclePart->update($validatedData);

        // Handle image deletions
        if ($request->has('images_to_delete')) {
            foreach ($request->input('images_to_delete') as $imageId) {
                $image = $usedVehiclePart->images()->find($imageId);
                if ($image) {
                    // Delete file from storage
                    Storage::disk('public')->delete($image->image_path);
                    // Delete record from database
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('used_vehicle_part_images', 'public');
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