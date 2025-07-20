<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Anzeige erstellen
        </h2>
        <p class="text-md text-gray-600 dark:text-gray-400">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
            </p>
    </x-slot>

    <div class="py-8 lg:py-12" x-data="{
        selectedCategory: null,
        showModal: false,
        categories: {{ $categories->toJson() }},
        selectedBrandId: '',
        models: [],
        selectedModelId: '',
        get selectedCategoryName() {
            const cat = this.categories.find(c => c.slug === this.selectedCategory);
            return cat ? cat.name : '';
        },
        async fetchModels() {
            if (!this.selectedBrandId) {
                this.models = [];
                this.selectedModelId = '';
                return;
            }
            try {
                const response = await fetch(`/models/${this.selectedBrandId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                this.models = Object.entries(data).map(([id, name]) => ({ id, name }));
                this.selectedModelId = ''; // Reset model when brand changes
            } catch (error) {
                console.error('Error fetching models:', error);
                this.models = [];
                this.selectedModelId = '';
            }
        },
        getFormAction() {
            switch (this.selectedCategory) {
                case 'fahrzeuge': return '{{ route('vehicles.store') }}';
                case 'fahrzeugeteile': return '{{ route('parts.store') }}';
                case 'elektronik': return '{{ route('electronics.store') }}';
                case 'haushalt': return '{{ route('household.store') }}';
                case 'immobilien': return '{{ route('realestate.store') }}';
                case 'dienstleistungen': return '{{ route('services.store') }}';
                default: return '#';
            }
        },
        openCategory(slug) {
            this.selectedCategory = slug;
            this.showModal = true;
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        },
        closeModal() {
            this.showModal = false;
            this.selectedCategory = null;
            this.selectedBrandId = '';
            this.models = [];
            this.selectedModelId = '';
            document.body.style.overflow = ''; // Re-enable scrolling
        }
    }" x-init="$watch('selectedBrandId', () => fetchModels())">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 bg-white p-6 sm:p-8 rounded-xl shadow-2xl ring-1 ring-gray-100 dark:ring-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <button
                        class="flex flex-col items-center justify-center p-6 bg-blue-50 hover:bg-blue-100 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 group"
                        @click="openCategory('{{ $category->slug }}')"
                    >
                        <img src="{{ asset('storage/icons/categories/' . $category->slug . '.png') }}"
                            alt="{{ $category->name }} Icon" class="w-16 h-16 object-contain mb-3 group-hover:animate-bounce" />
                        <span class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">
                            {{ $category->name }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div x-show="showModal"
                class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50 overflow-y-auto"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >

                <div class="bg-white rounded-xl w-full max-w-4xl lg:max-w-5xl max-h-[95vh] overflow-y-auto p-8 relative shadow-2xl transform transition-all duration-300"
                    @click.away="closeModal()" x-trap.noscroll="showModal"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >

                    <button @click="closeModal()"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-3xl font-bold p-1 rounded-full hover:bg-gray-100 transition-colors"
                        aria-label="Modal schließen">
                        &times;
                    </button>

                    <form method="POST" :action="getFormAction()" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                            <input type="hidden" name="category_slug" x-model="selectedCategory">
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg shadow-sm">
                                <h3 class="font-bold mb-2">Fehler beim Erstellen der Anzeige:</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex items-center pb-4 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Kategorie: <span x-text="selectedCategoryName" class="text-blue-600"></span>
                                </h2>
                        </div>

                        <template x-if="selectedCategory === 'fahrzeuge'">
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
                                            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                                            <select id="brand_id" name="brand_id" x-model="selectedBrandId" class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                                <option value="">Bitte wählen</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div x-show="models.length" x-transition>
                                            <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                                            <select id="car_model_id" name="car_model_id" x-model="selectedModelId" class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
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
                                        <x-number-input name="price_from" label="Preis (in €)" placeholder="z.B. 15.000" />
                                        <x-number-input name="mileage_from" label="Kilometerstand (in km)" placeholder="z.B. 50.000" />
                                        <x-month-input name="registration_to" label="Erstzulassung" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Typ & Zustand</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <x-select name="vehicle_type" label="Fahrzeugtyp"
                                            :options="['Cabrio', 'SUV', 'Limousine', 'Coupe', 'Kleinbus', 'Family Van']" />
                                        <x-select name="condition" label="Zustand"
                                            :options="['Gebrauchtwagen', 'Neuwagen', 'Oldtimer']" />
                                        <x-select name="warranty" label="Garantie"
                                            :options="['Beliebig', 'Ja', 'Nein']" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Motor</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-number-input name="power_from" label="Leistung (in PS)" placeholder="z.B. 150" />
                                        <x-select name="fuel_type" label="Treibstoff"
                                            :options="['Benzin', 'Diesel', 'Elektro', 'Hybrid']" />
                                            </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Getriebe & Antrieb</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-select name="transmission" label="Getriebeart"
                                            :options="['Automatik', 'Schaltgetriebe']" />
                                        <x-select name="drive" label="Antrieb"
                                            :options="['Vorderrad', 'Hinterrad', 'Allrad']" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <x-select name="color" label="Farbe"
                                            :options="['Weiß', 'Schwarz', 'Blau', 'Grau', 'Rot', 'Silber', 'Grün', 'Gelb', 'Braun', 'Orange', 'Violett']" />
                                            <x-number-input name="doors_from" label="Anzahl Türen" placeholder="z.B. 4" />
                                        <x-number-input name="seats_from" label="Anzahl Sitze" placeholder="z.B. 5" />
                                    </div>
                                </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Inserentendetails</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-select name="seller_type" label="Inserententyp"
                                            :options="['Privat', 'Händler']" />
                                    </div>
                                </section>

                                <section class="bg-white p-6 rounded-lg shadow">
                                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                                    <input type="text" name="title" id="title" placeholder="Aussagekräftiger Titel für deine Anzeige"
                                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                        value="{{ old('title') }}" />
                                        </section>

                                <section class="bg-white p-6 rounded-lg shadow">
                                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                                    <textarea name="description" id="description" rows="7"
                                        placeholder="Gib hier alle wichtigen Details zu deinem Fahrzeug ein. Je mehr Informationen, desto besser!"
                                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                                        </section>

                                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
                                    <div x-data="imageUploader()" class="space-y-4">
                                        <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                                            class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                                            <template x-for="(src, index) in previews" :key="index">
                                                <div class="relative group">
                                                    <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                                                    <button type="button" @click="remove(index)"
                                                        class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                                        aria-label="Bild entfernen">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                        </template>


        {{--  für fahrzeugeteile --}}
              <template x-if="selectedCategory === 'fahrzeugeteile'">
    <div class="space-y-8">
        {{-- Hidden Inputs --}}
        <input type="hidden" name="brand_id" :value="selectedBrandId" />
        <input type="hidden" name="car_model_id" :value="selectedModelId" />

        @php
            $brands = \App\Models\Brand::orderBy('name')->get();
        @endphp

        {{-- Gruppe: Zustand & Marke & Modell --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Teile-Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Zustand --}}
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                    <select name="condition" id="condition" class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Bitte wählen</option>
                        <option value="gebraucht">Gebraucht</option>
                        <option value="neu">Neu</option>
                        <option value="neuwertig">Neuwertig</option>
                    </select>
                </div>

                {{-- Marke --}}
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                    <select name="brand_id" x-model="selectedBrandId" id="brand_id" class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Bitte wählen</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Modell --}}
                <div x-show="models.length" x-transition>
                    <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                    <select name="car_model_id" x-model="selectedModelId" id="car_model_id" class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Bitte wählen</option>
                        <template x-for="model in models" :key="model.id">
                            <option :value="model.id" x-text="model.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </section>

        {{-- Gruppe: Basisdaten --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-number-input name="price_from" label="Preis (in €)" placeholder="z.B. 250" />
                <x-month-input name="registration_to" label="Baujahr oder Alter" />
                </div>
        </section>

        {{-- Gruppe: Titel --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Anzeigentitel</h4>
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Titel</label>
                <input type="text" name="title" id="title" required placeholder="Aussagekräftiger Titel für dein Fahrzeugteil"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('title') }}" />
                    </div>
        </section>

        {{-- Gruppe: Beschreibung --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Zusätzliche Informationen</label>
                <textarea name="description" id="description" rows="7"
                    placeholder="Gib hier alle wichtigen Details zu deinem Fahrzeugteil ein. Zustand, Kompatibilität, etc."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    </div>
        </section>

        {{-- Gruppe: Fotos --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
            <div x-data="imageUploader()" class="space-y-4">
                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- Submit Button --}}
        <div class="pt-6 border-t border-gray-200 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>

    </div>
</template>



     {{-- für elektronik --}}
<template x-if="selectedCategory === 'elektronik'">
    <div class="space-y-8">
        {{-- Added hidden input for category slug for backend processing --}}
        <input type="hidden" name="category_slug" value="elektronik">

        {{-- Hidden Inputs (kept as per your provided HTML, though discussed as potentially redundant) --}}
        <input type="hidden" name="brand_id" :value="selectedBrandId" />
        <input type="hidden" name="car_model_id" :value="selectedModelId" />

        @php
            // Assuming you have a way to fetch brands relevant to electronics if 'brand_id' is used.
            // If brands from the 'Brand' model are specifically for vehicles, you might need a different
            // data source for electronics brands, or remove the brand/model logic if not applicable.
            $brands = \App\Models\Brand::orderBy('name')->get(); // This line might need adjustment based on your DB structure for electronics brands
        @endphp

        {{-- Gruppe: Produktdetails --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Produktdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Unterkategorie --}}
                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-gray-800 mb-2">Unterkategorie</label>
                    <select name="subcategory" id="subcategory"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('subcategory') }}">
                        <option value="">Bitte wählen</option>
                        <option value="smartphone" {{ old('subcategory') == 'smartphone' ? 'selected' : '' }}>Smartphone</option>
                        <option value="laptop" {{ old('subcategory') == 'laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="tablet" {{ old('subcategory') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="fernseher" {{ old('subcategory') == 'fernseher' ? 'selected' : '' }}>Fernseher</option>
                        <option value="kamera" {{ old('subcategory') == 'kamera' ? 'selected' : '' }}>Kamera</option>
                        <option value="zubehör" {{ old('subcategory') == 'zubehör' ? 'selected' : '' }}>Zubehör</option>
                        <option value="haushaltsgeraet" {{ old('subcategory') == 'haushaltsgeraet' ? 'selected' : '' }}>Haushaltsgerät</option>
                        <option value="gaming" {{ old('subcategory') == 'gaming' ? 'selected' : '' }}>Gaming-Zubehör</option>
                    </select>
                </div>

                {{-- Marke (using standard input for direct string entry) --}}
                <div>
                    <label for="brand" class="block text-sm font-semibold text-gray-800 mb-2">Marke</label>
                    <input type="text" name="brand" id="brand" placeholder="z. B. Samsung, Apple, Sony"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('brand') }}" />
                </div>
            </div>
        </section>

        {{-- Gruppe: Basisdaten --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-800 mb-2">Preis (€)</label>
                    <input type="number" name="price" id="price" step="0.01" placeholder="z. B. 499.99"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('price') }}" />
                </div>
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-800 mb-2">Zustand</label>
                    <select name="condition" id="condition"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('condition') }}">
                        <option value="">Bitte wählen</option>
                        <option value="neu" {{ old('condition') == 'neu' ? 'selected' : '' }}>Neu</option>
                        <option value="neuwertig" {{ old('condition') == 'neuwertig' ? 'selected' : '' }}>Neuwertig</option>
                        <option value="gebraucht" {{ old('condition') == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                        <option value="defekt" {{ old('condition') == 'defekt' ? 'selected' : '' }}>Defekt (Ersatzteile)</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- Gruppe: Titel --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Anzeigentitel</h4>
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Titel</label>
                <input type="text" name="title" id="title" required placeholder="z. B. Samsung Galaxy S23 Ultra neuwertig"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('title') }}" />
            </div>
        </section>

        {{-- Gruppe: Beschreibung --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Zusätzliche Informationen</label>
                <textarea name="description" id="description" rows="7"
                    placeholder="Gib hier alle wichtigen Details zu deinem Elektronikartikel ein. Zustand, Funktionen, Zubehör etc."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('description') }}</textarea>
            </div>
        </section>

        {{-- Gruppe: Fotos --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
            <div x-data="imageUploader()" class="space-y-4">
                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- Submit Button --}}
        <div class="pt-6 border-t border-gray-200 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>
    </div>
</template>




                        {{-- für haushalt  --}}
                      <template x-if="selectedCategory === 'haushalt'">
                    <div>
                        <input type="hidden" name="brand_id" :value="selectedBrandId" />
                        <input type="hidden" name="car_model_id" :value="selectedModelId" />

                        @php
                            $brands = \App\Models\Brand::orderBy('name')->get();
                        @endphp
                        <div class="border-t pt-6">
                            <h4 class="text-md font-semibold text-gray-600 mb-4">Kategorie & Modell</h4>
                            <div class="grid md:grid-cols-2 gap-4"> 
                                {{-- Unterkategorie --}}
                                <x-select name="subcategory" label="Unterkategorie"
                                    :options="[
                                        '' => 'Bitte wählen',
                                        'waschmaschine' => 'Waschmaschine',
                                        'staubsauger' => 'Staubsauger',
                                        'kühlschrank' => 'Kühlschrank',
                                        'geschirrspüler' => 'Geschirrspüler',
                                        'mikrowelle' => 'Mikrowelle',
                                        'zubehör' => 'Zubehör',
                                        'herd_backofen' => 'Herd & Backofen',
                                        'kaffeemaschine' => 'Kaffeemaschine' 
                                    ]"
                                    class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    value="{{ old('subcategory') }}" />

                            </div>
                            <div x-show="models.length" class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                                <select name="car_model_id" x-model="selectedModelId"
                                    class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Bitte wählen</option>
                                    <template x-for="model in models" :key="model.id">
                                        <option :value="model.id" x-text="model.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        {{-- Gruppe: Basisdaten (Replaced "Weitere Felder...") --}}
                        <section class="bg-white p-6 rounded-lg shadow mt-6"> {{-- Added section styling similar to electronics --}}
                            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         
                                {{-- Price (Re-added, assuming it's a common field for household items despite missing from target example) --}}
                                <x-number-input name="price" label="Preis (€)" type="number" step="0.01" placeholder="z. B. 250.00"
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                    value="{{ old('price') }}" />
                                {{-- Condition (Added, common for most listings) --}}
                                <x-select name="condition" label="Zustand"
                                    :options="[
                                        '' => 'Bitte wählen',
                                        'neu' => 'Neu',
                                        'neuwertig' => 'Neuwertig',
                                        'gebraucht' => 'Gebraucht',
                                        'defekt' => 'Defekt (Ersatzteile)'
                                    ]"
                                    class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    value="{{ old('condition') }}" />
                            </div>
                        </section>

                       

                        {{-- Beschreibung --}}
                        <section class="bg-white p-6 rounded-lg shadow mt-4"> {{-- Consistent section styling --}}
                                    {{-- Title --}}
                                <div>
                                   <h4 class="text-xl font-semibold text-gray-700 mb-4">Titel</h4>
                           {{-- Adjusted mb-2 for consistency --}}
                                    <input type="text" name="title" id="title" placeholder="z. B. Bosch Waschmaschine Serie 6"
                                        class="w-full p-3 border border-gray-300  mb-4 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" {{-- New styling --}}
                                        value="{{ old('title') }}" />
                                </div>
                            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
                            <div>
                                <label for="description"
                                    class="block text-sm font-semibold text-gray-800 mb-2">Zusätzliche Informationen</label> {{-- Adjusted mb-2 --}}
                                <textarea name="description" id="description" rows="7" {{-- Changed rows to 7 for consistency --}}
                                    placeholder="Gib hier alle wichtigen Details zu deinem Haushaltsgerät ein. Zustand, Funktionen, technische Daten etc." {{-- Updated placeholder --}}
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                                    transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                            </div>
                        </section>

                        {{-- Fotos --}}
                        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-6"> {{-- Consistent section styling --}}
                            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
                            <div x-data="imageUploader()" class="space-y-4"> {{-- Added space-y-4 for spacing --}}
                                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" /> {{-- Modern file input styling --}}
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition> {{-- Previews grid --}}
                                    <template x-for="(src, index) in previews" :key="index">
                                        <div class="relative group">
                                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                                            <button type="button" @click="remove(index)"
                                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                                aria-label="Bild entfernen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </section>

                        {{-- Submit Button --}}
                        <div class="pt-6 border-t border-gray-200 flex justify-end"> {{-- Added border-t for separation --}}
                            <button type="submit"
                                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg"> {{-- Modern button styling --}}
                                Anzeige erstellen
                            </button>
                        </div>
                    </div>
                </template>



                        {{-- Nur Beispiel für immobilien (υπάρχουν και οι άλλες κατηγορίες σε παρόμοια μορφή) --}}
                  <template x-if="selectedCategory === 'immobilien'">
    <div class="space-y-8"> {{-- Added space-y-8 for consistent section spacing --}}

        {{-- Section: Basisdaten --}}
        <section class="bg-white p-6 rounded-lg shadow"> {{-- Removed mt-6 here as it's the first section --}}
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Immobilientyp --}}
                <div>
                    <label for="immobilientyp" class="block text-sm font-semibold text-gray-800 mb-2">Immobilientyp</label>
                    <select name="immobilientyp" id="immobilientyp"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                        <option value="" disabled {{ !old('immobilientyp') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="wohnung" {{ old('immobilientyp') == 'wohnung' ? 'selected' : '' }}>Wohnung</option>
                        <option value="haus" {{ old('immobilientyp') == 'haus' ? 'selected' : '' }}>Haus</option>
                        <option value="grundstück" {{ old('immobilientyp') == 'grundstück' ? 'selected' : '' }}>Grundstück</option>
                        <option value="büro" {{ old('immobilientyp') == 'büro' ? 'selected' : '' }}>Büro</option>
                        <option value="gewerbe" {{ old('immobilientyp') == 'gewerbe' ? 'selected' : '' }}>Gewerbeobjekt</option>
                        <option value="garage" {{ old('immobilientyp') == 'garage' ? 'selected' : '' }}>Garage/Stellplatz</option>
                    </select>
                </div>

                {{-- Titel --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Titel der Anzeige</label>
                    <input type="text" name="title" id="title" placeholder="z. B. Schöne 3-Zimmer Wohnung in Graz"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('title') }}" required />
                </div>

                {{-- Objekttyp --}}
                <div>
                    <label for="objekttyp" class="block text-sm font-semibold text-gray-800 mb-2">Objekttyp</label>
                    <select name="objekttyp" id="objekttyp"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('objekttyp') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="altbau" {{ old('objekttyp') == 'altbau' ? 'selected' : '' }}>Altbau vor 1945</option>
                        <option value="neubau" {{ old('objekttyp') == 'neubau' ? 'selected' : '' }}>Neubau</option>
                    </select>
                </div>

                {{-- Zustand --}}
                <div>
                    <label for="zustand" class="block text-sm font-semibold text-gray-800 mb-2">Zustand (optional)</label>
                    <select name="zustand" id="zustand"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('zustand') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="neu" {{ old('zustand') == 'neu' ? 'selected' : '' }}>Neu</option>
                        <option value="renoviert" {{ old('zustand') == 'renoviert' ? 'selected' : '' }}>Renoviert</option>
                        <option value="gebraucht" {{ old('zustand') == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                        <option value="sanierungsbeduerftig" {{ old('zustand') == 'sanierungsbeduerftig' ? 'selected' : '' }}>Sanierungsbedürftig</option>
                    </select>
                </div>

                {{-- Anzahl Zimmer --}}
                <div>
                    <label for="anzahl_zimmer" class="block text-sm font-semibold text-gray-800 mb-2">Anzahl Zimmer (optional)</label>
                    <input type="number" name="anzahl_zimmer" id="anzahl_zimmer" min="0" placeholder="z. B. 3"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('anzahl_zimmer') }}" />
                </div>

                {{-- Bautyp (Duplicate of Objekttyp, assuming you might want different options here) --}}
                <div>
                    <label for="bautyp" class="block text-sm font-semibold text-gray-800 mb-2">Bautyp (optional)</label>
                    <select name="bautyp" id="bautyp"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('bautyp') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="altbau_vor_1945" {{ old('bautyp') == 'altbau_vor_1945' ? 'selected' : '' }}>Altbau vor 1945</option>
                        <option value="neubau" {{ old('bautyp') == 'neubau' ? 'selected' : '' }}>Neubau</option>
                    </select>
                </div>

                {{-- Verfügbarkeit --}}
                <div>
                    <label for="verfugbarkeit" class="block text-sm font-semibold text-gray-800 mb-2">Verfügbarkeit (optional)</label>
                    <select name="verfugbarkeit" id="verfugbarkeit"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('verfugbarkeit') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="ab_sofort" {{ old('verfugbarkeit') == 'ab_sofort' ? 'selected' : '' }}>ab sofort</option>
                        <option value="nach_vereinbarung" {{ old('verfugbarkeit') == 'nach_vereinbarung' ? 'selected' : '' }}>nach Vereinbarung</option>
                        <option value="ab_datum" {{ old('verfugbarkeit') == 'ab_datum' ? 'selected' : '' }}>ab Datum</option>
                    </select>
                </div>

                {{-- Befristung --}}
                <div>
                    <label for="befristung" class="block text-sm font-semibold text-gray-800 mb-2">Befristung (optional)</label>
                    <select name="befristung" id="befristung"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('befristung') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="keine" {{ old('befristung') == 'keine' ? 'selected' : '' }}>keine</option>
                        <option value="1_jahr" {{ old('befristung') == '1_jahr' ? 'selected' : '' }}>1 Jahr</option>
                        <option value="2_jahre" {{ old('befristung') == '2_jahre' ? 'selected' : '' }}>2 Jahre</option>
                        <option value="3_jahre" {{ old('befristung') == '3_jahre' ? 'selected' : '' }}>3 Jahre</option>
                    </select>
                </div>

                {{-- Enddatum Befristung --}}
                <div>
                    <label for="befristung_ende" class="block text-sm font-semibold text-gray-800 mb-2">Enddatum Befristung (optional)</label>
                    <input type="date" name="befristung_ende" id="befristung_ende"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('befristung_ende') }}" />
                </div>
            </div>
        </section>

  
        

        {{-- Section: Beschreibung --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Hauptbeschreibung</label>
                <textarea name="description" id="description" rows="5"
                    placeholder="Beschreibe die Immobilie im Detail. Gehe auf Besonderheiten, Zustand und Ausstattung ein."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out" required>{{ old('description') }}</textarea>
            </div>
            <div class="mt-6">
                <label for="objektbeschreibung" class="block text-sm font-semibold text-gray-800 mb-2">Objektbeschreibung (optional)</label>
                <textarea name="objektbeschreibung" id="objektbeschreibung" rows="4"
                    placeholder="Zusätzliche Details zum Objekt, falls nötig."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('objektbeschreibung') }}</textarea>
            </div>
            <div class="mt-6">
                <label for="lage" class="block text-sm font-semibold text-gray-800 mb-2">Lage (optional)</label>
                <textarea name="lage" id="lage" rows="3"
                    placeholder="Beschreibe die Umgebung, Infrastruktur und Besonderheiten der Lage."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('lage') }}</textarea>
            </div>
            <div class="mt-6">
                <label for="sonstiges" class="block text-sm font-semibold text-gray-800 mb-2">Sonstiges (optional)</label>
                <textarea name="sonstiges" id="sonstiges" rows="3"
                    placeholder="Alle weiteren relevanten Informationen, die nicht in die anderen Kategorien passen."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('sonstiges') }}</textarea>
            </div>
            <div class="mt-6">
                <label for="zusatzinformation" class="block text-sm font-semibold text-gray-800 mb-2">Weitere Angaben (optional)</label>
                <textarea name="zusatzinformation" id="zusatzinformation" rows="3"
                    placeholder="Betriebskosten, Heizkosten, Wasser, etc."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out">{{ old('zusatzinformation') }}</textarea>
            </div>
        </section>


        {{-- Section: Standort --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Standort</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="land" class="block text-sm font-semibold text-gray-800 mb-2">Land</label>
                    <input type="text" name="land" id="land" value="Österreich" readonly
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-700 cursor-not-allowed" /> {{-- Styled as readonly --}}
                </div>
                <div>
                    <label for="plz" class="block text-sm font-semibold text-gray-800 mb-2">PLZ</label>
                    <input type="text" name="plz" id="plz" placeholder="z. B. 8010"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('plz') }}" required />
                </div>
                <div>
                    <label for="ort" class="block text-sm font-semibold text-gray-800 mb-2">Ort</label>
                    <input type="text" name="ort" id="ort" placeholder="z. B. Graz"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('ort') }}" required />
                </div>
                <div>
                    <label for="straße" class="block text-sm font-semibold text-gray-800 mb-2">Straße (optional)</label>
                    <input type="text" name="straße" id="straße" placeholder="Straße und Hausnummer"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('straße') }}" />
                </div>
            </div>
        </section>

   

        {{-- Section: Preise & Flächen --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise & Flächen</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="gesamtmiete" class="block text-sm font-semibold text-gray-800 mb-2">Gesamtmiete (€)</label>
                    <input type="number" name="gesamtmiete" id="gesamtmiete" step="0.01" placeholder="z. B. 850.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('gesamtmiete') }}" />
                </div>
                <div>
                    <label for="wohnflaeche" class="block text-sm font-semibold text-gray-800 mb-2">Wohnfläche (m²)</label>
                    <input type="number" name="wohnfläche" id="wohnflaeche" step="0.01" placeholder="z. B. 75.50"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('wohnfläche') }}" />
                </div>
                <div>
                    <label for="grundflaeche" class="block text-sm font-semibold text-gray-800 mb-2">Grundfläche (m², optional)</label>
                    <input type="number" name="grundfläche" id="grundflaeche" step="0.01" placeholder="z. B. 100.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('grundfläche') }}" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="kaution" class="block text-sm font-semibold text-gray-800 mb-2">Kaution (optional)</label>
                    <input type="number" name="kaution" id="kaution" step="0.01" placeholder="z. B. 2500.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kaution') }}" />
                </div>
                <div>
                    <label for="maklerprovision" class="block text-sm font-semibold text-gray-800 mb-2">Maklerprovision (optional)</label>
                    <input type="number" name="maklerprovision" id="maklerprovision" step="0.01" placeholder="z. B. 1000.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('maklerprovision') }}" />
                </div>
                <div>
                    <label for="abloese" class="block text-sm font-semibold text-gray-800 mb-2">Ablöse (optional)</label>
                    <input type="number" name="abloese" id="abloese" step="0.01" placeholder="z. B. 500.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('abloese') }}" />
                </div>
            </div>
        </section>

 

        {{-- Section: Ausstattung & Heizung --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung & Heizung</h4>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Ausstattung (optional)</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-2 gap-x-4 text-sm text-gray-700">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="balkon" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('balkon', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Balkon/Terrasse</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="garten" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('garten', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Garten</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="keller" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('keller', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Keller</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="garage" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('garage', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Garage/Parkplatz</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="aufzug" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('aufzug', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Aufzug</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ausstattung[]" value="barrierefrei" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ in_array('barrierefrei', old('ausstattung', [])) ? 'checked' : '' }} />
                        <span class="ml-2">Barrierefrei</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="heizung" class="block text-sm font-semibold text-gray-800 mb-2">Heizung (optional)</label>
                <select name="heizung" id="heizung"
                    class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="" disabled {{ !old('heizung') ? 'selected' : '' }}>Bitte wählen ...</option>
                    <option value="zentral" {{ old('heizung') == 'zentral' ? 'selected' : '' }}>Zentralheizung</option>
                    <option value="fern" {{ old('heizung') == 'fern' ? 'selected' : '' }}>Fernwärme</option>
                    <option value="gas" {{ old('heizung') == 'gas' ? 'selected' : '' }}>Gas</option>
                    <option value="strom" {{ old('heizung') == 'strom' ? 'selected' : '' }}>Strom</option>
                    <option value="pellets" {{ old('heizung') == 'pellets' ? 'selected' : '' }}>Pellets</option>
                    <option value="holz" {{ old('heizung') == 'holz' ? 'selected' : '' }}>Holz</option>
                    <option value="keine" {{ old('heizung') == 'keine' ? 'selected' : '' }}>Keine Heizung</option>
                </select>
            </div>
        </section>



        {{-- Section: Fotos & Dokumente --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>

            {{-- Bilder Upload --}}
            <div x-data="imageUploader()" class="space-y-4 mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Bilder hochladen</label>
                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                <p class="text-xs text-gray-500 mt-1">Bis zu 10 Bilder im JPG/PNG Format</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Grundriss Upload --}}
            <div x-data="imageUploader('grundriss')" class="space-y-4 mb-6"> {{-- Use imageUploader for single file --}}
                <label class="block text-sm font-semibold text-gray-800 mb-2">Grundriss (optional)</label>
                <input type="file" name="grundriss" accept=".jpg,.jpeg,.png,.pdf" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                <p class="text-xs text-gray-500 mt-1">PDF max. 3 Seiten und 5MB</p>
                <div class="grid grid-cols-1 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" x-show="src.startsWith('data:image')" />
                            <a :href="src" target="_blank" rel="noopener noreferrer" x-show="!src.startsWith('data:image')" class="flex items-center justify-center h-32 w-full border border-gray-300 rounded-lg shadow-md bg-white text-blue-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <span x-text="`Grundriss: ${model.name || 'Datei'}`">Grundriss-Datei</span> {{-- Adjusting for potential PDF display --}}
                            </a>
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Grundriss entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Energieausweis Upload --}}
            <div x-data="imageUploader('energieausweis')" class="space-y-4 mb-6"> {{-- Use imageUploader for single file --}}
                <label class="block text-sm font-semibold text-gray-800 mb-2">Energieausweis hochladen (optional)</label>
                <input type="file" name="energieausweis" accept=".pdf,.jpg,.jpeg,.png" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                <div class="grid grid-cols-1 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" x-show="src.startsWith('data:image')" />
                            <a :href="src" target="_blank" rel="noopener noreferrer" x-show="!src.startsWith('data:image')" class="flex items-center justify-center h-32 w-full border border-gray-300 rounded-lg shadow-md bg-white text-blue-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <span x-text="`Energieausweis: ${model.name || 'Datei'}`">Energieausweis-Datei</span>
                            </a>
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Energieausweis entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- 360° Rundgang --}}
            <div class="mb-6">
                <label for="rundgang" class="block text-sm font-semibold text-gray-800 mb-2">360° Rundgang (Link, optional)</label>
                <input type="url" name="rundgang" id="rundgang" placeholder="https://..."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('rundgang') }}" />
            </div>

            {{-- Objektinformationen --}}
            <div class="mb-6">
                <label for="objektinformationen" class="block text-sm font-semibold text-gray-800 mb-2">Objektinformationen (Link, optional)</label>
                <input type="url" name="objektinformationen" id="objektinformationen" placeholder="https://..."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('objektinformationen') }}" />
            </div>

            {{-- Zustandsbericht --}}
            <div class="mb-6">
                <label for="zustandsbericht" class="block text-sm font-semibold text-gray-800 mb-2">Zustandsbericht (Link, optional)</label>
                <input type="url" name="zustandsbericht" id="zustandsbericht" placeholder="https://..."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('zustandsbericht') }}" />
            </div>

            {{-- Verkaufsbericht --}}
            <div>
                <label for="verkaufsbericht" class="block text-sm font-semibold text-gray-800 mb-2">Verkaufsbericht (Link, optional)</label>
                <input type="url" name="verkaufsbericht" id="verkaufsbericht" placeholder="https://..."
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    value="{{ old('verkaufsbericht') }}" />
            </div>
        </section>

        ---

        {{-- Section: Kontakt --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kontakt_name" class="block text-sm font-semibold text-gray-800 mb-2">Name</label>
                    <input type="text" name="kontakt_name" id="kontakt_name" placeholder="Ihr Name"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_name') }}" required />
                </div>
                <div>
                    <label for="kontakt_email" class="block text-sm font-semibold text-gray-800 mb-2">E-Mail</label>
                    <input type="email" name="kontakt_email" id="kontakt_email" placeholder="ihre.email@example.com"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_email') }}" required />
                </div>
                <div>
                    <label for="kontakt_tel" class="block text-sm font-semibold text-gray-800 mb-2">Telefon (optional)</label>
                    <input type="tel" name="kontakt_tel" id="kontakt_tel" placeholder="z. B. +43 123 456789"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_tel') }}" />
                </div>
                <div>
                    <label for="telefon2" class="block text-sm font-semibold text-gray-800 mb-2">Telefon 2 (optional)</label>
                    <input type="tel" name="telefon2" id="telefon2" placeholder="alternative Telefonnummer"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('telefon2') }}" />
                </div>
                <div>
                    <label for="fax" class="block text-sm font-semibold text-gray-800 mb-2">Fax (optional)</label>
                    <input type="tel" name="fax" id="fax" placeholder="Faxnummer"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('fax') }}" />
                </div>
                <div>
                    <label for="firmenname" class="block text-sm font-semibold text-gray-800 mb-2">Firmenname (optional)</label>
                    <input type="text" name="firmenname" id="firmenname" placeholder="Ihr Unternehmen"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('firmenname') }}" />
                </div>
                <div>
                    <label for="homepage" class="block text-sm font-semibold text-gray-800 mb-2">Homepage (optional)</label>
                    <input type="url" name="homepage" id="homepage" placeholder="https://ihre-website.at"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('homepage') }}" />
                </div>
                <div>
                    <label for="immocard_id" class="block text-sm font-semibold text-gray-800 mb-2">Immocard-ID (optional)</label>
                    <input type="text" name="immocard_id" id="immocard_id" placeholder="Ihre Immocard-ID"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('immocard_id') }}" />
                </div>
                <div>
                    <label for="immocard_firma_id" class="block text-sm font-semibold text-gray-800 mb-2">Immocard-Firma-ID (optional)</label>
                    <input type="text" name="immocard_firma_id" id="immocard_firma_id" placeholder="Ihre Immocard-Firma-ID"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('immocard_firma_id') }}" />
                </div>
            </div>
            <div class="mt-4">
                <label class="inline-flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="zusatzkontakt" class="form-checkbox h-4 w-4 text-blue-600 rounded" {{ old('zusatzkontakt') ? 'checked' : '' }} />
                    <span class="ml-2">Zusätzliche Kontaktperson angeben</span>
                </label>
            </div>
        </section>


        {{-- Submit Button --}}
        <div class="pt-6 border-t border-gray-200 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>
    </div>
</template>



                        {{-- Nur Beispiel für dienstleistungen (υπάρχουν και οι άλλες κατηγορίες σε παρόμοια μορφή) --}}
<template x-if="selectedCategory === 'dienstleistungen'">
    <div class="space-y-8"> {{-- Consistent spacing between sections --}}

        <input type="hidden" name="category_slug" value="dienstleistungen"> {{-- Added hidden input for backend --}}

        {{-- Section: Basisdaten --}}
        <section class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten der Dienstleistung</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kategorie Dropdown --}}
                <div>
                    <label for="dienstleistung_kategorie" class="block text-sm font-semibold text-gray-800 mb-2">Kategorie</label>
                    <select name="dienstleistung_kategorie" id="dienstleistung_kategorie"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                        <option value="" disabled {{ !old('dienstleistung_kategorie') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="reinigung" {{ old('dienstleistung_kategorie') == 'reinigung' ? 'selected' : '' }}>Reinigung</option>
                        <option value="handwerk" {{ old('dienstleistung_kategorie') == 'handwerk' ? 'selected' : '' }}>Handwerk</option>
                        <option value="it" {{ old('dienstleistung_kategorie') == 'it' ? 'selected' : '' }}>IT & Technik</option>
                        <option value="beratung" {{ old('dienstleistung_kategorie') == 'beratung' ? 'selected' : '' }}>Beratung</option>
                        <option value="transport" {{ old('dienstleistung_kategorie') == 'transport' ? 'selected' : '' }}>Transport & Logistik</option>
                        <option value="sonstiges" {{ old('dienstleistung_kategorie') == 'sonstiges' ? 'selected' : '' }}>Sonstiges</option>
                    </select>
                </div>

                {{-- Titel --}}
                <div>
                    <label for="titel" class="block text-sm font-semibold text-gray-800 mb-2">Titel der Dienstleistung</label>
                    <input type="text" name="titel" id="titel" placeholder="z. B. Professionelle Hausreinigung"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('titel') }}" required />
                </div>

                {{-- Region --}}
                <div>
                    <label for="region" class="block text-sm font-semibold text-gray-800 mb-2">Region / Ort</label>
                    <input type="text" name="region" id="region" placeholder="z. B. Wien, Graz, Salzburg"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('region') }}" required />
                </div>

                {{-- Preis --}}
                <div>
                    <label for="preis" class="block text-sm font-semibold text-gray-800 mb-2">Preis (€) (optional)</label>
                    <input type="number" name="preis" id="preis" step="0.01" placeholder="z. B. 50.00"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('preis') }}" />
                </div>

                {{-- Verfügbarkeit --}}
                <div>
                    <label for="verfugbarkeit" class="block text-sm font-semibold text-gray-800 mb-2">Verfügbarkeit (optional)</label>
                    <select name="verfugbarkeit" id="verfugbarkeit"
                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="" disabled {{ !old('verfugbarkeit') ? 'selected' : '' }}>Bitte wählen ...</option>
                        <option value="sofort" {{ old('verfugbarkeit') == 'sofort' ? 'selected' : '' }}>Sofort verfügbar</option>
                        <option value="nach_vereinbarung" {{ old('verfugbarkeit') == 'nach_vereinbarung' ? 'selected' : '' }}>Nach Vereinbarung</option>
                        <option value="während_wochentagen" {{ old('verfugbarkeit') == 'während_wochentagen' ? 'selected' : '' }}>Während der Wochentage</option>
                        <option value="wochenende" {{ old('verfugbarkeit') == 'wochenende' ? 'selected' : '' }}>Wochenende</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- Section: Beschreibung --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung der Dienstleistung</h4>
            <div>
                <label for="beschreibung" class="block text-sm font-semibold text-gray-800 mb-2">Ausführliche Beschreibung</label>
                <textarea name="beschreibung" id="beschreibung" rows="7"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                    transition duration-150 ease-in-out"
                    placeholder="Beschreibe die Dienstleistung ausführlich, was sie beinhaltet, Vorteile, etc." required>{{ old('beschreibung') }}</textarea>
            </div>
        </section>

        {{-- Section: Fotos --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen (optional)</h4>
            <div x-data="imageUploader()" class="space-y-4"> {{-- Integrated imageUploader --}}
                <input type="file" name="bilder[]" multiple accept="image/*" @change="handleFiles"
                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                <p class="text-xs text-gray-500 mt-1">Bis zu 10 Bilder im JPG/PNG Format</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200" />
                            <button type="button" @click="remove(index)"
                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- Section: Kontakt --}}
        <section class="bg-white p-6 rounded-lg shadow mt-6">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kontakt_name" class="block text-sm font-semibold text-gray-800 mb-2">Name</label>
                    <input type="text" name="kontakt_name" id="kontakt_name" placeholder="Ihr Name"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_name') }}" required />
                </div>
                <div>
                    <label for="kontakt_email" class="block text-sm font-semibold text-gray-800 mb-2">E-Mail</label>
                    <input type="email" name="kontakt_email" id="kontakt_email" placeholder="ihre.email@example.com"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_email') }}" required />
                </div>
                <div>
                    <label for="kontakt_tel" class="block text-sm font-semibold text-gray-800 mb-2">Telefon (optional)</label>
                    <input type="tel" name="kontakt_tel" id="kontakt_tel" placeholder="z. B. +43 123 456789"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        value="{{ old('kontakt_tel') }}" />
                </div>
            </div>
        </section>

        {{-- Submit Button --}}
        <div class="pt-6 border-t border-gray-200 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>
    </div>
</template>

<template x-if="selectedCategory === 'boote'">
    <div class="space-y-8"> {{-- Consistent spacing between sections --}}

        <input type="hidden" name="category_slug" value="boote">

        {{-- Section: Boat Details --}}
        <section class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Boot Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="year_of_manufacture" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Baujahr</label>
                    <input type="number" name="year_of_manufacture" id="year_of_manufacture" placeholder="z.B. 2010"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                           value="{{ old('year_of_manufacture') }}" />
                </div>
                <div>
                    <label for="length_meters" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Länge (in Meter)</label>
                    <input type="number" name="length_meters" id="length_meters" step="0.1" placeholder="z.B. 7.5"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                           value="{{ old('length_meters') }}" />
                </div>
                <div>
                    <label for="engine_type" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Motortyp</label>
                    <select name="engine_type" id="engine_type"
                            class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                            value="{{ old('engine_type') }}">
                        <option value="">Bitte wählen</option>
                        <option value="inboard">Innenborder</option>
                        <option value="outboard">Außenborder</option>
                        <option value="sail">Segel</option>
                        <option value="other">Andere</option>
                    </select>
                </div>
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Zustand</label>
                    <select name="condition" id="condition"
                            class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                            value="{{ old('condition') }}">
                        <option value="">Bitte wählen</option>
                        <option value="neu">Neu</option>
                        <option value="neuwertig">Neuwertig</option>
                        <option value="gebraucht">Gebraucht</option>
                        <option value="reparaturbeduerftig">Reparaturbedürftig</option>
                    </select>
                </div>
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Standort</label>
                    <input type="text" name="location" id="location" placeholder="z.B. Hafen Wien"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                           value="{{ old('location') }}" />
                </div>
            </div>
        </section>

        {{-- Section: Price --}}
        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Preis</h4>
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Preis (€)</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="z. B. 25000.00"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                       value="{{ old('price') }}" />
            </div>
        </section>

        {{-- Section: Ad Title --}}
        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Anzeigentitel</h4>
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Titel</label>
                <input type="text" name="title" id="title" required placeholder="Aussagekräftiger Titel für Ihr Boot"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                       value="{{ old('title') }}" />
            </div>
        </section>

        {{-- Section: Description --}}
        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Beschreibung</h4>
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Zusätzliche Informationen</label>
                <textarea name="description" id="description" rows="7"
                          placeholder="Geben Sie hier alle wichtigen Details zu Ihrem Boot ein. Modell, Zustand, Ausstattung, Wartungshistorie etc."
                          class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                          transition duration-150 ease-in-out dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">{{ old('description') }}</textarea>
            </div>
        </section>

        {{-- Section: Add Photos --}}
        <section class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Fotos hinzufügen</h4>
            <div x-data="imageUploader()" class="space-y-4">
                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                       class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer dark:text-gray-300 dark:file:bg-blue-800 dark:file:text-blue-100 dark:hover:file:bg-blue-700" />
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200 dark:border-gray-600" />
                            <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 dark:bg-gray-900 dark:text-red-400"
                                    aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- Submit Button --}}
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>
    </div>
</template>

<template x-if="selectedCategory === 'sonstiges'">
    <div class="space-y-8">
        <input type="hidden" name="category_slug" value="sonstiges">

        <section class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Sonstiges Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Zustand</label>
                    <select name="condition" id="condition"
                            class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                            value="{{ old('condition') }}">
                        <option value="">Bitte wählen</option>
                        <option value="neu">Neu</option>
                        <option value="neuwertig">Neuwertig</option>
                        <option value="gebraucht">Gebraucht</option>
                        <option value="defekt">Defekt</option>
                    </select>
                </div>
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Standort</label>
                    <input type="text" name="location" id="location" placeholder="z.B. Wien"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                           value="{{ old('location') }}" />
                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Preis</h4>
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Preis (€) (optional)</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="z. B. 20.00"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                       value="{{ old('price') }}" />
            </div>
        </section>

        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Anzeigentitel</h4>
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Titel</label>
                <input type="text" name="title" id="title" required placeholder="Aussagekräftiger Titel für Ihre Anzeige"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100"
                       value="{{ old('title') }}" />
            </div>
        </section>

        <section class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Beschreibung</h4>
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Zusätzliche Informationen</label>
                <textarea name="description" id="description" rows="7"
                          placeholder="Geben Sie hier alle wichtigen Details zu Ihrer Anzeige ein."
                          class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                          transition duration-150 ease-in-out dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">{{ old('description') }}</textarea>
            </div>
        </section>

        <section class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-100 mb-6">Fotos hinzufügen</h4>
            <div x-data="imageUploader()" class="space-y-4">
                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                       class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer dark:text-gray-300 dark:file:bg-blue-800 dark:file:text-blue-100 dark:hover:file:bg-blue-700" />
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4" x-show="previews.length" x-transition>
                    <template x-for="(src, index) in previews" :key="index">
                        <div class="relative group">
                            <img :src="src" class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200 dark:border-gray-600" />
                            <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 dark:bg-gray-900 dark:text-red-400"
                                    aria-label="Bild entfernen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                Anzeige erstellen
            </button>
        </div>
    </div>
</template>


                        </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function imageUploader() {
            return {
                previews: [],
                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    this.previews = []; // Clear existing previews

                    files.forEach(file => {
                        if (file.type.startsWith('image/')) { // Ensure it's an image
                            const reader = new FileReader();
                            reader.onload = e => this.previews.push(e.target.result);
                            reader.readAsDataURL(file);
                        }
                    });
                },
                remove(index) {
                    this.previews.splice(index, 1);
                    // You might also want to clear the file input's files if needed,
                    // but for a simple preview removal, this is sufficient.
                }
            };
        }
    </script>
</x-app-layout>