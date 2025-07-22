<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Fahrzeuge Anzeige erstellen</h2>
    </x-slot>

   <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">


        <form method="POST" action="{{ route('ads.fahrzeuge.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

                <div class="space-y-8">
                                <input type="hidden" name="brand_id" :value="selectedBrandId" />
                                <input type="hidden" name="car_model_id" :value="selectedModelId" />

                                @php
                                    $brands = \App\Models\Brand::orderBy('name')->get();
                                @endphp

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="brand_id"
                                                class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                                            <select id="brand_id" name="brand_id" x-model="selectedBrandId"
                                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                                <option value="">Bitte wählen</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div x-show="models.length" x-transition>
                                            <label for="car_model_id"
                                                class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                                            <select id="car_model_id" name="car_model_id" x-model="selectedModelId"
                                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                                <option value="">Bitte wählen</option>
                                                <template x-for="model in models" :key="model.id">
                                                    <option :value="model.id" x-text="model.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <x-number-input name="price_from" label="Preis (in €)"
                                            placeholder="z.B. 15.000" />
                                        <x-number-input name="mileage_from" label="Kilometerstand (in km)"
                                            placeholder="z.B. 50.000" />
                                        <x-month-input name="registration_to" label="Erstzulassung" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Typ & Zustand</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <x-select name="vehicle_type" label="Fahrzeugtyp" :options="['Cabrio', 'SUV', 'Limousine', 'Coupe', 'Kleinbus', 'Family Van']" />
                                        <x-select name="condition" label="Zustand" :options="['Gebrauchtwagen', 'Neuwagen', 'Oldtimer']" />
                                        <x-select name="warranty" label="Garantie" :options="['Beliebig', 'Ja', 'Nein']" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Motor</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-number-input name="power_from" label="Leistung (in PS)"
                                            placeholder="z.B. 150" />
                                        <x-select name="fuel_type" label="Treibstoff" :options="['Benzin', 'Diesel', 'Elektro', 'Hybrid']" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Getriebe & Antrieb</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-select name="transmission" label="Getriebeart" :options="['Automatik', 'Schaltgetriebe']" />
                                        <x-select name="drive" label="Antrieb" :options="['Vorderrad', 'Hinterrad', 'Allrad']" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <x-select name="color" label="Farbe" :options="['Weiß', 'Schwarz', 'Blau', 'Grau', 'Rot', 'Silber', 'Grün', 'Gelb', 'Braun', 'Orange', 'Violett']" />
                                        <x-number-input name="doors_from" label="Anzahl Türen" placeholder="z.B. 4" />
                                        <x-number-input name="seats_from" label="Anzahl Sitze" placeholder="z.B. 5" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Inserentendetails</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-select name="seller_type" label="Inserententyp" :options="['Privat', 'Händler']" />
                                    </div>
                                </section>

                                <section class="bg-white p-6 rounded-lg shadow">
                                    <label for="title"
                                        class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="Aussagekräftiger Titel für deine Anzeige"
                                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                        value="{{ old('title') }}" />
                                </section>

                                <section class="bg-white p-6 rounded-lg shadow">
                                    <label for="description"
                                        class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                                    <textarea name="description" id="description" rows="7"
                                        placeholder="Gib hier alle wichtigen Details zu deinem Fahrzeug ein. Je mehr Informationen, desto besser!"
                                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
                                    <div x-data="imageUploader()" class="space-y-4">
                                        <input type="file" name="images[]" multiple accept="image/*"
                                            @change="handleFiles"
                                            class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4"
                                            x-show="previews.length" x-transition>
                                            <template x-for="(src, index) in previews" :key="index">
                                                <div class="relative group">
                                                    <img :src="src"
                                                        class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                                                    <button type="button" @click="remove(index)"
                                                        class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                                        aria-label="Bild entfernen">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </section>

                                <div class="pt-6 border-t border-gray-200 flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                                        Anzeige erstellen
                                    </button>
                                </div>

                            </div>

        </form>
    </div>
</x-app-layout>
