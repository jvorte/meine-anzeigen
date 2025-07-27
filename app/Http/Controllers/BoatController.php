<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BoatController extends Controller
{
    public function create()
    {
        $boatTypes = ['Segelboot', 'Motorboot', 'Schlauchboot', 'Kajak', 'Kanu', 'Jetski', 'Hausboot', 'Andere'];
        $materials = ['GFK (Fiberglas)', 'Holz', 'Stahl', 'Aluminium', 'Hypalon', 'PVC', 'Andere'];
        $engineTypes = ['Innenborder', 'Außenborder', 'Segelantrieb', 'Elektro', 'Kein Motor'];
        $conditions = ['neu', 'gebraucht', 'restaurierungsbedürftig'];

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
            'condition' => 'required|in:neu,gebraucht,restaurierungsbedürftig',
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

            'country' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'city' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',

            'seller_name' => 'required|string|max:255',
            'seller_phone' => 'nullable|string|max:50',
            'seller_email' => 'nullable|email|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $boat = new Boat();
        $boat->user_id = Auth::id();
        $boat->fill($validatedData);
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

    $conditions = ['neu', 'gebraucht', 'restaurierungsbedürftig']; // κατάσταση
    $boatTypes = ['Segelboot', 'Motorboot', 'Kajak', 'Ruderboot']; // τύποι πλοίων
    $materials = ['Holz', 'Fiberglas', 'Aluminium', 'Stahl']; // υλικά
    $engineTypes = ['Innenbordmotor', 'Außenbordmotor', 'Elektromotor', 'Segel']; // τύποι κινητήρα

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
        'condition' => 'nullable|string|in:neu,gebraucht,restaurierungsbedürftig',
        'boat_type' => 'nullable|string|in:Segelboot,Motorboot,Kajak,Ruderboot',
        'material' => 'nullable|string|in:Holz,Fiberglas,Aluminium,Stahl',
        'total_length' => 'nullable|numeric|min:0',
        'total_width' => 'nullable|numeric|min:0',
        'berths' => 'nullable|integer|min:0',
        'engine_type' => 'nullable|string|in:Innenbordmotor,Außenbordmotor,Elektromotor,Segel',
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
        'deleted_images' => 'nullable|string', // comma separated IDs of images to delete
    ]);

    // Ανάθεσε τιμές
    $boat->fill($validated);

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
