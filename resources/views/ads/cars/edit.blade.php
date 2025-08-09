{{-- resources/views/ads/cars/edit.blade.php --}}
<x-app-layout>

    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Auto Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Anzeige oder füge neue Fotos hinzu.
        </p>
    </x-slot>

 

    <div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Breadcrumbs component --}}
        <x-breadcrumbs :items="[
            {{-- Link to the general campers category page --}}
            ['label' => 'Cars Anzeigen', 'url' => route('categories.cars.index')],

            {{-- Link to the specific camper's show page --}}
            ['label' => 'Car Anzeige', 'url' => route('categories.cars.show', $car->id)],

            {{-- The current page (Camper Edit) - set URL to null as it's the current page --}}
            ['label' => 'Car bearbeiten', 'url' => null],
        ]" />
    </div>
</div>
    {{-- ------------------------------------------------------------------------------------- --}}

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        <form method="POST" action="{{ route('ads.cars.update', $car->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Vehicle Details Section (Marke & Modell) --}}
<section class="bg-gray-50 p-6 rounded-lg shadow-inner">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

   
     {{-- Marke --}}
<div>
    <label for="car_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
    <select name="car_brand_id" id="car_brand_id" onchange="loadModels(this.value)"
        class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Bitte wählen</option>
        @foreach($brands as $id => $name)
            <option value="{{ $id }}" {{ (old('car_brand_id', $car->car_brand_id ?? '') == $id) ? 'selected' : '' }}>
                {{-- FIX: Changed $car->car_brand_id to $car->brand_id --}}
                {{ $name }}
            </option>
        @endforeach
    </select>
    @error('car_brand_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

        {{-- Modell --}}
    <div>
            <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
            <select name="car_model_id" id="car_model_id"
                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">Bitte wählen</option>
                @foreach($initialModels as $id => $name)
                    <option value="{{ $id }}" {{ (old('car_model_id', $car->car_model_id ?? '') == $id) ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('car_model_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>
</section>

<script>
    function loadModels(brandId) {
        const modelSelect = document.getElementById('car_model_id');
        modelSelect.innerHTML = '<option value="">Bitte wählen</option>'; // Καθαρισμός

        if (!brandId) return;

        fetch(`/api/car-brands/${brandId}/models`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(models => {
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    modelSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading car models:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const brandId = '{{ old('car_brand_id', $car->car_brand_id ?? '') }}';
        const modelId = '{{ old('car_model_id', $car->car_model_id ?? '') }}';

        if (brandId) {
            loadModels(brandId);

            // Μετά από λίγο ορίζεις το επιλεγμένο μοντέλο
            setTimeout(() => {
                document.getElementById('car_model_id').value = modelId;
            }, 500);
        }
    });
</script>


            {{-- Basic Data Section (Erstzulassung, Kilometerstand, Leistung) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Erstzulassung --}}
                        <div>
                    <label for="registration_to" class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung (Year)</label>
                    <input type="number" name="registration_to" id="registration_to" 
                        value="{{ old('registration_to', $car->registration) }}"
                        min="1900" max="{{ date('Y') }}"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('registration_to')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage_from" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand
                            (in km)</label>
                        <input type="number" name="mileage_from" id="mileage_from" value="{{ old('mileage_from', $car->mileage) }}"
                            placeholder="z.B. 50.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Leistung (PS) --}}
                    <div>
                        <label for="power_from" class="block text-sm font-medium text-gray-700 mb-2">Leistung
                            (PS)</label>
                        <input type="number" name="power_from" id="power_from" value="{{ old('power_from', $car->power) }}"
                            placeholder="z.B. 150"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Type & Condition Section (Farbe & Zustand) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Typ & Zustand</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Farbe --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe</label>
                        <select name="color" id="color"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($colors as $colorOption)
                                <option value="{{ $colorOption }}" {{ old('color', $car->color) == $colorOption ? 'selected' : '' }}>{{ $colorOption }}
                                </option>
                            @endforeach
                        </select>
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
         <div>
    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
    <select name="condition" id="condition"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Please select</option>
        <option value="new" {{ old('condition', $car->condition) == 'new' ? 'selected' : '' }}>New</option>
        <option value="used" {{ old('condition', $car->condition) == 'used' ? 'selected' : '' }}>Used</option>
        <option value="accident" {{ old('condition', $car->condition) == 'accident' ? 'selected' : '' }}>Accident vehicle</option>
        <option value="damaged" {{ old('condition', $car->condition) == 'damaged' ? 'selected' : '' }}>Damaged vehicle</option>
    </select>
    @error('condition')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                </div>
            </section>

            {{-- New Fields for Autos (Fuel Type, Transmission, Drive, Doors, Seats, Seller Type, Price, Vehicle Type, Warranty) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Zusätzliche Fahrzeugmerkmale</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    
                    {{-- Fuel Type --}}
                    <div>
                        <label for="fuel_type"
                            class="block text-sm font-medium text-gray-700 mb-2">Kraftstoffart</label>
                        <select name="fuel_type" id="fuel_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="benzin" {{ old('fuel_type', $car->fuel_type) == 'benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="elektro" {{ old('fuel_type', $car->fuel_type) == 'elektro' ? 'selected' : '' }}>Elektro</option>
                            <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="lpg" {{ old('fuel_type', $car->fuel_type) == 'lpg' ? 'selected' : '' }}>LPG</option>
                            <option value="cng" {{ old('fuel_type', $car->fuel_type) == 'cng' ? 'selected' : '' }}>CNG</option>
                        </select>
                        @error('fuel_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700 mb-2">Transmission</label>
                        <select name="transmission" id="transmission"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual
                            </option>
                            <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic
                            </option>
                        </select>
                        @error('transmission')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Drive --}}
                    <div>
                        <label for="drive" class="block text-sm font-medium text-gray-700 mb-2">Antrieb</label>
                        <select name="drive" id="drive"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="front" {{ old('drive', $car->drive) == 'front' ? 'selected' : '' }}>Front
                            </option>
                            <option value="rear" {{ old('drive', $car->drive) == 'rear' ? 'selected' : '' }}>Rear</option>
                            <option value="all" {{ old('drive', $car->drive) == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                        @error('drive')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Doors --}}
                    <div>
                        <label for="doors_from" class="block text-sm font-medium text-gray-700 mb-2">Anzahl
                            Türen</label>
                        <select name="doors_from" id="doors_from"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="2" {{ old('doors_from', $car->doors) == '2' ? 'selected' : '' }}>2/3</option>
                            <option value="4" {{ old('doors_from', $car->doors) == '4' ? 'selected' : '' }}>4/5</option>
                            <option value="6" {{ old('doors_from', $car->doors) == '6' ? 'selected' : '' }}>6/7</option>
                        </select>
                        @error('doors_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Seats --}}
                    <div>
                        <label for="seats_from" class="block text-sm font-medium text-gray-700 mb-2">Anzahl
                            Sitze</label>
                        <select name="seats_from" id="seats_from"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="2" {{ old('seats_from', $car->seats) == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('seats_from', $car->seats) == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('seats_from', $car->seats) == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('seats_from', $car->seats) == '5' ? 'selected' : '' }}>5</option>
                            <option value="7" {{ old('seats_from', $car->seats) == '7' ? 'selected' : '' }}>7</option>
                            <option value="9" {{ old('seats_from', $car->seats) == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('seats_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price_from" class="block text-sm font-medium text-gray-700 mb-2">Preis (€)</label>
                        <input type="number" name="price_from" id="price_from" value="{{ old('price_from', $car->price) }}"
                            placeholder="z.B. 15000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Vehicle Type --}}
                  <div>
    <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
    <select name="vehicle_type" id="vehicle_type"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Bitte wählen</option>

        <option value="sedan" {{ old('vehicle_type', $car->vehicle_type) == 'sedan' ? 'selected' : '' }}>sedan</option>
        <option value="station" {{ old('vehicle_type', $car->vehicle_type) == 'station' ? 'selected' : '' }}>station wagon</option>
        <option value="SUV/Off-road" {{ old('vehicle_type', $car->vehicle_type) == 'SUV/Off-road' ? 'selected' : '' }}>SUV/Off-road</option>
        <option value="coupe" {{ old('vehicle_type', $car->vehicle_type) == 'coupe' ? 'selected' : '' }}>coupe</option>
        <option value="convertible" {{ old('vehicle_type', $car->vehicle_type) == 'convertible' ? 'selected' : '' }}>convertible</option>
        <option value="minivan" {{ old('vehicle_type', $car->vehicle_type) == 'minivan' ? 'selected' : '' }}>minivan</option>
        <option value="pickup" {{ old('vehicle_type', $car->vehicle_type) == 'pickup' ? 'selected' : '' }}>Pickup</option>
    </select>
    @error('vehicle_type')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


                    {{-- Warranty --}}
                    <div>
                        <label for="warranty" class="block text-sm font-medium text-gray-700 mb-2">Garantie</label>
                        <select name="warranty" id="warranty"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="yes" {{ old('warranty', $car->warranty) == 'yes' ? 'selected' : '' }}>Ja</option>
                            <option value="no" {{ old('warranty', $car->warranty) == 'no' ? 'selected' : '' }}>Nein</option>
                        </select>
                        @error('warranty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Seller Type --}}
                    <div>
                        <label for="seller_type" class="block text-sm font-medium text-gray-700 mb-2">Anbieter</label>
                        <select name="seller_type" id="seller_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="private" {{ old('seller_type', $car->seller_type) == 'private' ? 'selected' : '' }}>Privat
                            </option>
                            <option value="dealer" {{ old('seller_type', $car->seller_type) == 'dealer' ? 'selected' : '' }}>Händler</option>
                        </select>
                        @error('seller_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                {{-- Titel --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $car->title) }}"
                        placeholder="Aussagekräftiger Titel für deine Anzeige"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Gib hier alle wichtigen Details zu deinem Auto ein. Je mehr Informationen, desto besser!"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $car->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Existing Photos Section --}}
            @if ($car->images->count() > 0)
                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($car->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Car Image" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                <label class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="mr-1"> Löschen
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-600 mt-4">Wähle Fotos zum Löschen aus.</p>
                </section>
            @endif

    


      {{-- Photo Upload Section --}}
            {{-- The x-data="multiImageUploader()" is placed on a div wrapping the input and previews --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                <div x-data="multiImageUploader()" class="space-y-4">
                    {{-- The file input field. Laravel will pick up files from here. --}}
                    <input type="file" name="new_images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*') {{-- For individual image validation errors --}}
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="(image, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews and Main Form Logic --}}
                <script>
                    function multiImageUploader() {
                        return {
                            files: [],
                            previews: [],

                            addFiles(event) {
                                const newFiles = Array.from(event.target.files);

                                newFiles.forEach(file => {
                                    this.files.push(file);
                                    this.previews.push(URL.createObjectURL(file));
                                });

                                const dataTransfer = new DataTransfer();
                                this.files.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;
                            },

                            remove(index) {
                                URL.revokeObjectURL(this.previews[index]);

                                this.files.splice(index, 1);
                                this.previews.splice(index, 1);

                                const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                if (fileInput) {
                                    const dataTransfer = new DataTransfer();
                                    this.files.forEach(file => dataTransfer.items.add(file));
                                    fileInput.files = dataTransfer.files;
                                }
                            }
                        };
                    }

                    // Define the Alpine.js component for the car form
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('carAdForm', (initialBrandId, initialModelId, initialModels) => ({
                            selectedCarBrandId: initialBrandId || '',
                            selectedCarModelId: initialModelId || '',
                            carModels: initialModels || {},

                            async fetchCarModels() {
                                console.log('fetchCarModels triggered. Current selectedCarBrandId (before fetch):', this.selectedCarBrandId);

                                if (this.selectedCarBrandId) {
                                    const fetchUrl = `/car-models/${this.selectedCarBrandId}`;
                                    console.log('Attempting to fetch models from URL:', fetchUrl);
                                    try {
                                        const response = await fetch(fetchUrl);
                                        if (!response.ok) {
                                            console.error('HTTP error! Status:', response.status, 'Response text:', await response.text());
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        const data = await response.json();
                                        console.log('Models fetched successfully:', data);
                                        this.carModels = data;

                                        // If the previously selected model is not in the new list, clear it
                                        if (this.selectedCarModelId && !Object.keys(this.carModels).includes(String(this.selectedCarModelId))) {
                                            this.selectedCarModelId = '';
                                            console.log('Cleared selectedCarModelId as it was not in the new list.');
                                        }
                                    } catch (error) {
                                        console.error('Error fetching car models:', error);
                                        this.carModels = {}; // Clear models on error
                                        this.selectedCarModelId = ''; // Clear selected model on error
                                    }
                                } else {
                                    console.log('No brand selected, clearing models.');
                                    this.carModels = {};
                                    this.selectedCarModelId = '';
                                }
                            },

                            init() {
                                console.log('carAdForm init() called.');
                                console.log('  Initial state in init(): selectedCarBrandId:', this.selectedCarBrandId);
                                console.log('  Initial state in init(): selectedCarModelId:', this.selectedCarModelId);
                                console.log('  Initial state in init(): carModels (should be empty initially or pre-populated):', this.carModels);

                                this.$nextTick(async () => {
                                    console.log('  $nextTick callback entered.');
                                    // Only fetch models on init if a brand was previously selected (e.g., after validation error)
                                    if (this.selectedCarBrandId) {
                                        await this.fetchCarModels();
                                        // After models are fetched and rendered, try to set the old model ID
                                        if (initialModelId && Object.keys(this.carModels).includes(String(initialModelId))) {
                                            this.selectedCarModelId = initialModelId;
                                            console.log('  Final check: Successfully re-set selectedCarModelId to initialModelId:', this.selectedCarModelId);
                                        } else if (initialModelId) {
                                            console.log('  Final check: Initial model ID', initialModelId, 'not found in fetched models. Clearing selection.');
                                            this.selectedCarModelId = ''; // Clear if old model isn't valid for the brand
                                        }
                                    } else {
                                        // If no brand is selected initially, ensure models are empty and hidden
                                        this.carModels = {};
                                        this.selectedCarModelId = '';
                                        console.log('  No initial brand selected, ensuring models are cleared and hidden.');
                                    }
                                });

                                this.$watch('selectedCarBrandId', (value) => {
                                    console.log('selectedCarBrandId changed to (via $watch):', value);
                                    this.selectedCarModelId = ''; // Always clear model when brand changes
                                    this.fetchCarModels();
                                });
                            },
                        }));
                    });
                </script>
            </section>




            {{-- Add category_slug hidden input --}}
            <input type="hidden" name="category_slug" value="auto">

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige aktualisieren
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
