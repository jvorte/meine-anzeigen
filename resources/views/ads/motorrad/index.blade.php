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
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="brand" x-model="selectedBrand" @change="filterModels" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        <template x-for="brand in motorcycleBrands" :key="brand.id">
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
                        <option value="0-5000" {{ request('price') == '0-5000' ? 'selected' : '' }}>€0 - €5.000</option>
                        <option value="5001-15000" {{ request('price') == '5001-15000' ? 'selected' : '' }}>€5.001 - €15.000</option>
                        <option value="15001-99999" {{ request('price') == '15001-99999' ? 'selected' : '' }}>€15.001+</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Χιλιόμετρα' --}}
                <div class="relative flex-shrink-0">
                    <select name="mileage" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Χιλιόμετρα</option>
                        <option value="0-10000" {{ request('mileage') == '0-10000' ? 'selected' : '' }}>0 - 10.000 χλμ</option>
                        <option value="10001-50000" {{ request('mileage') == '10001-50000' ? 'selected' : '' }}>10.001 - 50.000 χλμ</option>
                        <option value="50001-999999" {{ request('mileage') == '50001-999999' ? 'selected' : '' }}>50.001+ χλμ</option>
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
                
                {{-- Dropdown Filter for 'Ιπποδύναμη' --}}
                <div class="relative flex-shrink-0">
                    <select name="power" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Ιπποδύναμη</option>
                        <option value="0-50" {{ request('power') == '0-50' ? 'selected' : '' }}>0 - 50 HP</option>
                        <option value="51-100" {{ request('power') == '51-100' ? 'selected' : '' }}>51 - 100 HP</option>
                        <option value="101-999" {{ request('power') == '101-999' ? 'selected' : '' }}>101+ HP</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Κατάσταση' --}}
                <div class="relative flex-shrink-0">
                    <select name="condition" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατάσταση</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Καινούργια</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Μεταχειρισμένη</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Χρώμα' --}}
                <div class="relative flex-shrink-0">
                    <select name="color" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Χρώμα</option>
                        <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>Λευκό</option>
                        <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>Μαύρο</option>
                        <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Κόκκινο</option>
                        <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Μπλε</option>
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
                <a href="{{ route('ads.motorcycles.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
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
