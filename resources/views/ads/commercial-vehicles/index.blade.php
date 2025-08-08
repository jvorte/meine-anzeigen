<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Όλα τα Επαγγελματικά Οχήματα
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες επαγγελματικών οχημάτων.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.commercial-vehicles.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        Νέα Αγγελία
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            ['label' => 'Επαγγελματικά Οχήματα', 'url' => route('ads.commercial-vehicles.index')],
        ]" class="mb-8" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.commercial-vehicles.index') }}" method="GET" x-data="{
            commercialBrands: {{ json_encode($commercialBrands) }},
            commercialModels: {{ json_encode($commercialModels) }},
            selectedBrand: '{{ request('brand') }}',
            selectedModel: '{{ request('model') }}',
            filteredModels: [],
            filterModels() {
                this.filteredModels = this.commercialModels.filter(model => model.commercial_brand_id == this.selectedBrand);
                if (!this.filteredModels.some(model => model.id == this.selectedModel)) {
                    this.selectedModel = '';
                }
            },
            init() {
                this.filterModels();
            }
        }">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">

                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="brand" x-model="selectedBrand" @change="filterModels" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        <template x-for="brand in commercialBrands" :key="brand.id">
                            <option :value="brand.id" x-text="brand.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Μοντέλο' --}}
                <div class="relative flex-shrink-0">
                    <select name="model" x-model="selectedModel" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μοντέλο</option>
                        <template x-for="model in filteredModels" :key="model.id">
                            <option :value="model.id" x-text="model.name"></option>
                        </template>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τιμή' --}}
                <div class="relative flex-shrink-0">
                    <select name="price" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τιμή</option>
                        <option value="0-10000" {{ request('price') == '0-10000' ? 'selected' : '' }}>€0 - €10.000</option>
                        <option value="10001-30000" {{ request('price') == '10001-30000' ? 'selected' : '' }}>€10.001 - €30.000</option>
                        <option value="30001-999999" {{ request('price') == '30001-999999' ? 'selected' : '' }}>€30.001+</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Έτος Κυκλοφορίας' --}}
                <div class="relative flex-shrink-0">
                    <select name="first_registration" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Έτος</option>
                        <option value="2020-2024" {{ request('first_registration') == '2020-2024' ? 'selected' : '' }}>2020 - 2024</option>
                        <option value="2010-2019" {{ request('first_registration') == '2010-2019' ? 'selected' : '' }}>2010 - 2019</option>
                        <option value="0-2009" {{ request('first_registration') == '0-2009' ? 'selected' : '' }}>Πριν από το 2010</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Τύπος Οχήματος' --}}
                <div class="relative flex-shrink-0">
                    <select name="commercial_vehicle_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τύπος Οχήματος</option>
                        @foreach(['truck' => 'Φορτηγό', 'van' => 'Βαν', 'bus' => 'Λεωφορείο'] as $value => $label)
                            <option value="{{ $value }}" {{ request('commercial_vehicle_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τύπος Καυσίμου' --}}
                <div class="relative flex-shrink-0">
                    <select name="fuel_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Καύσιμο</option>
                        @foreach(['diesel' => 'Πετρέλαιο', 'petrol' => 'Βενζίνη', 'electric' => 'Ηλεκτρικό', 'gas' => 'Αέριο'] as $value => $label)
                            <option value="{{ $value }}" {{ request('fuel_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dropdown Filter for 'Μετάδοση' --}}
                <div class="relative flex-shrink-0">
                    <select name="transmission" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μετάδοση</option>
                        @foreach(['manual' => 'Χειροκίνητο', 'automatic' => 'Αυτόματο'] as $value => $label)
                            <option value="{{ $value }}" {{ request('transmission') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dropdown Filter for 'Εκπομπές' --}}
                <div class="relative flex-shrink-0">
                    <select name="emission_class" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατηγορία Εκπομπών</option>
                        @foreach(['euro_4' => 'Euro 4', 'euro_5' => 'Euro 5', 'euro_6' => 'Euro 6'] as $value => $label)
                            <option value="{{ $value }}" {{ request('emission_class') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Κατάσταση' --}}
                <div class="relative flex-shrink-0">
                    <select name="condition" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατάσταση</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Καινούργιο</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Μεταχειρισμένο</option>
                    </select>
                </div>

                {{-- Dropdown for 'Ταξινόμηση' --}}
                <div class="relative flex-shrink-0">
                    <select name="sort_by" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Ταξινόμηση</option>
                        <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Τελευταία</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Τιμή: Φθηνότερο πρώτα</option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Τιμή: Ακριβότερο πρώτα</option>
                    </select>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Αναζήτηση
                </button>

                {{-- Reset Button --}}
                <a href="{{ route('ads.commercial-vehicles.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        {{-- Ads Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 my-5 gap-6">
            @foreach ($commercialVehicles as $vehicle)
                <a href="{{ route('ads.commercial-vehicles.show', $vehicle->id) }}" class="block bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    @if($vehicle->images && $vehicle->images->first())
                        <img src="{{ asset('storage/' . $vehicle->images->first()->image_path) }}"
                             alt="{{ $vehicle->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $vehicle->title }}</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ optional($vehicle->commercialBrand)->name }} {{ optional($vehicle->commercialModel)->name }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">{{ number_format($vehicle->price, 0, ',', '.') }} €</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $commercialVehicles->links() }}
        </div>
    </div>
</x-app-layout>
