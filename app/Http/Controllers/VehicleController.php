<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;

use App\Models\VehicleImage;
use Illuminate\Support\Facades\Storage;
use App\Models\Ad; // Αν υπάρχει το μοντέλο

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{



//     public function store(Request $request)
// {
//     dd($request->all());
// }





public function store(StoreVehicleRequest $request)
{
    // dd('μπήκαμε στο store', $request->all());

    $data = $request->validated();



    // 1. Δημιουργία αγγελίας
    $ad = Vehicle::create([
        'category_slug'   => $data['category_slug'],
        'brand_id'        => $data['brand_id'] ?? null,
        'car_model_id'    => $data['car_model_id'] ?? null,
        'price'           => $data['price_from'],
        'mileage'         => $data['mileage_from'],
        'registration'    => $data['registration_to'],
        'vehicle_type'    => $data['vehicle_type'] ?? null,
        'condition'       => $data['condition'] ?? null,
        'warranty'        => $data['warranty'] ?? null,
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
    // 2. Επεξεργασία εικόνων
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('/storage/vehicles_img', 'public'); // π.χ. storage/app/public/ads
            VehicleImage::create([
              'vehicle_id' => $ad->id,
    'path' => $path,
            ]);
        }
    }

    return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich erstellt.');
}


}
