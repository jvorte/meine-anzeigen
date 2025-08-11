{{-- resources/views/ads/commercial-vehicles/create.blade.php --}}
<x-app-layout>
{{-- --------------------------------------------------------------------------------- --}}
   <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            New commercial-vehicle ad
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
            ['label' => 'commercial-vehicle Anzeigen', 'url' => route('categories.commercial-vehicles.index')],

            {{-- The current page (New Car Ad creation) - set URL to null --}}
            ['label' => 'Neue commercial-vehicle Anzeige', 'url' => null],
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

        <form method="POST" action="{{ route('ads.commercial-vehicles.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Vehicle Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                {{-- In your commercial ad creation/edit form --}}

{{-- Commercial Brand Dropdown --}}
<div class="mb-4">
    <label for="commercial_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Commercial Brand</label>
    <select name="commercial_brand_id" id="commercial_brand_id" onchange="loadCommercialModels(this.value)"
        class="form-select w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Select a Brand</option>
        @foreach($commercialBrands as $brand) {{-- This variable needs to be passed from your controller --}}
            <option value="{{ $brand->id }}" {{ (old('commercial_brand_id') == $brand->id) ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
    @error('commercial_brand_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Commercial Model Dropdown --}}
<div class="mb-4">
    <label for="commercial_model_id" class="block text-sm font-medium text-gray-700 mb-2">Commercial Model</label>
    <select name="commercial_model_id" id="commercial_model_id"
        class="form-select w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Select a Model</option>
        {{-- Models will be loaded here by JavaScript --}}
        {{-- If editing, we might need to pre-fill. This depends on your controller passing initial models. --}}
        @isset($initialCommercialModels)
            @foreach($initialCommercialModels as $model)
                <option value="{{ $model->id }}" {{ (old('commercial_model_id') == $model->id) ? 'selected' : '' }}>
                    {{ $model->name }}
                </option>
            @endforeach
        @endisset
    </select>
    @error('commercial_model_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    async function loadCommercialModels(brandId, selectedModelId = null) {
        const modelSelect = document.getElementById('commercial_model_id');
        modelSelect.innerHTML = '<option value="">Select a Model</option>'; // Clear existing options

        if (!brandId) return;

        try {
            // Using the API endpoint you just confirmed
            const response = await fetch(`/api/commercial-brands/${brandId}/models`);
            if (!response.ok) {
                // Handle HTTP errors
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const models = await response.json();

            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.name;
                modelSelect.appendChild(option);
            });

            // If editing an ad, pre-select the existing model
            if (selectedModelId) {
                modelSelect.value = selectedModelId;
            }
        } catch (error) {
            console.error('Error loading commercial models:', error);
            // Optionally, display an error message to the user
            modelSelect.innerHTML = '<option value="">Error loading models</option>';
        }
    }

    // This block ensures models are loaded on page load if a brand is already selected
    // (e.g., when the form is redisplayed after a validation error, or when editing an existing ad)
    document.addEventListener('DOMContentLoaded', function() {
        // Use old() helper for repopulating after validation error, or existing ad data
  const initialBrandId = '{{ old('commercial_brand_id') }}';
const initialModelId = '{{ old('commercial_model_id') }}';

        if (initialBrandId) {
            loadCommercialModels(initialBrandId, initialModelId);
        }
    });
</script>
            </section>

            {{-- Basic Data Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 25.000"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Erstzulassung --}}
 
                  <div>
    <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-2">First registration</label>
    <select name="first_registration" id="first_registration"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Επιλέξτε Έτος</option>
        @php
            $currentYear = date('Y');
            $startYear = 1990;
        @endphp
        @for ($year = $currentYear; $year >= $startYear; $year--)
            <option value="{{ $year }}" {{ old('first_registration') == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endfor
    </select>
    @error('first_registration')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>



                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand (in km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" placeholder="z.B. 150.000"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Leistung (PS) --}}
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power') }}" placeholder="z.B. 200"
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
                                <option value="{{ $color }}" {{ old('color') == $color ? 'selected' : '' }}>{{ $color }}</option>
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
                            <option value="">Bitte wählen</option>
                     <option value="neu" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                            <option value="accident" {{ old('condition') == 'accident' ? 'selected' : '' }}>Accident vehicle</option>
                            <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Damaged vehicle</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Commercial Vehicle Specific Data --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Nutzfahrzeug-Spezifikationen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Commercial Vehicle Type --}}
                    <div>
                        <label for="commercial_vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Fahrzeugtyp</label>
                        <select name="commercial_vehicle_type" id="commercial_vehicle_type"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($commercialVehicleTypes as $type)
                                <option value="{{ $type }}" {{ old('commercial_vehicle_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('commercial_vehicle_type')
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
                                <option value="{{ $type }}" {{ old('fuel_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('fuel_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700 mb-2">Getriebeart</label>
                        <select name="transmission" id="transmission"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($transmissions as $trans)
                                <option value="{{ $trans }}" {{ old('transmission') == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                            @endforeach
                        </select>
                        @error('transmission')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payload Capacity --}}
                    <div>
                        <label for="payload_capacity" class="block text-sm font-medium text-gray-700 mb-2">Nutzlast (in kg)</label>
                        <input type="number" name="payload_capacity" id="payload_capacity" value="{{ old('payload_capacity') }}" placeholder="z.B. 1500"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('payload_capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gross Vehicle Weight --}}
                    <div>
                        <label for="gross_vehicle_weight" class="block text-sm font-medium text-gray-700 mb-2">Gesamtgewicht (in kg)</label>
                        <input type="number" name="gross_vehicle_weight" id="gross_vehicle_weight" value="{{ old('gross_vehicle_weight') }}" placeholder="z.B. 3500"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('gross_vehicle_weight')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Number of Axles --}}
                    <div>
                        <label for="number_of_axles" class="block text-sm font-medium text-gray-700 mb-2">Anzahl Achsen</label>
                        <input type="number" name="number_of_axles" id="number_of_axles" value="{{ old('number_of_axles') }}" placeholder="z.B. 2" min="1"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('number_of_axles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Emission Class --}}
                    <div>
                        <label for="emission_class" class="block text-sm font-medium text-gray-700 mb-2">Emissionsklasse</label>
                        <select name="emission_class" id="emission_class"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($emissionClasses as $class)
                                <option value="{{ $class }}" {{ old('emission_class') == $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                        @error('emission_class')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Seats (for vans/buses) --}}
                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700 mb-2">Anzahl Sitze</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats') }}" placeholder="z.B. 3" min="1"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('seats')
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
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="Gib hier alle wichtigen Details zu deinem Nutzfahrzeug ein. Je mehr Informationen, desto besser!"
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>
            </section>

           {{-- Photo Upload Section --}}
            {{-- The x-data="multiImageUploader()" is placed on a div wrapping the input and previews --}}
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

                                // Important: Assign the collected files back to the input's files property
                                // This ensures the native form submission sends the correct set of files
                                const dataTransfer = new DataTransfer();
                                this.files.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;

                                // No need to clear event.target.value = '' if you're managing `event.target.files` directly.
                                // It can sometimes interfere with re-selecting the *same* file if you clear it.
                                // If you want to allow selecting the same file multiple times, you might need
                                // to rethink the preview logic or clear it but rely on the `files` array.
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
                    Anzeige erstellen
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
