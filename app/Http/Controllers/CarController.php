<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; // <--- CHANGED from App\Models\Vehicle to App\Models\Car
use App\Http\Requests\StoreVehicleRequest; // Consider renaming this to StoreCarRequest
use App\Models\Brand;
use App\Models\CarModel; // Correct - This maps to car models specifically
use App\Models\CarImage; // <--- CHANGED from App\Models\VehicleImage to App\Models\CarImage
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    /**
     * Display the specified car.
     *
     * @param  \App\Models\Car  $car // <--- CHANGED parameter type hint and variable name
     * @return \Illuminate\View\View
     */
    public function show(Car $car) // <--- CHANGED type hint and variable name (matches route model binding in web.php)
    {
        return view('ads.cars.show', compact('car')); // <--- CHANGED view path to 'ads.cars.show' and compact('car')
    }

    /**
     * Show the form for creating a new car ad.
     *
     * @return \Illuminate\View\View
     */
    public function create() // <--- RENAMED from createAutos() to create()
    {
        $brands = Brand::orderBy('name')->pluck('name', 'id');
        $models = CarModel::orderBy('name')->pluck('name', 'id'); // Make sure this is $models

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];

        return view('ads.cars.create', compact('brands', 'models', 'colors')); // <--- CHANGED view path to 'ads.cars.create'
    }

    /**
     * Store a newly created car ad in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request // Consider renaming StoreVehicleRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVehicleRequest $request)
    {
        // dd('μπήκαμε στο store', $request->all()); // Good for debugging, remove in production

        $data = $request->validated();

        // 1. Create the car ad
        $ad = Car::create([ // <--- CHANGED from Vehicle::create to Car::create
            'category_slug'   => $data['category_slug'],
            'brand_id'        => $data['brand_id'],
            'car_model_id'    => $data['car_model_id'] ?? null,
            'price'           => $data['price_from'],
            'mileage'         => $data['mileage_from'],
            'registration'    => $data['registration_to'],
            'vehicle_type'    => $data['vehicle_type'], // This might also need to become 'car_type' or a specific enum
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

        Log::info('Car ad created:', $ad->toArray()); // <--- Log message updated

        // 2. Process images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store on the 'public' disk in the 'cars_img' directory (consider renaming this too)
                $path = Storage::disk('public')->putFile('cars_img', $image); // <--- Consider renaming directory

                CarImage::create([ // <--- CHANGED from VehicleImage::create to CarImage::create
                    'car_id' => $ad->id, // <--- CHANGED from 'vehicle_id' to 'car_id'
                    'path'   => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Auto-Anzeige erfolgreich erstellt.'); // <--- Message updated
    }

    // --- REMOVED: Methods for other vehicle types ---
    // public function createMotorrad() { ... }
    // public function storeMotorrad(Request $request) { ... }
    // public function createNutzfahrzeug() { ... }
    // public function storeNutzfahrzeug(Request $request) { ... }
    // public function createWohnmobile() { ... }
    // public function storeWohnmobile(Request $request) { ... }
    // These methods should be in their respective controllers (MotorradAdController, CommercialVehicleController, CamperController)
}