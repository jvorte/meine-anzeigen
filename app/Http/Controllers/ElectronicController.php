<?php

namespace App\Http\Controllers;

use App\Models\Electronic;
use App\Models\ElectronicImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ElectronicController extends Controller
{

    public function index(Request $request): View
    {
        // Start with a base query and eager load images.
        // We order by 'created_at' descending by default.
        $query = Electronic::with(['images']);

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }


        // Apply filters if they exist in the request
        if ($request->has('category') && $request->input('category')) {
            $query->where('category', $request->input('category'));
        }

        // Use a 'like' operator for the brand search for partial matches
        if ($request->has('brand') && $request->input('brand')) {
            $query->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        // Add the year of purchase filter
        if ($request->has('year_of_purchase') && $request->input('year_of_purchase')) {
            $query->where('year_of_purchase', $request->input('year_of_purchase'));
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

        // Paginate the results with 12 items per page as suggested.
        $ads = $query->paginate(12);
        $brands = Electronic::distinct()->pluck('brand')->filter()->toArray();

        $warrantyStatuses = [
            'Yes',
            'No',

        ];
        $categories = [
            'Mobile Phone',
            'TV',
            'Laptop',
            'Camera',
            'Audio Device',
            'Gaming Console',
            'Smartwatch',
            'Tablet',
            'Other'
        ];

        $conditions = ['New', 'Used', 'Refurbished', 'Broken'];



        // Pass the paginated ads and brands to the view
        return view('ads.electronics.index', compact('ads', 'brands', 'warrantyStatuses', 'conditions', 'categories'));
    }
    /**
     * Show the form for creating a new electronic ad.
     */
    public function create(): View
    {
        $categories = [
            'Mobile Phone',
            'TV',
            'Laptop',
            'Camera',
            'Audio Device',
            'Gaming Console',
            'Smartwatch',
            'Tablet',
            'Other'
        ];

        $warrantyStatuses = [
            'Yes',
            'No',

        ];

        $conditions = ['new', 'used', 'refurbished', 'broken'];

        return view('ads.electronics.create', compact('categories', 'warrantyStatuses', 'conditions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'condition' => 'required|string',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'electronic_model' => 'nullable|string|max:255',
            'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
            'warranty_status' => 'nullable|string|max:255',
            'accessories' => 'nullable|string|max:65535',
            'color' => 'nullable|string|max:50',
            'usage_time' => 'nullable|string|max:100',
            'operating_system' => 'nullable|string|max:100',
            'storage_capacity' => 'nullable|string|max:100',
            'screen_size' => 'nullable|string|max:100',
            'processor' => 'nullable|string|max:100',
            'ram' => 'nullable|string|max:100',

            
        ];

        $validatedData = $request->validate($rules);

        $imageFiles = $request->file('images');
        $dataToCreateElectronic = Arr::except($validatedData, ['images']);
        $dataToCreateElectronic['user_id'] = Auth::id();
        $dataToCreateElectronic['status'] = 'active';



        $electronic = Electronic::create($dataToCreateElectronic);

        $electronic->show_phone = $request->has('show_phone') ? 1 : 0;
        $electronic->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $electronic->show_email = $request->has('show_email') ? 1 : 0;
        $electronic->save();

        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('electronic_images', 'public');
                ElectronicImage::create([
                    'electronic_id' => $electronic->id,
                    'image_path' => $path,
                    'is_thumbnail' => ($index === 0),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Elektronik Anzeige erfolgreich erstellt!');
    }


    public function show(Electronic $electronic): View
    {
        $electronic->load('images');
        return view('ads.electronics.show', compact('electronic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Electronic $electronic): View
    {
        $categories = [
            'Mobile Phone',
            'TV',
            'Laptop',
            'Camera',
            'Audio Device',
            'Gaming Console',
            'Smartwatch',
            'Tablet',
            'Other'
        ];

        $garrantyStatus = [
            'Yes',
            'No',
        ];
        $conditions = ['new', 'used', 'refurbished', 'broken'];

        return view('ads.electronics.edit', compact('electronic', 'garrantyStatus', 'conditions', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Electronic $electronic): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'electronic_model' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'condition' => 'nullable|string',
            'year_of_purchase' => 'nullable|integer|min:1950|max:' . date('Y'),
            'warranty_status' => 'nullable|string|max:255',
            'accessories' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'usage_time' => 'nullable|string|max:100',
            'operating_system' => 'nullable|string|max:100',
            'storage_capacity' => 'nullable|string|max:100',
            'screen_size' => 'nullable|string|max:100',
            'processor' => 'nullable|string|max:100',
            'ram' => 'nullable|string|max:100',
            'new_images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'delete_images' => 'array',
            'delete_images.*' => 'integer|exists:electronic_images,id',
        ]);

        $updateData = collect($validatedData)->except(['new_images', 'delete_images'])->toArray();
        $electronic->update($updateData);

          $electronic->show_phone = $request->has('show_phone') ? 1 : 0;
        $electronic->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $electronic->show_email = $request->has('show_email') ? 1 : 0;
        $electronic->save();


        if ($request->filled('delete_images')) {
            $imagesToDelete = $electronic->images()->whereIn('id', $request->input('delete_images'))->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $imageFile) {
                $path = $imageFile->store('electronic_images', 'public');
                $electronic->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('ads.electronics.show', $electronic)->with('success', 'Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Electronic $electronic): RedirectResponse
    {
        foreach ($electronic->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $electronic->delete();

        return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich gelöscht!');
    }
}
