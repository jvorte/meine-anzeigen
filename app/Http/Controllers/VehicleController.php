<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Brand;
use App\Models\CarModel; // Still needed for the initial Brand::orderBy('name')->get() if it references CarModel
use App\Models\VehicleImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    
  /**
     * Display the specified vehicle.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\View\View
     */
    public function show(Vehicle $vehicle) // Laravel automatically finds the Vehicle by ID from the route wildcard
    {
        // The $vehicle variable now contains the specific Vehicle model instance
        // that matches the ID in the URL (e.g., /autos/123 will fetch Vehicle with ID 123)

        // Return a view and pass the vehicle data to it
        return view('vehicles.show', compact('vehicle'));
    }


public function createAutos()
{
 // Ensure these are at the top of the file

    $brands = Brand::orderBy('name')->pluck('name', 'id');
    $models = CarModel::orderBy('name')->pluck('name', 'id'); // Make sure this is $models

    $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];

    return view('ads.auto.create', compact('brands', 'models', 'colors')); // <--- EXACTLY THIS LINE
}

    public function storeFahrzeuge(StoreVehicleRequest $request)
    {
        // dd('μπήκαμε στο store', $request->all()); // Good for debugging, remove in production

        $data = $request->validated();

        // 1. Create the vehicle ad
        $ad = Vehicle::create([
            'category_slug'   => $data['category_slug'],
            'brand_id'        => $data['brand_id'], // Assuming validation makes this required
            'car_model_id'    => $data['car_model_id'] ?? null, // Model can be null if none selected for brand
            'price'           => $data['price_from'],
            'mileage'         => $data['mileage_from'],
            'registration'    => $data['registration_to'],
            'vehicle_type'    => $data['vehicle_type'],
            'condition'       => $data['condition'],
            'warranty'        => $data['warranty'],
            'power'           => $data['power_from'],
            'fuel_type'       => $data['fuel_type'],
            'transmission'    => $data['transmission'],
            'drive'           => $data['drive'],
            'color'           => $data['color'],
            'doors'           => $data['doors_from'],
            'seats'           => $data['seats_from'],
            'seller_type'     => $data['seller_type'],
            'title'           => $data['title'],
            'description'     => $data['description'],
            'user_id'         => auth()->id(),
            'slug'            => Str::slug($data['title']) . '-' . uniqid(),
        ]);

        Log::info('Ad created:', $ad->toArray());

        // 2. Process images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store on the 'public' disk in the 'vehicles_img' directory
                $path = Storage::disk('public')->putFile('vehicles_img', $image);

                VehicleImage::create([
                    'vehicle_id' => $ad->id,
                    'path'       => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
    }

    public function createMotorrad()
    {
        // Same logic, different view or same form with another category slug
        return view('ads.motorrad.create');
    }

    public function storeMotorrad(Request $request)
    {
        // ... (add validation and storage logic for motorrad)
    }

    public function createNutzfahrzeug()
    {
        return view('ads.nutzfahrzeug.create');
    }

    public function storeNutzfahrzeug(Request $request)
    {
        // ...
    }

    public function createWohnmobile()
    {
        return view('ads.wohnmobile.create');
    }

    public function storeWohnmobile(Request $request)
    {
        // ...
    }
}