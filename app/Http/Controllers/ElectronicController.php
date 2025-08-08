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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Electronic::with('images')->orderBy('created_at', 'desc');

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        if ($request->filled('year_of_purchase')) {
            $query->where('year_of_purchase', $request->input('year_of_purchase'));
        }
        
        $electronics = $query->paginate(12);

        return view('ads.electronics.index', [
            'ads' => $electronics,
            'category' => (object)['name' => 'Elektronik', 'slug' => 'electronics']
        ]);
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
            'No warranty',
            'Manufacturer Warranty',
            'Retailer Warranty',
            'Used Warranty'
        ];

        return view('ads.electronics.create', compact('categories', 'warrantyStatuses'));
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
            'condition' => 'required|in:neu,gebraucht,defekt',
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

    /**
     * Display the specified resource.
     */
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
        $warrantyStatuses = [
            'No warranty',
            'Manufacturer Warranty',
            'Retailer Warranty',
            'Used Warranty'
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

        
        return view('ads.electronics.edit', compact('electronic', 'warrantyStatuses', 'categories'));
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
            'condition' => 'nullable|string|in:neu,gebraucht,defekt',
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