<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electronic; // Make sure this path is correct
use Illuminate\Support\Facades\Storage;

class ElectronicsController extends Controller
{
    /**
     * Store a newly created electronic ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        // This validation now correctly reflects the latest HTML for 'elektronik',
        // which uses a free-text 'brand' and does NOT have 'brand_id' or 'car_model_id'.
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255'], // Ensure this hidden input exists in your form
            'subcategory' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'], // Free-text brand input
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'condition' => ['required', 'string', 'in:neu,neuwertig,gebraucht,defekt'], // Ensure these match your <x-select> options
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images.*' validates each file in the array
        ]);

        // 2. Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in 'public/electronics_images' directory
                $path = $image->store('electronics_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Electronic record
        $electronic = Electronic::create([
            'category_slug' => $validatedData['category_slug'], // Use validated slug from hidden input
            'subcategory' => $validatedData['subcategory'],
            'brand' => $validatedData['brand'],
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
}