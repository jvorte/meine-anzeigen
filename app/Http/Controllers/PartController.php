<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Brand; // Assuming you have a Brand model
use App\Models\CarModel; // Assuming you have a CarModel model
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import Rule for conditional validation

class PartController extends Controller
{
    /**
     * Store a newly created vehicle part ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'], // Ensure this matches the hidden input name
            'brand_id' => ['nullable', 'exists:brands,id'],
            'car_model_id' => [
                'nullable',
                // Conditionally validate car_model_id only if brand_id is present
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    $query->where('brand_id', $request->brand_id);
                }),
            ],
            'condition' => ['nullable', 'string', 'max:255'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'registration_to' => ['nullable', 'string', 'max:255'], // For "Baujahr oder Alter"
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images.*' validates each file in the array
        ]);

        // 2. Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in 'public/parts_images' directory
                // and get the path relative to the 'public' disk
                $path = $image->store('parts_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Part record
        $part = Part::create([
            'category_slug' => $validatedData['category_slug'],
            'brand_id' => $validatedData['brand_id'],
            'car_model_id' => $validatedData['car_model_id'],
            'condition' => $validatedData['condition'],
            'price_from' => $validatedData['price_from'],
            'registration_to' => $validatedData['registration_to'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'images' => $imagePaths, // Save the array of paths (will be JSON-encoded by Eloquent)
        ]);

        // 4. Redirect with a success message
      return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
        // Or redirect to a specific page, e.g., return redirect()->route('dashboard');
    }

    /**
     * Get car models by brand ID (for Alpine.js dynamic dropdowns).
     * This method is shared with VehicleController if you want to reuse it.
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
        $models = CarModel::where('brand_id', $brandId)->orderBy('name')->pluck('name', 'id');

        return response()->json($models);
    }
}
