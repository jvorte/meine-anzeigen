<?php

namespace App\Http\Controllers;

use App\Models\HouseholdItem; // Corrected: Use HouseholdItem
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Import Arr helper

class HouseholdItemController extends Controller
{
    /**
     * Show the form for creating a new household item ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id'); // Reuse existing brands
        $categories = [
            'Möbel', 'Küchengeräte', 'Waschmaschinen & Trockner', 'Staubsauger & Reinigungsgeräte',
            'Beleuchtung', 'Dekoration', 'Gartenmöbel & -geräte', 'Sport & Freizeit', 'Baby & Kind', 'Sonstiges'
        ];
        $conditions = ['neu', 'gebraucht', 'stark gebraucht', 'defekt'];

        return view('ads.household.create', compact(
            'brands',
            'categories',
            'conditions'
        ));
    }

    /**
     * Store a newly created household item ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for files
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:neu,gebraucht,stark gebraucht,defekt',
            'category' => 'required|string|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'model_name' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'dimensions' => 'nullable|string|max:255',
        ]);

        // 2. Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('household_item_images', 'public'); // Store in 'storage/app/public/household_item_images'
                $imagePaths[] = $path;
            }
        }

        // 3. Create the HouseholdItem record
        $householdItem = new HouseholdItem(); // Corrected: Use HouseholdItem
        $householdItem->user_id = Auth::id();

        // Remove 'images' (the file objects) from $validatedData before mass assignment
        $dataToFill = Arr::except($validatedData, ['images']);

        // Assign the collected image paths to the 'image_paths' attribute
        $householdItem->image_paths = $imagePaths; // This will be automatically JSON encoded by the model cast

        $householdItem->fill($dataToFill); // Fill other attributes
        $householdItem->save();

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Haushaltsartikel Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseholdItem $householdItem) // Corrected: Use HouseholdItem
    {
        return view('ads.household.show', compact('householdItem'));
    }

    // You can add edit, update, destroy methods as needed
}
