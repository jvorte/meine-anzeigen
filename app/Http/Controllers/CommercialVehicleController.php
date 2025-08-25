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
use App\Models\Favorite;
use Illuminate\Validation\Rule;

class CommercialVehicleController extends Controller
{


    public function index(Request $request)
    {
        // Start with a base query
        $query = CommercialVehicle::with(['commercialBrand', 'commercialModel', 'images']);

        // Apply filters if they exist in the request
        if ($request->has('brand') && $request->input('brand')) {
            $query->where('commercial_brand_id', $request->input('brand'));
        }

        if ($request->has('model') && $request->input('model')) {
            $query->where('commercial_model_id', $request->input('model'));
        }

        if ($request->has('min_price') && $request->input('min_price') !== null) {
            $query->where('price', '>=', (int)$request->input('min_price'));
        }

        if ($request->has('max_price') && $request->input('max_price') !== null) {
            $query->where('price', '<=', (int)$request->input('max_price'));
        }

        // Year of registration filters
        if ($request->filled('min_year') && $request->filled('max_year')) {
            $query->whereBetween('first_registration', [(int)$request->min_year, (int)$request->max_year]);
        } elseif ($request->filled('min_year')) {
            $query->where('first_registration', '>=', (int)$request->min_year);
        } elseif ($request->filled('max_year')) {
            $query->where('first_registration', '<=', (int)$request->max_year);
        }

        if ($request->has('first_registration') && $request->input('first_registration')) {
            $registrationRange = explode('-', $request->input('first_registration'));
            $query->whereBetween('first_registration', [(int)$registrationRange[0], (int)$registrationRange[1]]);
        }

        $query->when($request->filled('mileage'), function ($q) use ($request) {
            list($min, $max) = explode('-', $request->get('mileage'));
            $q->whereBetween('mileage', [(int)$min, (int)$max]);
        });


        // Color filter (case-insensitive)
        if ($request->filled('color')) {
            $color = strtolower($request->input('color'));
            $query->whereRaw('LOWER(`color`) = ?', [$color]);
        }

        if ($request->has('power') && $request->input('power')) {
            $powerRange = explode('-', $request->input('power'));
            $query->whereBetween('power', [(int)$powerRange[0], (int)$powerRange[1]]);
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->has('commercial_vehicle_type') && $request->input('commercial_vehicle_type')) {
            $query->where('commercial_vehicle_type', $request->input('commercial_vehicle_type'));
        }

        if ($request->has('fuel_type') && $request->input('fuel_type')) {
            $query->where('fuel_type', $request->input('fuel_type'));
        }

        if ($request->has('transmission') && $request->input('transmission')) {
            $query->where('transmission', $request->input('transmission'));
        }

        if ($request->has('emission_class') && $request->input('emission_class')) {
            $query->where('emission_class', $request->input('emission_class'));
        }

        if ($request->has('seats') && $request->input('seats')) {
            $query->where('seats', $request->input('seats'));
        }


        // Apply sorting based on the request, or default to latest
        $sortBy = $request->input('sort_by', 'latest');

        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $commercialVehicles = $query->paginate(15);
        $commercialBrands = CommercialBrand::all();
        $commercialModels = CommercialModel::all();

        return view('ads.commercial-vehicles.index', compact('commercialVehicles', 'commercialBrands', 'commercialModels'));
    }

    /**
     * Show the form for creating a new commercial vehicle ad.
     */
    public function create()
    {
        // --- FIX START: Define $commercialBrands here ---
        $commercialBrands = CommercialBrand::orderBy('name')->get(); // Fetch commercial brands

           $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];
   
