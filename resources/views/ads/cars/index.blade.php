<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                  {{ __('Cars Ads') }}
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                 {{ __('Browse all available cars listings') }}
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.cars.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                     {{ __('new_ad') }}
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
        ['label' => __('Cars Ads'), 'url' => route('ads.index')],        
    ]" class="mb-8" />

        {{-- Filters Section --}}
        {{-- Redesigned Filters Section --}}
        <form action="{{ route('ads.cars.index') }}" method="GET" x-data="{
        brands: {{ json_encode($brands) }},
        models: {{ json_encode($models) }},
        selectedBrand: '{{ request('brand') }}',
        selectedModel: '{{ request('model') }}',
        showMoreFilters: false,
        filterModels() {
            this.filteredModels = this.models.filter(model => model.car_brand_id == this.selectedBrand);
            if (!this.filteredModels.some(model => model.id == this.selectedModel)) {
                this.selectedModel = '';
            }
        },
        init() {
            this.filterModels();
        },
        filteredModels: [],
    }">

            <div class="p-6 rounded-xl bg-gray-50 border border-gray-200">
                {{-- Primary Filters --}}
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    {{-- Brand and Model --}}
                    <div class="flex-grow min-w-[150px]">
                        <label for="brand" class="sr-only">{{ __('brand') }}</label>
                        <select name="brand" x-model="selectedBrand" @change="filterModels"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Brand</option>
                            <template x-for="brand in brands" :key="brand.id">
                                <option :value="brand.id" x-text="brand.name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="flex-grow min-w-[150px]">
                        <label for="model" class="sr-only">{{ __('model') }}</label>
                        <select name="model" x-model="selectedModel"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            :disabled="!selectedBrand">
                            <option value="">Model</option>
                            <template x-for="model in filteredModels" :key="model.id">
                                <option :value="model.id" x-text="model.name"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Price Range with Input Fields --}}
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="min_price" class="sr-only">{{ __('min_price') }}</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('min_price') }}"
                            class="w-full rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="max_price" class="sr-only">{{ __('max_price') }}</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('max_price') }}"
                            class="w-full rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    {{-- Submission and Reset Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="hidden sm:inline">{{ __('search') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('ads.cars.index') }}"
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
                        <span x-text="showMoreFilters ? '{{ __('less_filters') }}' : '{{ __('more_filters') }}'"></span>
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
                        {{-- Mileage Filter --}}
                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">{{ __('Mileage') }}</label>
                            <select name="mileage" id="mileage"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="0-50000" {{ request('mileage') == '0-50000' ? 'selected' : '' }}>0 - 50.000
                                    km</option>
                                <option value="50001-100000" {{ request('mileage') == '50001-100000' ? 'selected' : '' }}>
                                    50.001 - 100.000 km</option>
                                <option value="100001-150000" {{ request('mileage') == '100001-150000' ? 'selected' : '' }}>100.001 - 150.000 km</option>
                                <option value="150001-200000" {{ request('mileage') == '150001-200000' ? 'selected' : '' }}>150.001 - 200.000 km</option>
                                <option value="200001-250000" {{ request('mileage') == '200001-250000' ? 'selected' : '' }}>200.001 - 250.000 km</option>
                            </select>
                        </div>

                        {{-- Year of Registration Filter --}}
                        <div class="flex flex-wrap  ">
                            {{-- Primary Filters... (rest of your form) --}}

                            {{-- Year of Registration with Input Fields --}}
                            <div class="flex-grow min-w-[150px] relative">
                                <label for="min_year" class="block text-sm font-medium text-gray-700">{{ __('year_of_construction') }}</label>
                                <div class="flex items-center mt-1">
                                    <input type="number" name="min_year" id="min_year" value="{{ request('min_year') }}"
                                        placeholder="{{ __('from') }}" min="1920" max="{{ date('Y') }}"
                                        class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                    <input type="number" name="max_year" id="max_year" value="{{ request('max_year') }}"
                                        placeholder="{{ __('to') }}" min="1920" max="{{ date('Y') }}"
                                        class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                            </div>

                            {{-- ...Submit and Reset Buttons (rest of your form) --}}
                        </div>

                    {{-- Vehicle Type Filter --}}
