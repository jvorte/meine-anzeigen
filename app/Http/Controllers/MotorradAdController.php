<?php

namespace App\Http\Controllers;

use App\Models\MotorradAd;
use App\Models\MotorcycleBrand;
use App\Models\MotorcycleModel;
use App\Models\MotorradAdImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MotorradAdController extends Controller
{


    public function index(Request $request)
    {
        // Start with a base query
        $query = MotorradAd::with(['motorcycleBrand', 'motorcycleModel', 'images']);

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('motorcycle_brand_id', $request->input('brand'));
        }

        // Model filter
        if ($request->filled('model')) {
            $query->where('motorcycle_model_id', $request->input('model'));
        }

        // Price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Mileage range filters
        if ($request->filled('min_mileage')) {
            $query->where('mileage', '>=', (int)$request->min_mileage);
        }
        if ($request->filled('max_mileage')) {
            $query->where('mileage', '<=', (int)$request->max_mileage);
        }

        // Year of registration filters
        if ($request->filled('min_year') && $request->filled('max_year')) {
            $query->whereBetween('first_registration', [(int)$request->min_year, (int)$request->max_year]);
        } elseif ($request->filled('min_year')) {
            $query->where('first_registration', '>=', (int)$request->min_year);
        } elseif ($request->filled('max_year')) {
            $query->where('first_registration', '<=', (int)$request->max_year);
        }

        // Power range filters
        if ($request->filled('min_power')) {
            $query->where('power', '>=', (int)$request->min_power);
        }
        if ($request->filled('max_power')) {
            $query->where('power', '<=', (int)$request->max_power);
        }

        // Condition filter (case-insensitive)
        if ($request->filled('condition')) {
            $condition = strtolower($request->input('condition'));
            $query->whereRaw('LOWER(`condition`) = ?', [$condition]);
        }

        // Color filter (case-insensitive)
        if ($request->filled('color')) {
            $color = strtolower($request->input('color'));
            $query->whereRaw('LOWER(`color`) = ?', [$color]);
        }

        // Sorting
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

        $motorradAds = $query->paginate(15);
        $motorcycleBrands = MotorcycleBrand::all();
        $motorcycleModels = MotorcycleModel::all();

        return view('ads.motorrads.index', compact('motorradAds', 'motorcycleBrands', 'motorcycleModels'));
    }

    /**
     * Show the form for creating a new motorrad ad.
     */
    public function create()
    {

        $brands = MotorcycleBrand::orderBy('name')->pluck('name', 'id');


        $initialModels = [];
        if (old('motorcycle_brand_id')) {
            $initialModels = MotorcycleModel::where('motorcycle_brand_id', old('motorcycle_brand_id'))
                ->orderBy('name')
                ->pluck('name', 'id');
        }

        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Other'];
        $conditions = ['New', 'Used', 'Accident', 'Damaged'];

        return view('ads.motorrads.create', compact('brands', 'initialModels', 'colors', 'conditions'));
    }





    public function getModels($id)
    {
        return response()->json(
            MotorcycleModel::where('motorcycle_brand_id', $id)->get(['id', 'name'])
        );
    }





