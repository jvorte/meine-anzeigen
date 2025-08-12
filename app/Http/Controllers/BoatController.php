<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BoatImage;


class BoatController extends Controller
{

    public function index(Request $request)
    {
        // Start with a base query
        $query = Boat::with(['images']);

        // Apply filters if they exist in the request
        if ($request->has('brand') && $request->input('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        if ($request->has('boat_type') && $request->input('boat_type')) {
            $query->where('boat_type', $request->input('boat_type'));
        }

        if ($request->has('material') && $request->input('material')) {
            $query->where('material', $request->input('material'));
        }

        // Price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('year_of_construction') && $request->input('year_of_construction')) {
            $yearRange = explode('-', $request->input('year_of_construction'));
            $query->whereBetween('year_of_construction', [(int)$yearRange[0], (int)$yearRange[1]]);
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->has('engine_type') && $request->input('engine_type')) {
            $query->where('engine_type', $request->input('engine_type'));
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

        $boatAds = $query->paginate(15);
        $brands = Boat::distinct()->pluck('brand')->filter()->toArray();
        $boatTypes = ['Sailboat', 'Motorboat', 'Inflatable Boat', 'Kayak', 'Canoe', 'Jet ski', 'Houseboat', 'Other'];
        $conditions = ['new', 'used', 'refurbished', 'broken'];
        $materials = ['Wood', 'Fiberglass', 'Aluminum', 'Steel'];
        return view('ads.boats.index', compact('boatAds', 'brands', 'boatTypes', 'conditions', 'materials'));
    }


    public function create()
    {

        $boatTypes = ['Sailboat', 'Motorboat', 'Inflatable Boat', 'Kayak', 'Canoe', 'Jet ski', 'Houseboat', 'Other'];
        $materials = ['Wood', 'Fiberglass', 'Aluminum', 'Steel'];
        $engineTypes = ['Inboard', 'Outboard', 'Sail', 'Electric', 'No Engine'];
        $conditions = ['new', 'used', 'refurbished', 'broken'];


        return view('ads.boats.create', compact(
            'boatTypes',
            'materials',
            'engineTypes',
            'conditions'
        ));
    }

    public function store(Request $request)
    {
        // Βασικός validation με brand & model ως string
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'year_of_construction' => 'required|integer|min:1900|max:' . date('Y'),
            'condition' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'boat_type' => 'required|string|max:100',
            'material' => 'nullable|string|max:100',
            'total_length' => 'nullable|numeric|min:0',
            'total_width' => 'nullable|numeric|min:0',
            'berths' => 'nullable|integer|min:0',
            'engine_type' => 'nullable|string|max:100',
            'engine_power' => 'nullable|integer|min:0',
            'operating_hours' => 'nullable|integer|min:0',
            'last_service' => 'nullable|date',


        ]);
        // dd( $validatedData);
        $boat = new Boat();
        $boat->user_id = Auth::id();
        $boat->fill($validatedData);
         $boat->show_phone = $request->has('show_phone') ? 1 : 0;
        $boat->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $boat->show_email = $request->has('show_email') ? 1 : 0;


        $boat->save();

        // Φόρτωση εικόνων
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('boat_images', 'public');
                $boat->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Boots Anzeige erfolgreich erstellt!');
    }
    public function show(Boat $boat)
    {
        return view('ads.boats.show', compact('boat'));
    }

    public function edit($id)
    {
        $boat = Boat::findOrFail($id);

        $boatTypes = ['Sailboat', 'Motorboat', 'Inflatable Boat', 'Kayak', 'Canoe', 'Jet ski', 'Houseboat', 'Other'];
        $materials = ['Wood', 'Fiberglass', 'Aluminum', 'Steel'];
        $engineTypes = ['Inboard', 'Outboard', 'Sail', 'Electric', 'No Engine'];
        $conditions = ['new', 'used', 'refurbished', 'broken'];


        return view('ads.boats.edit', compact('boat', 'conditions', 'boatTypes', 'materials', 'engineTypes'));
    }
    public function update(Request $request, $id)
    {
        $boat = Boat::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'model_name' => 'nullable|string|max:255',
            'year_of_construction' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'condition' => 'nullable|string|max:100',
            'boat_type' => 'required|string|max:100',
            'material' => 'nullable|string|max:100',
            'total_length' => 'nullable|numeric|min:0',
            'total_width' => 'nullable|numeric|min:0',
            'berths' => 'nullable|integer|min:0',
            'engine_type' => 'nullable|string|max:100',
            'engine_power' => 'nullable|integer|min:0',
            'operating_hours' => 'nullable|integer|min:0',
            'last_service' => 'nullable|date',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048',
            'deleted_images' => 'nullable|string',
        ]);


        // Ανάθεσε τιμές
        $boat->fill($validated);
        $boat->show_phone = $request->has('show_phone') ? 1 : 0;
        $boat->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $boat->show_email = $request->has('show_email') ? 1 : 0;

        $boat->save();

        // Επεξεργασία διαγραφής εικόνων αν χρειάζεται
        if (!empty($validated['deleted_images'])) {
            $imageIds = explode(',', $validated['deleted_images']);
            // Διαγραφή εικόνων logic εδώ (delete files + records)
        }

        // Διαχείριση νέων εικόνων upload...

        return redirect()->route('dashboard', $boat->id)->with('success', 'Anzeige aktualisiert!');
    }
    public function destroy($id)
    {
        $boat = Boat::findOrFail($id);

        // Αν έχεις σχετικές εικόνες, διαγραφή αρχείων και records:
        foreach ($boat->images as $image) {
            // Διαγραφή αρχείου από storage
            Storage::delete($image->image_path);
            $image->delete();
        }

        // Διαγραφή του ίδιου του boat
        $boat->delete();

        return redirect()->route('dashboard') // ή όπου θέλεις να πας μετά
            ->with('success', 'Anzeige erfolgreich gelöscht.');
    }
}