<div>
    <label for="vehicle_type" class="block text-sm font-medium text-gray-700">{{ __('Vehicle Type') }}</label>
    <select name="vehicle_type" id="vehicle_type"
        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
        
        <option value="">{{ __('Select type') }}</option>
        <option value="sedan" {{ request('vehicle_type') == 'sedan' ? 'selected' : '' }}>{{ __('Sedan') }}</option>
        <option value="station wagon" {{ request('vehicle_type') == 'station wagon' ? 'selected' : '' }}>{{ __('Station Wagon') }}</option>
        <option value="SUV/Off-road vehicle" {{ request('vehicle_type') == 'SUV/Off-road vehicle' ? 'selected' : '' }}>{{ __('SUV/Off-road vehicle') }}</option>
        <option value="coupe" {{ request('vehicle_type') == 'coupe' ? 'selected' : '' }}>{{ __('Coupe') }}</option>
        <option value="convertible" {{ request('vehicle_type') == 'convertible' ? 'selected' : '' }}>{{ __('Convertible') }}</option>
        <option value="minivan" {{ request('vehicle_type') == 'minivan' ? 'selected' : '' }}>{{ __('Minivan') }}</option>
        <option value="pickup" {{ request('vehicle_type') == 'pickup' ? 'selected' : '' }}>{{ __('Pickup') }}</option>
    </select>
</div>


                  {{-- Condition Filter --}}
