<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Other;
use App\Models\OtherImage; // Importieren Sie das OtherImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Importieren Sie Arr helper for data manipulation
use Illuminate\Validation\Rule; // Importieren Sie Rule for advanced validation

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

        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'images' (the file objects) from $validatedData before creating the Other record
        $dataToCreateOther = Arr::except($validatedData, ['images']);

        // 2. Create the Other record first
        $other = Other::create(array_merge($dataToCreateOther, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
        ]));

        // 3. Handle image uploads and save to OtherImage model
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                // Store image in 'public/other_images' directory
                $path = $image->store('other_images', 'public');
                OtherImage::create([
                    'other_id' => $other->id,
                    'image_path' => $path, // Use 'image_path' as per your schema
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                ]);
            }
        }

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
