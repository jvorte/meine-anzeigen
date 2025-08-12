{{-- resources/views/ads/camper/edit.blade.php --}}
<x-app-layout>
    {{-- --------------------------------------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Wohnmobil Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Passe die Details deiner Wohnmobil Anzeige an.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
            {{-- Link to the general campers category page --}}
            ['label' => 'Campers Anzeigen', 'url' => route('categories.campers.index')],

            {{-- Link to the specific camper's show page --}}
            ['label' => 'Camper Anzeige', 'url' => route('categories.campers.show', $camper->id)],

            {{-- The current page (Camper Edit) - set URL to null as it's the current page --}}
            ['label' => 'Camper bearbeiten', 'url' => null],
        ]" />
        </div>
    </div>
    {{-- --------------------------------------------------------------------------------- --}}
    <!-- check form fields -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>



    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        {{-- Use PUT method for update, and enctype for file uploads --}}
        <form method="POST" action="{{ route('ads.camper.update', $camper->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- This is crucial for update operations --}}

            {{-- Vehicle Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner" x-data="{
    selectedBrand: {{ old('camper_brand_id', $camper->camper_brand_id ?? 'null') }},
    models: [],
    fetchModels() {
        if (this.selectedBrand) {
            fetch(`/api/camper-brands/${this.selectedBrand}/models`)
                .then(response => response.json())
                .then(data => {
                    this.models = Object.keys(data).map(key => ({ id: key, name: data[key] }));
                    this.$nextTick(() => {
                        let oldModelId = {{ old('camper_model_id', $camper->camper_model_id ?? 'null') }};
                        if (oldModelId && this.models.some(model => model.id == oldModelId)) {
                            document.getElementById('camper_model_id').value = oldModelId;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching models:', error);
                    this.models = [];
                });
        } else {
            this.models = [];
        }
    }
}" x-init="fetchModels()">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        {{-- Marke (Dropdown from camper_brands table) --}}
                        <label for="camper_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <select name="camper_brand_id" id="camper_brand_id" x-model="selectedBrand" @change="fetchModels()"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen Sie eine Marke</option>
                            @foreach (App\Models\CamperBrand::orderBy('name')->get() as $brand)
                            <option value="{{ $brand->id }}" {{ old('camper_brand_id', $camper->camper_brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('camper_brand_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        {{-- Modell (Dynamic Dropdown) --}}
                        <label for="camper_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="camper_model_id" id="camper_model_id"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            :disabled="!selectedBrand">
                            <option value="">Bitte wählen Sie ein Modell</option>
                            <template x-for="model in models" :key="model.id">
                                <option :value="model.id" x-text="model.name"
                                    :selected="model.id == {{ old('camper_model_id', $camper->camper_model_id ?? 'null') }}">
                                </option>
                            </template>
                        </select>
                        @error('camper_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Basic Data Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $camper->price) }}"
                            placeholder="z.B. 45.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- First registration --}}
                    <div>
                        <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-2">First Registration</label>
                        <select name="first_registration" id="first_registration" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Επιλέξτε Έτος</option>
                            @php
                            $currentYear = date('Y');
                            $startYear = 1990;
                            $selectedYear = old('first_registration', isset($camper) ? $camper->first_registration : '');
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('first_registration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand (in
                            km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $camper->mileage) }}"
                            placeholder="z.B. 75.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Leistung (PS) --}}
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power', $camper->power) }}" placeholder="z.B. 130"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Farbe --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe</label>
                        <select name="color" id="color"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($colors as $color)
                            <option value="{{ $color }}" {{ old('color', $camper->color) == $color ? 'selected' : '' }}>{{ $color }}
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
                            <option value="new" {{ old('condition', $camper->condition) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition', $camper->condition) == 'used' ? 'selected' : '' }}>Used</option>
                            <option value="accident" {{ old('condition', $camper->condition) == 'accident' ? 'selected' : '' }}>Accident vehicle</option>
                            <option value="damaged" {{ old('condition', $camper->condition) == 'damaged' ? 'selected' : '' }}>Damaged vehicle</option>
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                </div>
            </section>

            {{-- Camper Specific Data --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Wohnmobil-Spezifikationen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Camper Type --}}
                    <div>
                        <label for="camper_type"
                            class="block text-sm font-medium text-gray-700 mb-2">Wohnmobil-Typ</label>
                        <select name="camper_type" id="camper_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($camperTypes as $type)
                            <option value="{{ $type }}" {{ old('camper_type', $camper->camper_type) == $type ? 'selected' : '' }}>{{ $type }}
                            </option>
                            @endforeach
                        </select>
                        @error('camper_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Berths --}}
                    <div>
                        <label for="berths" class="block text-sm font-medium text-gray-700 mb-2">Anzahl
                            Schlafplätze</label>
                        <input type="number" name="berths" id="berths" value="{{ old('berths', $camper->berths) }}" placeholder="z.B. 4"
                            min="1"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('berths')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Length --}}
                    <div>
                        <label for="total_length" class="block text-sm font-medium text-gray-700 mb-2">Gesamtlänge (in
                            m)</label>
                        <input type="number" step="0.1" name="total_length" id="total_length"
                            value="{{ old('total_length', $camper->total_length) }}" placeholder="z.B. 6.5"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_length')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Width --}}
                    <div>
                        <label for="total_width" class="block text-sm font-medium text-gray-700 mb-2">Gesamtbreite (in
                            m)</label>
                        <input type="number" step="0.1" name="total_width" id="total_width"
                            value="{{ old('total_width', $camper->total_width) }}" placeholder="z.B. 2.3"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_width')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Height --}}
                    <div>
                        <label for="total_height" class="block text-sm font-medium text-gray-700 mb-2">Gesamthöhe (in
                            m)</label>
                        <input type="number" step="0.1" name="total_height" id="total_height"
                            value="{{ old('total_height', $camper->total_height) }}" placeholder="z.B. 2.9"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_height')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gross Vehicle Weight --}}
                    <div>
                        <label for="gross_vehicle_weight"
                            class="block text-sm font-medium text-gray-700 mb-2">Gesamtgewicht (in kg)</label>
                        <input type="number" name="gross_vehicle_weight" id="gross_vehicle_weight"
                            value="{{ old('gross_vehicle_weight', $camper->gross_vehicle_weight) }}" placeholder="z.B. 3500"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('gross_vehicle_weight')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fuel Type --}}
                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-2">Treibstoff</label>
                        <select name="fuel_type" id="fuel_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($fuelTypes as $type)
                            <option value="{{ $type }}" {{ old('fuel_type', $camper->fuel_type) == $type ? 'selected' : '' }}>{{ $type }}
                            </option>
                            @endforeach
                        </select>
                        @error('fuel_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label for="transmission"
                            class="block text-sm font-medium text-gray-700 mb-2">Getriebeart</label>
                        <select name="transmission" id="transmission"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($transmissions as $trans)
                            <option value="{{ $trans }}" {{ old('transmission', $camper->transmission) == $trans ? 'selected' : '' }}>
                                {{ $trans }}
                            </option>
                            @endforeach
                        </select>
                        @error('transmission')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Emission Class --}}
                    <div>
                        <label for="emission_class"
                            class="block text-sm font-medium text-gray-700 mb-2">Emissionsklasse</label>
                        <select name="emission_class" id="emission_class"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($emissionClasses as $class)
                            <option value="{{ $class }}" {{ old('emission_class', $camper->emission_class) == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                            @endforeach
                        </select>
                        @error('emission_class')
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
                    <input type="text" name="title" id="title" value="{{ old('title', $camper->title) }}"
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
                        placeholder="Gib hier alle wichtigen Details zu deinem Wohnmobil ein. Je mehr Informationen, desto besser!"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $camper->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>




          


            
{{-- Contact Section --}}
<section class="bg-gray-50 p-6 rounded-lg shadow-inner">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">
        Select if you want to publish your Mobile phone or email
    </h4>

    {{-- Phone --}}
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_phone" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_phone', $camper->show_phone) ? 'checked' : '' }}
            >
            <span class="ml-2">Phone</span>
        </label>
    </div>

    {{-- Mobile --}}
    <div class="mt-2">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_mobile_phone" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_mobile_phone', $camper->show_mobile_phone) ? 'checked' : '' }}
            >
            <span class="ml-2">Mobile</span>
        </label>
    </div>

    {{-- Email --}}
    <div class="mt-2">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_email" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_email', $camper->show_email) ? 'checked' : '' }}
            >
            <span class="ml-2">Email</span>
        </label>
    </div>
</section>




            {{-- Existing Photos Section --}}
            @if ($camper->images->count() > 0)
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($camper->images as $image)
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
                    <input type="file" name="images[]" multiple @change="addFiles($event)"
                        class="block w-full border p-2 rounded" />
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

                {{-- Alpine.js Script for Image Previews --}}
                <script>
                    function multiImageUploader() {
                        return {
                            files: [], // Stores the actual File objects
                            previews: [], // Stores URLs for image previews

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
                                // Remove from internal arrays
                                this.files.splice(index, 1);
                                this.previews.splice(index, 1);

                                // Update the actual file input's files property
                                // Find the file input within the current component's scope
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