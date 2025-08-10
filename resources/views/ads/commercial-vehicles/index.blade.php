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
    showMoreFilters: false,
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
            <div class="p-6 rounded-xl bg-gray-50 border border-gray-200">
                {{-- Primary Filters --}}
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    {{-- Brand and Model --}}
                    <div class="flex-grow min-w-[150px]">
                        <label for="brand" class="sr-only">Μάρκα</label>
                        <select name="brand" x-model="selectedBrand" @change="filterModels"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Μάρκα</option>
                            <template x-for="brand in commercialBrands" :key="brand.id">
                                <option :value="brand.id" x-text="brand.name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="flex-grow min-w-[150px]">
                        <label for="model" class="sr-only">Μοντέλο</label>
                        <select name="model" x-model="selectedModel"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            :disabled="!selectedBrand">
                            <option value="">Μοντέλο</option>
                            <template x-for="model in filteredModels" :key="model.id">
                                <option :value="model.id" x-text="model.name"></option>
                            </template>
                        </select>
                    </div>


                    {{-- Price Range with Input Fields --}}
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="min_price" class="sr-only">min Price</label>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                            placeholder="min Price" step="0.01" min="0"
                            class="w-full rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="max_price" class="sr-only">max Price</label>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                            placeholder="max Price" step="0.01" min="0"
                            class="w-full rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>


                    {{-- Submit and Reset Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="hidden sm:inline">Αναζήτηση</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('ads.commercial-vehicles.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                </div>



                {{-- More Filters Toggle Button --}}
                <div class="flex justify-start">
                    <button type="button" @click="showMoreFilters = !showMoreFilters"
                        class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out font-medium inline-flex items-center">
                        <span x-text="showMoreFilters ? 'Λιγότερα Φίλτρα' : 'Περισσότερα Φίλτρα'"></span>
                        <svg x-show="!showMoreFilters" class="ml-1 h-4 w-4 transform transition-transform duration-200"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showMoreFilters" class="ml-1 h-4 w-4 transform transition-transform duration-200"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>




                {{-- Secondary Filters (Collapsible) --}}
                <div x-show="showMoreFilters" x-collapse.duration.300ms class="mt-4 border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">



                        {{-- Year of Registration Filter --}}


                        <div class="flex-grow min-w-[150px] relative">
                            <label for="min_year" class="block text-sm font-medium text-gray-700">Year of
                                manufacture</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_year" id="min_year" value="{{ request('min_year') }}"
                                    placeholder="Από" min="1920" max="{{ date('Y') }}"
                                    class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_year" id="max_year" value="{{ request('max_year') }}"
                                    placeholder="Έως" min="1920" max="{{ date('Y') }}"
                                    class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>

                        {{-- Vehicle Type Filter --}}
                        <div>
                            <label for="commercial_vehicle_type" class="block text-sm font-medium text-gray-700">Vehicle
                                Type</label>
                            <select name="commercial_vehicle_type" id="vehicle_type"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="Small van" {{ request('vehicle_type') == 'Small van' ? 'selected' : '' }}>
                                    Small van</option>
                                <option value="minibus" {{ request('vehicle_type') == 'minibus' ? 'selected' : '' }}>
                                    Minibus</option>
                                <option value="Panel van" {{ request('vehicle_type') == 'Panel van' ? 'selected' : '' }}>
                                    Panel van</option>
                                <option value="Station wagon" {{ request('vehicle_type') == 'Station wagon' ? 'selected' : '' }}>Station wagon</option>
                                <option value="Pick-up" {{ request('vehicle_type') == 'Pick-up' ? 'selected' : '' }}>
                                    Pick-up</option>
                                <option value="Special conversion" {{ request('vehicle_type') == 'Special conversion' ? 'selected' : '' }}>Special conversion</option>
                                <option value="Other" {{ request('vehicle_type') == 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                        </div>


                        {{-- Mileage Filter --}}
                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
                            <select name="mileage" id="mileage"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="0-50000" {{ request('mileage') == '0-50000' ? 'selected' : '' }}>0 - 50.000
                                    km</option>
                                <option value="50001-100000" {{ request('mileage') == '50001-100000' ? 'selected' : '' }}>
                                    50.001 - 100.000 km</option>
                                <option value="100001-150000" {{ request('mileage') == '100001-150000' ? 'selected' : '' }}>100.001 - 150.000 km</option>
                                <option value="150001-200000" {{ request('mileage') == '150001-200000' ? 'selected' : '' }}>150.001 - 200.000 km</option>
                                <option value="200001-250000" {{ request('mileage') == '200001-250000' ? 'selected' : '' }}>200.001 - 250.000 km</option>
                            </select>
                        </div>



                        {{-- Power (HP) Filter --}}
                        <div>
                            <label for="power" class="block text-sm font-medium text-gray-700">Horse Power(HP)</label>
                            <select name="power" id="power"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="0-100" {{ request('power') == '0-100' ? 'selected' : '' }}>0 - 100 HP
                                </option>
                                <option value="101-200" {{ request('power') == '101-200' ? 'selected' : '' }}>101 - 200 HP
                                </option>
                                <option value="201-99999" {{ request('power') == '201-99999' ? 'selected' : '' }}>201+ HP
                                </option>
                            </select>
                        </div>


                        {{-- Color Filter --}}
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <select name="color" id="color"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>Black</option>
                                <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>White</option>
                                <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                <option value="green" {{ request('color') == 'green' ? 'selected' : '' }}>Green</option>
                                <option value="yellow" {{ request('color') == 'yellow' ? 'selected' : '' }}>Yellow
                                </option>
                                <option value="orange" {{ request('color') == 'orange' ? 'selected' : '' }}>Orange
                                </option>
                                <option value="silver" {{ request('color') == 'silver' ? 'selected' : '' }}>Silver
                                </option>
                                <option value="grey" {{ request('color') == 'grey' ? 'selected' : '' }}>Grey</option>
                                <option value="brown" {{ request('color') == 'brown' ? 'selected' : '' }}>Brown</option>
                                <option value="other" {{ request('color') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        {{-- Fuel Type Filter --}}
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">Καύσιμο</label>
                            <select name="fuel_type" id="fuel_type"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Επιλέξτε</option>
                                @foreach(['diesel' => 'Diesel', 'petrol' => 'Petrol', 'electric' => 'Electric', 'gas' => 'Gas'] as $value => $label)
                                    <option value="{{ $value }}" {{ request('fuel_type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Transmission Filter --}}
                        <div>
                            <label for="transmission" class="block text-sm font-medium text-gray-700">Μετάδοση</label>
                            <select name="transmission" id="transmission"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Επιλέξτε</option>
                                @foreach(['manual' => 'Manual', 'automatic' => 'Automatic'] as $value => $label)
                                    <option value="{{ $value }}" {{ request('transmission') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Emission Class Filter --}}

                        <div>
                            <label for="emission_class" class="block text-sm font-medium text-gray-700">Κατηγορία
                                Εκπομπών</label>
                            <select name="emission_class" id="emission_class"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Επιλέξτε</option>
                                @foreach(['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'] as $value)
                                    <option value="{{ $value }}" {{ request('emission_class') == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Seats Filter --}}
                        <div>
                            <label for="seats" class="block text-sm font-medium text-gray-700">Seats</label>
                            <select name="seats" id="seats"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="2" {{ request('seats') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request('seats') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request('seats') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request('seats') == '5' ? 'selected' : '' }}>5</option>
                                <option value="6" {{ request('seats') == '6' ? 'selected' : '' }}>6</option>
                                <option value="7+" {{ request('seats') == '7+' ? 'selected' : '' }}>7+</option>
                            </select>
                        </div>

                        {{-- Condition Filter --}}
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700">Κατάσταση</label>
                            <select name="condition" id="condition"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Επιλέξτε</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>new
                                </option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>used
                                </option>
                            </select>
                        </div>

                        {{-- Sort By Dropdown --}}
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">Ταξινόμηση</label>
                            <select name="sort_by" id="sort_by"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Επιλέξτε</option>
                                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Τελευταία
                                </option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Τιμή:
                                    Φθηνότερο πρώτα</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>
                                    Τιμή: Ακριβότερο πρώτα</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- Ads Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 my-5 gap-6">
            @foreach ($commercialVehicles as $vehicle)
                <a href="{{ route('ads.commercial-vehicles.show', $vehicle->id) }}"
                    class="block bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    @if($vehicle->images && $vehicle->images->first())
                        <img src="{{ asset('storage/' . $vehicle->images->first()->image_path) }}" alt="{{ $vehicle->title }}"
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