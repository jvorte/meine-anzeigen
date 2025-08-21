<?php

namespace App\Http\Controllers;

use App\Models\UsedVehiclePart;
use App\Models\UsedVehiclePartImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Still useful for general validation, but specific 'exists' rules will change

class UsedVehiclePartController extends Controller
{

    public function index(Request $request)
    {
        // Start with a base query
        $query = UsedVehiclePart::with(['images']);

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Apply filters if they exist in the request
        if ($request->has('part_category') && $request->input('part_category')) {
            $query->where('part_category', $request->input('part_category'));
        }

        if ($request->has('compatible_brand') && $request->input('compatible_brand')) {
            $query->where('compatible_brand', $request->input('compatible_brand'));
        }

        if ($request->has('vehicle_type') && $request->input('vehicle_type')) {
            $query->where('vehicle_type', $request->input('vehicle_type'));
        }

        // Price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
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

        $usedVehicleParts = $query->paginate(15);

        $partCategories = [
            'Engine & Attachments',
            'Transmission & Drivetrain',
            'Body & Attachments',
            'Chassis & Steering',
            'Braking System',
            'Exhaust System',
            'Electrical & Lighting',
            'Interior & Equipment',
            'Wheels & Tires',
            'Filters & Maintenance',
            'Cooling System',
            'Heating & Air Conditioning',
            'Fuel System',
            'Other'
        ];

        $vehicleTypes = [
            'Car',
            'Motorcycle',
            'Truck',
            'Motorhome',
            'Bus',
            'Trailer',
            'Boat',
            'Construction Machine',
            'Agricultural Machine',
            'Other'
        ];
        return view('ads.used-vehicle-parts.index', compact('usedVehicleParts', 'partCategories', 'vehicleTypes'));
    }
 
    public function create()
    {


        $partCategories = [
            'Engine & Attachments',
            'Transmission & Drivetrain',
            'Body & Attachments',
            'Chassis & Steering',
            'Braking System',
            'Exhaust System',
            'Electrical & Lighting',
            'Interior & Equipment',
            'Wheels & Tires',
            'Filters & Maintenance',
            'Cooling System',
            'Heating & Air Conditioning',
            'Fuel System',
            'Other'
        ];
        $conditions = ['new', 'used', 'refurbished', 'broken'];

        // Define a list of generic vehicle types
        $vehicleTypes = [
            'Car',
            'Motorcycle',
            'Truck',
            'Motorhome',
            'Bus',
            'Trailer',
            'Boat',
            'Construction Machine',
            'Agricultural Machine',
            'Other'
        ];

        return view('ads.used-vehicle-parts.create', compact(
            'partCategories',
            'conditions',
            'vehicleTypes' // Pass the new vehicle types
        ));
    }

    /**
     * Store a newly created used vehicle part ad in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            // NEW VALIDATION RULES for generic fields
            'vehicle_type' => 'required|string|max:50', // Validate the selected vehicle type
            'compatible_brand' => 'nullable|string|max:255', // Validate the text input for brand
            'compatible_model' => 'nullable|string|max:255', // Validate the text input for model
            // END NEW VALIDATION RULES
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',
        ]);

        $usedVehiclePart = new UsedVehiclePart();
        $usedVehiclePart->user_id = Auth::id();
        $usedVehiclePart->fill($validatedData);
        $usedVehiclePart->show_phone = $request->has('show_phone') ? 1 : 0;
        $usedVehiclePart->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $usedVehiclePart->show_email = $request->has('show_email') ? 1 : 0;
        $usedVehiclePart->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('used_vehicle_part_images', 'public');
                $usedVehiclePart->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Fahrzeugteil Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UsedVehiclePart $usedVehiclePart)
    {
        // No change needed here typically, as the model will fetch the new string fields.
        return view('ads.used-vehicle-parts.show', compact('usedVehiclePart'));
    }

    /**
     * Show the form for editing the specified used vehicle part ad.
     */
    public function edit(UsedVehiclePart $usedVehiclePart)
    {
      
//    dd($usedVehiclePart);
        // Make sure images are loaded for the view
        $usedVehiclePart->load('images');


        $partCategories = [
            'Engine & Attachments',
            'Transmission & Drivetrain',
            'Body & Attachments',
            'Chassis & Steering',
            'Braking System',
            'Exhaust System',
            'Electrical & Lighting',
            'Interior & Equipment',
            'Wheels & Tires',
            'Filters & Maintenance',
            'Cooling System',
            'Heating & Air Conditioning',
            'Fuel System',
            'Other'
        ];
        $conditions = ['new', 'used', 'refurbished', 'broken'];

        // Define a list of generic vehicle types
        $vehicleTypes = [
            'Car',
            'Motorcycle',
            'Truck',
            'Motorhome',
            'Bus',
            'Trailer',
            'Boat',
            'Construction Machine',
            'Agricultural Machine',
            'Other'
        ];
        return view('ads.used-vehicle-parts.edit', compact(
            'usedVehiclePart',
            'partCategories',
            'conditions',
            'vehicleTypes'
        ));
    }


