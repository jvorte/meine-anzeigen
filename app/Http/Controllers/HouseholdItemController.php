<?php

namespace App\Http\Controllers;

use App\Models\HouseholdItem;
use App\Models\HouseholdItemImage; // Importieren Sie das HouseholdItemImage Model
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; // Import Arr helper
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class HouseholdItemController extends Controller
{



    public function index(Request $request): View
    {
        // Start with a base query and eager load images.
        $query = HouseholdItem::with('images');

          if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Apply filters if they exist in the request
        if ($request->has('category') && $request->input('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('brand') && $request->input('brand')) {
            $query->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        if ($request->has('material') && $request->input('material')) {
            $query->where('material', $request->input('material'));
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }

         // Price range filters
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->input('min_price'));
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->input('max_price'));
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

        $householdAds = $query->paginate(12);

   $categories = [
            'Furniture',
            'Kitchen Appliances',
            'Washing Machines & Dryers',
            'Vacuum Cleaners & Cleaning Equipment',
            'Lighting',
            'Decoration',
            'Garden Furniture & Equipment',
            'Sports & Leisure',
            'Baby & Child',
            'Other'
        ];

        $conditions = ['New', 'Used', 'Heavily used', 'Broken'];

        // Fetch unique values for filter dropdowns
        // $categories = HouseholdItem::distinct()->pluck('category')->filter()->toArray();
        $brands = HouseholdItem::distinct()->pluck('brand')->filter()->toArray();
        $materials = HouseholdItem::distinct()->pluck('material')->filter()->toArray();

        return view('ads.household.index', compact('householdAds', 'categories', 'brands', 'materials', 'conditions'));
    }

    use AuthorizesRequests;
    /**
     * Show the form for creating a new household item ad.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $categories = [
            'Furniture',
            'Kitchen Appliances',
            'Washing Machines & Dryers',
            'Vacuum Cleaners & Cleaning Equipment',
            'Lighting',
            'Decoration',
            'Garden Furniture & Equipment',
            'Sports & Leisure',
            'Baby & Child',
            'Other'
        ];
         $conditions = ['New', 'Used', 'Heavily used', 'Broken'];

        return view('ads.household.create', compact(
            'brands',
            'categories',
            'conditions'
        ));
    }


    /**
     * Store a newly created household item ad in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([

            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Validation for files
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'condition' => 'required|string',
            'category' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'model_name' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'dimensions' => 'nullable|string|max:255',
        ]);
        // dd(Auth::id());
        // Separate image files from other validated data
        $imageFiles = $request->file('images'); // Get the uploaded image files
        // Remove 'images' (the file objects) from $validatedData before creating the HouseholdItem record
        $dataToCreateHouseholdItem = Arr::except($validatedData, ['images']);

        // 2. Create the HouseholdItem record first
        $householdItem = HouseholdItem::create(array_merge($dataToCreateHouseholdItem, [
            'user_id' => Auth::id(), // Assign the authenticated user's ID
        ]));


         $householdItem->show_phone = $request->has('show_phone') ? 1 : 0;
        $householdItem->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $householdItem->show_email = $request->has('show_email') ? 1 : 0;
        $householdItem->save();

        // 3. Handle image uploads and save to HouseholdItemImage model
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('household_item_images', 'public'); // Store in 'storage/app/public/household_item_images'
                HouseholdItemImage::create([
                    'household_item_id' => $householdItem->id,
                    'image_path' => $path, // Use 'image_path' as per your schema
                    'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                ]);
            }
        }

        // 4. Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Haushaltsartikel Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseholdItem $householdItem)
    {
        $householdItem->load('images');
        return view('ads.household.show', compact('householdItem'));
    }

    public function edit(HouseholdItem $householdItem)
    {
        // Φόρτωσε τις κατηγορίες για το dropdown (αν χρειάζεται)
         $categories = [
            'Furniture',
            'Kitchen Appliances',
            'Washing Machines & Dryers',
            'Vacuum Cleaners & Cleaning Equipment',
            'Lighting',
            'Decoration',
            'Garden Furniture & Equipment',
            'Sports & Leisure',
            'Baby & Child',
            'Other'
        ];
        $conditions = ['New', 'Used', 'Heavily used', 'Broken'];

        return view('ads.household.edit', compact('householdItem', 'categories', 'conditions'));
    }


    public function update(Request $request, HouseholdItem $householdItem)
    {
        $validated = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'condition' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'model_name' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'dimensions' => 'nullable|string|max:255',
        ]);

        // Update main HouseholdItem fields
        $householdItem->fill([
            'category' => $validated['category'],
            'brand' => $validated['brand'] ?? null,
            'model_name' => $validated['model_name'] ?? null,
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'material' => $validated['material'] ?? null,
            'color' => $validated['color'] ?? null,
            'dimensions' => $validated['dimensions'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
        ])->save();



         $householdItem->show_phone = $request->has('show_phone') ? 1 : 0;
        $householdItem->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $householdItem->show_email = $request->has('show_email') ? 1 : 0;
        $householdItem->save();
        // 1. Handle deletion of existing images
        if ($request->has('existing_images_to_delete')) {
            $idsToDelete = array_filter(explode(',', $request->input('existing_images_to_delete'))); // Split string by comma and remove empty values

            if (!empty($idsToDelete)) {
                // Get the image records that belong to THIS householdItem AND are in the $idsToDelete array
                $imagesToDelete = $householdItem->images()->whereIn('id', $idsToDelete)->get();

                foreach ($imagesToDelete as $image) {
                    // Delete the file from storage
                    if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    // Delete the image record from the database
                    $image->delete();
                }
            }
        }

        // 2. Handle upload of new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('household_images', 'public');

                $householdItem->images()->create([
                    'image_path' => $path,
                    'is_thumbnail' => false, // Set appropriately, perhaps based on original order
                ]);
            }
        }

        return redirect()->route('ads.household.show', $householdItem)->with('success', 'Anzeige erfolgreich aktualisiert!');
    }

    public function destroy($id)
    {
        // Correct variable name: fetch HouseholdItem and assign to $householdItem
        $householdItem = HouseholdItem::findOrFail($id);

        // Delete associated images (files and database records)
        // Ensure image_path is not null before attempting to delete
        foreach ($householdItem->images as $image) {
            // Delete file from storage
            // Add a check to ensure the path exists before attempting deletion to prevent errors
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            // Delete the image record from the database
            $image->delete();
        }

        // Delete the HouseholdItem itself
        $householdItem->delete();

        return redirect()->route('dashboard') // or any other appropriate redirect route
            ->with('success', 'Anzeige erfolgreich gelöscht.');
    }
}
