{{-- resources/views/commercial_vehicles/edit.blade.php --}}

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
            ['label' => 'commercial-vehicles Anzeigen', 'url' => route('categories.show', 'commercial-vehicles')],

            {{-- Link to the specific camper's show page --}}
            ['label' => 'commercial-vehicle Anzeige', 'url' => route('categories.commercial-vehicles.show', $commercialAd->id)],

            {{-- The current page (Camper Edit) - set URL to null as it's the current page --}}
            ['label' => 'commercial-vehicle bearbeiten', 'url' => null],
        ]" />
    </div>
</div>
    {{-- ------------------------------------------------------------------------------------- --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <form method="POST" action="{{ route('ads.commercial-vehicles.update', ['commercialAd' => $commercialAd->id]) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $commercialAd->title) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Preis (€)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $commercialAd->price) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="commercial_brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marke</label>
                        <select name="commercial_brand_id" id="commercial_brand_id" {{-- Changed name and id --}}
                                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Bitte wählen --</option>
                            @foreach($commercialBrands as $brand) {{-- Iterating over $commercialBrands --}}
                                <option value="{{ $brand->id }}" {{ old('commercial_brand_id', $commercialAd->commercial_brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

               <div>
                        <label for="commercial_model_id" class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                        <select name="commercial_model_id" id="commercial_model_id"
                                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Bitte wählen --</option>
                            {{-- CHANGE THIS LINE: from $commercialModels to $initialCommercialModels --}}
                            @foreach($initialCommercialModels as $model)
                                <option value="{{ $model->id }}" {{ old('commercial_model_id', $commercialAd->commercial_model_id) == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-1">Erstzulassung</label>
                        <input type="date" name="first_registration" id="first_registration" value="{{ old('first_registration', $commercialAd->first_registration) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Kilometerstand (km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $commercialAd->mileage) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power', $commercialAd->power) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Farbe</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $commercialAd->color) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Zustand</label>
                        <input type="text" name="condition" id="condition" value="{{ old('condition', $commercialAd->condition) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="commercial_vehicle_type" class="block text-sm font-medium text-gray-700 mb-1">Fahrzeugtyp</label>
                        <input type="text" name="commercial_vehicle_type" id="commercial_vehicle_type" value="{{ old('commercial_vehicle_type', $commercialAd->commercial_vehicle_type) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Kraftstoffart</label>
                        <input type="text" name="fuel_type" id="fuel_type" value="{{ old('fuel_type', $commercialAd->fuel_type) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Getriebe</label>
                        <input type="text" name="transmission" id="transmission" value="{{ old('transmission', $commercialAd->transmission) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="payload_capacity" class="block text-sm font-medium text-gray-700 mb-1">Nutzlast (kg)</label>
                        <input type="number" name="payload_capacity" id="payload_capacity" value="{{ old('payload_capacity', $commercialAd->payload_capacity) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="gross_vehicle_weight" class="block text-sm font-medium text-gray-700 mb-1">Zulässiges Gesamtgewicht (kg)</label>
                        <input type="number" name="gross_vehicle_weight" id="gross_vehicle_weight" value="{{ old('gross_vehicle_weight', $commercialAd->gross_vehicle_weight) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="number_of_axles" class="block text-sm font-medium text-gray-700 mb-1">Anzahl der Achsen</label>
                        <input type="number" name="number_of_axles" id="number_of_axles" value="{{ old('number_of_axles', $commercialAd->number_of_axles) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="emission_class" class="block text-sm font-medium text-gray-700 mb-1">Emissionsklasse</label>
                        <input type="text" name="emission_class" id="emission_class" value="{{ old('emission_class', $commercialAd->emission_class) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700 mb-1">Sitze</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats', $commercialAd->seats) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Beschreibung</label>
                    <textarea name="description" id="description" rows="6"
                              class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $commercialAd->description) }}</textarea>
                </div>


                
            {{-- Existing Photos Section --}}
            @if ($commercialAd->images->count() > 0)
                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($commercialAd->images as $image)
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




                <div class="flex justify-between items-center pt-6 border-t">
              

                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 shadow transition">
                        Aktualisieren
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
