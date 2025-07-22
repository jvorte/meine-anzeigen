{{-- resources/views/ads/nutzfahrzeug/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Neue Nutzfahrzeug Anzeige</h2>
        <p class="text-sm text-gray-500">Fülle das Formular aus, um dein Nutzfahrzeug anzubieten.</p>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <form method="POST" action="{{ route('ads.nutzfahrzeug.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf

            {{-- Bilder hochladen mit preview --}}
            <div x-data="imageUploader()" class="space-y-2">
                <label for="images" class="block text-sm font-medium text-gray-700">Bilder hochladen</label>
                <input
                    type="file"
                    id="images"
                    name="images[]"
                    multiple
                    accept="image/*"
                    @change="handleFiles"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                @error('images')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <template x-if="previews.length > 0">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 mt-2">
                        <template x-for="(src, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="src" class="w-full h-24 object-cover rounded-md border border-gray-200 shadow-sm" />
                                <button
                                    type="button"
                                    @click="remove(index)"
                                    class="absolute top-1 right-1 bg-white text-red-600 rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                    aria-label="Bild entfernen"
                                >
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Titel --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titel</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Beschreibung --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Beschreibung</label>
                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Grid πεδίων --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Marke --}}
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700">Marke</label>
                    <select
                        name="brand_id"
                        id="brand_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Bitte wählen</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Modell --}}
                <div>
                    <label for="car_model_id" class="block text-sm font-medium text-gray-700">Modell</label>
                    <select
                        name="car_model_id"
                        id="car_model_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Bitte wählen</option>
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}" @selected(old('car_model_id') == $model->id)>{{ $model->name }}</option>
                        @endforeach
                    </select>
                    @error('car_model_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preis --}}
                <div>
                    <label for="price_from" class="block text-sm font-medium text-gray-700">Preis (€)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="price_from"
                        id="price_from"
                        value="{{ old('price_from') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                    @error('price_from')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kilometerstand --}}
                <div>
                    <label for="mileage_from" class="block text-sm font-medium text-gray-700">Kilometerstand</label>
                    <input
                        type="number"
                        name="mileage_from"
                        id="mileage_from"
                        value="{{ old('mileage_from') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                    @error('mileage_from')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Erstzulassung --}}
                <div>
                    <label for="registration_to" class="block text-sm font-medium text-gray-700">Erstzulassung (MM/JJJJ)</label>
                    <input
                        type="month"
                        name="registration_to"
                        id="registration_to"
                        value="{{ old('registration_to') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    />
                    @error('registration_to')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fahrzeugtyp --}}
                <div>
                    <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Fahrzeugtyp</label>
                    <select
                        name="vehicle_type"
                        id="vehicle_type"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Bitte wählen</option>
                        @foreach ($vehicleTypes as $type)
                            <option value="{{ $type }}" @selected(old('vehicle_type') == $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('vehicle_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kraftstoff --}}
                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700">Kraftstoff</label>
                    <select
                        name="fuel_type"
                        id="fuel_type"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Bitte wählen</option>
                        @foreach ($fuelTypes as $fuel)
                            <option value="{{ $fuel }}" @selected(old('fuel_type') == $fuel)>{{ $fuel }}</option>
                        @endforeach
                    </select>
                    @error('fuel_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Getriebe --}}
                <div>
                    <label for="transmission" class="block text-sm font-medium text-gray-700">Getriebe</label>
                    <select
                        name="transmission"
                        id="transmission"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Bitte wählen</option>
                        @foreach ($transmissions as $transmission)
                            <option value="{{ $transmission }}" @selected(old('transmission') == $transmission)>{{ $transmission }}</option>
                        @endforeach
                    </select>
                    @error('transmission')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Submit Button --}}
            <div class="pt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md shadow-md transition-colors duration-300">
                    Anzeige erstellen
                </button>
            </div>
        </form>
    </div>

    <script>
        function imageUploader() {
            return {
                previews: [],
                files: [],
                handleFiles(event) {
                    this.previews = [];
                    this.files = Array.from(event.target.files);
                    for (let file of this.files) {
                        let reader = new FileReader();
                        reader.onload = e => {
                            this.previews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                },
                remove(index) {
                    this.files.splice(index, 1);
                    this.previews.splice(index, 1);
                    // Προαιρετικά: Ενημέρωσε το input αν θέλεις να αφαιρέσεις το αρχείο από το πραγματικό input
                }
            }
        }
    </script>
</x-app-layout>
