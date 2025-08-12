<?php

namespace App\Http\Controllers;

use App\Models\Camper;
use App\Models\CamperImage;
use App\Models\CamperBrand;
use App\Models\CamperModel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CamperController extends Controller
{



    // Dummy data for dropdowns - you might get this from a database or config
    private  $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Grey', 'Brown', 'Other'];
    private $camperTypes = ['Alcove', 'Semi-integrated', 'Fully integrated', 'Panel van', 'Caravan'];
    private $fuelTypes = ['Petrol', 'Diesel', 'Electric', 'Hybrid', 'LPG', 'CNG'];
    private  $transmissions = ['manual', 'automatic'];
    private $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6'];




    public function index(Request $request)
    {
        // Start with a base query
        $query = Camper::with(['camperBrand', 'camperModel', 'images']);

        // Apply filters if they exist in the request
        if ($request->filled('brand')) {
            $query->where('camper_brand_id', $request->input('brand'));
        }

        if ($request->filled('model')) {
            $query->where('camper_model_id', $request->input('model'));
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int)$request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int)$request->input('max_price'));
        }

        // Power range filter (newly added to match the form)
        if ($request->filled('min_power')) {
            $query->where('power', '>=', (int)$request->input('min_power'));
        }
        if ($request->filled('max_power')) {
            $query->where('power', '<=', (int)$request->input('max_power'));
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->input('transmission'));
        }

        if ($request->filled('emission_class')) {
            $query->where('emission_class', $request->input('emission_class'));
        }

        // Color filter (case-insensitive)
        if ($request->filled('color')) {
            $color = strtolower($request->input('color'));
            $query->whereRaw('LOWER(`color`) = ?', [$color]);
        }

        // Mileage range filters
        if ($request->filled('min_mileage')) {
            $query->where('mileage', '>=', (int)$request->min_mileage);
        }
        if ($request->filled('max_mileage')) {
            $query->where('mileage', '<=', (int)$request->max_mileage);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->input('fuel_type'));
        }

        // Year of registration filters
        if ($request->filled('min_year')) {
            $query->where('first_registration', '>=', (int)$request->min_year);
        }
        if ($request->filled('max_year')) {
            $query->where('first_registration', '<=', (int)$request->max_year);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->filled('camper_type')) {
            $query->where('camper_type', $request->input('camper_type'));
        }

        if ($request->filled('berths')) {
            $berthsRange = explode('-', $request->input('berths'));
            if (count($berthsRange) == 2) {
                $query->whereBetween('berths', [(int)$berthsRange[0], (int)$berthsRange[1]]);
            }
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

        $campers = $query->paginate(15);
        $camperBrands = CamperBrand::all();
        $camperModels = CamperModel::all();
        $camperTypes = ['Panel van', 'Alcove', 'Fully integrated', 'Semi-integrated', 'Caravan'];

        return view('ads.camper.index', compact('campers', 'camperBrands', 'camperModels', 'camperTypes'));
    }
    /**
     * Get models by brand ID for AJAX requests.
     */
    public function getModelsByBrand($brandId)
    {
        // IMPORTANT: Fetch from CamperModel, not Camper, and use pluck('name', 'id')
        $models = CamperModel::where('camper_brand_id', $brandId)->orderBy('name')->pluck('name', 'id');
        return response()->json($models);
    }

    /**
     * Show the form for creating a new camper.
     */
    public function create()
    {

        // Pass all camper brands to the view for the initial dropdown
        $camperBrands = CamperBrand::orderBy('name')->get();

        return view('ads.camper.create', [
            'camperBrands' => $camperBrands,
            'colors' => $this->colors,
            'camperTypes' => $this->camperTypes,
            'fuelTypes' => $this->fuelTypes,
            'transmissions' => $this->transmissions,
            'emissionClasses' => $this->emissionClasses,
        ]);
    }




