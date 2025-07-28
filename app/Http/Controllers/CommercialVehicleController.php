<?php

namespace App\Http\Controllers;

use App\Models\CommercialVehicle;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommercialVehicleController extends Controller
{
    /**
     * Show the form for creating a new commercial vehicle ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id'); // Assuming CarModel covers commercial models
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Violett', 'Andere'];
        $commercialVehicleTypes = ['LKW', 'Transporter', 'Bus', 'Anhänger', 'Spezialfahrzeug', 'Andere'];
        $fuelTypes = ['Diesel', 'Benzin', 'Elektro', 'Hybrid', 'Gas'];
        $transmissions = ['Manuell', 'Automatik'];
        $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];

        return view('ads.commercial-vehicles.create', compact(
            'brands',
            'models',
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
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
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
//    dd($validatedData);
        // 2. Create the CommercialVehicle
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

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Nutzfahrzeug Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommercialVehicle $commercialVehicle)
    {
        return view('ads.commercial-vehicles.show', compact('commercialVehicle'));
    }

  public function edit($id)
    {
        $commercialVehicle = CommercialVehicle::findOrFail($id);

        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id');
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Violett', 'Andere'];
        $commercialVehicleTypes = ['LKW', 'Transporter', 'Bus', 'Anhänger', 'Spezialfahrzeug', 'Andere'];
        $fuelTypes = ['Diesel', 'Benzin', 'Elektro', 'Hybrid', 'Gas'];
        $transmissions = ['Manuell', 'Automatik'];
        $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];

        return view('ads.commercial-vehicles.edit', compact(
            'commercialVehicle', 'brands', 'models', 'colors',
            'commercialVehicleTypes', 'fuelTypes',
            'transmissions', 'emissionClasses'
        ));
    }

    public function update(Request $request, $id)
    {
        $commercialVehicle = CommercialVehicle::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
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
//    dd($validated);
        $commercialVehicle->update($validated);

        // Αν θέλεις να υποστηρίξεις upload νέων εικόνων στο edit, πχ:
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

        // Διαγραφή εικόνων από storage και DB
        foreach ($commercialVehicle->images as $image) {
            Storage::disk('public')->delete($image->image_path); // Σημείωση: Στο show blade εσύ χρησιμοποιείς 'path' ή 'image_path'? (Εδώ βάζω image_path)
            $image->delete();
        }

        $commercialVehicle->delete();

        return redirect()->route('categories.show', 'commercial-vehicle')
            ->with('success', 'Anzeige gelöscht');
    }

}
