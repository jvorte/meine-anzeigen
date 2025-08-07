<?php

namespace App\Http\Controllers;

use App\Models\CommercialVehicle; // Assuming this is your ad model: CommercialVehicle
use App\Models\Brand; // You might still need this for other sections (e.g., cars)
use App\Models\CommercialBrand; // Correct import for commercial brands
use App\Models\CommercialModel; // Correct import for commercial models
use App\Models\CarModel; // You might still need this for cars
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommercialVehicleController extends Controller
{

    
public function index()
{
    $commercialVehicles = CommercialVehicle::with(['commercialBrand', 'commercialModel', 'user', 'images'])
        ->latest()
        ->paginate(12);

    return view('ads.commercial-vehicles.index', [
        'commercialVehicles' => $commercialVehicles,
        'category' => (object)[
            'name' => 'Commercial Vehicles',
            'slug' => 'commercial-vehicles',
        ]
    ]);
}

    /**
     * Show the form for creating a new commercial vehicle ad.
     */
    public function create()
    {
        // --- FIX START: Define $commercialBrands here ---
        $commercialBrands = CommercialBrand::orderBy('name')->get(); // Fetch commercial brands
    

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Violett', 'Andere'];
        // You mentioned mini-vans/mini-buses, so review this list. 'LKW', 'Anhänger', 'Spezialfahrzeug' might be too broad.
        $commercialVehicleTypes = ['Kleintransporter', 'Minibus', 'Kastenwagen', 'Kombi', 'Pick-up', 'Spezialumbau', 'Andere'];
        $fuelTypes = ['Diesel', 'Benzin', 'Elektro', 'Hybrid', 'Gas'];
        $transmissions = ['Manuell', 'Automatik'];
        $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];

        return view('ads.commercial-vehicles.create', compact(
            'commercialBrands', // Now correctly defined
            // Removed the duplicate 'commercialBrands'
            'colors',
            'commercialVehicleTypes',
            'fuelTypes',
            'transmissions',
            'emissionClasses'
        ));
    }





    /**
     * Store a newly created commercial vehicle ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            
            // --- FIX START: Use commercial_brand_id and commercial_model_id ---
            'commercial_brand_id' => 'required|exists:commercial_brands,id', // Use your new table
            'commercial_model_id' => 'required|exists:commercial_models,id', // Use your new table
            // --- FIX END ---

            'first_registration' => 'required|date',
            'mileage' => 'required|integer|min:0',
            'power' => 'nullable|integer|min:1',
            'color' => 'nullable|string|max:50',
            'condition' => 'required|in:neu,gebraucht,unfallfahrzeug',
            'price' => 'nullable|numeric|min:0',
            'commercial_vehicle_type' => 'required|string|max:100',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'payload_capacity' => 'nullable|integer|min:0',
            'gross_vehicle_weight' => 'nullable|integer|min:0',
            'number_of_axles' => 'nullable|integer|min:1',
            'emission_class' => 'nullable|string|max:50',
            'seats' => 'nullable|integer|min:1',
        ]);
        // dd($validatedData); // For debugging, uncomment if needed

      
        $commercialVehicle = new CommercialVehicle();
        $commercialVehicle->user_id = Auth::id(); // Assign the authenticated user's ID
        $commercialVehicle->fill($validatedData); // Fill all validated data
        $commercialVehicle->save();

        // 3. Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('commercial_vehicle_images', 'public'); // Store in 'storage/app/public/commercial_vehicle_images'
                $commercialVehicle->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

    
        return redirect()->route('dashboard')->with('success', 'Nutzfahrzeug Anzeige erfolgreich erstellt!');
    }






    /**
     * Display the specified resource.
     */
public function show(CommercialVehicle $commercialVehicle)
{

    $commercialVehicle->load(['commercialBrand', 'commercialModel', 'images', 'user']);

    // dd($commercialVehicle);

    return view('ads.commercial-vehicles.show', compact('commercialVehicle'));
}





    /**
     * Show the form for editing the specified commercial vehicle ad.
     *
     * @param  \App\Models\CommercialVehicle  $commercialAd
     * @return \Illuminate\Http\Response
     */
