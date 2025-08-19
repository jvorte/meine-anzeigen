<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    {{ __('All the campers') }}
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    {{ __('Browse all available motorhome listings.') }}
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.campers.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        {{ __('create_ad') }}
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
        ['label' => __('Campers Ads'), 'url' => route('ads.index')],
       
    ]" class="mb-8" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.campers.index') }}" method="GET" x-data="{
            camperBrands: {{ json_encode($camperBrands) }},
            camperModels: {{ json_encode($camperModels) }},
            selectedBrand: '{{ request('brand') }}',
            selectedModel: '{{ request('model') }}',
            filteredModels: [],
            showMoreFilters: false,
            filterModels() {
                this.filteredModels = this.camperModels.filter(model => model.camper_brand_id == this.selectedBrand);
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
                        <label for="brand" class="sr-only">{{ __('brand') }}</label>
                        <select name="brand" x-model="selectedBrand" @change="filterModels"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">{{ __('brand') }}</option>
                            <template x-for="brand in camperBrands" :key="brand.id">
                                <option :value="brand.id" x-text="brand.name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="flex-grow min-w-[150px]">
                        <label for="model" class="sr-only">{{ __('model') }}</label>
                        <select name="model" x-model="selectedModel"
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            :disabled="!selectedBrand">
                            <option value="">{{ __('model') }}</option>
                            <template x-for="model in filteredModels" :key="model.id">
                                <option :value="model.id" x-text="model.name"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Price Range with Input Fields --}}
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="min_price" class="sr-only">{{ __('min_price') }}</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                            placeholder="{{ __('min_price') }}"
                            class="w-full rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="max_price" class="sr-only">{{ __('max_price') }}</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                            placeholder="{{ __('max_price') }}"
                            class="w-full rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    {{-- Submit and Reset Buttons --}}
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
                        <a href="{{ route('ads.campers.index') }}"
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

                        {{-- Year of Registration Filter --}}
                        <div class="flex-grow min-w-[150px] relative">
                            <label for="first_registration" class="block text-sm font-medium text-gray-700">{{ __('year_of_construction') }}</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_year" id="min_year" value="{{ request('min_year') }}"
                                    placeholder="{{ __('from') }}" min="1920" max="{{ date('Y') }}"
                                    class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_year" id="max_year" value="{{ request('max_year') }}"
                                    placeholder="{{ __('to') }}" min="1920" max="{{ date('Y') }}"
                                    class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>

                        {{-- Mileage Range with Input Fields --}}
                        <div class="flex-grow min-w-[150px] relative">
                            <label for="min_mileage" class="block text-sm font-medium text-gray-700">{{ __('Mileage') }}</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_mileage" value="{{ request('min_mileage') }}"
                                    placeholder="{{ __('from') }}"
                                    class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_mileage" value="{{ request('max_mileage') }}"
                                    placeholder="{{ __('to') }}"
                                    class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>

                        {{-- Power Range with Input Fields --}}
                        <div class="flex-grow min-w-[150px] relative">
                            <label for="min_power" class="block text-sm font-medium text-gray-700">{{ __('Power') }} (HP)</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_power" value="{{ request('min_power') }}"
                                    placeholder="{{ __('from') }}"
                                    class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_power" value="{{ request('max_power') }}"
                                    placeholder="{{ __('to') }}"
                                    class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>

                        {{-- Fuel Type Filter --}}
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">{{ __('fuel') }}
                            </label>
                            <select name="fuel_type" id="fuel_type"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>{{ __('Petrol') }}
                                </option>
                                <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>{{ __('Diesel') }}
                                </option>
                                <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>
                                    {{ __('Electric') }}
                                </option>
                                <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>{{ __('Hybrid') }}
                                </option>
                            </select>
                        </div>

                        {{-- Color Filter --}}
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">{{ __('Color') }}</label>
                            <select name="color" id="color"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>{{ __('Black') }}</option>
                                <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>{{ __('White') }}</option>
                                <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>{{ __('Red') }}</option>
                                <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>{{ __('Blue') }}</option>
                                <option value="green" {{ request('color') == 'green' ? 'selected' : '' }}>{{ __('Green') }}</option>
                                <option value="yellow" {{ request('color') == 'yellow' ? 'selected' : '' }}>{{ __('Yellow') }}</option>
                                <option value="orange" {{ request('color') == 'orange' ? 'selected' : '' }}>{{ __('Orange') }}</option>
                                <option value="silver" {{ request('color') == 'silver' ? 'selected' : '' }}>{{ __('Silver') }}</option>
                                <option value="gray" {{ request('color') == 'gray' ? 'selected' : '' }}>{{ __('Gray') }}</option>
                                <option value="brown" {{ request('color') == 'brown' ? 'selected' : '' }}>{{ __('Brown') }}</option>
                                <option value="beige" {{ request('color') == 'beige' ? 'selected' : '' }}>{{ __('Beige') }}</option>
                                <option value="purple" {{ request('color') == 'purple' ? 'selected' : '' }}>{{ __('Purple') }}</option>
                                <option value="pink" {{ request('color') == 'pink' ? 'selected' : '' }}>{{ __('Pink') }}</option>
                                <option value="gold" {{ request('color') == 'gold' ? 'selected' : '' }}>{{ __('Gold') }}</option>
                                <option value="bronze" {{ request('color') == 'bronze' ? 'selected' : '' }}>{{ __('Bronze') }}</option>
                                <option value="turquoise" {{ request('color') == 'turquoise' ? 'selected' : '' }}>{{ __('Turquoise') }}</option>
                                <option value="other" {{ request('color') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>

                            </select>
                        </div>

                        {{-- Camper Type Filter --}}
                        <div>
                            <label for="camper_type" class="block text-sm font-medium text-gray-700">{{ __('Τype') }}</label>
                            <select name="camper_type" id="camper_type"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($camperTypes as $type)
                                <option value="{{ $type }}" {{ request('camper_type') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Transmission Filter --}}
                        <div>
                            <label for="transmission" class="block text-sm font-medium text-gray-700">{{ __('gearbox') }}</label>
                            <select name="transmission" id="transmission"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach(['manual' => 'Manual', 'automatic' => 'Automatic'] as $value => $label)
                                <option value="{{ $value }}" {{ request('transmission') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Emission Class Filter --}}
                        <div>
                            <label for="emission_class" class="block text-sm font-medium text-gray-700">{{ __('Emission') }}</label>
                            <select name="emission_class" id="emission_class"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach(['Euro 1', 'Euro 2', 'Euro 3', 'Euro 4', 'Euro 5', 'Euro 6', 'Euro 6d-TEMP', 'Euro 6d'] as $value)
                                <option value="{{ $value }}" {{ request('emission_class') == $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Berths Filter --}}
                        <div>
                            <label for="berths" class="block text-sm font-medium text-gray-700">{{ __('beds') }}</label>
                            <select name="berths" id="berths"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="1-2" {{ request('berths') == '1-2' ? 'selected' : '' }}>1-2</option>
                                <option value="3-4" {{ request('berths') == '3-4' ? 'selected' : '' }}>3-4</option>
                                <option value="5-9" {{ request('berths') == '5-9' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        {{-- Condition Filter --}}
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700">{{ __('condition') }}</label>
                            <select name="condition" id="condition"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>{{ __('new') }}</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>{{ __('used') }}</option>
                                <option value="accident" {{ old('condition') == 'accident' ? 'selected' : '' }}>{{ __('Accident vehicle') }}</option>
                                <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>{{ __('Damaged vehicle') }}</option>
                            </select>
                        </div>

                        {{-- Sort By Dropdown --}}
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">{{ __('year_of_construction') }}</label>
                            <select name="sort_by" id="sort_by"
                                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>{{ __('Last') }}
                                </option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>{{ __('Price: Cheapest first') }}</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>{{ __('Price: Most expensive first') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($campers->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 my-5 gap-6">
            @foreach ($campers as $camper)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
                <a href="{{ route('ads.campers.show', $camper->id) }}">
                    <div class="aspect-w-4 aspect-h-3 bg-gray-100">
                        @if ($camper->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $camper->images->first()->image_path) }}"
                            alt="{{ $camper->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                            {{ $camper->title }}
                        </h3>
                        <p class="text-sm text-gray-600 truncate">
                            {{ $camper->camperBrand->name ?? '' }} {{ $camper->camperModel->name ?? '' }}
                        </p>
                        <div class="mt-2 text-blue-600 font-bold">
                            € {{ number_format($camper->price, 2) }}
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $campers->links() }}
        </div>
        @else
        <div class="text-gray-600 text-center py-20">
            Δεν βρέθηκαν campers με τα συγκεκριμένα κριτήρια.
        </div>
        @endif
    </div>
</x-app-layout>