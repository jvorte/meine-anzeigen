<?php

namespace App\Http\Controllers;

use App\Models\MotorradAd;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MotorradAdController extends Controller
{
    /**
     * Show the form for creating a new motorrad ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id'); // Adjust this if models are dynamic based on brand
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere']; // Example colors

        return view('ads.motorrad.create', compact('brands', 'models', 'colors'));
    }

    /**
     * Store a newly created motorrad ad in storage.
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
            'power' => 'required|integer|min:1',
            'color' => 'required|string|max:50',
            'condition' => 'required|in:neu,gebraucht',
        ]);

        // 2. Create the MotorradAd
        $motorradAd = new MotorradAd();
        $motorradAd->user_id = Auth::id(); // Assign the authenticated user's ID
        $motorradAd->title = $validatedData['title'];
        $motorradAd->description = $validatedData['description'];
        $motorradAd->brand_id = $validatedData['brand_id'];
        $motorradAd->car_model_id = $validatedData['car_model_id'];
        $motorradAd->first_registration = $validatedData['first_registration'];
        $motorradAd->mileage = $validatedData['mileage'];
        $motorradAd->power = $validatedData['power'];
        $motorradAd->color = $validatedData['color'];
        $motorradAd->condition = $validatedData['condition'];
        $motorradAd->save();

        // 3. Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('motorrad_ads_images', 'public'); // Store in 'storage/app/public/motorrad_ads_images'
                $motorradAd->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Motorrad Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MotorradAd $motorradAd)
    {
        return view('ads.motorrad.show', compact('motorradAd'));
    }

    // You can add edit, update, destroy methods as needed
}