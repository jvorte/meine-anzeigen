<?php

namespace App\Http\Controllers;
use App\Models\ElectronicBrand;
use App\Models\Electronic;
use App\Models\ElectronicImage; // Import the ElectronicImage Model
use App\Models\Brand;
use App\Models\ElectronicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse; // Add this import for redirect types

use Illuminate\View\View;

class ElectronicController extends Controller
{
    /**
     * Show the form for creating a new electronic ad.
     */
public function create()
    {
        $categories = [
            'Mobile Phone',
            'TV',
            'Laptop',
            'Camera',
            'Audio Device',
            'Gaming Console',
            'Smartwatch',
            'Tablet',
            'Other'
        ];

        $warrantyStatuses = [
            'No warranty',
            'Manufacturer Warranty',
            'Retailer Warranty',
            'Used Warranty'
        ];

        // Fetch brands from the NEW ElectronicBrand model
        $electronicBrands = ElectronicBrand::orderBy('name')->get();

        // Handle pre-selected old value for electronic models if brand_id was already selected
        $initialElectronicModels = [];
        if (old('brand_id')) { // brand_id here still refers to the foreign key in electronics table
            $initialElectronicModels = ElectronicModel::where('brand_id', old('brand_id'))->pluck('name', 'id')->toArray();
        }

        return view('ads.electronics.create', compact('categories', 'warrantyStatuses', 'electronicBrands', 'initialElectronicModels'));
    }


public function store(Request $request)
    {
        // ... (validation rules and logic remain the same as previous answer) ...
        $rules = [
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:neu,gebraucht,defekt',
            'category' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:electronic_brands,id', // IMPORTANT: Validate against electronic_brands
            'electronic_model_id' => 'nullable|exists:electronic_models,id',
            'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
            'warranty_status' => 'nullable|string|max:255',
            'accessories' => 'nullable|string|max:65535',
        ];

        // Define rules for fields that are conditionally required based on category
        $conditionalRules = [
            // ... (keep your conditional rules as before) ...
            'Mobile Phone' => [
                'color' => 'nullable|string|max:50',
                'usage_time' => 'nullable|string|max:100',
                'operating_system' => 'nullable|string|max:100',
                'storage_capacity' => 'nullable|string|max:100',
                'processor' => 'nullable|string|max:100',
                'ram' => 'nullable|string|max:100',
            ],
            'TV' => [
                'screen_size' => 'nullable|string|max:100',
                'usage_time' => 'nullable|string|max:100',
            ],
        ];

        $selectedCategory = $request->input('category');
        if ($selectedCategory && isset($conditionalRules[$selectedCategory])) {
            $rules = array_merge($rules, $conditionalRules[$selectedCategory]);
        }

        $validatedData = $request->validate($rules);

        $imageFiles = $request->file('images');
        $dataToCreateElectronic = Arr::except($validatedData, ['images']);
        $dataToCreateElectronic['user_id'] = Auth::id();
        $dataToCreateElectronic['status'] = 'active';

        $electronic = Electronic::create($dataToCreateElectronic);

        // ... (image handling remains the same) ...
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('electronic_images', 'public');
                ElectronicImage::create([
                    'electronic_id' => $electronic->id,
                    'image_path' => $path,
                    'is_thumbnail' => ($index === 0),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Elektronik Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
public function show(Electronic $electronic)
    {
        // Eager load all necessary relationships for the show page
        $electronic->load(['electronicBrand', 'electronicModel', 'images']);

        // --- DEBUG STEP ---
        // Temporarily uncomment the line below to see all the data.
        // This is the most important step to understand what's missing.
        // dd($electronic->toArray());
        // ------------------

        return view('ads.electronics.show', compact('electronic'));
    }

    public function edit(Electronic $electronic)
    {
        $warrantyStatuses = ['Keine', 'Noch gültig', 'Abgelaufen'];
        $initialElectronicModels = $electronic->brand
            ? $electronic->brand->electronicModels->pluck('name', 'id')
            : [];

        return view('ads.electronics.edit', compact('electronic', 'warrantyStatuses', 'initialElectronicModels'));
    }
 public function update(Request $request, Electronic $electronic)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'brand' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'electronic_model_id' => 'nullable|exists:electronic_models,id',
        'price' => 'nullable|numeric',
        'condition' => 'nullable|string|in:neu,gebraucht,defekt',
        'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
        'warranty_status' => 'nullable|string|max:255',
        'accessories' => 'nullable|string',
        'new_images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        'delete_images' => 'array',
        'delete_images.*' => 'integer|exists:electronic_images,id',
    ]);

    // Απομόνωσε τα πεδία που θέλεις να κάνεις update (χωρίς new_images & delete_images)
    $updateData = collect($validatedData)->except(['new_images', 'delete_images'])->toArray();

    $electronic->update($updateData);

    // Διαγραφή εικόνων που επιλέχθηκαν για διαγραφή
    if ($request->filled('delete_images')) {
        $imagesToDelete = $electronic->images()->whereIn('id', $request->input('delete_images'))->get();

        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    // Αποθήκευση νέων εικόνων
    if ($request->hasFile('new_images')) {
        foreach ($request->file('new_images') as $imageFile) {
            $path = $imageFile->store('electronics', 'public');
            $electronic->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('categories.electronics.show', $electronic)->with('success', 'Anzeige aktualisiert.');
}


public function destroy(Electronic $electronic)
{
    // Delete images
    foreach ($electronic->images as $image) {
        // Check if the path exists before attempting to delete the file
        if ($image->path) { // <--- ADD THIS CHECK
            Storage::delete($image->path);
        }
        // Always delete the image record from the database, regardless of file existence
        $image->delete();
    }

    $electronic->delete();

    return redirect()->route('dashboard', 'elektronik')->with('success', 'Anzeige gelöscht.');
}
}
