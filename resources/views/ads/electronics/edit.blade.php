{{-- resources/views/ads/electronics/edit.blade.php --}}
<x-app-layout>

    {{-- -----------------------------------breadcrumbs ---------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Electronics Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Anzeige für {{ $electronic->title }}.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Electronics Anzeigen', 'url' => route('categories.show', 'elektronik')],
                ['label' => $electronic->title, 'url' => route('ads.show', $electronic)], {{-- Link to the ad's show page --}}
                ['label' => 'Anzeige bearbeiten', 'url' => null],
            ]" />
        </div>
    </div>
    {{-- --------------------------------------------------------------------------------- --}}

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        <form method="POST" action="{{ route('ads.electronics.update', $electronic->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Specify the PUT method for updates --}}

            {{-- Electronic Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Electronics-Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                     x-data="{
                         selectedBrandId: @json(old('brand_id', $electronic->brand_id)),
                         selectedElectronicModelId: @json(old('electronic_model_id', $electronic->electronic_model_id)),
                         electronicModels: @json($initialElectronicModels ?? []), // Initial models for old value or existing ad
                         async fetchElectronicModels() {
                             if (this.selectedBrandId) {
                                 const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                                 this.electronicModels = await response.json();
                                 // Reset selected model if it's not in the new list
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
                  @php
    $categories = ['Smartphone', 'Tablet', 'Laptop', 'Fernseher', 'Kopfhörer', 'Spielkonsole'];
@endphp

<select name="category" id="category"
        class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
    <option value="">Bitte wählen</option>
    @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ old('category', $electronic->category) == $cat ? 'selected' : '' }}>
            {{ $cat }}
        </option>
    @endforeach
</select>

                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Marke (Text Input) --}}
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $electronic->brand) }}"
                                placeholder="Samsung"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('brand')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Modell (Text Input) --}}
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                            <input type="text" name="model" id="model" value="{{ old('model', $electronic->model) }}"
                                placeholder="z.B. s24 plus"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('model')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
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
                        <input type="number" name="price" id="price" value="{{ old('price', $electronic->price) }}" placeholder="z.B. 750"
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
                            <option value="neu" {{ old('condition', $electronic->condition) == 'neu' ? 'selected' : '' }}>Neu</option>
                            <option value="gebraucht" {{ old('condition', $electronic->condition) == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                            <option value="defekt" {{ old('condition', $electronic->condition) == 'defekt' ? 'selected' : '' }}>Defekt (als Ersatzteilspender)</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Year of Purchase --}}
                    <div>
                        <label for="year_of_purchase" class="block text-sm font-medium text-gray-700 mb-2">Kaufjahr (optional)</label>
                        <input type="number" name="year_of_purchase" id="year_of_purchase" value="{{ old('year_of_purchase', $electronic->year_of_purchase) }}" placeholder="z.B. 2023" min="1950" max="{{ date('Y') }}"
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
                                <option value="{{ $status }}" {{ old('warranty_status', $electronic->warranty_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('warranty_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Accessories --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="accessories" class="block text-sm font-medium text-gray-700 mb-2">Zubehör (optional, z.B. Ladekabel, Fernbedienung)</label>
                        <textarea name="accessories" id="accessories" rows="3" placeholder="Liste hier enthaltenes Zubehör auf."
                                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('accessories', $electronic->accessories) }}</textarea>
                        @error('accessories')
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
                    <input type="text" name="title" id="title" value="{{ old('title', $electronic->title) }}"
                           placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. iPhone 15 Pro Max 256GB)"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                                placeholder="Gib hier alle wichtigen Details zu deinem Elektronikartikel ein. Zustand, Funktionen, Mängel."
                                class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $electronic->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

                     {{-- Existing Photos Section --}}
            @if ($electronic->images->count() > 0)
                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($electronic->images as $image)
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
                    Anzeige aktualisieren
                </button>
            </div>

        </form>
    </div>

    {{-- Alpine.js for dynamic models (can be removed from here if already in multiImageUploader) --}}
    @push('scripts')
        <script>
            // Ensure Alpine.js is loaded before this script runs
            document.addEventListener('alpine:init', () => {
                Alpine.data('electronicForm', () => ({
                    selectedBrandId: @json(old('brand_id', $electronic->brand_id)),
                    selectedElectronicModelId: @json(old('electronic_model_id', $electronic->electronic_model_id)),
                    electronicModels: @json($initialElectronicModels ?? []),

                    async fetchElectronicModels() {
                        if (this.selectedBrandId) {
                            try {
                                const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                this.electronicModels = await response.json();
                                // Reset selected model if it's not in the new list
                                if (!Object.keys(this.electronicModels).includes(String(this.selectedElectronicModelId))) {
                                    this.selectedElectronicModelId = '';
                                }
                            } catch (error) {
                                console.error('Error fetching electronic models:', error);
                                this.electronicModels = {}; // Clear models on error
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