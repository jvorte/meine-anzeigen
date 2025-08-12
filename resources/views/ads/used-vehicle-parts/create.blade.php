{{-- resources/views/ads/used-vehicle-parts/create.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
          new parts ad
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'All Ads', 'url' => route('ads.index')],
                ['label' => 'vehicles-parts', 'url' => route('categories.vehicles-parts.index')],
                ['label' => 'New Add', 'url' => null],
            ]" />
        </div>
    </div>


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
                            @foreach($conditions as $conditionOption)
                                <option value="{{ $conditionOption }}" {{ old('condition') == $conditionOption ? 'selected' : '' }}>
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
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 150"
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
                                <option value="{{ $type }}" {{ old('vehicle_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Brand (Text Input) --}}
                    <div>
                        <label for="compatible_brand" class="block text-sm font-medium text-gray-700 mb-2">Kompatible Marke</label>
                        <input type="text" name="compatible_brand" id="compatible_brand" value="{{ old('compatible_brand') }}" placeholder="z.B. Mercedes-Benz, BMW, Yamaha"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_brand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Compatible Model (Text Input) --}}
                    <div>
                        <label for="compatible_model" class="block text-sm font-medium text-gray-700 mb-2">Kompatibles Modell</label>
                        <input type="text" name="compatible_model" id="compatible_model" value="{{ old('compatible_model') }}" placeholder="z.B. E-Klasse, R 1250 GS, Actros"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('compatible_model')
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

                {{-- conatct Section --}}
    <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
        <h4 class="text-xl font-semibold text-gray-700 mb-6">Select if you want to publish your Mobile phone or email</h4>
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_phone" value="1" class="rounded border-gray-300">
                <span class="ml-2">Phone</span>
            </label>
        </div>

        <div class="mt-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_mobile_phone" value="1" class="rounded border-gray-300">
                <span class="ml-2">Mobile</span>
            </label>
        </div>


              <div class="mt-2">
            <label class="inline-flex items-center">
                <input type="checkbox" name="show_email" value="1" class="rounded border-gray-300">
                <span class="ml-2">email</span>
            </label>
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

                {{-- Alpine.js Script for Image Previews --}}
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