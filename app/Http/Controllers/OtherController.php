<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Other;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Arr; // Import Arr helper for data manipulation
use Illuminate\Validation\Rule; // Import Rule for advanced validation

class OtherController extends Controller
{
    /**
     * Show the form for creating a new "other" ad.
     * This method prepares data needed for the form.
     */
    public function create()
    {
        // Define options for dropdowns, matching the Blade form
        $conditionOptions = ['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'];

        return view('ads.others.create', compact(
            'conditionOptions'
        ));
    }

    /**
     * Store a newly created "other" ad in storage.
     * This method handles the form submission and saves data.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['sonstiges'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'condition' => ['nullable', 'string', Rule::in(['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'])],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:2048'], // 'images[]' validates each file in the array
        ]);

        // 2. Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in 'public/other_images' directory
                $path = $image->store('other_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Create the Other record
        $other = Other::create([
            'user_id' => Auth::id(), // Assign the authenticated user's ID
            'category_slug' => $validatedData['category_slug'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'condition' => $validatedData['condition'],
            'location' => $validatedData['location'],
            'contact_phone' => $validatedData['contact_phone'],
            'images' => $imagePaths, // Save the array of paths (will be JSON-encoded by Eloquent due to $casts)
        ]);

        // 4. Redirect with a success message
        return redirect()->route('dashboard')->with('success', 'Sonstiges Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     * This method is for showing a single "other" ad.
     */
    public function show(Other $other)
    {
        return view('ads.others.show', compact('other'));
    }

    // You can add edit, update, destroy methods as needed
}
