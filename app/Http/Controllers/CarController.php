<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand; // Make sure this is imported
use App\Models\CarModel; // Make sure this is imported
use App\Models\CarImage; // Assuming you have a CarImage model for car-specific images
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Needed for dynamic model validation

class CarController extends Controller
{
    /**
     * Show the form for creating a new car ad.
     * (Retained for completeness, assuming it exists)
     */
    public function create()
    {
        $brands = CarBrand::orderBy('name')->pluck('name', 'id');
        $initialModels = []; // No models initially selected

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];
        $conditions = ['Neu', 'Gebraucht', 'Unfallfahrzeug']; // Consistent with your blade
        $vehicleTypes = ['Limousine', 'Kombi', 'SUV/Geländewagen', 'Coupé', 'Cabrio', 'Minivan', 'Kleinwagen', 'Pickup']; // Example
        $fuelTypes = ['Benzin', 'Diesel', 'Elektro', 'Hybrid', 'LPG', 'CNG']; // Example
        $transmissions = ['Manuell', 'Automatik']; // Example
        $drives = ['Vorderradantrieb', 'Hinterradantrieb', 'Allrad']; // Example
        $sellerTypes = ['Privat', 'Händler']; // Example

        return view('ads.cars.create', compact(
            'brands',
            'initialModels',
            'colors',
            'conditions',
            'vehicleTypes',
            'fuelTypes',
            'transmissions',
            'drives',
            'sellerTypes'
        ));
    }

    /**
     * Store a newly created car ad in storage.
     * (Retained for completeness, assuming it exists)
     */
    public function store(Request $request)
    {
    //    dd('dd');
        $data = $request->validate([
           
            'category_slug' => ['required', 'string', 'max:255'],
           'car_brand_id' => ['required', 'exists:car_brands,id'], // Validates input named 'car_brand_id'
            'car_model_id' => [
                'nullable',
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('car_brand_id', $request->car_brand_id);
                }),
            ],
            'price_from' => ['required', 'numeric', 'min:0'],
            'mileage_from' => ['required', 'numeric', 'min:0'],
            'registration_to' => ['required', 'date'],
            'vehicle_type' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:255'],
            'warranty' => ['nullable', 'string', 'in:yes,no'], // Corrected validation rule
            'power_from' => ['required', 'numeric', 'min:0'],
            'fuel_type' => ['required', 'string', 'max:255'],
            'transmission' => ['required', 'string', 'max:255'],
            'drive' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'doors_from' => ['required', 'numeric', 'min:2', 'max:7'],
            'seats_from' => ['required', 'numeric', 'min:2', 'max:9'],
            'seller_type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images' => ['nullable', 'array', 'max:10'], // Max 10 images
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Individual image rules
        ]);
//  dd( $data);
        $mappedData = [
            'category_slug' => $data['category_slug'],
            'brand_id'  => $data['car_brand_id'], 
            'car_model_id'  => $data['car_model_id'] ?? null,
            'price' => $data['price_from'],
            'mileage' => $data['mileage_from'],
            'registration' => $data['registration_to'],
            'vehicle_type' => $data['vehicle_type'],
            'condition' => $data['condition'],
            'warranty' => $data['warranty'] ?? 'no',
            'power' => $data['power_from'],
            'fuel_type' => $data['fuel_type'],
            'transmission' => $data['transmission'],
            'drive' => $data['drive'],
            'color' => $data['color'],
            'doors' => $data['doors_from'],
            'seats' => $data['seats_from'],
            'seller_type' => $data['seller_type'],
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::id(),
            'slug' => Str::slug($data['title'] . '-' . uniqid()),
        ];
