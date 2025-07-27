<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Requests\StoreVehicleRequest; // Consider renaming this to StoreCarRequest
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Import Rule for validation

class CarController extends Controller
{
    /**
     * Display the specified car.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\View\View
     */
    public function show(Car $car)
    {
        return view('ads.cars.show', compact('car'));
    }

    /**
     * Show the form for creating a new car ad.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $brands = Brand::orderBy('name')->pluck('name', 'id');
        $models = CarModel::orderBy('name')->pluck('name', 'id');

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];

        return view('ads.cars.create', compact('brands', 'models', 'colors'));
    }

    /**
     * Store a newly created car ad in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();

        // 1. Create the car ad
        $ad = Car::create([
            'category_slug'   => $data['category_slug'],
            'brand_id'        => $data['brand_id'],
            'car_model_id'    => $data['car_model_id'] ?? null,
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

        Log::info('Car ad created:', $ad->toArray());

        // 2. Process images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = Storage::disk('public')->putFile('cars_img', $image);

                // Safeguard: Ensure only the relative path is stored.
                $cleanedPath = str_replace('storage/app/public/', '', $path);
                $cleanedPath = str_replace('storage\\app\\public\\', '', $cleanedPath); // For Windows paths
                $cleanedPath = str_replace('\\', '/', $cleanedPath); // Normalize backslashes

                CarImage::create([
                    'car_id'     => $ad->id,
                    'image_path' => $cleanedPath,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Auto-Anzeige erfolgreich erstellt.');
    }

    /**
     * Show the form for editing the specified car.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\View\View
     */
    public function edit(Car $car)
    {
        // Ensure only the owner can edit
        if (auth()->id() !== $car->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $brands = Brand::orderBy('name')->pluck('name', 'id');
        $models = CarModel::orderBy('name')->pluck('name', 'id'); // All models, or filter by brand if needed
        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];

        // Pass the car and its associated images to the view
        return view('ads.cars.edit', compact('car', 'brands', 'models', 'colors'));
    }

    /**
     * Update the specified car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Car $car)
    {
        // Ensure only the owner can update
        if (auth()->id() !== $car->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data for updates
        // You might want to create a separate UpdateCarRequest for more complex validation
        $validatedData = $request->validate([
            'category_slug'   => ['required', 'string', Rule::in(['auto'])],
            'brand_id'        => 'required|exists:brands,id',
            'car_model_id'    => 'nullable|exists:car_models,id',
            'price_from'      => 'required|numeric|min:0',
            'mileage_from'    => 'required|numeric|min:0',
            'registration_to' => 'required|date',
            'vehicle_type'    => 'required|string',
            'condition'       => 'required|string',
            'warranty'        => 'required|in:yes,no',
            'power_from'      => 'required|numeric|min:0',
            'fuel_type'       => 'required|string',
            'transmission'    => 'required|string',
            'drive'           => 'required|string',
            'color'           => 'required|string',
            'doors_from'      => 'required|numeric|min:2',
            'seats_from'      => 'required|numeric|min:2',
            'seller_type'     => 'required|string',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'new_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // For new images
            'delete_images'   => 'nullable|array', // Array of image IDs to delete
            'delete_images.*' => 'exists:car_images,id', // Each ID must exist in car_images
        ]);

        // Update car details
        $car->update([
            'category_slug'   => $validatedData['category_slug'],
            'brand_id'        => $validatedData['brand_id'],
            'car_model_id'    => $validatedData['car_model_id'] ?? null,
            'price'           => $validatedData['price_from'],
            'mileage'         => $validatedData['mileage_from'],
            'registration'    => $validatedData['registration_to'],
            'vehicle_type'    => $validatedData['vehicle_type'],
            'condition'       => $validatedData['condition'],
            'warranty'        => $validatedData['warranty'],
            'power'           => $validatedData['power_from'],
            'fuel_type'       => $validatedData['fuel_type'],
            'transmission'    => $validatedData['transmission'],
            'drive'           => $validatedData['drive'],
            'color'           => $validatedData['color'],
            'doors'           => $validatedData['doors_from'],
            'seats'           => $validatedData['seats_from'],
            'seller_type'     => $validatedData['seller_type'],
            'title'           => $validatedData['title'],
            'description'     => $validatedData['description'],
            // user_id and slug typically don't change on update, but if they do, add them here
        ]);

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                if ($image) { // Ensure file exists
                    $path = Storage::disk('public')->putFile('cars_img', $image);
                    $cleanedPath = str_replace('storage/app/public/', '', $path);
                    $cleanedPath = str_replace('storage\\app\\public\\', '', $cleanedPath);
                    $cleanedPath = str_replace('\\', '/', $cleanedPath);

                    CarImage::create([
                        'car_id'     => $car->id,
                        'image_path' => $cleanedPath,
                    ]);
                }
            }
        }

        // Handle image deletions
        if (isset($validatedData['delete_images'])) {
            foreach ($validatedData['delete_images'] as $imageId) {
                $imageToDelete = CarImage::where('car_id', $car->id)->find($imageId);
                if ($imageToDelete) {
                    // Delete from storage
                    Storage::disk('public')->delete($imageToDelete->image_path);
                    // Delete from database
                    $imageToDelete->delete();
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Auto-Anzeige erfolgreich aktualisiert.');
    }
}