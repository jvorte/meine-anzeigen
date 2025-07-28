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
                ['label' => 'Meine Anzeigen', 'url' => route('dashboard')], {{-- Adjust as needed for your "my ads" page --}}
                ['label' => 'Wohnmobil Anzeige bearbeiten', 'url' => route('ads.camper.edit', $camper)],
            ]" />
        </div>
    </div>
    {{-- --------------------------------------------------------------------------------- --}}
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        {{-- Use PUT method for update, and enctype for file uploads --}}
        <form method="POST" action="{{ route('ads.camper.update', $camper->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- This is crucial for update operations --}}

            {{-- Vehicle Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Marke (Text Input) --}}
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $camper->brand) }}"
                                placeholder="z.B. Bavaria, Jeanneau"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('brand')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Modell (Text Input) --}}
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                            <input type="text" name="model" id="model" value="{{ old('model', $camper->model) }}"
                                placeholder="z.B. 37 Cruiser"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('model')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
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

                    {{-- Erstzulassung --}}
                    <div>
                        <label for="first_registration"
                            class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung</label>
                        <input type="date" name="first_registration" id="first_registration"
                            value="{{ old('first_registration', $camper->first_registration) }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
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
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="neu" {{ old('condition', $camper->condition) == 'neu' ? 'selected' : '' }}>Neu</option>
                            <option value="gebraucht" {{ old('condition', $camper->condition) == 'gebraucht' ? 'selected' : '' }}>Gebraucht
                            </option>
                            <option value="unfallfahrzeug" {{ old('condition', $camper->condition) == 'unfallfahrzeug' ? 'selected' : '' }}>
                                Unfallfahrzeug</option>
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
                                    {{ $trans }}</option>
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
                                    {{ $class }}</option>
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


            {{-- Verkäufer (Seller) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-6">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Verkäufer Informationen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="seller_name" class="block text-sm font-medium text-gray-700 mb-2">Name des
                            Verkäufers</label>
                        <input type="text" name="seller_name" id="seller_name" value="{{ old('seller_name', $camper->seller_name) }}"
                            placeholder="Max Mustermann" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('seller_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="seller_phone"
                            class="block text-sm font-medium text-gray-700 mb-2">Telefonnummer</label>
                        <input type="text" name="seller_phone" id="seller_phone" value="{{ old('seller_phone', $camper->seller_phone) }}"
                            placeholder="+49 123 4567890" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('seller_phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="seller_email" class="block text-sm font-medium text-gray-700 mb-2">E-Mail
                            Adresse</label>
                        <input type="email" name="seller_email" id="seller_email" value="{{ old('seller_email', $camper->seller_email) }}"
                            placeholder="max@example.com" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('seller_email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
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