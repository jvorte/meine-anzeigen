<?php

namespace App\Http\Controllers;

use App\Models\Electronic;
use App\Models\ElectronicImage; // Import the ElectronicImage Model
use App\Models\Brand;
use App\Models\ElectronicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Import Arr helper

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
        if (old('brand_id')) {
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
            'brand' => 'nullable|exists:brands,id',
            'model' => 'nullable|exists:brands,id',
            'electronic_model_id' => 'nullable|exists:electronic_models,id',
            'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
            'warranty_status' => 'nullable|string|max:100',
            'accessories' => 'nullable|string|max:1000',
        ]);

        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'images' (the file objects) from $validatedData before creating the Electronic record
        $dataToCreateElectronic = Arr::except($validatedData, ['images']);

        // 2. Create the Electronic record first
        $electronic = Electronic::create(array_merge($dataToCreateElectronic, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
        ]));

        // 3. Handle image uploads and save to ElectronicImage model
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('electronic_images', 'public'); // Store in 'storage/app/public/electronic_images'
                ElectronicImage::create([
                    'electronic_id' => $electronic->id,
                    'image_path' => $path,
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
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

    // You can add edit, update, destroy methods as needed
}
