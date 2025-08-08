<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Other; // Ensure this is App\Models\Other
use App\Models\OtherImage; // Ensure this is App\Models\OtherImage
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions

class OtherController extends Controller
{

    
public function index()
{
    $otherAds = Other::with('images')->latest()->paginate(12);

    return view('ads.others.index', [
        'otherAds' => $otherAds,
    ]);
}
    /**
     * Display a listing of the "other" ads.
     * This method fetches all "other" ads for listing.
     */

    /**
     * Show the form for creating a new "other" ad.
     * This method prepares data needed for the form.
     */
    public function create()
    {
        // Define options for dropdowns, matching the Blade form
        $conditionOptions = ['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'];

        return view('ads.others.create', compact(
            'conditionOptions'
        ));
    }

    /**
     * Store a newly created "other" ad in storage.
     * This method handles the form submission and saves data.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['sonstiges'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'], // Added max
            'condition' => ['nullable', 'string', Rule::in(['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'])],

            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Added mimes and 'nullable'
        ]);

        DB::beginTransaction(); // Start a database transaction

        try {
            // Separate image files from other validated data
            $imageFiles = $request->file('images');
            // Remove 'images' (the file objects) from $validatedData before creating the Other record
            $dataToCreateOther = Arr::except($validatedData, ['images']);

            // 2. Create the Other record first
            $other = Other::create(array_merge($dataToCreateOther, [
                'user_id' => Auth::id(), // Assign the authenticated user's ID
            ]));

            // 3. Handle image uploads and save to OtherImage model
            if ($imageFiles) {
                foreach ($imageFiles as $index => $image) {
                    // Store image in 'public/other_images' directory
                    $path = $image->store('other_images', 'public');
                    OtherImage::create([
                        'other_id' => $other->id,
                        'image_path' => $path, // Use 'image_path' as per your schema
                        'is_thumbnail' => ($index === 0), // Set the first image as thumbnail
                    ]);
                }
            }

            DB::commit(); // Commit the transaction
            return redirect()->route('dashboard')->with('success', 'Sonstiges Anzeige erfolgreich erstellt!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            \Log::error('Error creating other ad: ' . $e->getMessage()); // Log the error for debugging
            return back()->withInput()->with('error', 'Fehler beim Erstellen der Anzeige: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * This method is for showing a single "other" ad.
     */
    public function show(Other $other)
    {
        return view('ads.others.show', compact('other'));
    }

    

    /**
     * Show the form for editing the specified "other" ad.
     *
     * @param  \App\Models\Other  $other
     * @return \Illuminate\View\View
     */
    public function edit(Other $other)
    {
        // Optional: Add authorization check. Requires a policy (e.g., OtherPolicy).
        // Example: $this->authorize('update', $other);

        $conditionOptions = ['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'];

        // Eager load images to ensure they are available in the view
        $other->load('images');

        return view('ads.others.edit', compact('other', 'conditionOptions'));
    }

    /**
     * Update the specified "other" ad in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Other  $other
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Other $other)
    {
        // Optional: Add authorization check
        // Example: $this->authorize('update', $other);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'condition' => ['nullable', 'string', Rule::in(['Neu', 'Gebraucht', 'Stark gebraucht', 'Defekt'])],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // For new images
            'existing_image_ids' => ['nullable', 'array'], // Array of IDs of images to keep
            'existing_image_ids.*' => ['integer', 'exists:other_images,id'], // Each ID must be an integer and exist in other_images
        ]);

        DB::beginTransaction(); // Start a database transaction

        try {
            // Update the main 'Other' record
            $other->update(Arr::except($validatedData, ['images', 'existing_image_ids']));

            // Handle existing images (delete unchecked ones)
            $existingImageIdsToKeep = $validatedData['existing_image_ids'] ?? [];
            foreach ($other->images as $image) {
                if (!in_array($image->id, $existingImageIdsToKeep)) {
                    // Delete image file from storage
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    // Delete image record from database
                    $image->delete();
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $imageFile) {
                    $path = $imageFile->store('other_images', 'public');
                    OtherImage::create([
                        'other_id' => $other->id,
                        'image_path' => $path,
                        // Determine if it's a thumbnail. If there were no existing images and this is the first new one, or set a default.
                        'is_thumbnail' => ($other->images()->count() === 0 && $index === 0) ? true : false,
                    ]);
                }
            }

            DB::commit(); // Commit the transaction
            return redirect()->route('ads.others.show', $other->id)->with('success', 'Anzeige erfolgreich aktualisiert!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            \Log::error('Error updating other ad: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Fehler beim Aktualisieren der Anzeige: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified "other" ad from storage.
     *
     * @param  \App\Models\Other  $other
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Other $other)
    {
        // Optional: Add authorization check
        // Example: $this->authorize('delete', $other);

        DB::beginTransaction(); // Start a database transaction

        try {
            // Delete associated images from storage first
            foreach ($other->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            // Delete image records from the database
            $other->images()->delete();

            // Delete the main "Other" ad record
            $other->delete();

            DB::commit(); // Commit the transaction
            return redirect()->route('dashboard')->with('success', 'Anzeige erfolgreich gelöscht!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            \Log::error('Error deleting other ad: ' . $e->getMessage());
            return back()->with('error', 'Fehler beim Löschen der Anzeige: ' . $e->getMessage());
        }
    }
}