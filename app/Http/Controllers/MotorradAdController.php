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
    /**
     * Show the form for creating a new motorrad ad.
     */
    public function create()
    {
        $brands = MotorcycleBrand::orderBy('name')->pluck('name', 'id');

        // --- DEBUG: Check what $brands contains on page load ---
        // dd($brands); // <--- THIS LINE IS NOW COMMENTED OUT

        $initialModels = [];
        if (old('motorcycle_brand_id')) {
            $initialModels = MotorcycleModel::where('motorcycle_brand_id', old('motorcycle_brand_id'))
                                     ->orderBy('name')
                                     ->pluck('name', 'id');
        }

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];
        $conditions = ['neu', 'gebraucht', 'unfallfahrzeug'];

        return view('ads.motorrad.create', compact('brands', 'initialModels', 'colors', 'conditions'));
    }

    /**
     * Store a newly created motorrad ad in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'motorcycle_brand_id' => 'required|exists:motorcycle_brands,id',
            'motorcycle_model_id' => [
                'required',
                Rule::exists('motorcycle_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('motorcycle_brand_id', $request->motorcycle_brand_id);
                }),
            ],
            'first_registration' => 'required|date',
            'mileage' => 'required|integer|min:0',
            'power' => 'required|integer|min:1',
            'color' => 'required|string|max:50',
            'condition' => 'required|in:neu,gebraucht,unfallfahrzeug',
        ]);

        $motorradAd = new MotorradAd();
        $motorradAd->user_id = Auth::id();
        $motorradAd->title = $validatedData['title'];
        $motorradAd->description = $validatedData['description'];
        $motorradAd->motorcycle_brand_id = $validatedData['motorcycle_brand_id'];
        $motorradAd->motorcycle_model_id = $validatedData['motorcycle_model_id'];
        $motorradAd->first_registration = $validatedData['first_registration'];
        $motorradAd->mileage = $validatedData['mileage'];
        $motorradAd->power = $validatedData['power'];
        $motorradAd->color = $validatedData['color'];
        $motorradAd->condition = $validatedData['condition'];
        $motorradAd->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('motorrad_ads_images', 'public');
                $motorradAd->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Motorrad Anzeige erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MotorradAd $motorradAd)
    {
        $motorradAd->load(['motorcycleBrand', 'motorcycleModel', 'user', 'images']);
        return view('ads.motorrad.show', compact('motorradAd'));
    }

    /**
     * Show the form for editing the specified motorrad ad.
     */
    public function edit(MotorradAd $motorradAd)
    {
        if (Auth::id() !== $motorradAd->user_id && (!Auth::user() || !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized action.');
        }

        $brands = MotorcycleBrand::orderBy('name')->pluck('name', 'id');

        $initialModels = [];
        if ($motorradAd->motorcycle_brand_id) {
            $initialModels = MotorcycleModel::where('motorcycle_brand_id', $motorradAd->motorcycle_brand_id)
                                     ->orderBy('name')
                                     ->pluck('name', 'id');
        }

        $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];
        $conditions = ['neu', 'gebraucht', 'unfallfahrzeug'];

        return view('ads.motorrad.edit', compact('motorradAd', 'brands', 'initialModels', 'colors', 'conditions'));
    }

    /**
     * Update the specified motorrad ad in storage.
     */
    public function update(Request $request, MotorradAd $motorradAd)
    {
        if (Auth::id() !== $motorradAd->user_id && (!Auth::user() || !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'motorcycle_brand_id' => 'required|exists:motorcycle_brands,id',
            'motorcycle_model_id' => [
                'required',
                Rule::exists('motorcycle_models', 'id')->where(function ($query) use ($request) {
                    return $query->where('motorcycle_brand_id', $request->motorcycle_brand_id);
                }),
            ],
            'first_registration' => 'required|date',
            'mileage' => 'required|integer|min:0',
            'power' => 'required|integer|min:1',
            'color' => 'required|string|max:50',
            'condition' => 'required|in:neu,gebraucht,unfallfahrzeug',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'exists:motorrad_ad_images,id',
        ]);

        $motorradAd->title = $validatedData['title'];
        $motorradAd->description = $validatedData['description'];
        $motorradAd->motorcycle_brand_id = $validatedData['motorcycle_brand_id'];
        $motorradAd->motorcycle_model_id = $validatedData['motorcycle_model_id'];
        $motorradAd->first_registration = $validatedData['first_registration'];
        $motorradAd->mileage = $validatedData['mileage'];
        $motorradAd->power = $validatedData['power'];
        $motorradAd->color = $validatedData['color'];
        $motorradAd->condition = $validatedData['condition'];
        $motorradAd->save();

        $currentImageIds = $motorradAd->images->pluck('id')->toArray();
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
                $motorradAd->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('ads.motorrad.show', $motorradAd)->with('success', 'Motorrad Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified motorrad ad from storage.
     */
    public function destroy(MotorradAd $motorradAd)
    {
        if (Auth::id() !== $motorradAd->user_id && (!Auth::user() || !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized action.');
        }

        foreach ($motorradAd->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $motorradAd->delete();

        return redirect()->route('dashboard')->with('success', 'Motorrad Anzeige erfolgreich gelöscht!');
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
