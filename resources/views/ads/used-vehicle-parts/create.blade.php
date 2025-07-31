{{-- resources/views/ads/used-vehicle-parts/create.blade.php --}}
<x-app-layout>


      {{-- --------------------------------------------------------------------------------- --}}
   <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Gebrauchte Fahrzeugteile  Anzeige erstellen
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
            ['label' => 'Cars Anzeigen', 'url' => route('categories.show', 'cars')],

            {{-- The current page (New Car Ad creation) - set URL to null --}}
            ['label' => 'Neue Auto Anzeige', 'url' => null],
        ]" />
    </div>
</div>
{{-- --------------------------------------------------------------------------------- --}}

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.used-vehicle-parts.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Part Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Teile-Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Part Category --}}
                    <div>
                        <label for="part_category" class="block text-sm font-medium text-gray-700 mb-2">Teilekategorie</label>
                        <select name="part_category" id="part_category"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($partCategories as $category)
                                <option value="{{ $category }}" {{ old('part_category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('part_category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Part Name (e.g., "Motor", "Getriebe", "Scheinwerfer") --}}
                    <div>
                        <label for="part_name" class="block text-sm font-medium text-gray-700 mb-2">Teilebezeichnung</label>
                        <input type="text" name="part_name" id="part_name" value="{{ old('part_name') }}" placeholder="z.B. Frontstoßstange, Lichtmaschine"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('part_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Manufacturer Part Number (Optional) --}}
                    <div>
                        <label for="manufacturer_part_number" class="block text-sm font-medium text-gray-700 mb-2">Hersteller-Teilenummer (optional)</label>
                        <input type="text" name="manufacturer_part_number" id="manufacturer_part_number" value="{{ old('manufacturer_part_number') }}" placeholder="z.B. 1K0 123 456 A"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('manufacturer_part_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Condition --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="neu" {{ old('condition') == 'neu' ? 'selected' : '' }}>Neu</option>
                            <option value="gebraucht" {{ old('condition') == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                            <option value="überholt" {{ old('condition') == 'überholt' ? 'selected' : '' }}>Überholt</option>
                            <option value="defekt" {{ old('condition') == 'defekt' ? 'selected' : '' }}>Defekt (als Ersatzteilspender)</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 150"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Compatibility Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Kompatibilität (für welche Fahrzeuge passt das Teil?)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Compatible Brand --}}
                    <div>
                        <label for="compatible_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <select name="compatible_brand_id" id="compatible_brand_id"
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('compatible_brand_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('compatible_brand_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Model --}}
                    <div>
                        <label for="compatible_car_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="compatible_car_model_id" id="compatible_car_model_id"
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($models as $id => $name)
                                <option value="{{ $id }}" {{ old('compatible_car_model_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('compatible_car_model_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Year From --}}
                    <div>
                        <label for="compatible_year_from" class="block text-sm font-medium text-gray-700 mb-2">Baujahr von (optional)</label>
                        <input type="number" name="compatible_year_from" id="compatible_year_from" value="{{ old('compatible_year_from') }}" placeholder="z.B. 2005" min="1900" max="{{ date('Y') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_year_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Year To --}}
                    <div>
                        <label for="compatible_year_to" class="block text-sm font-medium text-gray-700 mb-2">Baujahr bis (optional)</label>
                        <input type="number" name="compatible_year_to" id="compatible_year_to" value="{{ old('compatible_year_to') }}" placeholder="z.B. 2012" min="1900" max="{{ date('Y') + 1 }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_year_to')
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
                           placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. Scheinwerfer für Golf 7)"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="Gib hier alle wichtigen Details zu deinem Fahrzeugteil ein. Zustand, Gebrauchsspuren, Besonderheiten."
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

          {{-- Photo Upload Section (with Alpine.js for previews) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                <div x-data="multiImageUploader()" class="space-y-4">
                    <input type="file" name="images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
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

                    // Define the Alpine.js component for the motorcycle form
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('motorcycleAdForm', (initialBrandId, initialModelId, initialModels) => ({
                            selectedMotorcycleBrandId: initialBrandId || '',
                            selectedMotorcycleModelId: initialModelId || '',
                            motorcycleModels: initialModels || {}, // Ensure it's an object, not null

                            // Define the async function first, so it's available when init() calls it
                            async fetchMotorcycleModels() {
                                console.log('fetchMotorcycleModels triggered. Current selectedBrandId (before fetch):', this.selectedMotorcycleBrandId);

                                // The fix for the AJAX URL should be `/api/motorcycle-models/...`
                                // Double-check your routes/api.php and the previous conversation for the correct URL prefix.
                                // If you moved it to web.php and removed the /api prefix, then it should match that.
                                // For consistency, it's generally better to use /api for such endpoints.
                                const fetchUrl = `/api/motorcycle-models/${this.selectedMotorcycleBrandId}`; // Assuming API route is /api/motorcycle-models
                                console.log('Attempting to fetch models from URL:', fetchUrl);
                                try {
                                    const response = await fetch(fetchUrl);
                                    if (!response.ok) {
                                        console.error('HTTP error! Status:', response.status, 'Response text:', await response.text());
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    const data = await response.json();
                                    console.log('Models fetched successfully:', data);
                                    this.motorcycleModels = data;

                                    // If the previously selected model is not in the new list, clear it
                                    if (this.selectedMotorcycleModelId && !Object.keys(this.motorcycleModels).includes(String(this.selectedMotorcycleModelId))) {
                                        this.selectedMotorcycleModelId = '';
                                        console.log('Cleared selectedMotorcycleModelId as it was not in the new list.');
                                    }
                                } catch (error) {
                                    console.error('Error fetching motorcycle models:', error);
                                    this.motorcycleModels = {}; // Clear models on error
                                    this.selectedMotorcycleModelId = ''; // Clear selected model on error
                                }
                            },

                            // The init method for the component
                            init() {
                                // Call fetch on init to handle cases where old('brand_id') exists on page load
                                // Use $nextTick to ensure all component properties are fully initialized
                                this.$nextTick(() => {
                                    this.fetchMotorcycleModels();
                                });

                                // Watch for changes on the brand select element's x-model bound variable
                                this.$watch('selectedMotorcycleBrandId', (value) => {
                                    console.log('selectedMotorcycleBrandId changed to (via $watch):', value);
                                    this.fetchMotorcycleModels();
                                });
                            },
                        }));
                    });
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
