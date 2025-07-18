<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;

use App\Models\VehicleImage;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{



    public function store(StoreVehicleRequest $request)
    {
      
        // Αποθήκευση βασικής αγγελίας
    $vehicle = Vehicle::create([
    'user_id' => auth()->id(),
    'title' => $request->title,
    'description' => $request->description,
    'brand_id' => $request->brand_id,
    'car_model_id' => $request->car_model_id,
    'price_from' => $request->price_from,
    'mileage_from' => $request->mileage_from,
    'registration_to' => $request->registration_to,
    'vehicle_type' => $request->vehicle_type,
    'condition' => $request->condition,
    'warranty' => $request->warranty,
    'power_from' => $request->power_from,
    'fuel_type' => $request->fuel_type,
    'transmission' => $request->transmission,
    'drive' => $request->drive,
    'color' => $request->color,
    'doors_from' => $request->doors_from,
    'seats_from' => $request->seats_from,
    'seller_type' => $request->seller_type,
]);


        // Αποθήκευση εικόνων
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('vehicles.index')->with('success', 'Anzeige erfolgreich gespeichert.');
    }
}
