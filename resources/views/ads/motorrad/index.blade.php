<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Όλες οι Μοτοσυκλέτες
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες μοτοσυκλετών.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.motorcycles.create') }}" class="c-button">
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
            ['label' => 'Μοτοσυκλέτες', 'url' => route('ads.motorcycles.index')],
        ]" class="mb-8" />

        {{-- Filters Section --}}
      <form action="{{ route('ads.motorcycles.index') }}" method="GET" x-data="{ 
    motorcycleBrands: {{ json_encode($motorcycleBrands) }},
    motorcycleModels: {{ json_encode($motorcycleModels) }},
    selectedBrand: '{{ request('brand') }}',
    selectedModel: '{{ request('model') }}',
    filteredModels: [],
    showMoreFilters: false,
    filterModels() {
        this.filteredModels = this.motorcycleModels.filter(model => model.motorcycle_brand_id == this.selectedBrand);
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
                <select name="brand" x-model="selectedBrand" @change="filterModels" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Μάρκα</option>
                    <template x-for="brand in motorcycleBrands" :key="brand.id">
                        <option :value="brand.id" x-text="brand.name"></option>
                    </template>
                </select>
            </div>
            
            <div class="flex-grow min-w-[150px]">
                <label for="model" class="sr-only">Μοντέλο</label>
                <select name="model" x-model="selectedModel" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" :disabled="!selectedBrand">
                    <option value="">Μοντέλο</option>
                    <template x-for="model in filteredModels" :key="model.id">
                        <option :value="model.id" x-text="model.name"></option>
                    </template>
                </select>
            </div>

            {{-- Price Range with Input Fields --}}
            <div class="flex-grow min-w-[150px] relative">
                <label for="min_price" class="sr-only">Ελάχιστη Τιμή</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Ελάχιστη τιμή" class="w-full rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div class="flex-grow min-w-[150px] relative">
                <label for="max_price" class="sr-only">Μέγιστη Τιμή</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Μέγιστη τιμή" class="w-full rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Submit and Reset Buttons --}}
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="hidden sm:inline">Αναζήτηση</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <a href="{{ route('ads.motorcycles.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        </div>
        
        {{-- More Filters Toggle Button --}}
        <div class="flex justify-start">
            <button type="button" @click="showMoreFilters = !showMoreFilters" class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out font-medium inline-flex items-center">
                <span x-text="showMoreFilters ? 'Λιγότερα Φίλτρα' : 'Περισσότερα Φίλτρα'"></span>
                <svg x-show="!showMoreFilters" class="ml-1 h-4 w-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                <svg x-show="showMoreFilters" class="ml-1 h-4 w-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Secondary Filters (Collapsible) --}}
        <div x-show="showMoreFilters" x-collapse.duration.300ms class="mt-4 border-t border-gray-200 pt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                {{-- Mileage Range with Input Fields --}}
                <div class="flex-grow min-w-[150px] relative">
                    <label for="min_mileage" class="block text-sm font-medium text-gray-700">Χιλιόμετρα</label>
                    <div class="flex items-center mt-1">
                        <input type="number" name="min_mileage" value="{{ request('min_mileage') }}" placeholder="Από" class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        <input type="number" name="max_mileage" value="{{ request('max_mileage') }}" placeholder="Έως" class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                {{-- Year of Registration Filter --}}
                <div>
                    <label for="first_registration" class="block text-sm font-medium text-gray-700">Έτος Κυκλοφορίας</label>
                    <select name="first_registration" id="first_registration" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Επιλέξτε</option>
                        <option value="2020-2024" {{ request('first_registration') == '2020-2024' ? 'selected' : '' }}>2020 - 2024</option>
                        <option value="2010-2019" {{ request('first_registration') == '2010-2019' ? 'selected' : '' }}>2010 - 2019</option>
                        <option value="0-2009" {{ request('first_registration') == '0-2009' ? 'selected' : '' }}>Πριν από το 2010</option>
                    </select>
                </div>
                
                {{-- Power Range with Input Fields --}}
                <div class="flex-grow min-w-[150px] relative">
                    <label for="min_power" class="block text-sm font-medium text-gray-700">Ιπποδύναμη</label>
                    <div class="flex items-center mt-1">
                        <input type="number" name="min_power" value="{{ request('min_power') }}" placeholder="Από" class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        <input type="number" name="max_power" value="{{ request('max_power') }}" placeholder="Έως" class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                {{-- Condition Filter --}}
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700">Κατάσταση</label>
                    <select name="condition" id="condition" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Επιλέξτε</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Καινούργια</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Μεταχειρισμένη</option>
                    </select>
                </div>
                
                {{-- Color Filter --}}
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700">Χρώμα</label>
                    <select name="color" id="color" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Επιλέξτε</option>
                        <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>Λευκό</option>
                        <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>Μαύρο</option>
                        <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Κόκκινο</option>
                        <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Μπλε</option>
                    </select>
                </div>
                
                {{-- Sort By Dropdown --}}
                <div>
                    <label for="sort_by" class="block text-sm font-medium text-gray-700">Ταξινόμηση</label>
                    <select name="sort_by" id="sort_by" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Επιλέξτε</option>
                        <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Τελευταία</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Τιμή: Φθηνότερο πρώτα</option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Τιμή: Ακριβότερο πρώτα</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 my-5 gap-6">
            @foreach($motorradAds as $motorradAd)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <a href="{{ route('ads.motorrad.show', $motorradAd->id) }}">
                        @if($motorradAd->images->count())
                            <img src="{{ asset('storage/' . $motorradAd->images->first()->image_path) }}" alt="{{ $motorradAd->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No image
                            </div>
                        @endif
                    </a>
                    
                    
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('ads.motorrad.show', $motorradAd->id) }}">
                                {{ $motorradAd->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm">
                            {{ $motorradAd->motorcycleBrand->name ?? '-' }} {{ $motorradAd->motorcycleModel->name ?? '' }}
                        </p>
                        <p class="text-gray-900 font-bold mt-2">
                            €{{ number_format($motorradAd->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $motorradAds->links() }}
        </div>

    </div>
</x-app-layout>
