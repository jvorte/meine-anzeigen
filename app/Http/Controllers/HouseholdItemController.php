<?php

namespace App\Http\Controllers;

use App\Models\HouseholdItem;
use App\Models\HouseholdItemImage; // Importieren Sie das HouseholdItemImage Model
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
        $brands = Brand::pluck('name', 'id');
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

        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'images' (the file objects) from $validatedData before creating the HouseholdItem record
        $dataToCreateHouseholdItem = Arr::except($validatedData, ['images']);

        // 2. Create the HouseholdItem record first
        $householdItem = HouseholdItem::create(array_merge($dataToCreateHouseholdItem, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
        ]));

        // 3. Handle image uploads and save to HouseholdItemImage model
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('household_item_images', 'public'); // Store in 'storage/app/public/household_item_images'
                HouseholdItemImage::create([
                    'household_item_id' => $householdItem->id,
                    'image_path' => $path, // Use 'image_path' as per your schema
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Haushaltsartikel Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseholdItem $householdItem)
    {
        return view('ads.household.show', compact('householdItem'));
    }

    // You can add edit, update, destroy methods as needed
}