public function edit(CommercialVehicle $commercialVehicle) // Renamed parameter for clarity with your Blade
{
    // Eager load for the edit form if you need to display them this way
    $commercialVehicle->load(['commercialBrand', 'commercialModel']);

    // Pass the necessary data to the view
    $commercialBrands = CommercialBrand::orderBy('name')->get();
    // You might also need to pass initial models for the selected brand
    $initialCommercialModels = collect(); // Initialize empty collection
    if ($commercialVehicle->commercial_brand_id) {
        $initialCommercialModels = CommercialModel::where('commercial_brand_id', $commercialVehicle->commercial_brand_id)->get();
    }

    // Define your static arrays if they are not coming from the database
    $colors = ['Rot', 'Blau', 'Grün', 'Schwarz', 'Weiß', 'Grau', 'Silber', 'Gelb', 'Orange', 'Braun', 'Beige', 'Violett', 'Metallic', 'Andere'];
    $commercialVehicleTypes = ['Kastenwagen', 'LKW', 'Transporter', 'Bus', 'Anhänger', 'Sattelzugmaschine', 'Kipper', 'Pritsche', 'Sonderfahrzeug', 'Wohnmobil']; // Example types
    $fuelTypes = ['Diesel', 'Benzin', 'Elektro', 'Hybrid', 'Gas', 'Ethanol', 'Andere']; // Example types
    $transmissions = ['Manuell', 'Automatik']; // Example types
    $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d']; // Example types

    return view('ads.commercial-vehicles.edit', compact(
        'commercialVehicle', // The main model
        'commercialBrands',
        'initialCommercialModels', // For the model dropdown
        'colors',
        'commercialVehicleTypes',
        'fuelTypes',
        'transmissions',
        'emissionClasses'
    ));
}




public function update(Request $request, CommercialVehicle $commercialVehicle)
{
    // The model is already provided by Route Model Binding, so this line is not needed.
    // $commercialVehicle = CommercialVehicle::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'commercial_brand_id' => 'required|exists:commercial_brands,id',
        'commercial_model_id' => 'required|exists:commercial_models,id',
        'first_registration' => 'required|date',
        'mileage' => 'required|integer|min:0',
        'power' => 'nullable|integer|min:1',
        'color' => 'nullable|string|max:50',
        'condition' => 'required|string|in:neu,gebraucht,unfallfahrzeug',
        'price' => 'nullable|numeric|min:0',
        'commercial_vehicle_type' => 'required|string|max:100',
        'fuel_type' => 'nullable|string|max:50',
        'transmission' => 'nullable|string|max:50',
        'payload_capacity' => 'nullable|integer|min:0',
        'gross_vehicle_weight' => 'nullable|integer|min:0',
        'number_of_axles' => 'nullable|integer|min:1',
        'emission_class' => 'nullable|string|max:50',
        'seats' => 'nullable|integer|min:1',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    
    // Update the existing model instance
    $commercialVehicle->update($validated);

    // Handle new image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('commercial_vehicle_images', 'public');
            $commercialVehicle->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('ads.commercial-vehicles.show', $commercialVehicle);
}


    public function destroy($id)
    {
        $commercialVehicle = CommercialVehicle::findOrFail($id);

        // Delete images from storage and DB
        foreach ($commercialVehicle->images as $image) {
            Storage::disk('public')->delete($image->image_path); // Assuming 'image_path'
            $image->delete();
        }

        $commercialVehicle->delete();

        return redirect()->route('categories.commercial-vehicles.index', 'commercial-vehicle')
            ->with('success', 'Anzeige gelöscht');
    }






    /**
     * Get commercial models by brand ID for AJAX requests.
     *
     * @param  int  $brandId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCommercialModelsByBrand(int $brandId)
    {
        $brand = CommercialBrand::find($brandId);

        if (!$brand) {
            return response()->json(['error' => 'Brand not found.'], 404);
        }

        // Get all models related to this brand, ordered by name
        $models = $brand->models()->select('id', 'name')->orderBy('name')->get();

        return response()->json($models);
    }





}