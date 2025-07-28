<?php

namespace App\Http\Controllers;

use App\Models\Camper;
use App\Models\CamperImage;
use App\Http\Requests\StoreCamperRequest;
use App\Http\Requests\UpdateCamperRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth

class CamperController extends Controller
{
    // Dummy data for dropdowns - you might get this from a database or config
    private $colors = ['Black', 'White', 'Silver', 'Grey', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Brown'];
    private $camperTypes = ['Alkoven', 'Teilintegriert', 'Vollintegriert', 'Kastenwagen', 'Wohnwagen'];
    private $fuelTypes = ['Diesel', 'Petrol', 'Electric'];
    private $transmissions = ['Manual', 'Automatic'];
    private $emissionClasses = ['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6'];


    /**
     * Show the form for creating a new camper.
     */
    public function create()
    {
        return view('ads.camper.create', [
            'colors' => $this->colors,
            'camperTypes' => $this->camperTypes,
            'fuelTypes' => $this->fuelTypes,
            'transmissions' => $this->transmissions,
            'emissionClasses' => $this->emissionClasses,
        ]);
    }

    /**
     * Store a newly created camper in storage.
     */
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

        return view('ads.camper.edit', [
            'camper' => $camper,
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
        // Authorization is handled by the UpdateCamperRequest

        $validatedData = $request->validated();

        // Update camper details
        $camper->update($validatedData);

        // Handle image updates
        // 1. Determine which existing images to keep
        $existingImageIdsToKeep = $request->input('existing_images', []);
        $currentImageIds = $camper->images->pluck('id')->toArray();

        // Delete images that are no longer in existing_images
        foreach ($currentImageIds as $imageId) {
            if (!in_array($imageId, $existingImageIdsToKeep)) {
                $imageToDelete = CamperImage::find($imageId);
                if ($imageToDelete) {
                    Storage::disk('public')->delete($imageToDelete->image_path);
                    $imageToDelete->delete();
                }
            }
        }

        // 2. Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('camper_images', 'public');
                $camper->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('ads.camper.show', $camper->id)
            ->with('success', 'Wohnmobil Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified camper from storage.
     */
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

        $camper->delete();

        return redirect()->route('dashboard')->with('success', 'Wohnmobil Anzeige erfolgreich gelöscht!');
    }
}