public function store(Request $request)
{
    // Validation rules
    $validatedData = $request->validate([
        'camper_brand_id' => ['required', 'exists:camper_brands,id'],
        'camper_model_id' => ['nullable', 'exists:camper_models,id'],
        'price' => ['required', 'numeric', 'min:0'],
        'first_registration' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        'mileage' => ['required', 'integer', 'min:0'],
        'power' => ['required', 'integer', 'min:1'],
        'color' => ['required', 'string', 'max:255'],
        'condition' => ['required', 'string', 'max:255'],
        'camper_type' => ['required', 'string', 'max:255'],
        'berths' => ['required', 'integer', 'min:1'],
        'total_length' => ['required', 'numeric', 'min:0'],
        'total_width' => ['required', 'numeric', 'min:0'],
        'total_height' => ['required', 'numeric', 'min:0'],
        'gross_vehicle_weight' => ['required', 'integer', 'min:1'],
        'fuel_type' => ['required', 'string', 'max:255'],
        'transmission' => ['required', 'string', 'max:255'],
        'emission_class' => ['required', 'string', 'max:255'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'images' => ['nullable', 'array', 'max:10'],
        'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    ]);

    // Create the camper with the validated data
    $camper = Auth::user()->campers()->create($validatedData);

    // Set the new values for the checkboxes
    $camper->show_phone = $request->has('show_phone') ? 1 : 0;
    $camper->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
    $camper->show_email = $request->has('show_email') ? 1 : 0;

    // Save the changes to the database
    $camper->save();

    // ... (rest of your image logic)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('camper_images', 'public');
            $camper->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('ads.camper.show', $camper->id)
        ->with('success', 'Wohnmobil Anzeige erfolgreich erstellt!');
}


    /**
     * Display the specified camper.
     */
    public function show(Camper $camper)
    {
        // Eager load relationships needed for the show view, e.g., brand and model
        $camper->load('user', 'images', 'camperBrand', 'camperModel');

        return view('ads.camper.show', compact('camper')); // You'll need to create this view
    }

    /**
     * Show the form for editing the specified camper.
     */
    public function edit(Camper $camper)
    {
        // Add authorization check
        if (Auth::user()->id !== $camper->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $camper->load('images'); // This fetches all associated images for the camper

        // Pass all camper brands to the view
        $camperBrands = CamperBrand::orderBy('name')->get();

        // Pass models specific to the camper's current brand for the initial model dropdown state
        $currentCamperModels = [];
        if ($camper->camper_brand_id) {
            $currentCamperModels = CamperModel::where('camper_brand_id', $camper->camper_brand_id)
                ->orderBy('name')
                ->get();
        }

        return view('ads.camper.edit', [
            'camper' => $camper,
            'camperBrands' => $camperBrands,       // New parameter
            'currentCamperModels' => $currentCamperModels, // New parameter for edit view's model dropdown
            'colors' => $this->colors,
            'camperTypes' => $this->camperTypes,
            'fuelTypes' => $this->fuelTypes,
            'transmissions' => $this->transmissions,
            'emissionClasses' => $this->emissionClasses,
        ]);
    }

    /**
     * Update the specified camper in storage.
     */
    public function update(Request $request, Camper $camper)
    {
        // Validation rules (χωρίς διπλές επαναλήψεις)
        $validatedData = $request->validate([
            'camper_brand_id' => ['required', 'exists:camper_brands,id'],
            'camper_model_id' => ['nullable', 'exists:camper_models,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'first_registration' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'mileage' => ['required', 'integer', 'min:0'],
            'power' => ['required', 'integer', 'min:1'],
            'color' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', Rule::in(['new', 'used', 'accident', 'damaged'])],
            'camper_type' => ['required', 'string', 'max:255'],
            'berths' => ['required', 'integer', 'min:1'],
            'total_length' => ['required', 'numeric', 'min:0'],
            'total_width' => ['required', 'numeric', 'min:0'],
            'total_height' => ['required', 'numeric', 'min:0'],
            'gross_vehicle_weight' => ['required', 'integer', 'min:1'],
            'fuel_type' => ['required', 'string', 'max:255'],
            'transmission' => ['required', 'string', 'max:255'],
            'emission_class' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'delete_images' => ['nullable', 'array'], // αν η φόρμα σου στέλνει delete_images
            'delete_images.*' => ['integer', 'exists:camper_images,id'],
        ]);

        // Ορισμός show_* πεδίων ως 0 ή 1
        $validatedData['show_phone'] = $request->has('show_phone') ? 1 : 0;
        $validatedData['show_mobile_phone'] = $request->has('show_mobile_phone') ? 1 : 0;
        $validatedData['show_email'] = $request->has('show_email') ? 1 : 0;

        // Ενημέρωση camper με validated data
        $camper->update($validatedData);

        // Διαγραφή επιλεγμένων εικόνων
        if (!empty($validatedData['delete_images'])) {
            $imagesToDelete = $camper->images()->whereIn('id', $validatedData['delete_images'])->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Προσθήκη νέων εικόνων (αν υπάρχουν)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('camper_images', 'public');
                $camper->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('ads.camper.show', $camper->id)
            ->with('success', 'Wohnmobil Anzeige erfolgreich aktualisiert!');
    }






    public function destroy(Camper $camper)
    {
        // Add authorization check
        if (Auth::user()->id !== $camper->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated images from storage
        foreach ($camper->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Soft delete the camper record
        $camper->delete();

        return redirect()->route('dashboard')->with('success', 'Wohnmobil Anzeige erfolgreich gelöscht!');
    }
}
