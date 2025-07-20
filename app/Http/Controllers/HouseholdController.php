<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Household; // Make sure this path is correct
use App\Models\Brand; // Needed for getModelsByBrand method
use App\Models\CarModel; // Needed for getModelsByBrand method
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import Rule for conditional validation

class HouseholdController extends Controller
{
    /**
     * Store a newly created household ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        // This validation is based on the provided 'haushalt' frontend HTML.
        // It includes brand_id and car_model_id as per your frontend structure.
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'], // Add a hidden input for this in your form
            'subcategory' => ['required', 'string', 'max:255'], // e.g., waschmaschine, staubsauger
            'brand_id' => ['nullable', 'exists:brands,id'], // Validating brand_id from the select box
            'car_model_id' => [ // Validating car_model_id from the select box
                'nullable',
                // Conditionally validate car_model_id only if brand_id is present
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    $query->where('brand_id', $request->brand_id);
                }),
            ],
            'title' => ['required', 'string', 'max:255'], // Titel
            'description' => ['nullable', 'string'], // Beschreibung
            'price' => ['nullable', 'numeric', 'min:0'], // Preis
            'condition' => ['nullable', 'string', 'in:neu,neuwertig,gebraucht,defekt'], // Zustand
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images[]' validates each file in the array
        ]);

        // 2. Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) { // Assuming your file input name is 'images[]'
            foreach ($request->file('images') as $image) {
                // Store image in 'public/household_images' directory
                $path = $image->store('household_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Household record
        $household = Household::create([
            'category_slug' => $validatedData['category_slug'], // Use validated slug from hidden input
            'subcategory' => $validatedData['subcategory'],
            'brand_id' => $validatedData['brand_id'],
            'car_model_id' => $validatedData['car_model_id'], // Will be null if not provided/relevant
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'condition' => $validatedData['condition'],
            'images' => $imagePaths, // Save the array of paths (will be JSON-encoded by Eloquent)
        ]);

        // 4. Redirect with a success message
       return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
        // Or redirect to a specific page, e.g., return redirect()->route('dashboard');
    }

    /**
     * Get car models by brand ID (for Alpine.js dynamic dropdowns).
     * This method is needed because your frontend uses brand_id and car_model_id selects.
     * This method can be shared or duplicated if needed across controllers that use it.
     *
     * @param  int  $brandId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModelsByBrand($brandId)
    {
        // Ensure the Brand exists
        $brand = Brand::find($brandId);

        if (!$brand) {
            return response()->json([], 404); // Or handle error appropriately
        }

        // Fetch models associated with the brand
        // Assuming CarModel has a 'brand_id' foreign key
        $models = CarModel::where('brand_id', $brandId)->orderBy('name')->pluck('name', 'id');

        return response()->json($models);
    }
}
