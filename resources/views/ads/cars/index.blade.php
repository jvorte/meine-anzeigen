<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    All Cars
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.cars.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        New Add
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
            ['label' => 'All Ads', 'url' => route('ads.index')],
            ['label' => 'Cars', 'url' => route('ads.cars.index')],
        ]" class="mb-8" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.cars.index') }}" method="GET" x-data="{ 
                brands: {{ json_encode($brands) }},
                models: {{ json_encode($models) }},
                selectedBrand: '{{ request('brand') }}',
                selectedModel: '{{ request('model') }}',
                filteredModels: [],
                filterModels() {
                    this.filteredModels = this.models.filter(model => model.car_brand_id == this.selectedBrand);
                    // Reset selected model if the new filtered list doesn't contain the old one
                    if (!this.filteredModels.some(model => model.id == this.selectedModel)) {
                        this.selectedModel = '';
                    }
                },
                init() {
                    // Call on initial load to set the correct models
                    this.filterModels();
                }
            }">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="brand" x-model="selectedBrand" @change="filterModels" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        <template x-for="brand in brands" :key="brand.id">
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
                        <option value="10001-20000" {{ request('price') == '10001-20000' ? 'selected' : '' }}>€10.001 - €20.000</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Χιλιόμετρα' --}}
                <div class="relative flex-shrink-0">
                    <select name="mileage" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Χιλιόμετρα</option>
                        <option value="0-50000" {{ request('mileage') == '0-50000' ? 'selected' : '' }}>0 - 50.000 χλμ</option>
                        <option value="50001-100000" {{ request('mileage') == '50001-100000' ? 'selected' : '' }}>50.001 - 100.000 χλμ</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Έτος Κυκλοφορίας' --}}
                <div class="relative flex-shrink-0">
                    <select name="registration" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Έτος</option>
                        <option value="2023-2024" {{ request('registration') == '2023-2024' ? 'selected' : '' }}>2023 - 2024</option>
                        <option value="2020-2022" {{ request('registration') == '2020-2022' ? 'selected' : '' }}>2020 - 2022</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τύπος Οχήματος' --}}
                <div class="relative flex-shrink-0">
                    <select name="vehicle_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τύπος Οχήματος</option>
                        <option value="sedan" {{ request('vehicle_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="suv" {{ request('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                        <option value="hatchback" {{ request('vehicle_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
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

                {{-- Dropdown Filter for 'Εγγύηση' --}}
                <div class="relative flex-shrink-0">
                    <select name="warranty" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Εγγύηση</option>
                        <option value="yes" {{ request('warranty') == 'yes' ? 'selected' : '' }}>Με εγγύηση</option>
                        <option value="no" {{ request('warranty') == 'no' ? 'selected' : '' }}>Χωρίς εγγύηση</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Ιπποδύναμη' --}}
                <div class="relative flex-shrink-0">
                    <select name="power" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Ιπποδύναμη</option>
                        <option value="0-100" {{ request('power') == '0-100' ? 'selected' : '' }}>0 - 100 HP</option>
                        <option value="101-200" {{ request('power') == '101-200' ? 'selected' : '' }}>101 - 200 HP</option>
                        <option value="201-99999" {{ request('power') == '201-99999' ? 'selected' : '' }}>201+ HP</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Καύσιμο' --}}
                <div class="relative flex-shrink-0">
                    <select name="fuel_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Καύσιμο</option>
                        <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>Βενζίνη</option>
                        <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Πετρέλαιο</option>
                        <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Υβριδικό</option>
                        <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Ηλεκτρικό</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Μετάδοση' --}}
                <div class="relative flex-shrink-0">
                    <select name="transmission" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μετάδοση</option>
                        <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Αυτόματο</option>
                        <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Χειροκίνητο</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Κίνηση' --}}
                <div class="relative flex-shrink-0">
                    <select name="drive" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κίνηση</option>
                        <option value="fwd" {{ request('drive') == 'fwd' ? 'selected' : '' }}>Προηγούμενη</option>
                        <option value="rwd" {{ request('drive') == 'rwd' ? 'selected' : '' }}>Πίσω</option>
                        <option value="awd" {{ request('drive') == 'awd' ? 'selected' : '' }}>Τετρακίνηση</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Χρώμα' --}}
                <div class="relative flex-shrink-0">
                    <select name="color" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Χρώμα</option>
                        <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>Λευκό</option>
                        <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>Μαύρο</option>
                        <option value="silver" {{ request('color') == 'silver' ? 'selected' : '' }}>Ασημί</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Πόρτες' --}}
                <div class="relative flex-shrink-0">
                    <select name="doors" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Πόρτες</option>
                        <option value="2" {{ request('doors') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ request('doors') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ request('doors') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5+" {{ request('doors') == '5+' ? 'selected' : '' }}>5+</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Θέσεις' --}}
                <div class="relative flex-shrink-0">
                    <select name="seats" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Θέσεις</option>
                        <option value="2" {{ request('seats') == '2' ? 'selected' : '' }}>2</option>
                        <option value="4" {{ request('seats') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5" {{ request('seats') == '5' ? 'selected' : '' }}>5</option>
                        <option value="7+" {{ request('seats') == '7+' ? 'selected' : '' }}>7+</option>
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
                <a href="{{ route('ads.cars.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 my-5 gap-6">
            @foreach($cars as $car)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <a href="{{ route('ads.cars.show', $car->id) }}">
                        @if($car->images->count())
                            <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" alt="{{ $car->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No image
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('ads.cars.show', $car->id) }}">
                                {{ $car->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm">
                            {{ $car->carBrand->name ?? '-' }} {{ $car->carModel->name ?? '' }}
                        </p>
                        <p class="text-gray-900 font-bold mt-2">
                            €{{ number_format($car->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $cars->links() }}
        </div>

    </div>
</x-app-layout>