    /**
     * Update the specified used vehicle part ad in storage.
     */
    public function update(Request $request, UsedVehiclePart $usedVehiclePart)
    {

    
        // Policy check: Ensure the authenticated user owns this ad
        if (Auth::id() !== $usedVehiclePart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            // Standard fields validation
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'part_category' => 'required|string|max:100',
            'part_name' => 'required|string|max:255',
            'manufacturer_part_number' => 'nullable|string|max:255',
            'condition' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'vehicle_type' => 'required|string|max:50',
            'compatible_brand' => 'nullable|string|max:255',
            'compatible_model' => 'nullable|string|max:255',
            'compatible_year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'compatible_year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 1) . '|after_or_equal:compatible_year_from',

            // Validation for new image uploads
            'images.*' => ['nullable', 'image', 'max:2048'], // Allow new images

            // Validation for images to be deleted
            'images_to_delete' => 'nullable|array', // Expects an array of image IDs to delete
            // Ensure each ID in the array belongs to an image associated with THIS usedVehiclePart
            'images_to_delete.*' => [
                'integer',
                Rule::exists('used_vehicle_part_images', 'id')->where(function ($query) use ($usedVehiclePart) {
                    $query->where('used_vehicle_part_id', $usedVehiclePart->id);
                }),
            ],
        ]);


         $usedVehiclePart->show_phone = $request->has('show_phone') ? 1 : 0;
        $usedVehiclePart->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $usedVehiclePart->show_email = $request->has('show_email') ? 1 : 0;
        $usedVehiclePart->save();

        // Update the main UsedVehiclePart data
        $usedVehiclePart->update($validatedData);

        // --- Handle Image Deletions ---
        if ($request->has('images_to_delete')) {
            foreach ($request->input('images_to_delete') as $imageId) {
                // Find the image record to delete
                $image = UsedVehiclePartImage::find($imageId); // Or $usedVehiclePart->images()->find($imageId);

                // Double check it belongs to this ad and actually exists
                if ($image && $image->used_vehicle_part_id === $usedVehiclePart->id) {
                    // Delete the file from storage
                    Storage::disk('public')->delete($image->image_path);
                    // Delete the record from the database
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('service_images', 'public');
                // Use the correct relationship method from the Service model
                $usedVehiclePart->images()->create([
                    'image_path' => $path,

                ]);
            }
        }

        return redirect()->route('ads.vehicles-parts.show', $usedVehiclePart)
            ->with('success', 'Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified used vehicle part ad from storage.
     */
    public function destroy(UsedVehiclePart $usedVehiclePart)
    {
        // Policy check: Ensure the authenticated user owns this ad
        if (Auth::id() !== $usedVehiclePart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated images from storage first
        foreach ($usedVehiclePart->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the UsedVehiclePart record
        $usedVehiclePart->delete();

        return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich gelöscht!');
    }
}