<div>
    <label for="condition" class="block text-sm font-medium text-gray-700">{{ __('Condition') }}</label>
    <select name="condition" id="condition"
        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
        
        <option value="">{{ __('Select condition') }}</option>
        <option value="new"      {{ request('condition') == 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
        <option value="used"     {{ request('condition') == 'used' ? 'selected' : '' }}>{{ __('Used') }}</option>
        <option value="accident" {{ request('condition') == 'accident' ? 'selected' : '' }}>{{ __('Accident vehicle') }}</option>
        <option value="damaged"  {{ request('condition') == 'damaged' ? 'selected' : '' }}>{{ __('Damaged vehicle') }}</option>
    </select>
</div>



                        {{-- Warranty Filter --}}
                        <div>
                            <label for="warranty" class="block text-sm font-medium text-gray-700">{{ __('Warranty') }}</label>
                            <select name="warranty" id="warranty"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">select</option>
                                <option value="yes" {{ request('warranty') == 'yes' ? 'selected' : '' }}>{{ __('yes') }}
                                </option>
                                <option value="no" {{ request('warranty') == 'no' ? 'selected' : '' }}>{{ __('no') }}
                                </option>
                            </select>
                        </div>

                        {{-- Power (HP) Filter --}}
                        <div>
                            <label for="power" class="block text-sm font-medium text-gray-700">{{ __('Power') }}(HP)</label>
                            <select name="power" id="power"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="0-100" {{ request('power') == '0-100' ? 'selected' : '' }}>0 - 100 HP
                                </option>
                                <option value="101-200" {{ request('power') == '101-200' ? 'selected' : '' }}>101 - 200 HP
                                </option>
                                <option value="201-99999" {{ request('power') == '201-99999' ? 'selected' : '' }}>201+ HP
                                </option>
                            </select>
                        </div>

                        {{-- Fuel Type Filter --}}
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">{{ __('fuel') }}</label>
                            <select name="fuel_type" id="fuel_type"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>{{ __('Petrol') }}
                                </option>
                                <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>
                                    {{ __('Electric') }}</option>
                                <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                                <option value="lpg" {{ request('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                                <option value="cng" {{ request('fuel_type') == 'cng' ? 'selected' : '' }}>CNG</option>
                            </select>
                        </div>


                        {{-- Transmission Filter --}}
                        <div>
                            <label for="transmission"
                                class="block text-sm font-medium text-gray-700">{{ __('gearbox') }}</label>
                            <select name="transmission" id="transmission"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>{{ __('Automatic') }}</option>
                                <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>{{ __('Manual') }}
                                </option>
                            </select>
                        </div>


                        {{-- Drive Filter --}}
                        <div>
                            <label for="drive" class="block text-sm font-medium text-gray-700">{{ __('Wheel drive') }}</label>
                            <select name="drive" id="drive"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="front" {{ old('drive') == 'front' ? 'selected' : '' }}>{{ __('Front-wheel drive') }}
                                </option>
                                <option value="rear" {{ old('drive') == 'rear' ? 'selected' : '' }}>{{ __('Rear-wheel drive') }}
                                </option>
                                <option value="all" {{ old('drive') == 'all' ? 'selected' : '' }}>{{ __('All-wheel drive') }}</option>
                            </select>
                        </div>

                        {{-- Color Filter --}}
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">{{ __('Color') }}</label>
                            <select name="color" id="color"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                           <option value="" disabled selected>{{ __('Select Color') }}</option>
    <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>{{ __('Black') }}</option>
    <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>{{ __('White') }}</option>
    <option value="gray" {{ request('color') == 'gray' ? 'selected' : '' }}>{{ __('Gray') }}</option>
    <option value="silver" {{ request('color') == 'silver' ? 'selected' : '' }}>{{ __('Silver') }}</option>
    <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>{{ __('Blue') }}</option>
    <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>{{ __('Red') }}</option>
    <option value="green" {{ request('color') == 'green' ? 'selected' : '' }}>{{ __('Green') }}</option>
    <option value="yellow" {{ request('color') == 'yellow' ? 'selected' : '' }}>{{ __('Yellow') }}</option>
    <option value="orange" {{ request('color') == 'orange' ? 'selected' : '' }}>{{ __('Orange') }}</option>
    <option value="brown" {{ request('color') == 'brown' ? 'selected' : '' }}>{{ __('Brown') }}</option>
    <option value="beige" {{ request('color') == 'beige' ? 'selected' : '' }}>{{ __('Beige') }}</option>
    <option value="gold" {{ request('color') == 'gold' ? 'selected' : '' }}>{{ __('Gold') }}</option>
    <option value="purple" {{ request('color') == 'purple' ? 'selected' : '' }}>{{ __('Purple') }}</option>
    <option value="pink" {{ request('color') == 'pink' ? 'selected' : '' }}>{{ __('Pink') }}</option>
    <option value="other" {{ request('color') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
 </select>
                        </div>

                        {{-- Doors Filter --}}
                        <div>
                            <label for="doors" class="block text-sm font-medium text-gray-700">{{ __('Doors') }}</label>
                            <select name="doors" id="doors"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="2" {{ request('doors') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request('doors') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request('doors') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5+" {{ request('doors') == '5+' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        {{-- Seats Filter --}}
                        <div>
                            <label for="seats" class="block text-sm font-medium text-gray-700">{{ __('Seats') }}</label>
                            <select name="seats" id="seats"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="2" {{ request('seats') == '2' ? 'selected' : '' }}>2</option>
                                <option value="4" {{ request('seats') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request('seats') == '5' ? 'selected' : '' }}>5</option>
                                <option value="7+" {{ request('seats') == '7+' ? 'selected' : '' }}>7+</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </form>


        {{--end Filters Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 my-5 gap-6">
            @foreach($cars as $car)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <a href="{{ route('ads.cars.show', $car->id) }}">
                        @if($car->images->count())
                            <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" alt="{{ $car->title }}"
                                class="w-full h-48 object-cover">
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