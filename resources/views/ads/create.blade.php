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
        },
        selectedBrandId: '',
        models: [],
        selectedModelId: '',
        async fetchModels() {
            if (!this.selectedBrandId) {
                this.models = [];
                this.selectedModelId = '';
                return;
            }
            const response = await fetch(`/models/${this.selectedBrandId}`);
            const data = await response.json();
            this.models = Object.entries(data).map(([id, name]) => ({ id, name }));
            this.selectedModelId = '';
        }
    }" x-init="$watch('selectedBrandId', () => fetchModels())">

        <div
            class="max-w-4xl mx-auto bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">

            {{-- Kategorie Auswahl --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-3" x-show="!selectedCategory"
                x-transition.opacity.duration.300ms>
                @foreach ($categories as $category)
                    <button
                        class="flex items-center justify-center gap-3 bg-gray-100 px-4 py-6 text-black rounded shadow hover:bg-blue-100 transition font-medium"
                        @click="selectedCategory = '{{ $category->slug }}'">
                        <img src="{{ asset('storage/icons/categories/' . $category->slug . '.png') }}"
                            alt="{{ $category->name }} Icon" class="w-14 h-14 object-contain" />
                        <span class="text-gray-800">{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>




           

  {{------------------------ Felder für Fahrzeuge------------------------------ --}}
                 {{-- Formular --}}
            <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data"
                class="space-y-8 bg-white p-6 rounded-xl" x-show="selectedCategory" x-transition.opacity.duration.300ms>

                @csrf
                <input type="hidden" name="category_slug" x-model="selectedCategory" />
                     {{-- Header mit Kategorie und zurück Button --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Kategorie: <span x-text="selectedCategoryName"></span>
                    </h3>
                    <button type="button" @click="selectedCategory = null"
                        class="text-sm text-blue-600 hover:text-blue-800 underline flex items-center gap-1 transition">
                        ← Zurück zur Auswahl
                    </button>
                </div>


                <div x-show="selectedCategory === 'fahrzeuge'" x-transition>
                    <input type="hidden" name="brand_id" x-model="selectedBrandId" />
                    <input type="hidden" name="car_model_id" x-model="selectedModelId" />

                    {{-- Marke --}}
                    @php
                        $brands = \App\Models\Brand::orderBy('name')->get();
                    @endphp
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Kategorie & Modell</h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marke</label>
                            <select name="brand_id" x-model="selectedBrandId" class="form-select w-full">
                                <option value="">Bitte wählen</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Modell --}}
                        <div x-show="models.length" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                            <select name="car_model_id" x-model="selectedModelId" class="form-select w-full">
                                <option value="">Bitte wählen</option>
                                <template x-for="model in models" :key="model.id">
                                    <option :value="model.id" x-text="model.name"></option>
                                </template>
                            </select>
                        </div>
                    </div>



                    {{-- Basisdaten --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Basisdaten</h4>
                        <div class="grid md:grid-cols-4 gap-4">
                            <x-number-input name="price_from" label="Preis" />
                            <x-number-input name="mileage_from" label="Kilometerstand" />
                            <x-month-input name="registration_to" label="Erstzulassung" />
                        </div>
                    </div>

                    {{-- Typ & Zustand --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Typ & Zustand</h4>
                        <div class="grid md:grid-cols-3 gap-4">
                            <x-select name="vehicle_type" label="Fahrzeugtyp" :options="['Cabrio', 'SUV', 'Limousine', 'Coupe', 'Kleinbus', 'Family Van']" />
                            <x-select name="condition" label="Zustand" :options="['Gebrauchtwagen', 'Neuwagen', 'Oldtimer']" />
                            <x-select name="warranty" label="Garantie" :options="['Beliebig', 'Ja', 'Nein']" />
                        </div>
                    </div>

                    {{-- Motor --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Motor</h4>
                        <div class="grid md:grid-cols-3 gap-4">
                            <x-number-input name="power_from" label="Leistung (PS)" />
                            <x-select name="fuel_type" label="Treibstoff" :options="['Benzin', 'Diesel', 'Elektro']" />
                        </div>
                    </div>

                    {{-- Getriebe & Antrieb --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Getriebe & Antrieb</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <x-select name="transmission" label="Getriebeart" :options="['Automatik', 'Schaltgetriebe']" />
                            <x-select name="drive" label="Antrieb" :options="['Vorderrad', 'Hinterrad', 'Allrad']" />
                        </div>
                    </div>

                    {{-- Ausstattung --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Ausstattung</h4>
                        <div class="grid md:grid-cols-3 gap-4">
                            <x-select name="color" label="Farbe" :options="['Weiß', 'Schwarz', 'Blau']" />
                            <x-number-input name="doors_from" label="Türen" />
                            <x-number-input name="seats_from" label="Sitze" />
                        </div>
                    </div>

                    {{-- Inserent --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Inserent</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <x-select name="seller_type" label="Inserent" :options="['Privat', 'Händler']" />
                        </div>
                    </div>
                    {{-- required --}}
                    {{-- Titel --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-1">Titel</label>
                        <input type="text" name="title" id="title"
                            class="w-full p-2 border border-gray-600 rounded-md shadow-sm bg-white focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50" />
                    </div>

                    {{-- Beschreibung --}}
                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-gray-800 mb-1">Beschreibung</label>
                        <textarea name="description" id="description" rows="5"
                            placeholder="Zusätzliche Informationen zum Fahrzeug..."
                            class="w-full p-3 border border-gray-600 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    </div>

                    {{-- Fotos --}}
                    <div class="border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-600 mb-4">Fotos</h4>
                        <div x-data="imageUploader()" class="space-y-2">
                            <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                                class="w-full text-sm text-gray-600" />
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2" x-show="previews.length">
                                <template x-for="(src, index) in previews" :key="index">
                                    <div class="relative">
                                        <img :src="src" class="w-full h-32 object-cover rounded-md shadow" />
                                        <button type="button" @click="remove(index)"
                                            class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full px-2 shadow">✕</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="pt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                        Anzeige erstellen
                    </button>
                </div>
        

            {{-- ===========================end===fahrzeuge==================================== --}}



            {{-- ==============================fahrzeugeteile==================================== --}}
            <div x-show="selectedCategory === 'fahrzeugeteile'" x-transition>
                {{-- τιτλος --}}
                @php
                    $brands = \App\Models\Brand::orderBy('name')->get();
                @endphp
                <div class="border-t pt-6">
                    <h4 class="text-md font-semibold text-gray-600 mb-4">Kategorie & Modell</h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Marke</label>
                        <select name="brand_id" x-model="selectedBrandId" class="form-select w-full">
                            <option value="">Bitte wählen</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Modell --}}
                    <div x-show="models.length" class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                        <select name="car_model_id" x-model="selectedModelId" class="form-select w-full">
                            <option value="">Bitte wählen</option>
                            <template x-for="model in models" :key="model.id">
                                <option :value="model.id" x-text="model.name"></option>
                            </template>
                        </select>
                    </div>
                </div>


                {{-- Gruppe: Basisdaten --}}
                <div class="border-t pt-6">
                    <h4 class="text-md font-semibold text-gray-600 mb-4">Basisdaten</h4>
                    <div class="grid md:grid-cols-4 gap-4">
                        <x-number-input name="price_from" label="Preis" />

                        <x-month-input name="registration_to" label="Jahre" />
                    </div>
                </div>
       

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-1">Titel</label>
                    <input type="text" name="title" id="title" required
                        class="w-full p-2 border border-gray-600 rounded-md shadow-sm bg-white focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                {{-- κειμενο --}}

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Beschreibung</label>
                    <textarea name="description" id="description" rows="5"
                        placeholder="Zusätzliche Informationen zum Fahrzeug..." class="w-full p-3 border border-gray-600 rounded-md shadow-sm bg-white text-gray-900
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600
               transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                </div>

                {{-- Gruppe: Fotos --}}
                <div class="border-t pt-6">
                    <h4 class="text-md font-semibold text-gray-600 mb-4">Fotos</h4>

                    <div x-data="imageUploader()" class="space-y-2">
                        <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                            class="w-full text-sm text-gray-600">

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2" x-show="previews.length">
                            <template x-for="(src, index) in previews" :key="index">
                                <div class="relative">
                                    <img :src="src" class="w-full h-32 object-cover rounded-md shadow">
                                    <button type="button" @click="remove(index)"
                                        class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full px-2 shadow">
                                        ✕
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                       <div class="pt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                    Anzeige erstellen
                </button>
            </div>
            </div>
     

            {{-- ==========================end fahrzeugeteile======================================= --}}


            {{-- ================================elektronik================================= --}}
            <div x-show="selectedCategory === 'elektronik'" x-transition>
            </div>
            {{-- =========================end elektronik======================================== --}}


            {{-- =============================haushalt==================================== --}}
            <div x-show="selectedCategory === 'haushalt'" x-transition>
            </div>
            {{-- ==========================end =haushalt====================================== --}}


            {{-- ==============================immobilien=================================== --}}
            <div x-show="selectedCategory === 'immobilien'" x-transition class="space-y-6">
            </div>
            {{-- ============================end immobilien===================================== --}}


            {{-- ==========================dienstleistungen======================================= --}}
            <div x-show="selectedCategory === 'dienstleistungen'" x-transition class="space-y-6">
            </div>

            {{-- =====================end dienstleistungen======================================== --}}

        </div>
    </div>



    <script>
        function imageUploader() {
            return {
                previews: [],
                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    this.previews = [];

                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = e => this.previews.push(e.target.result);
                        reader.readAsDataURL(file);
                    });
                },
                remove(index) {
                    this.previews.splice(index, 1);
                    // Optionally clear from file input too, depending on setup
                }
            };
        }
    </script>



</x-app-layout>