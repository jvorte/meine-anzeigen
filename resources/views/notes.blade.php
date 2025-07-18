<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">
            Neue Anzeige erstellen
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Wähle eine Kategorie und fülle die passenden Felder aus.
        </p>
    </x-slot>

    <div class="py-12" x-data="{
        selectedCategory: null,
        categories: {{ $categories->toJson() }},
        get selectedCategoryName() {
            const cat = this.categories.find(c => c.slug === this.selectedCategory);
            return cat ? cat.name : '';
        }
    }">
        <div
            class="max-w-4xl mx-auto bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">

            {{-- Κατηγορίες --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6" x-show="!selectedCategory"
                x-transition.opacity.duration.300ms>
                @foreach ($categories as $category)
                    <button
                        class="flex items-center justify-center gap-3 bg-gray-100 px-4 py-6 text-black rounded shadow hover:bg-blue-100  transition font-medium"
                        @click="selectedCategory = '{{ $category->slug }}'">

                        <img src="{{ asset('storage/icons/categories/' . $category->slug . '.png') }}"
                            alt="{{ $category->name }} Icon" class="w-14 h-14 object-contain" />

                        <span class="text-gray-800 d">{{ $category->name }}</span>
                    </button>
                @endforeach

            </div>

            {{-- Δυναμική Φόρμα --}}
            <div x-show="selectedCategory" x-transition.opacity.duration.300ms>
                <form method="POST" action="{{ route('ads.store') }}" class="space-y-8 bg-white p-6 rounded-xl">
                    @csrf
                    <input type="hidden" name="category_slug" :value="selectedCategory">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 ">
                            Kategorie: <span x-text="selectedCategoryName"></span>

                        </h3>
                        <button type="button" @click="selectedCategory = null"
                            class="text-sm text-blue-600 hover:text-blue-800 underline flex items-center gap-1 transition">
                            ← Zurück zur Auswahl
                        </button>
                    </div>




                    {{-- Fahrzeuge --}}
                    <div x-show="selectedCategory === 'fahrzeuge'" x-transition>

                        {{-- Gruppe: Kategorie & Modell --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Kategorie & Modell</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block">Kategorie</label>
                                    <select name="category" class="form-input w-full">
                                        <option>Gebrauchtwagen</option>
                                        <option>Neuwagen</option>
                                        <option>Oldtimer</option>
                                    </select>
                                </div>
                                @php
                                    $brands = [
                                        'vw' => ['Golf', 'Polo', 'Passat'],
                                        'bmw' => ['3er', '5er', 'X5'],
                                        'audi' => ['A3', 'A4', 'Q5'],
                                    ];
                                @endphp

                                <div x-data="{
                                            brands: {{ json_encode($brands) }},
                                            selectedBrand: '',
                                            selectedModel: '',
                                            get models() {
                                                return this.selectedBrand ? this.brands[this.selectedBrand] : [];
                                            }
                                        }">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Marke</label>
                                        <select name="brand" x-model="selectedBrand" class="form-select w-full">
                                            <option value="">Bitte wählen</option>
                                            @foreach(array_keys($brands) as $brand)
                                                <option value="{{ $brand }}">{{ strtoupper($brand) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4" x-show="selectedBrand">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                                        <select name="model" x-model="selectedModel" class="form-select w-full">
                                            <option value="">Bitte wählen</option>
                                            <template x-for="model in models" :key="model">
                                                <option x-text="model" :value="model"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Gruppe: Basisdaten --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Basisdaten</h4>
                            <div class="grid md:grid-cols-4 gap-4">
                                <x-number-input name="price_from" label="Preis von" />
                                <x-number-input name="price_to" label="Preis bis" />
                                <x-number-input name="mileage_from" label="Kilometerstand von" />
                                <x-number-input name="mileage_to" label="Kilometerstand bis" />
                                <x-month-input name="registration_from" label="Erstzulassung von" />
                                <x-month-input name="registration_to" label="Erstzulassung bis" />
                            </div>
                        </div>

                        {{-- Gruppe: Typ & Zustand --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Typ & Zustand</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <x-select name="vehicle_type" label="Fahrzeugtyp" :options="['Cabrio', 'SUV', 'Limousine']" />
                                <x-select name="condition" label="Zustand" :options="['Gebrauchtwagen', 'Neuwagen', 'Oldtimer']" />
                                <x-select name="warranty" label="Garantie" :options="['Beliebig', 'Ja', 'Nein']" />
                            </div>
                        </div>

                        {{-- Gruppe: Motor --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Motor</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <x-number-input name="power_from" label="Leistung von (PS)" />
                                <x-number-input name="power_to" label="Leistung bis (PS)" />
                                <x-select name="fuel_type" label="Treibstoff" :options="['Benzin', 'Diesel', 'Elektro']" />
                            </div>
                        </div>

                        {{-- Gruppe: Getriebe & Antrieb --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Getriebe & Antrieb</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <x-select name="transmission" label="Getriebeart" :options="['Automatik', 'Schaltgetriebe']" />
                                <x-select name="drive" label="Antrieb" :options="['Vorderrad', 'Hinterrad', 'Allrad']" />
                            </div>
                        </div>

                        {{-- Gruppe: Ausstattung --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Ausstattung</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <x-select name="color" label="Farbe" :options="['Weiß', 'Schwarz', 'Blau']" />
                                <x-number-input name="doors_from" label="Türen von" />
                                <x-number-input name="seats_from" label="Sitze von" />
                            </div>
                        </div>

                        {{-- Gruppe: Inserent --}}
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Inserent</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <x-select name="seller_type" label="Inserent" :options="['Privat', 'Händler']" />
                                <x-select name="published_within" label="Zeitraum" :options="['Alle', '48h', '7 Tage']" />
                            </div>
                        </div>
                    </div>


                    {{-- τιτλος --}}

                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-1">Titel</label>
                        <input type="text" name="title" id="title" required
                            class="w-full p-2 border border-gray-600 rounded-md shadow-sm bg-white focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>
                    {{-- κειμενο --}}

                    {{-- Beschreibung --}}
                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-gray-800 mb-1">Beschreibung</label>
                        <textarea name="description" id="description" rows="5"
                            placeholder="Zusätzliche Informationen zum Fahrzeug..." class="w-full p-3 border border-gray-600 rounded-md shadow-sm bg-white text-gray-900
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600
               transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    </div>



                    {{-- Immobilien (σε επόμενη φάση με την ίδια λογική) --}}

                    <div class="pt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                            Anzeige erstellen
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</x-app-layout>