{{-- resources/views/ads/motorrad/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Motorrad Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Motorrad Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Motorrad Anzeigen', 'url' => route('categories.show', 'motorrad')],
                ['label' => $motorradAd->title, 'url' => route('ads.motorrad.show', $motorradAd)],
                ['label' => 'Bearbeiten', 'url' => null],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.motorrad.update', $motorradAd) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Vehicle Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                     x-data="{
                        selectedMotorcycleBrandId: @json(old('motorcycle_brand_id', $motorradAd->motorcycle_brand_id)), // Changed Alpine.js variable name
                        selectedMotorcycleModelId: @json(old('motorcycle_model_id', $motorradAd->motorcycle_model_id)), // Changed Alpine.js variable name
                        motorcycleModels: @json($initialModels), // Pass initial models from controller

                        async fetchMotorcycleModels() { // Changed function name for clarity
                            if (this.selectedMotorcycleBrandId) {
                                try {
                                    const response = await fetch(`/motorcycle-models/${this.selectedMotorcycleBrandId}`);
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    this.motorcycleModels = await response.json();
                                    // If the previously selected model is not in the new list, clear it
                                    if (!Object.keys(this.motorcycleModels).includes(String(this.selectedMotorcycleModelId))) {
                                        this.selectedMotorcycleModelId = '';
                                    }
                                } catch (error) {
                                    console.error('Error fetching motorcycle models:', error);
                                    this.motorcycleModels = {};
                                    this.selectedMotorcycleModelId = '';
                                }
                            } else {
                                this.motorcycleModels = {};
                                this.selectedMotorcycleModelId = '';
                            }
                        }
                    }"
                     x-init="fetchMotorcycleModels(); $watch('selectedMotorcycleBrandId', fetchMotorcycleModels)">

                    {{-- Marke --}}
                    <div>
                        <label for="motorcycle_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <select name="motorcycle_brand_id" id="motorcycle_brand_id" x-model="selectedMotorcycleBrandId" {{-- Changed name and x-model --}}
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('motorcycle_brand_id', $motorradAd->motorcycle_brand_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('motorcycle_brand_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modell (Dynamic with Alpine.js) --}}
                    <div x-show="Object.keys(motorcycleModels).length > 0" x-transition>
                        <label for="motorcycle_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="motorcycle_model_id" id="motorcycle_model_id" x-model="selectedMotorcycleModelId" {{-- Changed name and x-model --}}
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <template x-for="(name, id) in motorcycleModels" :key="id">
                                <option :value="id" x-text="name"></option>
                            </template>
                        </select>
                        @error('motorcycle_model_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Basic Data Section (Erstzulassung, Kilometerstand, Leistung) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Erstzulassung --}}
                    <div>
                        <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung</label>
                        <input type="date" name="first_registration" id="first_registration" value="{{ old('first_registration', $motorradAd->first_registration ? \Carbon\Carbon::parse($motorradAd->first_registration)->format('Y-m-d') : '') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('first_registration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand (in km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $motorradAd->mileage) }}" placeholder="z.B. 50.000"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Leistung (PS) --}}
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power', $motorradAd->power) }}" placeholder="z.B. 150"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power')
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
                                <option value="{{ $color }}" {{ old('color', $motorradAd->color) == $color ? 'selected' : '' }}>{{ $color }}</option>
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
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ old('condition', $motorradAd->condition) == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                            @endforeach
                        </select>
                        @error('condition')
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
                    <input type="text" name="title" id="title" value="{{ old('title', $motorradAd->title) }}"
                           placeholder="Aussagekräftiger Titel für deine Anzeige"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                               placeholder="Gib hier alle wichtigen Details zu deinem Motorrad ein. Je mehr Informationen, desto besser!"
                               class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $motorradAd->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Photo Upload Section (with Alpine.js for previews) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                <div x-data="multiImageUploader(@json($motorradAd->images->map(fn($image) => ['id' => $image->id, 'path' => asset('storage/' . $image->image_path)])))" class="space-y-4">
                    {{-- Existing images --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <template x-for="(image, index) in existingPreviews" :key="image.id">
                            <div class="relative group">
                                <img :src="image.path" class="w-full h-32 object-cover rounded shadow">
                                <input type="hidden" :name="'existing_images[]'" :value="image.id">
                                <button type="button" @click="removeExisting(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>

                    {{-- New image input --}}
                    <input type="file" name="images[]" multiple @change="addNewFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Previews for newly added images --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <template x-for="(image, index) in newPreviews" :key="index">
                            <div class="relative group">
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="removeNew(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews (Modified for Edit) --}}
                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            existingPreviews: initialImages, // For images already saved
                            newFiles: [], // Stores new File objects
                            newPreviews: [], // Stores URLs for new image previews

                            addNewFiles(event) {
                                const files = Array.from(event.target.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newPreviews.push(URL.createObjectURL(file));
                                });

                                // Update the actual file input's files property for submission
                                const dataTransfer = new DataTransfer();
                                this.newFiles.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;
                            },

                            removeExisting(index) {
                                // Remove from existing previews
                                this.existingPreviews.splice(index, 1);
                                // The hidden input for this image will automatically be removed from the DOM
                                // and thus not sent with the form, signaling its deletion.
                            },

                            removeNew(index) {
                                URL.revokeObjectURL(this.newPreviews[index]); // Revoke URL for new image
                                this.newFiles.splice(index, 1);
                                this.newPreviews.splice(index, 1);

                                // Update the new file input's files property
                                const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                if (fileInput) {
                                    const dataTransfer = new DataTransfer();
                                    this.newFiles.forEach(file => dataTransfer.items.add(file));
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