        return view('ads.commercial-vehicles.create', compact(
            'commercialBrands',   
               'emissionClasses',
        ));
    }


    /**
     * Store a newly created commercial vehicle ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([

            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'commercial_brand_id' => 'required|exists:commercial_brands,id',
            'commercial_model_id' => 'required|exists:commercial_models,id',
            'first_registration' => ['required', 'integer', 'min:1990', 'max:' . date('Y')],
            'mileage' => 'required|integer|min:0',
            'power' => 'nullable|integer|min:1',
            'color' => 'nullable|string|max:50',
            'condition' => 'required|string',
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
      

// dd($validatedData);
        $commercialVehicle = new CommercialVehicle();
        $commercialVehicle->user_id = Auth::id(); // Assign the authenticated user's ID
        $commercialVehicle->show_phone = $request->has('show_phone') ? 1 : 0;
        $commercialVehicle->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $commercialVehicle->show_email = $request->has('show_email') ? 1 : 0;
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



        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Purple', 'Other'];
        $commercialVehicleTypes = ['Small van', 'Minibus', 'Panel van', 'Station wagon', 'Pick-up', 'Special conversion', 'Other'];
        $fuelTypes = ['Diesel', 'Petrol', 'Electric', 'Hybrid', 'Gas'];
        $transmissions = ['manual', 'automatic'];
        $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'];
        $conditions = [
            'new' => 'New',
            'used' => 'Used',
            'Accident vehicle' => 'Accident vehicle',
            'Damaged vehicle' => 'Damaged vehicle'
        ];


        return view('ads.commercial-vehicles.edit', compact(
            'commercialVehicle', // The main model
            'commercialBrands',
            'initialCommercialModels', // For the model dropdown
            'colors',
            'commercialVehicleTypes',
            'fuelTypes',
            'transmissions',
            'emissionClasses',
            'conditions'

        ));


        
    }




public function update(Request $request, CommercialVehicle $commercialVehicle)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'commercial_brand_id' => 'required|exists:commercial_brands,id',
        'commercial_model_id' => 'required|exists:commercial_models,id',
        'first_registration' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        'mileage' => 'required|integer|min:0',
        'power' => 'nullable|integer|min:1',
        'color' => 'nullable|string|max:50',
        'condition' => 'required|string', // Combined rules
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

    // Update the checkbox values, which are not in the $validated array
    $commercialVehicle->show_phone = $request->has('show_phone') ? 1 : 0;
    $commercialVehicle->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
    $commercialVehicle->show_email = $request->has('show_email') ? 1 : 0;
    
    // Save these new changes to the database
    $commercialVehicle->save();

    // Handle new image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('commercial_vehicle_images', 'public');
            $commercialVehicle->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('ads.commercial-vehicles.show', $commercialVehicle)->with('success', 'Commercial vehicle updated successfully!');
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



    
public function favorite(CommercialVehicle $commercialVehicle)
{
    $user = auth()->user();

    // Check if the user has already favorited this specific ad.
    // The `where()` clauses must match the polymorphic columns in your favorites table.
    $existingFavorite = $user->favorites()
                             ->where('favoriteable_id', $commercialVehicle->id)
                             ->where('favoriteable_type', get_class($commercialVehicle))
                             ->first();

    if ($existingFavorite) {
        // If the favorite exists, delete it.
        $existingFavorite->delete();
        $message = 'Ad removed from favorites!';
    } else {
        // If the favorite does not exist, create a new one.
        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->favoriteable_id = $commercialVehicle->id;
        $favorite->favoriteable_type = get_class($commercialVehicle);
        $favorite->save();
        $message = 'Ad added to favorites!';
    }

    return back()->with('status', $message);
}




public function share(CommercialVehicle $commercialVehicle)
{
    // A simple approach is to get the full URL and pass it to the view
    $shareableUrl = route('ads.commercial-vehicles.show', $commercialVehicle);
    
    // You can then return to the previous page with the URL or a view that displays sharing options.
    return view('ads.boats.show', ['commercialVehicle' => $commercialVehicle, 'shareUrl' => $shareableUrl]);
}

public function print(CommercialVehicle $commercialVehicle)
{
    // The show method already handles fetching the ad and related data.
    // The print method can use the same logic but return a different view.
    return view('ads.commercial-vehicles.print', [
        'commercialVehicle' => $commercialVehicle,
    ]);
}


}
