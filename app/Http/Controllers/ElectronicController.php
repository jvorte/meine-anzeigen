<?php

namespace App\Http\Controllers;

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
        $brands = Brand::orderBy('name')->get();
        $categories = [
            'Mobiltelefone',
            'Fernseher',
            'Computer & Laptops',
            'Haushaltsgeräte',
            'Kameras & Foto',
            'Audio & HiFi',
            'Gaming Konsolen',
            'Wearables',
            'Drohnen',
            'Sonstiges'
        ];
        $conditions = ['neu', 'gebraucht', 'defekt'];
        $warrantyStatuses = ['Keine Garantie', 'Herstellergarantie', 'Händlergarantie', 'Garantie abgelaufen'];

        $initialElectronicModels = [];
        // Important: check if old('brand_id') exists and is NOT empty, because old('') returns null if not present
        if (!empty(old('brand_id'))) { // Changed from old('brand_id') to !empty(old('brand_id'))
            $initialElectronicModels = ElectronicModel::where('brand_id', old('brand_id'))
                ->orderBy('name')
                ->pluck('name', 'id');
        }

        return view('ads.electronics.create', compact(
            'brands',
            'categories',
            'conditions',
            'warrantyStatuses',
            'initialElectronicModels'
        ));
    }

    /**
     * Store a newly created electronic ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for uploaded files
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:neu,gebraucht,defekt',
            'category' => 'required|string|max:100',
            // Corrected validation rules:
            'brand_id' => 'nullable|exists:brands,id', // 'brand' text input is removed from form
            'electronic_model_id' => [
                'nullable',
                'exists:electronic_models,id',
                // Optional: Ensure the model belongs to the selected brand_id for stricter validation
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $value && $request->input('brand_id') &&
                        !ElectronicModel::where('id', $value)->where('brand_id', $request->input('brand_id'))->exists()
                    ) {
                        $fail('The selected model does not belong to the selected brand.');
                    }
                },
            ],
            // Removed 'model' as it's no longer a direct form input
            // 'model' => 'nullable|exists:brands,id', // This was also incorrect, 'model' should reference 'electronic_models'
            'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
            'warranty_status' => 'nullable|string|max:100',
            'accessories' => 'nullable|string|max:1000',
        ]);
        // dd($validatedData); // Remove this dd() to allow form submission

        // Separate image files from other validated data
        $imageFiles = $request->file('images');
        $dataToCreateElectronic = Arr::except($validatedData, ['images']);

        // 2. Create the Electronic record
        $electronic = Electronic::create(array_merge($dataToCreateElectronic, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
        ]));

        // 3. Handle image uploads and save to ElectronicImage model
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

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Elektronik Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Electronic $electronic)
    {
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
