{{-- resources/views/ads/auto/create.blade.php --}}
<x-app-layout>

    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Auto Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                {{-- Link to the general Cars category listing --}}
                ['label' => 'Cars Anzeigen', 'url' => route('categories.cars.index')],

                {{-- The current page (New Car Ad creation) - set URL to null --}}
                ['label' => 'Neue Auto Anzeige', 'url' => null],
            ]" />
        </div>
    </div>


    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        <form method="POST" action="{{ route('ads.cars.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

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
                    <option value="{{ $id }}"
                        {{ old('car_brand_id') == $id ? 'selected' : '' }}>
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
                {{-- Δεν φορτώνουμε μοντέλα server side στο create --}}
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
    modelSelect.innerHTML = '<option>Loading...</option>';

    if (!brandId) {
        modelSelect.innerHTML = '<option value="">Bitte zuerst eine Marke wählen</option>';
        return;
    }

    fetch(`/api/car-brands/${brandId}/models`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(models => {
            modelSelect.innerHTML = '<option value="">Bitte wählen</option>';
            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.name;

                // Επιλογή αν υπάρχει old('car_model_id') (πχ μετά από validation error)
                const oldModelId = "{{ old('car_model_id') }}";
                if (model.id == oldModelId) {
                    option.selected = true;
                }

                modelSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading car models:', error);
            modelSelect.innerHTML = '<option value="">Fehler beim Laden</option>';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const selectedBrandId = document.getElementById('car_brand_id').value;
    if (selectedBrandId) {
        loadModels(selectedBrandId);
    }
});
</script>


            {{-- Basic Data Section (Erstzulassung, Kilometerstand, Leistung) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Erstzulassung --}}
                    <div>
                        <label for="registration_to"
                            class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung</label>
                        <input type="date" name="registration_to" id="registration_to"
                            value="{{ old('registration_to') }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('registration_to')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage_from" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand
                            (in km)</label>
                        <input type="number" name="mileage_from" id="mileage_from" value="{{ old('mileage_from') }}"
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
                        <input type="number" name="power_from" id="power_from" value="{{ old('power_from') }}"
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
                            @foreach($colors as $color)
                                <option value="{{ $color }}" {{ old('color') == $color ? 'selected' : '' }}>{{ $color }}
                                </option>
                            @endforeach
                        </select>
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="neu" {{ old('condition') == 'neu' ? 'selected' : '' }}>Neu</option>
                            <option value="gebraucht" {{ old('condition') == 'gebraucht' ? 'selected' : '' }}>Gebraucht
                            </option>
                            <option value="unfallfahrzeug" {{ old('condition') == 'unfallfahrzeug' ? 'selected' : '' }}>
                                Unfallfahrzeug</option>
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
                            <option value="benzin" {{ old('fuel_type') == 'benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="elektro" {{ old('fuel_type') == 'elektro' ? 'selected' : '' }}>Elektro</option>
                            <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="lpg" {{ old('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                            <option value="cng" {{ old('fuel_type') == 'cng' ? 'selected' : '' }}>CNG</option>
                        </select>
                        @error('fuel_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700 mb-2">Getriebe</label>
                        <select name="transmission" id="transmission"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="manuell" {{ old('transmission') == 'manuell' ? 'selected' : '' }}>Manuell
                            </option>
                            <option value="automatik" {{ old('transmission') == 'automatik' ? 'selected' : '' }}>Automatik
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
                            <option value="front" {{ old('drive') == 'front' ? 'selected' : '' }}>Vorderradantrieb
                            </option>
                            <option value="rear" {{ old('drive') == 'rear' ? 'selected' : '' }}>Hinterradantrieb</option>
                            <option value="all" {{ old('drive') == 'all' ? 'selected' : '' }}>Allrad</option>
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
                            <option value="2" {{ old('doors_from') == '2' ? 'selected' : '' }}>2/3</option>
                            <option value="4" {{ old('doors_from') == '4' ? 'selected' : '' }}>4/5</option>
                            <option value="6" {{ old('doors_from') == '6' ? 'selected' : '' }}>6/7</option>
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
                            <option value="2" {{ old('seats_from') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('seats_from') == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('seats_from') == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('seats_from') == '5' ? 'selected' : '' }}>5</option>
                            <option value="7" {{ old('seats_from') == '7' ? 'selected' : '' }}>7</option>
                            <option value="9" {{ old('seats_from') == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('seats_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price_from" class="block text-sm font-medium text-gray-700 mb-2">Preis (€)</label>
                        <input type="number" name="price_from" id="price_from" value="{{ old('price_from') }}"
                            placeholder="z.B. 15000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Vehicle Type --}}
                    <div>
                        <label for="vehicle_type"
                            class="block text-sm font-medium text-gray-700 mb-2">Fahrzeugtyp</label>
                        <select name="vehicle_type" id="vehicle_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="limousine" {{ old('vehicle_type') == 'limousine' ? 'selected' : '' }}>Limousine
                            </option>
                            <option value="kombi" {{ old('vehicle_type') == 'kombi' ? 'selected' : '' }}>Kombi</option>
                            <option value="suv" {{ old('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV/Geländewagen
                            </option>
                            <option value="coupe" {{ old('vehicle_type') == 'coupe' ? 'selected' : '' }}>Coupé</option>
                            <option value="cabrio" {{ old('vehicle_type') == 'cabrio' ? 'selected' : '' }}>Cabrio</option>
                            <option value="minivan" {{ old('vehicle_type') == 'minivan' ? 'selected' : '' }}>Minivan
                            </option>
                            <option value="kleinwagen" {{ old('vehicle_type') == 'kleinwagen' ? 'selected' : '' }}>
                                Kleinwagen</option>
                            <option value="pickup" {{ old('vehicle_type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
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
                            <option value="yes" {{ old('warranty') == 'yes' ? 'selected' : '' }}>Ja</option>
                            <option value="no" {{ old('warranty') == 'no' ? 'selected' : '' }}>Nein</option>
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
                            <option value="private" {{ old('seller_type') == 'private' ? 'selected' : '' }}>Privat
                            </option>
                            <option value="dealer" {{ old('seller_type') == 'dealer' ? 'selected' : '' }}>Händler</option>
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
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="Aussagekräftiger Titel für deine Anzeige"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Gib hier alle wichtigen Details zu deinem Auto ein. Je mehr Informationen, desto besser!"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>
            </section>


            {{-- Photo Upload Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                <div x-data="multiImageUploader()" class="space-y-4">
                    {{-- The file input field. Laravel will pick up files from here. --}}
                    <input type="file" name="images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
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

                   
                </script>
            </section>


            {{-- Add category_slug hidden input --}}
            <input type="hidden" name="category_slug" value="auto">

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige erstellen
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
