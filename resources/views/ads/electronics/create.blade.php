<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Electronics Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Electronics Anzeigen', 'url' => route('categories.electronics.index')],
                ['label' => 'Neue Electronic Anzeige', 'url' => null],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.electronics.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Electronic Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Electronics-Details</h4>
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
     x-data="{
        selectedBrandId: @json(old('brand_id')),
        selectedElectronicModelId: @json(old('electronic_model_id')),
        electronicModels: @json($initialElectronicModels),
        selectedCategory: @json(old('category')),

        // Mapping categories to their required fields
        categoryFields: {
            'Mobile Phone': ['color', 'usage_time', 'operating_system', 'storage_capacity', 'processor', 'ram'],
            'TV': ['screen_size', 'usage_time'],
            // Add other categories and their specific fields here
        },

        shouldShowField(field) {
            if (!this.selectedCategory) return false;
            const category = this.selectedCategory.replace(/\s+/g, ' ').trim();
            return this.categoryFields[category] && this.categoryFields[category].includes(field);
        },

        async fetchElectronicModels() {
            if (this.selectedBrandId) {
                const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                this.electronicModels = await response.json();
                if (!Object.keys(this.electronicModels).includes(String(this.selectedElectronicModelId))) {
                    this.selectedElectronicModelId = '';
                }
            } else {
                this.electronicModels = {};
                this.selectedElectronicModelId = '';
            }
        }
    }"
    x-init="fetchElectronicModels(); $watch('selectedBrandId', fetchElectronicModels)">


                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
                        <select name="category" id="category" x-model="selectedCategory"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Brand (Dropdown) --}}
                  <div>
        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
        <select name="brand_id" id="brand_id" x-model="selectedBrandId"
                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            <option value="">Bitte wählen</option>
            {{-- Loop through $electronicBrands now --}}
            @foreach($electronicBrands as $electronicBrand)
                <option value="{{ $electronicBrand->id }}" {{ old('brand_id') == $electronicBrand->id ? 'selected' : '' }}>{{ $electronicBrand->name }}</option>
            @endforeach
        </select>
        @error('brand_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

                    {{-- Electronic Model (Dynamic with Alpine.js) --}}
                    <div x-show="Object.keys(electronicModels).length > 0" x-transition>
                        <label for="electronic_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="electronic_model_id" id="electronic_model_id" x-model="selectedElectronicModelId"
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <template x-for="(name, id) in electronicModels" :key="id">
                                <option :value="id" x-text="name"></option>
                            </template>
                        </select>
                        @error('electronic_model_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 750"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
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
                            <option value="defekt" {{ old('condition') == 'defekt' ? 'selected' : '' }}>Defekt (als Ersatzteilspender)</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Year of Purchase --}}
                    <div>
                        <label for="year_of_purchase" class="block text-sm font-medium text-gray-700 mb-2">Kaufjahr (optional)</label>
                        <input type="number" name="year_of_purchase" id="year_of_purchase" value="{{ old('year_of_purchase') }}" placeholder="z.B. 2023" min="1950" max="{{ date('Y') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('year_of_purchase')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Warranty Status --}}
                    <div>
                        <label for="warranty_status" class="block text-sm font-medium text-gray-700 mb-2">Garantie-Status</label>
                        <select name="warranty_status" id="warranty_status"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($warrantyStatuses as $status)
                                <option value="{{ $status }}" {{ old('warranty_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('warranty_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Specific fields that show based on category selection --}}

                    <div x-show="shouldShowField('color')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe (optional)</label>
                        <input type="text" name="color" id="color" value="{{ old('color') }}" placeholder="z.B. Schwarz"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('usage_time')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="usage_time" class="block text-sm font-medium text-gray-700 mb-2">Nutzungszeit (optional)</label>
                        <input type="text" name="usage_time" id="usage_time" value="{{ old('usage_time') }}" placeholder="z.B. 1 Jahr"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('usage_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('power')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Leistung (optional)</label>
                        <input type="text" name="power" id="power" value="{{ old('power') }}" placeholder="z.B. 60W"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('operating_system')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="operating_system" class="block text-sm font-medium text-gray-700 mb-2">Betriebssystem (optional)</label>
                        <input type="text" name="operating_system" id="operating_system" value="{{ old('operating_system') }}" placeholder="z.B. iOS 17"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('operating_system')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('storage_capacity')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="storage_capacity" class="block text-sm font-medium text-gray-700 mb-2">Speicherkapazität (optional)</label>
                        <input type="text" name="storage_capacity" id="storage_capacity" value="{{ old('storage_capacity') }}" placeholder="z.B. 256GB"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('storage_capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('screen_size')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="screen_size" class="block text-sm font-medium text-gray-700 mb-2">Bildschirmgröße (optional)</label>
                        <input type="text" name="screen_size" id="screen_size" value="{{ old('screen_size') }}" placeholder="z.B. 6.7 Zoll"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('screen_size')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('processor')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="processor" class="block text-sm font-medium text-gray-700 mb-2">Prozessor (optional)</label>
                        <input type="text" name="processor" id="processor" value="{{ old('processor') }}" placeholder="z.B. Apple A17 Bionic"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('processor')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="shouldShowField('ram')" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
                        <label for="ram" class="block text-sm font-medium text-gray-700 mb-2">RAM (optional)</label>
                        <input type="text" name="ram" id="ram" value="{{ old('ram') }}" placeholder="z.B. 8GB"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('ram')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Accessories (always visible) --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="accessories" class="block text-sm font-medium text-gray-700 mb-2">Zubehör (optional, z.B. Ladekabel, Fernbedienung)</label>
                        <textarea name="accessories" id="accessories" rows="3" placeholder="Liste hier enthaltenes Zubehör auf."
                                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('accessories') }}</textarea>
                        @error('accessories')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Title & Description Section (always visible) --}}
            <section class="bg-white p-6 rounded-lg shadow">
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                            placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. iPhone 15 Pro Max 256GB)"
                            class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                                placeholder="Gib hier alle wichtigen Details zu deinem Elektronikartikel ein. Zustand, Funktionen, Mängel."
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
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-300 transition-all duration-300 shadow-lg">
                    Anzeige erstellen
                </button>
            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('electronicForm', () => ({
                    selectedBrandId: @json(old('brand_id')),
                    selectedElectronicModelId: @json(old('electronic_model_id')),
                    electronicModels: @json($initialElectronicModels),
                    // This `selectedCategory` here is for the Alpine data scope,
                    // but the main `selectedCategory` controlling the form is in the x-data of the grid div
                    // We can remove this if not strictly needed here for other Alpine logic.

                    async fetchElectronicModels() {
                        if (this.selectedBrandId) {
                            try {
                                const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                this.electronicModels = await response.json();
                                if (!Object.keys(this.electronicModels).includes(String(this.selectedElectronicModelId))) {
                                    this.selectedElectronicModelId = '';
                                }
                            } catch (error) {
                                console.error('Error fetching electronic models:', error);
                                this.electronicModels = {};
                                this.selectedElectronicModelId = '';
                            }
                        } else {
                            this.electronicModels = {};
                            this.selectedElectronicModelId = '';
                        }
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>