public function store(Request $request)
{
    // Step 1: Validate all incoming data from the form.
    $validatedData = $request->validate([
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0|max:9999999.99',
        'description' => 'required|string',
        'motorcycle_brand_id' => 'required|exists:motorcycle_brands,id',
        'motorcycle_model_id' => [
            'required',
            Rule::exists('motorcycle_models', 'id')->where(function ($query) use ($request) {
                return $query->where('motorcycle_brand_id', $request->motorcycle_brand_id);
            }),
        ],
        'first_registration' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . date('Y')],
        'mileage' => 'required|integer|min:0',
        'power' => 'required|integer|min:1',
        'color' => 'required|string|max:50',
        'condition' => 'required|in:New,Used,Accident,Damaged',
    ]);

    // Step 2: Combine validated data with essential fields
    // The `auth()->id()` gets the ID of the currently logged-in user.
    $dataToSave = array_merge($validatedData, [
        'user_id' => auth()->id(),
        'show_phone' => $request->has('show_phone'),
        'show_mobile_phone' => $request->has('show_mobile_phone'),
        'show_email' => $request->has('show_email'),
    ]);

    // Step 3: Create and save the new motorcycle ad in one command.
    $motorrad = MotorradAd::create($dataToSave);

    // Step 4: Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('motorrad_ads_images', 'public');
            $motorrad->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    // Step 5: Redirect to the dashboard with a success message.
    return redirect()->route('ads.motorrads.index')->with('success', 'Motorrad Anzeige erfolgreich erstellt!');
}



    public function show(MotorradAd $motorrad)
    {
        $motorrad->load(['motorcycleBrand', 'motorcycleModel', 'user', 'images']);
        return view('ads.motorrads.show', compact('motorrad'));
    }






    public function edit(MotorradAd $motorrad)
    {
       

        $brands = MotorcycleBrand::pluck('name', 'id');

   
        $initialModels = [];
        if ($motorrad->motorcycle_brand_id) {
            $initialModels = MotorcycleModel::where('motorcycle_brand_id', $motorrad->motorcycle_brand_id)->pluck('name', 'id');
        }

         $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Other'];
        $conditions = ['New', 'Used', 'Accident', 'Damaged'];
   
        return view('ads.motorrads.edit', compact('motorrad', 'brands', 'initialModels', 'colors', 'conditions'));
    }


    /**
     * Update the specified motorrad ad in storage.
     */
public function update(Request $request, MotorradAd $motorrad)
{
    $validatedData = $request->validate([
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0|max:9999999.99',
        'motorcycle_brand_id' => 'required|exists:motorcycle_brands,id',
        'motorcycle_model_id' => [
            'required',
            Rule::exists('motorcycle_models', 'id')->where(function ($query) use ($request) {
                return $query->where('motorcycle_brand_id', $request->motorcycle_brand_id);
            }),
        ],
        'first_registration' => ['required','integer','digits:4','min:1900','max:'.date('Y')],
        'mileage' => 'required|integer|min:0',
        'power' => 'required|integer|min:1',
        'color' => 'required|string|max:50',
        'condition' => 'required|in:New,Used,Accident,Damaged',
        'existing_images' => 'nullable|array',
        'existing_images.*' => 'exists:motorrad_ad_images,id',
        'show_phone' => 'nullable|boolean',
        'show_mobile_phone' => 'nullable|boolean',
        'show_email' => 'nullable|boolean',
    ]);

    // **ΜΗΝ ΚΑΝΕΙΣ create, απλά fill το υπάρχον**
    $motorrad->fill($validatedData);

    // Φτιάχνουμε τα checkboxes
    $motorrad->show_phone = $request->has('show_phone');
    $motorrad->show_mobile_phone = $request->has('show_mobile_phone');
    $motorrad->show_email = $request->has('show_email');

    // **Σιγουρέψου ότι το user_id δεν χάνεται**
    $motorrad->user_id = $motorrad->user_id ?? auth()->id();

    // Αποθήκευση
    $motorrad->save();

    // Διαχείριση εικόνων (existing + new) όπως πριν
    $currentImageIds = $motorrad->images->pluck('id')->toArray();
    $imagesToKeep = $validatedData['existing_images'] ?? [];
    $imagesToDelete = array_diff($currentImageIds, $imagesToKeep);

    foreach ($imagesToDelete as $imageId) {
        $image = MotorradAdImage::find($imageId);
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('motorrad_ads_images', 'public');
            $motorrad->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('ads.motorrads.show', $motorrad)->with('success', 'Motorrad Anzeige erfolgreich aktualisiert!');
}


    /**
     * Remove the specified motorrad ad from storage.
     */
    public function destroy(MotorradAd $motorrad)
    {
    

        foreach ($motorrad->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $motorrad->delete();

        return redirect()->route('ads.motorrads.index')->with('success', 'Motorrad Anzeige erfolgreich gelöscht!');
    }

    /**
     * Get motorcycle models by brand ID (for AJAX/Alpine.js).
     */
    public function getModelsByBrand($brandId)
    {
        $models = MotorcycleModel::where('motorcycle_brand_id', $brandId)
            ->orderBy('name')
            ->pluck('name', 'id');
        // dd($models); // <--- THIS LINE IS COMMENTED OUT
        return response()->json($models);
    }
}
