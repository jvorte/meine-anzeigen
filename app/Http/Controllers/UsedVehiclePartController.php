<?php

namespace App\Http\Controllers;

use App\Models\UsedVehiclePart;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class UsedVehiclePartController extends Controller
{
    /**
     * Show the form for creating a new used vehicle part ad.
     */
    // public function create()
    // {
    //     $brands = Brand::pluck('name', 'id');
    //     $models = CarModel::pluck('name', 'id'); // For compatibility dropdown
    //     $partCategories = [
    //         'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
    //         'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
    //         'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
    //         'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
    //     ];
    //     $conditions = ['neu', 'gebraucht', 'überholt', 'defekt']; // Defined in Blade, but good to have here too

    //     return view('ads.used-vehicle-parts.create', compact(
    //         'brands',
    //         'models',
    //         'partCategories',
    //         'conditions'
    //     ));
    // }
    

        public function create()
    {
        $brands = CarBrand::orderBy('name')->pluck('name', 'id');
        $models = []; // No models initially selected

       $conditions = ['neu', 'gebraucht', 'überholt', 'defekt']; // Defined in Blade, but good to have here too
              $partCategories = [
            'Motor & Anbauteile', 'Getriebe & Antrieb', 'Karosserie & Anbauteile',
            'Fahrwerk & Lenkung', 'Bremsanlage', 'Abgasanlage', 'Elektrik & Beleuchtung',
            'Innenraum & Ausstattung', 'Räder & Reifen', 'Filter & Wartung', 'Kühlsystem',
            'Heizung & Klima', 'Kraftstoffsystem', 'Sonstiges'
        ];

       return view('ads.used-vehicle-parts.create', compact(
            'brands',
            'models',
            'partCategories',
            'conditions'
        ));
    }
    /**
     * Store a newly created used vehicle part ad in storage.
     */
    public function store(Request $request)
    {
        // dd('f');
        // 1. Validation
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|in:neu,gebraucht,überholt,defekt',
            'price' => 'nullable|numeric|min:0',
              'car_brand_id' => ['required', 'exists:car_brands,id'], // Validates input named 'car_brand_id'
            'car_model_id' => [
                'nullable',
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('car_brand_id', $request->car_brand_id);
                }),
            ],
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',
        ]);
// dd($validatedData);
        // 2. Create the UsedVehiclePart
        $usedVehiclePart = new UsedVehiclePart();
        $usedVehiclePart->user_id = Auth::id(); // Assign the authenticated user's ID
        $usedVehiclePart->fill($validatedData); // Fill all validated data
        $usedVehiclePart->save();

        // 3. Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('used_vehicle_part_images', 'public'); // Store in 'storage/app/public/used_vehicle_part_images'
                $usedVehiclePart->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Fahrzeugteil Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UsedVehiclePart $usedVehiclePart)
    {
        return view('ads.used-vehicle-parts.show', compact('usedVehiclePart'));
    }

    // You can add edit, update, destroy methods as needed
}
