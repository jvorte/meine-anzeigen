{{-- resources/views/ads/used-vehicle-parts/create.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Gebrauchte Fahrzeugteile Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Cars Anzeigen', 'url' => route('categories.show', 'cars')],
                ['label' => 'Neue Auto Anzeige', 'url' => null],
            ]" />
        </div>
    </div>

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
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
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
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner"> {{-- Added section for consistency --}}
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Kompatibilität (Fahrzeugdetails für das Teil)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    x-data="carAdForm(
                        @json(old('car_brand_id')),
                        @json(old('car_model_id')),
                        @json($initialModels ?? [])
                    )">
                    {{-- Marke --}}
                    <div>
                        <label for="car_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <select name="car_brand_id" id="car_brand_id" x-model="selectedCarBrandId"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('car_brand_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modell (Dynamic with Alpine.js) --}}
                    <div x-show="Object.keys(carModels).length > 0" x-transition x-cloak>
                        <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="car_model_id" id="car_model_id" x-model="selectedCarModelId"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <template x-for="(name, id) in carModels" :key="id">
                                <option :value="id" x-text="name"></option>
                            </template>
                        </select>
                        @error('car_model_id')
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

                    // Define the Alpine.js component for the car form
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('carAdForm', (initialBrandId, initialModelId, initialModels) => ({
                            selectedCarBrandId: initialBrandId || '',
                            selectedCarModelId: initialModelId || '',
                            carModels: initialModels || {},

                            async fetchCarModels() {
                                if (this.selectedCarBrandId) {
                                    const fetchUrl = `/car-models/${this.selectedCarBrandId}`;
                                    try {
                                        const response = await fetch(fetchUrl);
                                        if (!response.ok) {
                                            console.error('HTTP error! Status:', response.status, 'Response text:', await response.text());
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        const data = await response.json();
                                        this.carModels = data;

                                        // If the previously selected model is not in the new list, clear it
                                        if (this.selectedCarModelId && !Object.keys(this.carModels).includes(String(this.selectedCarModelId))) {
                                            this.selectedCarModelId = '';
                                        }
                                    } catch (error) {
                                        console.error('Error fetching car models:', error);
                                        this.carModels = {}; // Clear models on error
                                        this.selectedCarModelId = ''; // Clear selected model on error
                                    }
                                } else {
                                    this.carModels = {};
                                    this.selectedCarModelId = '';
                                }
                            },

                            init() {
                                this.$nextTick(async () => {
                                    // Only fetch models on init if a brand was previously selected (e.g., after validation error)
                                    if (this.selectedCarBrandId) {
                                        await this.fetchCarModels();
                                        // After models are fetched and rendered, try to set the old model ID
                                        if (initialModelId && Object.keys(this.carModels).includes(String(initialModelId))) {
                                            this.selectedCarModelId = initialModelId;
                                        } else if (initialModelId) {
                                            this.selectedCarModelId = ''; // Clear if old model isn't valid for the brand
                                        }
                                    } else {
                                        // If no brand is selected initially, ensure models are empty and hidden
                                        this.carModels = {};
                                        this.selectedCarModelId = '';
                                    }
                                });

                                this.$watch('selectedCarBrandId', (value) => {
                                    this.selectedCarModelId = ''; // Always clear model when brand changes
                                    this.fetchCarModels();
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