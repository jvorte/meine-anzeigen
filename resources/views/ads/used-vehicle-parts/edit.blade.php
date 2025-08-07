{{-- resources/views/ads/used-vehicle-parts/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Anzeige Bearbeiten: {{ $usedVehiclePart->title }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Passe die Details deiner Anzeige an und speichere deine Änderungen.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                ['label' => 'Gebrauchte Fahrzeugteile', 'url' => route('categories.vehicles-parts.index')],
                ['label' => $usedVehiclePart->title, 'url' => route('ads.vehicles-parts.index', $usedVehiclePart)],
                ['label' => 'Bearbeiten', 'url' => null],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.used-vehicle-parts.update', $usedVehiclePart) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

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
                                <option value="{{ $category }}" {{ old('part_category', $usedVehiclePart->part_category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('part_category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Part Name (e.g., "Motor", "Getriebe", "Scheinwerfer") --}}
                    <div>
                        <label for="part_name" class="block text-sm font-medium text-gray-700 mb-2">Teilebezeichnung</label>
                        <input type="text" name="part_name" id="part_name" value="{{ old('part_name', $usedVehiclePart->part_name) }}" placeholder="z.B. Frontstoßstange, Lichtmaschine"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('part_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Manufacturer Part Number (Optional) --}}
                    <div>
                        <label for="manufacturer_part_number" class="block text-sm font-medium text-gray-700 mb-2">Hersteller-Teilenummer (optional)</label>
                        <input type="text" name="manufacturer_part_number" id="manufacturer_part_number" value="{{ old('manufacturer_part_number', $usedVehiclePart->manufacturer_part_number) }}" placeholder="z.B. 1K0 123 456 A"
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
                            @foreach($conditions as $conditionOption)
                                <option value="{{ $conditionOption }}" {{ old('condition', $usedVehiclePart->condition) == $conditionOption ? 'selected' : '' }}>
                                    {{ ucfirst($conditionOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $usedVehiclePart->price) }}" placeholder="z.B. 150"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Compatibility Section (Generic Vehicle Details) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Kompatibilität (Fahrzeugdetails für das Teil)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Vehicle Type --}}
                    <div>
                        <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Fahrzeugtyp</label>
                        <select name="vehicle_type" id="vehicle_type"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($vehicleTypes as $type)
                                <option value="{{ $type }}" {{ old('vehicle_type', $usedVehiclePart->vehicle_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Brand (Text Input) --}}
                    <div>
                        <label for="compatible_brand" class="block text-sm font-medium text-gray-700 mb-2">Kompatible Marke</label>
                        <input type="text" name="compatible_brand" id="compatible_brand" value="{{ old('compatible_brand', $usedVehiclePart->compatible_brand) }}" placeholder="z.B. Mercedes-Benz, BMW, Yamaha"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_brand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Model (Text Input) --}}
                    <div>
                        <label for="compatible_model" class="block text-sm font-medium text-gray-700 mb-2">Kompatibles Modell</label>
                        <input type="text" name="compatible_model" id="compatible_model" value="{{ old('compatible_model', $usedVehiclePart->compatible_model) }}" placeholder="z.B. E-Klasse, R 1250 GS, Actros"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_model')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Year From --}}
                    <div>
                        <label for="compatible_year_from" class="block text-sm font-medium text-gray-700 mb-2">Baujahr von (optional)</label>
                        <input type="number" name="compatible_year_from" id="compatible_year_from" value="{{ old('compatible_year_from', $usedVehiclePart->compatible_year_from) }}" placeholder="z.B. 2005" min="1900" max="{{ date('Y') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_year_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Year To --}}
                    <div>
                        <label for="compatible_year_to" class="block text-sm font-medium text-gray-700 mb-2">Baujahr bis (optional)</label>
                        <input type="number" name="compatible_year_to" id="compatible_year_to" value="{{ old('compatible_year_to', $usedVehiclePart->compatible_year_to) }}" placeholder="z.B. 2012" min="1900" max="{{ date('Y') + 1 }}"
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
                    <input type="text" name="title" id="title" value="{{ old('title', $usedVehiclePart->title) }}"
                           placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. Scheinwerfer für Golf 7)"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="Gib hier alle wichtigen Details zu deinem Fahrzeugteil ein. Zustand, Gebrauchsspuren, Besonderheiten."
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $usedVehiclePart->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

      
            {{-- Fotoverwaltung --}}
            <section class="bg-gray-50 p-8 rounded-xl shadow-inner border border-gray-300">
                <h4 class="text-2xl font-semibold text-gray-800 mb-8 tracking-wide border-b border-gray-300 pb-2">
                    Fotos verwalten
                </h4>
                <div x-data="multiImageUploader(
                    {{ $usedVehiclePart->images->map(fn($image) => ['id' => $image->id, 'url' => asset('storage/' . $image->image_path)])->toJson() }}
                )" class="space-y-6">

                    <label for="images" class="block text-sm font-semibold text-gray-700 mb-4">
                        Neue Fotos hinzufügen
                    </label>
                    {{-- ADD x-ref="newFilesInput" HERE --}}
                    <input type="file" name="images[]" id="images" multiple x-ref="newFilesInput" @change="addNewFiles($event)"
                        class="block w-full rounded-lg border border-gray-300 p-3 shadow-sm cursor-pointer transition focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50" />

                    @error('images')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        {{-- Bestehende Bilder --}}
                        <template x-for="(image, index) in existingImages" :key="'existing-' + image.id">
                            <div class="relative group rounded-xl overflow-hidden shadow-lg">
                                <img :src="image.url" alt="Vorhandenes Bild" class="w-full h-32 object-cover rounded-lg cursor-pointer" />
                                <button type="button" @click="removeExistingImage(index)" aria-label="Foto entfernen"
                                    class="absolute top-2 right-2 bg-red-600 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    &times;
                                </button>
                            </div>
                        </template>

                        {{-- Neue Upload Bildvorschau --}}
                        <template x-for="(image, index) in newImagePreviews" :key="'new-' + index">
                            <div class="relative group rounded-xl overflow-hidden shadow-lg">
                                <img :src="image" alt="Neue Bildvorschau" class="w-full h-32 object-cover rounded-lg cursor-pointer" />
                                <button type="button" @click="removeNewImage(index)" aria-label="Foto entfernen"
                                    class="absolute top-2 right-2 bg-red-600 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Hidden Inputs für zu löschende Bilder --}}
                    <template x-for="id in imagesToDelete" :key="'delete-' + id">
                        <input type="hidden" :name="'images_to_delete[]'" :value="id" />
                    </template>
                </div>

                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            existingImages: initialImages,
                            newFiles: [], // Array of File objects
                            newImagePreviews: [], // Array of Blob URLs
                            imagesToDelete: [], // Array of IDs

                            init() {
                                // You can add a check here to ensure Alpine is loading
                                console.log('Alpine multiImageUploader initialized.');
                                this.updateFileInput(); // Initialize the file input's files property
                            },

                            addNewFiles(event) {
                                const files = Array.from(event.target.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newImagePreviews.push(URL.createObjectURL(file));
                                });
                                event.target.value = ''; // Clear the input field's visual selection
                                this.updateFileInput(); // Update the actual FileList
                            },

                            removeExistingImage(index) {
                                if (confirm('Möchtest du dieses Bild wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.')) {
                                    this.imagesToDelete.push(this.existingImages[index].id);
                                    this.existingImages.splice(index, 1);
                                }
                            },

                            removeNewImage(index) {
                                URL.revokeObjectURL(this.newImagePreviews[index]); // Free up memory
                                this.newFiles.splice(index, 1);
                                this.newImagePreviews.splice(index, 1);
                                this.updateFileInput(); // Update the actual FileList
                            },

                            updateFileInput() {
                                const dataTransfer = new DataTransfer();
                                this.newFiles.forEach(file => dataTransfer.items.add(file));

                                // Use x-ref to directly access the input element
                                const fileInput = this.$refs.newFilesInput;

                                if (fileInput) {
                                    fileInput.files = dataTransfer.files;
                                    console.log('updateFileInput: Files assigned to input. Count:', fileInput.files.length);
                                    for (let i = 0; i < fileInput.files.length; i++) {
                                        console.log(`File[${i}]: ${fileInput.files[i].name} (${fileInput.files[i].size} bytes)`);
                                    }
                                } else {
                                    console.error('updateFileInput: x-ref="newFilesInput" element not found!');
                                }
                            }
                        }
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