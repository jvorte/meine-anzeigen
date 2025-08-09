<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['carBrand', 'carModel', 'user', 'images']);

        // Εφαρμογή φίλτρων με βάση τις παραμέτρους του URL
        $query->when($request->filled('brand'), function ($q) use ($request) {
            $q->where('car_brand_id', $request->get('brand'));
        });

        $query->when($request->filled('model'), function ($q) use ($request) {
            $q->where('car_model_id', $request->get('model'));
        });

        $query->when($request->filled('price'), function ($q) use ($request) {
            list($min, $max) = explode('-', $request->get('price'));
            $q->whereBetween('price', [(int)$min, (int)$max]);
        });

        $query->when($request->filled('mileage'), function ($q) use ($request) {
            list($min, $max) = explode('-', $request->get('mileage'));
            $q->whereBetween('mileage', [(int)$min, (int)$max]);
        });

        $query->when($request->filled(['min_year', 'max_year']), function ($q) use ($request) {
            $minYear = (int)$request->get('min_year');
            $maxYear = (int)$request->get('max_year');
            $q->whereBetween('registration', [$minYear, $maxYear]);
        })
            // Handle only a minimum year being provided
            ->when($request->filled('min_year') && !$request->filled('max_year'), function ($q) use ($request) {
                $minYear = (int)$request->get('min_year');
                $q->where('registration', '>=', $minYear);
            })
            // Handle only a maximum year being provided
            ->when($request->filled('max_year') && !$request->filled('min_year'), function ($q) use ($request) {
                $maxYear = (int)$request->get('max_year');
                $q->where('registration', '<=', $maxYear);
            });

        $query->when($request->filled('vehicle_type'), function ($q) use ($request) {
            $q->where('vehicle_type', $request->get('vehicle_type'));
        });

        $query->when($request->filled('condition'), function ($q) use ($request) {
            $q->where('condition', $request->get('condition'));
        });

        $query->when($request->filled('warranty'), function ($q) use ($request) {
            $q->where('warranty', $request->get('warranty'));
        });

        $query->when($request->filled('power'), function ($q) use ($request) {
            list($min, $max) = explode('-', $request->get('power'));
            $q->whereBetween('power', [(int)$min, (int)$max]);
        });

        $query->when($request->filled('fuel_type'), function ($q) use ($request) {
            $q->where('fuel_type', $request->get('fuel_type'));
        });

        $query->when($request->filled('transmission'), function ($q) use ($request) {
            $q->where('transmission', $request->get('transmission'));
        });

        $query->when($request->filled('drive'), function ($q) use ($request) {
            $q->where('drive', $request->get('drive'));
        });

        $query->when($request->filled('color'), function ($q) use ($request) {
            $q->where('color', $request->get('color'));
        });

        $query->when($request->filled('doors'), function ($q) use ($request) {
            $q->where('doors', $request->get('doors'));
        });

        $query->when($request->filled('seats'), function ($q) use ($request) {
            $q->where('seats', $request->get('seats'));
        });

        $cars = $query->latest()->paginate(12);

        $brands = CarBrand::all();
        $models = CarModel::all();

        return view('ads.cars.index', [
            'cars' => $cars,
            'brands' => $brands,
            'models' => $models,
            'category' => (object)[
                'name' => 'Cars',
                'slug' => 'cars',
            ]
        ]);
    }

    /**
     * Επιστρέφει τα μοντέλα με βάση την ID της μάρκας.
     * Χρησιμοποιείται για κλήσεις AJAX από το frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModelsByBrand(Request $request)
    {
        $brandId = $request->input('brand_id');
        $models = CarModel::where('car_brand_id', $brandId)->get();

        return response()->json($models);
    }

    public function create()
    {
        $brands = CarBrand::orderBy('name')->pluck('name', 'id');

        $initialModels = []; // No models initially selected

        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Other'];
        $conditions = ['new', 'used', 'accident', 'damaged'];
        $vehicleTypes = ['sedan', 'station', 'SUV/Off-road', 'coupe', 'convertible', 'minivan', 'pickup'];
        $fuelTypes = ['Petrol', 'Diesel', 'Electric', 'Hybrid', 'LPG', 'CNG'];
        $transmissions = ['manual', 'automatic'];
        $drives = ['front', 'rear', 'all'];
        $sellerTypes = ['Private', 'Handler'];

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
            'registration_to' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . date('Y')],

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
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg'], // Individual image rules
        ]);

        $mappedData = [
            'category_slug' => $data['category_slug'],
            'car_brand_id'  => $data['car_brand_id'],
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
    // In your CarsController@edit method:
    public function edit(Car $car)
    {
        $brands = CarBrand::pluck('name', 'id');

        // Make sure $initialModels contains models for the *actual* brand_id of the car
        $initialModels = [];
        if ($car->brand_id) { // Use $car->brand_id (the correct DB column)
            // Assuming CarModel has a foreign key 'car_brand_id' to CarBrand table
            $initialModels = CarModel::where('car_brand_id', $car->brand_id)->pluck('name', 'id');
        }
        $condition = ['new', 'used', 'accident', 'damaged'];
        $vehicleTypes = ['sedan', 'station', 'SUV/Off-road', 'coupe', 'convertible', 'minivan', 'pickup'];
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Other'];
        $fuelType = ['Petrol', 'Diesel', 'Electric', 'Hybrid', 'LPG', 'CNG'];
        $transmission = ['manual', 'automatic'];
        $drives = ['front', 'rear', 'all'];
        $sellerTypes = ['Private', 'Handler'];


        return view('ads.cars.edit', compact('car', 'brands', 'initialModels', 'colors', 'condition', 'vehicleTypes', 'fuelType', 'transmission', 'drives', 'sellerTypes'));
    }


    public function getModels($id)
    {
        return response()->json(
            CarModel::where('car_brand_id', $id)->get(['id', 'name'])
        );
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
    if (Auth::id() !== $car->user_id) {
        abort(403, 'Unauthorized action. You do not own this car advertisement.');
    }

    $validatedData = $request->validate([
        'category_slug' => ['required', 'string', 'max:255'],
        'car_brand_id' => ['required', 'exists:car_brands,id'],
        'car_model_id' => [
            'nullable',
            Rule::exists('car_models', 'id')->where(function ($query) use ($request) {
                return $query->where('car_brand_id', $request->car_brand_id);
            }),
        ],
        'price_from' => ['required', 'numeric', 'min:0'],
        'mileage_from' => ['required', 'numeric', 'min:0'],
        'registration_to' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],

        'vehicle_type' => ['required', 'string', 'max:255'],
        'condition' => ['required', 'string', Rule::in(['new', 'used', 'accident', 'damaged'])],

        'warranty' => ['nullable', 'string', 'in:yes,no'],
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
        'new_images' => ['nullable', 'array', 'max:10'],
        'new_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        'delete_images' => ['nullable', 'array'],
        'delete_images.*' => ['exists:car_images,id'],
    ]);

    $car->title = $validatedData['title'];
    $car->description = $validatedData['description'];
    $car->car_brand_id = $validatedData['car_brand_id'];
    $car->car_model_id = $validatedData['car_model_id'] ?? null;
    $car->price = $validatedData['price_from'];
    $car->mileage = $validatedData['mileage_from'];
    $car->registration = \Carbon\Carbon::parse($validatedData['registration_to'])->format('Y'); // μόνο έτος
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

    $car->save();

    // Διαγραφή εικόνων
    if (isset($validatedData['delete_images'])) {
        foreach ($validatedData['delete_images'] as $imageId) {
            $image = CarImage::find($imageId);
            if ($image && $image->car_id === $car->id) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
    }

    // Νέες εικόνες
    if ($request->hasFile('new_images')) {
        foreach ($request->file('new_images') as $imageFile) {
            $path = $imageFile->store('car_images', 'public');
            $car->images()->create([
                'image_path' => $path,
                'is_thumbnail' => false,
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
     * @param  \App\Models\CarBrand  $brand The CarBrand model instance resolved by route model binding.
     * @return \Illuminate\Http\JsonResponse
     */
}
