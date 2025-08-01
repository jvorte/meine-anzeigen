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

    
        // dd($brands);

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

    public function getModels($id)
{
    return response()->json(
        MotorcycleModel::where('motorcycle_brand_id', $id)->get(['id', 'name'])
    );
}


  
    public function store(Request $request)
    {
        // dd('fff');
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
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
            'first_registration' => 'required|date',
            'mileage' => 'required|integer|min:0',
            'power' => 'required|integer|min:1',
            'color' => 'required|string|max:50',
            'condition' => 'required|in:neu,gebraucht,unfallfahrzeug',
        ]);
        // dd($validatedData );

        $motorradAd = new MotorradAd();
        $motorradAd->user_id = Auth::id();
        $motorradAd->title = $validatedData['title'];
        $motorradAd->description = $validatedData['description'];
        $motorradAd->price = $validatedData['price'];
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

    // Πάρε τις μάρκες μοτοσυκλετών σωστά
    $brands = MotorcycleBrand::pluck('name', 'id');

    // Μοντέλα της συγκεκριμένης μάρκας (αν υπάρχει)
    $initialModels = [];
    if ($motorradAd->motorcycle_brand_id) {
        $initialModels = MotorcycleModel::where('motorcycle_brand_id', $motorradAd->motorcycle_brand_id)->pluck('name', 'id');
    }

    $colors = ['Schwarz', 'Weiß', 'Rot', 'Blau', 'Grün', 'Gelb', 'Orange', 'Silber', 'Grau', 'Braun', 'Andere'];
    $conditions = ['neu', 'gebraucht', 'unfallfahrzeug'];
//  dd($motorradAd->images->toArray());
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
            'price' => 'required|numeric|min:0|max:9999999.99',
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
    // dd($validatedData['existing_images'] ?? 'No existing images sent');
        $motorradAd->title = $validatedData['title'];
        $motorradAd->description = $validatedData['description'];
        $motorradAd->motorcycle_brand_id = $validatedData['motorcycle_brand_id'];
        $motorradAd->motorcycle_model_id = $validatedData['motorcycle_model_id'];
        $motorradAd->price = $validatedData['price'];
        $motorradAd->first_registration = $validatedData['first_registration'];
        $motorradAd->mileage = $validatedData['mileage'];
        $motorradAd->power = $validatedData['power'];
        $motorradAd->color = $validatedData['color'];
        $motorradAd->condition = $validatedData['condition'];
        $motorradAd->save();
    // dd($motorradAd->images->pluck('id')->toArray());
   $currentImageIds = $motorradAd->images->pluck('id')->toArray();
        $imagesToKeep = $validatedData['existing_images'] ?? []; // This will now receive IDs from the Blade!
        $imagesToDelete = array_diff($currentImageIds, $imagesToKeep);
//    dd(array_diff($currentImageIds, $imagesToKeep));
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
