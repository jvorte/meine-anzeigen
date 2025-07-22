<?php

namespace App\Http\Controllers;

use App\Models\Camper;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CamperController extends Controller
{
    /**
     * Show the form for creating a new camper ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id'); // Assuming CarModel covers camper models
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Violett', 'Andere'];
        $camperTypes = ['Alkoven', 'Teilintegriert', 'Vollintegriert', 'Kastenwagen', 'Wohnwagen', 'Andere'];
        $fuelTypes = ['Diesel', 'Benzin', 'Elektro', 'Hybrid', 'Gas'];
        $transmissions = ['Manuell', 'Automatik'];
        $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];

        return view('ads.camper.create', compact(
            'brands',
            'models',
            'colors',
            'camperTypes',
            'fuelTypes',
            'transmissions',
            'emissionClasses'
        ));
    }

    /**
     * Store a newly created camper ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'first_registration' => 'required|date',
            'mileage' => 'required|integer|min:0',
            'power' => 'nullable|integer|min:1',
            'color' => 'nullable|string|max:50',
            'condition' => 'required|in:neu,gebraucht,unfallfahrzeug',
            'price' => 'nullable|numeric|min:0',

            // Camper-specific validation
            'camper_type' => 'required|string|max:100',
            'berths' => 'nullable|integer|min:1',
            'total_length' => 'nullable|numeric|min:0',
            'total_width' => 'nullable|numeric|min:0',
            'total_height' => 'nullable|numeric|min:0',
            'gross_vehicle_weight' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'emission_class' => 'nullable|string|max:50',
        ]);

        // 2. Create the Camper
        $camper = new Camper();
        $camper->user_id = Auth::id(); // Assign the authenticated user's ID
        $camper->fill($validatedData); // Fill all validated data
        $camper->save();

        // 3. Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('camper_images', 'public'); // Store in 'storage/app/public/camper_images'
                $camper->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Wohnmobil Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Camper $camper)
    {
        return view('ads.camper.show', compact('camper'));
    }

    // You can add edit, update, destroy methods as needed
}