// dd( $mappedData);
        $car = Car::create($mappedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('car_images', 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'is_thumbnail' => ($index === 0),
                ]);
            }
        }

        return redirect()->route('dashboard', $car)->with('success', 'Auto Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified car ad.
     * (Retained for completeness, assuming it exists)
     */
    public function show(Car $car)
    {
        $car->load(['carBrand', 'carModel', 'user', 'images']); // Assuming relationships are named carBrand and carModel
        return view('ads.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car advertisement.
     *
     * @param  \App\Models\Car  $car The Car model instance to be edited.
     * @return \Illuminate\Http\Response
     */
public function edit(Car $car) // Correct type-hinting for Car model
    {
    
        if (Auth::id() !== $car->user_id) {
            abort(403, 'Unauthorized action. You do not own this car advertisement.');
        }

        // Fetch car brands for the dropdown
        $brands = CarBrand::orderBy('name')->pluck('name', 'id');

        // Fetch car models for the dropdown, pre-filtered by the car's current brand
        $initialModels = [];
        if ($car->car_brand_id) {
            $initialModels = CarModel::where('car_brand_id', $car->car_brand_id)
                                     ->orderBy('name')
                                     ->pluck('name', 'id')
                                     ->toArray();
        }

        // Define options for dropdowns (consistent with your Blade and store method)
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];
        $conditions = ['Neu', 'Gebraucht', 'Unfallfahrzeug'];
        $vehicleTypes = ['Limousine', 'Kombi', 'SUV/Geländewagen', 'Coupé', 'Cabrio', 'Minivan', 'Kleinwagen', 'Pickup'];
        $fuelTypes = ['Benzin', 'Diesel', 'Elektro', 'Hybrid', 'LPG', 'CNG'];
        $transmissions = ['Manuell', 'Automatik'];
        $drives = ['Vorderradantrieb', 'Hinterradantrieb', 'Allrad'];
        $sellerTypes = ['Privat', 'Händler'];

        return view('ads.cars.edit', compact(
            'car',
            'brands',
            'initialModels',
            'colors',
            'conditions',
            'vehicleTypes',
            'fuelTypes',
            'transmissions',
            'drives',
            'sellerTypes'
        ));
    }

    /**
     * Update the specified car advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car The Car model instance to be updated.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Car $car)
    {  
        // Ensure only the owner can update the car ad
        if (Auth::id() !== $car->user_id) {
            abort(403, 'Unauthorized action. You do not own this car advertisement.');
        }
// dd( 'hh');
        // 1. Validation
        $validatedData = $request->validate([
              
            'category_slug' => ['required', 'string', 'max:255'], // Assuming this is still sent
            'brand_id' => ['required', 'exists:car_brands,id'],
            'car_model_id' => [
                'nullable',
                Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('car_brand_id', $request->car_brand_id);
                }),
              
            ],
            'price_from' => ['required', 'numeric', 'min:0'],
            'mileage_from' => ['required', 'numeric', 'min:0'],
            'registration_to' => ['required', 'date'],
            'vehicle_type' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:255'],
            'warranty' => ['nullable', 'string', 'in:yes,no'], // Corrected validation rule for 'yes'/'no' strings
            'power_from' => ['required', 'numeric', 'min:0'],
            'fuel_type' => ['required', 'string', 'max:255'],
            'transmission' => ['required', 'string', 'max:255'],
            'drive' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'doors_from' => ['required', 'numeric', 'min:2', 'max:7'],
            'seats_from' => ['required', 'numeric', 'min:2', 'max:9'],
            'seller_type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'new_images' => ['nullable', 'array', 'max:10'], // For newly uploaded images
            'new_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Rules for each new image
            'delete_images' => ['nullable', 'array'], // Array of image IDs to delete
            'delete_images.*' => ['exists:car_images,id'], // Validate that each ID exists in car_images table
        ]);
//   dd( $validatedData );
        // 2. Map validated data to Car model attributes
        $car->title = $validatedData['title'];
        $car->description = $validatedData['description'];
        $car->car_brand_id = $validatedData['car_brand_id'];
        $car->car_model_id = $validatedData['car_model_id'] ?? null;
        $car->price = $validatedData['price_from'];
        $car->mileage = $validatedData['mileage_from'];
        $car->registration = $validatedData['registration_to'];
        $car->vehicle_type = $validatedData['vehicle_type'];
        $car->condition = $validatedData['condition'];
        $car->warranty = $validatedData['warranty'] ?? 'no';
        $car->power = $validatedData['power_from'];
        $car->fuel_type = $validatedData['fuel_type'];
        $car->transmission = $validatedData['transmission'];
        $car->drive = $validatedData['drive'];
        $car->color = $validatedData['color'];
        $car->doors = $validatedData['doors_from'];
        $car->seats = $validatedData['seats_from'];
        $car->seller_type = $validatedData['seller_type'];
        // category_slug and user_id should not change on update
        $car->save();

        // 3. Handle image deletions
        if (isset($validatedData['delete_images'])) {
            foreach ($validatedData['delete_images'] as $imageId) {
                $image = CarImage::find($imageId);
                if ($image && $image->car_id === $car->id) { // Ensure image belongs to this car
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // 4. Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $imageFile) {
                $path = $imageFile->store('car_images', 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'is_thumbnail' => false, // New images are not thumbnails by default
                ]);
            }
        }

        return redirect()->route('ads.cars.show', $car)->with('success', 'Auto Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified car ad from storage.
     * (Add this method if it's not already present)
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Car $car)
    {
        // Ensure only the owner can delete the car ad
        if (Auth::id() !== $car->user_id) {
            abort(403, 'Unauthorized action. You do not own this car advertisement.');
        }

        // Delete associated images from storage
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the car ad itself (this will also delete images if cascade delete is set up in migration)
        $car->delete();

        return redirect()->route('dashboard')->with('success', 'Auto Anzeige erfolgreich gelöscht!');
    }

    /**
     * Get car models by brand ID (for AJAX/Alpine.js).
     * Assumes CarModel has a 'car_brand_id' foreign key.
     */
    public function getModelsByBrand($brandId)
    {
        $models = CarModel::where('car_brand_id', $brandId)
                          ->orderBy('name')
                          ->pluck('name', 'id');
        return response()->json($models);
    }
}
