<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealEstate;
use App\Models\RealEstateImage; // Import the RealEstateImage Model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RealEstateController extends Controller
{


    public function index(Request $request): View
    {
        // Start with a base query and eager load images.
        $query = RealEstate::with('images');

        // Apply filters if they exist in the request

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->has('objekttyp') && $request->input('objekttyp')) {
            $query->where('objekttyp', $request->input('objekttyp'));
        }

        if ($request->has('propertyTypeOptions') && $request->input('propertyTypeOptions')) {
            $query->where('propertyTypeOptions', $request->input('propertyTypeOptions'));
        }

        if ($request->has('objekttyp') && $request->input('objekttyp')) {
            $query->where('objekttyp', $request->input('objekttyp'));
        }

        if ($request->has('condition') && $request->input('condition')) {
            $query->where('condition', $request->input('condition'));
        }

        if ($request->has('constructionTypeOption') && $request->input('constructionTypeOption')) {
            $query->where('constructionTypeOption', $request->input('constructionTypeOption'));
        }


        if ($request->has('heatingOptions') && $request->input('heatingOptions')) {
            $query->where('heating', $request->input('heatingOptions'));
        }



        if ($request->has('petFriendlyOption') && $request->input('petFriendlyOption')) {
            $query->where('pet_friendly', $request->input('petFriendlyOption'));
        }

        if ($request->has('location') && $request->input('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->has('anzahl_zimmer') && $request->input('anzahl_zimmer')) {
            // Filter for 4+ rooms if selected
            if ($request->input('anzahl_zimmer') == '4') {
                $query->where('anzahl_zimmer', '>=', 4);
            } else {
                $query->where('anzahl_zimmer', $request->input('anzahl_zimmer'));
            }
        }


        //    {{-- Year of Construction Filter yearConstraction --}}
        if ($request->filled('min_year')) {
            $query->where('year_of_construction', '>=', $request->input('min_year'));
        }
        if ($request->filled('max_year')) {
            $query->where('year_of_construction', '<=', $request->input('max_year'));
        }


        // Price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }


        // Living space range filters
        if ($request->filled('min_area')) {
            $query->where('livingSpace', '>=', $request->input('min_area'));
        }
        if ($request->filled('max_area')) {
            $query->where('livingSpace', '<=', $request->input('max_area'));
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

        $realEstateAds = $query->paginate(12);
        $petFriendlyOptions = ['Yes', 'No'];
        // Fetch unique values for filter dropdowns
        $constructionTypeOptions = ['solid construction', 'prefabricated house', 'timber construction', 'brick construction', 'reinforced concrete'];
        $conditions = ['New building', 'Renovated', 'Needs renovation', 'Old building'];
        $propertyTypeOptions = ['Apartment', 'House', 'Land', 'Commercial Property', 'Garage', 'Other'];
        $objekttyps = ['Buy', 'Rent'];     
        $objekttypen = RealEstate::distinct()->pluck('objekttyp')->filter()->toArray();
        $postcodes = RealEstate::distinct()->pluck('postcode')->filter()->toArray();
        $locations = RealEstate::distinct()->pluck('location')->filter()->toArray();
        $heatingOptions = ['Central heating', 'floor heating', 'underfloor heating', 'district heating', 'gas heating', 'oil heating', 'electric heating', 'fireplace/stove'];

        return view('ads.real-estate.index', compact('realEstateAds', 'propertyTypeOptions', 'objekttypen', 'locations', 'objekttyps', 'petFriendlyOptions', 'heatingOptions', 'postcodes', 'conditions', 'constructionTypeOptions'));
    }
    /**
     * Display a form to create a new real estate listing.
     * This method prepares the data needed for the form.
     */
    public function create()
    {
        // Define options for dropdowns and checkboxes, matching the Blade form
        $propertyTypeOptions = ['Apartment', 'House', 'Land', 'Commercial Property', 'Garage', 'Other'];
        $objectTypeOptions = ['Buy', 'Rent'];
        $stateOptions = ['New building', 'Renovated', 'Needs renovation', 'Old building'];
        $constructionTypeOptions = ['solid construction', 'prefabricated house', 'timber construction', 'brick construction', 'reinforced concrete'];
        $availabilityOptions = ['Immediately', 'By appointment', 'From [date]'];
        $fixedTermContractOptions = ['Permanent', 'Fixed-term'];
        $yearOfConstructionOptions = range(date('Y'), 1900);
        $petFriendlyOptions = ['Yes', 'No'];
        $heatingOptions = ['Central heating', 'floor heating', 'underfloor heating', 'district heating', 'gas heating', 'oil heating', 'electric heating', 'fireplace/stove'];
        $equipmentOptions = [
            'Balcony',
            'Terrace',
            'Garden',
            'Basement',
            'Attic',
            'Garage',
            'Parking space',
            'Fitted kitchen',
            'Furnished',
            'Accessible',
            'Elevator',
            'Air conditioning',
            'Swimming pool',
            'Sauna',
            'Alarm system',
            'Wheelchair accessible',
            'Cable/satellite TV',
            'Internet connection',
            'Laundry room',
            'Storage room',
            'Guest toilet',
            'Bathtub',
            'Shower',
            'Separate toilet'
        ];

        return view('ads.real-estate.create', compact(
            'propertyTypeOptions',
            'objectTypeOptions',
            'stateOptions',
            'constructionTypeOptions',
            'availabilityOptions',
            'fixedTermContractOptions',
            'heatingOptions',
            'equipmentOptions',
            'yearOfConstructionOptions',
            'petFriendlyOptions'
        ));
    }

    /**
     * Store a newly created real estate listing in storage.
     * This method processes the form submission and saves data.
     */
    public function store(Request $request)
    {
        // Validation rules, ταιριάζουν με τα ονόματα στα inputs του Blade
        $validatedData = $request->validate([


            'category_slug' => ['required', 'string', 'max:255'],

            // Basic Data
            'propertyTypeOptions' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],

            'year_of_construction' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')], // Επιτρεπτά χρόνια από 1800 έως σήμερα
            'pet_friendly' => ['nullable', 'in:Yes,No'],


            'objekttyp' => ['nullable', 'string'],
            'condition' => ['nullable', 'string'],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'],
            'propertyTypeOptions' => ['required', 'string'],
            'verfugbarkeit' => ['nullable', 'string'],
            'befristung' => ['nullable', 'string'],
            'befristung_ende' => ['nullable', 'date'],

            // Description
            'description' => ['required', 'string'],
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],

            // Location
            'land' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:10'],
            'location' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'],

            // Prices & Areas
            'price' => 'required|numeric|min:0|max:9999999999999.99',
            'livingSpace' => ['nullable', 'numeric', 'min:0'],
            'grundflaeche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],

            // Features & Heating
            'ausstattung' => ['nullable', 'array'],
            'ausstattung.*' => ['string'],
            'heating' => ['nullable', 'string', Rule::in([
                'Central heating',
                'floor heating',
                'underfloor heating',
                'district heating',
                'gas heating',
                'oil heating',
                'electric heating',
                'fireplace/stove'
            ])],

            // Photos & Documents
            'images.*' => ['nullable', 'image'], // Multiple images
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'rundgang_link' => ['nullable', 'url', 'max:2048'],
            'objektinformationen_link' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht_link' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht_link' => ['nullable', 'url', 'max:2048'],

            // Contact
            'contact_name' => ['required', 'string', 'max:255'],

            'homepage' => ['nullable', 'url', 'max:2048'],

            'zusatzkontakt' => ['boolean'],
        ]);
    
        // Απομονώνουμε αρχεία εικόνων
        $imageFiles = $request->file('images');

        // Αφαιρούμε 'images' και 'zusatzkontakt' από τα δεδομένα για την αποθήκευση
        $dataToCreateRealEstate = Arr::except($validatedData, ['images', 'zusatzkontakt']);

        // Χειρισμός checkbox 'zusatzkontakt'
        $dataToCreateRealEstate['zusatzkontakt'] = $request->has('zusatzkontakt');

        // File uploads για έγγραφα
        $grundrissPath = null;
        if ($request->hasFile('grundriss_path')) {
            $grundrissPath = $request->file('grundriss_path')->store('real_estate_documents', 'public');
        }

        $energieausweisPath = null;
        if ($request->hasFile('energieausweis_path')) {
            $energieausweisPath = $request->file('energieausweis_path')->store('real_estate_documents', 'public');
        }

        // Δημιουργία εγγραφής RealEstate
        $realEstate = RealEstate::create(array_merge($dataToCreateRealEstate, [
            'user_id' => Auth::id(),
            'grundriss_path' => $grundrissPath,
            'energieausweis_path' => $energieausweisPath,
        ]));

           $realEstate->show_phone = $request->has('show_phone') ? 1 : 0;
        $realEstate->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $realEstate->show_email = $request->has('show_email') ? 1 : 0;
        $realEstate->save();

        // Αποθήκευση εικόνων
        if ($imageFiles) {
            foreach ($imageFiles as $index => $image) {
                $path = $image->store('real_estate_images', 'public');
                RealEstateImage::create([
                    'real_estate_id' => $realEstate->id,
                    'propertyTypeOptions' => $validatedData['propertyTypeOptions'],
                    'image_path' => $path,
                    'is_thumbnail' => ($index === 0),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Real estate listing created successfully!');
    }


    /**
     * Display the specified resource.
     * This method is used to display a single real estate listing.
     */
    public function show(RealEstate $realEstate)
    {
        
        return view('ads.real-estate.show', compact('realEstate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate)
    {
        // Ensure only the owner can edit the listing
        if ($realEstate->user_id !== Auth::id()) {

            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this listing.');
        }

        // Define options for dropdowns and checkboxes, same as in create method
        $currentYear = date('Y');
        $yearOptions = range(1900, $currentYear);

        $propertyTypeOptions = ['Apartment', 'House', 'Land', 'Commercial Property', 'Garage', 'Other'];
        $objectTypeOptions = ['Buy', 'Rent'];
        $stateOptions = ['New building', 'Renovated', 'Needs renovation', 'Old building'];
        $constructionTypeOptions = ['solid construction', 'prefabricated house', 'timber construction', 'brick construction', 'reinforced concrete'];
        $availabilityOptions = ['Immediately', 'By appointment', 'From [date]'];
        $fixedTermContractOptions = ['Permanent', 'Fixed-term'];
        $heatingOptions = ['Central heating', 'floor heating', 'underfloor heating', 'district heating', 'gas heating', 'oil heating', 'electric heating', 'fireplace/stove'];
        $equipmentOptions = [
            'Balcony',
            'Terrace',
            'Garden',
            'Basement',
            'Attic',
            'Garage',
            'Parking space',
            'Fitted kitchen',
            'Furnished',
            'Accessible',
            'Elevator',
            'Air conditioning',
            'Swimming pool',
            'Sauna',
            'Alarm system',
            'Wheelchair accessible',
            'Cable/satellite TV',
            'Internet connection',
            'Laundry room',
            'Storage room',
            'Guest toilet',
            'Bathtub',
            'Shower',
            'Separate toilet'
        ];
        if ($realEstate->befristung_ende) {
            $realEstate->befristung_ende = \Carbon\Carbon::parse($realEstate->befristung_ende);
        }


        // Ensure 'ausstattung' is an array for the form
        if (!is_array($realEstate->ausstattung)) {
            $realEstate->ausstattung = json_decode($realEstate->ausstattung, true) ?? [];
        }


        return view('ads.real-estate.edit', compact(
            'realEstate',
            'propertyTypeOptions',
            'objectTypeOptions',
            'stateOptions',
            'constructionTypeOptions',
            'availabilityOptions',
            'fixedTermContractOptions',
            'heatingOptions',
            'equipmentOptions',
            'yearOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate)
    {
        if ($realEstate->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update this listing.');
        }

        $validatedData = $request->validate([
            'category_slug' => ['required', 'string', 'max:255', Rule::in(['immobilien'])],
            'propertyTypeOptions' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'objekttyp' => ['nullable', 'string'],
            'condition' => ['nullable', 'string'],
            'anzahl_zimmer' => ['nullable', 'numeric', 'min:0.5'],
            'propertyTypeOptions' => ['nullable', 'string'],
            'verfugbarkeit' => ['nullable', 'string'],
            'befristung' => ['nullable', 'string'],
            'befristung_ende' => ['nullable', 'date'],
            'year_of_construction' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'pet_friendly' => ['nullable', Rule::in(['Yes', 'No'])],
            'description' => ['required', 'string'],
            'objektbeschreibung' => ['nullable', 'string'],
            'lage' => ['nullable', 'string'],
            'sonstiges' => ['nullable', 'string'],
            'zusatzinformation' => ['nullable', 'string'],
            'land' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:10'],
            'location' => ['required', 'string', 'max:255'],
            'strasse' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'livingSpace' => ['nullable', 'numeric', 'min:0'],
            'grundflaeche' => ['nullable', 'numeric', 'min:0'],
            'kaution' => ['nullable', 'numeric', 'min:0'],
            'maklerprovision' => ['nullable', 'numeric', 'min:0'],
            'abloese' => ['nullable', 'numeric', 'min:0'],
            'ausstattung' => ['nullable', 'array'],
            'ausstattung.*' => ['string'],
            'heating' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'grundriss_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'energieausweis_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'rundgang_link' => ['nullable', 'url', 'max:2048'],
            'objektinformationen_link' => ['nullable', 'url', 'max:2048'],
            'zustandsbericht_link' => ['nullable', 'url', 'max:2048'],
            'verkaufsbericht_link' => ['nullable', 'url', 'max:2048'],
            'contact_name' => ['required', 'string', 'max:255'],
            'homepage' => ['nullable', 'url', 'max:2048'],
            'zusatzkontakt' => ['boolean'],
        ]);

        $imageFiles = $request->file('images');
        $dataToUpdateRealEstate = Arr::except($validatedData, ['images', 'zusatzkontakt']);
        $dataToUpdateRealEstate['zusatzkontakt'] = $request->has('zusatzkontakt');
        $dataToUpdateRealEstate['pet_friendly'] = $request->input('pet_friendly', null);


          $realEstate->show_phone = $request->has('show_phone') ? 1 : 0;
        $realEstate->show_mobile_phone = $request->has('show_mobile_phone') ? 1 : 0;
        $realEstate->show_email = $request->has('show_email') ? 1 : 0;
        $realEstate->save();

        // Handle document updates
        foreach (['grundriss_path', 'energieausweis_path'] as $doc) {
            if ($request->hasFile($doc)) {
                if ($realEstate->$doc) {
                    Storage::disk('public')->delete($realEstate->$doc);
                }
                $dataToUpdateRealEstate[$doc] = $request->file($doc)->store('real_estate_documents', 'public');
            } elseif ($request->boolean("remove_{$doc}")) {
                if ($realEstate->$doc) {
                    Storage::disk('public')->delete($realEstate->$doc);
                }
                $dataToUpdateRealEstate[$doc] = null;
            }
        }

        $realEstate->update($dataToUpdateRealEstate);


        if (is_array($imageFiles)) {
            foreach ($imageFiles as $image) {
                $path = $image->store('real_estate_images', 'public');
                RealEstateImage::create([
                    'real_estate_id' => $realEstate->id,
                    'image_path' => $path,
                    'is_thumbnail' => false,
                ]);
            }
        }

        if ($request->filled('existing_images_to_delete')) {
            $imageIdsToRemove = explode(',', $request->input('existing_images_to_delete'));
            $imagesToDelete = RealEstateImage::where('real_estate_id', $realEstate->id)
                ->whereIn('id', $imageIdsToRemove)
                ->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            if ($realEstate->images()->where('is_thumbnail', true)->doesntExist() && $realEstate->images()->count() > 0) {
                $realEstate->images()->first()->update(['is_thumbnail' => true]);
            }
        }

        return redirect()->route('ads.real-estate.show', $realEstate)->with('success', 'Immobilien Anzeige erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate)
    {
        // Ensure only the owner can delete the listing
        if ($realEstate->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this listing.');
        }

        // Delete associated images from storage and database
        foreach ($realEstate->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete associated documents from storage
        if ($realEstate->grundriss_path) {
            Storage::disk('public')->delete($realEstate->grundriss_path);
        }
        if ($realEstate->energieausweis_path) {
            Storage::disk('public')->delete($realEstate->energieausweis_path);
        }

        // Delete the real estate listing itself
        $realEstate->delete();

        return redirect()->route('dashboard')->with('success', 'Immobilien Anzeige erfolgreich gelöscht!');
    }
}
