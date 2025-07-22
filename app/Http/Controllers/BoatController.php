<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\Brand;
use App\Models\CarModel; // Using CarModel for consistency, adjust if you have BoatModel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BoatController extends Controller
{
    /**
     * Show the form for creating a new boat ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id'); // For boat models, if applicable
        $boatTypes = ['Segelboot', 'Motorboot', 'Schlauchboot', 'Kajak', 'Kanu', 'Jetski', 'Hausboot', 'Andere'];
        $materials = ['GFK (Fiberglas)', 'Holz', 'Stahl', 'Aluminium', 'Hypalon', 'PVC', 'Andere'];
        $engineTypes = ['Innenborder', 'Außenborder', 'Segelantrieb', 'Elektro', 'Kein Motor'];
        $conditions = ['neu', 'gebraucht', 'restaurierungsbedürftig']; // Defined in Blade, but good to have here too

        return view('ads.boats.create', compact(
            'brands',
            'models',
            'boatTypes',
            'materials',
            'engineTypes',
            'conditions'
        ));
    }

    /**
     * Store a newly created boat ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'car_model_id' => 'nullable|exists:car_models,id',
            'year_of_construction' => 'required|integer|min:1900|max:' . date('Y'),
            'condition' => 'required|in:neu,gebraucht,restaurierungsbedürftig',
            'price' => 'nullable|numeric|min:0',

            // Boat-specific validation
            'boat_type' => 'required|string|max:100',
            'material' => 'nullable|string|max:100',
            'total_length' => 'nullable|numeric|min:0',
            'total_width' => 'nullable|numeric|min:0',
            'berths' => 'nullable|integer|min:0',
            'engine_type' => 'nullable|string|max:100',
            'engine_power' => 'nullable|integer|min:0',
            'operating_hours' => 'nullable|integer|min:0',
            'last_service' => 'nullable|date',
        ]);

        // 2. Create the Boat
        $boat = new Boat();
        $boat->user_id = Auth::id(); // Assign the authenticated user's ID
        $boat->fill($validatedData); // Fill all validated data
        $boat->save();

        // 3. Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('boat_images', 'public'); // Store in 'storage/app/public/boat_images'
                $boat->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Boots Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Boat $boat)
    {
        return view('ads.boats.show', compact('boat'));
    }

    // You can add edit, update, destroy methods as needed
}
