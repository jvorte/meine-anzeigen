<?php

namespace App\Http\Controllers;

use App\Models\Camper;
use App\Models\CamperImage;
use App\Models\CamperBrand; // Import the CamperBrand model
use App\Models\CamperModel; // Import the CamperModel model
use App\Http\Requests\StoreCamperRequest;
use App\Http\Requests\UpdateCamperRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Make sure this is imported for getModelsByBrand

class CamperController extends Controller
{



    // Dummy data for dropdowns - you might get this from a database or config
    private $colors = ['Black', 'White', 'Silver', 'Grey', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Brown'];
    private $camperTypes = ['Alkoven', 'Teilintegriert', 'Vollintegriert', 'Kastenwagen', 'Wohnwagen'];
    private $fuelTypes = ['Diesel', 'Petrol', 'Electric'];
    private $transmissions = ['Manual', 'Automatic'];
    private $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6'];




// CamperController.php
 public function index(Request $request)
    {
        // Start with a base query
        $query = Camper::with(['camperBrand', 'camperModel', 'images']);

        // Apply filters if they exist in the request
        if ($request->has('brand') && $request->input('brand')) {
            $query->where('camper_brand_id', $request->input('brand'));
        }

        if ($request->has('model') && $request->input('model')) {
            $query->where('camper_model_id', $request->input('model'));
        }

        if ($request->has('price') && $request->input('price')) {
            $priceRange = explode('-', $request->input('price'));
            $query->whereBetween('price', [(int)$priceRange[0], (int)$priceRange[1]]);
        }
        
        if ($request->has('mileage') && $request->input('mileage')) {
            $mileageRange = explode('-', $request->input('mileage'));
            $query->whereBetween('mileage', [(int)$mileageRange[0], (int)$mileageRange[1]]);
        }
        
        if ($request->has('first_registration') && $request->input('first_registration')) {
            $registrationRange = explode('-', $request->input('first_registration'));
            $query->whereBetween('first_registration', [(int)$registrationRange[0], (int)$registrationRange[1]]);
        }
        
        if ($request->has('power') && $request->input('power')) {
            $powerRange = explode('-', $request->input('power'));
            $query->whereBetween('power', [(int)$powerRange[0], (int)$powerRange[1]]);
        }
        
        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }
        
        if ($request->has('camper_type') && $request->input('camper_type')) {
            $query->where('camper_type', $request->input('camper_type'));
        }

        if ($request->has('berths') && $request->input('berths')) {
            $berthsRange = explode('-', $request->input('berths'));
            $query->whereBetween('berths', [(int)$berthsRange[0], (int)$berthsRange[1]]);
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

        return view('ads.camper.index', compact('campers', 'camperBrands', 'camperModels'));
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

 
    public function store(StoreCamperRequest $request)
    {
   
        $validatedData = $request->validated();

        // Create the camper
        $camper = Auth::user()->campers()->create($validatedData);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('camper_images', 'public'); // Store in 'storage/app/public/camper_images'
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
    public function update(UpdateCamperRequest $request, Camper $camper)
    {
      
        $validatedData = $request->validated();

     
        $camper->update($validatedData);

        // Delete images that the user checked for deletion
        if ($request->filled('delete_images')) {
            $imagesToDelete = $camper->images()->whereIn('id', $request->input('delete_images'))->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Add new images
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