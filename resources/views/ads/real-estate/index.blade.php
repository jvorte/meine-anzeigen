{{-- resources/views/ads/real-estate/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                  {{ __('Real Estate') }}
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                   {{ __('Find your new home – simply advertise and discover properties.') }}
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.real-estate.create') }}" class="c-button">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-breadcrumbs :items="[
            ['label' => __('All ads'), 'url' => route('ads.index')],
    
        ]" class="mb-6" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.real-estate.index') }}" method="GET" x-data="{ showMoreFilters: false }">
            <div class="p-6 rounded-xl bg-gray-50 border border-gray-200">
                {{-- Primary Filters --}}
                <div class="flex flex-wrap items-center gap-4 mb-4">


                    <div class="flex-grow min-w-[200px]">
                        <label for="title" class="sr-only">{{ __('search') }}</label>
                        <input type="text" name="title" id="title" value="{{ request('title') }}" placeholder="{{ __('search') }}..." class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 p-1">
                    </div>


                    {{-- buy or rent--}}
                    <div class="flex-grow min-w-[150px]">
                        <label for="objekttyp" class="sr-only">{{ __('Property for') }}</label>
                        <select name="objekttyp" id="objekttyp" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">{{ __('Property for') }}</option>
                            @foreach($objekttyps as $objekttyp)
                            <option value="{{ $objekttyp }}" {{ request('propertyTypeOption') == $objekttyp ? 'selected' : '' }}>{{ $objekttyp }}</option>
                            @endforeach
                        </select>
                    </div>



                    {{-- Property Type Dropdown --}}
                    <div class="flex-grow min-w-[150px]">
                        <label for="propertyTypeOptions" class="sr-only">{{ __('Real Estate type') }}e</label>
                        <select name="propertyTypeOptions" id="propertyTypeOptions" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">{{ __('Real Estate type') }}</option>
                            @foreach($propertyTypeOptions as $propertyTypeOption)
                            <option value="{{ $propertyTypeOption }}" {{ request('propertyTypeOption') == $propertyTypeOption ? 'selected' : '' }}>{{ $propertyTypeOption }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Range with Input Fields --}}
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="min_price" class="sr-only">{{ __('min_price') }}</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('min_price') }}" class="w-full rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                    <div class="flex-grow min-w-[150px] relative">
                        <label for="max_price" class="sr-only">{{ __('max_price') }}</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('max_price') }}" class="w-full rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    {{-- Submit and Reset Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="hidden sm:inline">{{ __('search') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('ads.real-estate.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- More Filters Toggle Button --}}
                <div class="flex justify-start">
                    <button type="button" @click="showMoreFilters = !showMoreFilters" class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out font-medium inline-flex items-center">
                        <span x-text="showMoreFilters ? '{{ __('less_filters') }}' : '{{ __('more_filters') }}'"></span>
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


               {{-- Location --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="location" class="block text-sm font-medium text-gray-700">{{ __('location') }}</label>
                            <select name="location" id="location" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('petFriendlyOption') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                          {{-- Postcode --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">{{ __('Postal code') }}</label>
                            <select name="postcode" id="postcode" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($postcodes as $postcode)
                                <option value="{{ $postcode }}" {{ request('postcode') == $postcode ? 'selected' : '' }}>
                                    {{ $postcode }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                                        {{-- condition --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="condition" class="block text-sm font-medium text-gray-700">{{ __('condition') }}</label>
                            <select name="condition" id="condition" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                                    {{ __($condition) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        

                                       {{-- constructionTypeOptions --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="constructionTypeOption" class="block text-sm font-medium text-gray-700">{{ __('ConstructionType') }}</label>
                            <select name="constructionTypeOption" id="condition" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($constructionTypeOptions as $constructionTypeOption)
                                <option value="{{ $constructionTypeOption }}" {{ request('constructionTypeOption') == $condition ? 'selected' : '' }}>
                                    {{ __($constructionTypeOption) }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                        {{-- Number of Rooms Filter --}}
                        <div>
                            <label for="anzahl_zimmer" class="block text-sm font-medium text-gray-700">{{ __('Number of Rooms') }}</label>
                            <select name="anzahl_zimmer" id="anzahl_zimmer" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="1" {{ request('anzahl_zimmer') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request('anzahl_zimmer') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request('anzahl_zimmer') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request('anzahl_zimmer') == '4' ? 'selected' : '' }}>4+</option>
                            </select>
                        </div>



                                 {{--  heating --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="heatingOptions" class="block text-sm font-medium text-gray-700">{{ __('Heating Options') }}</label>
                            <select name="heatingOptions" id="heatingOptions" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($heatingOptions as $heatingOption)
                                <option value="{{ $heatingOption }}" {{ request('heatingOptions') == $heatingOption ? 'selected' : '' }}>
                                    {{ __($heatingOption) }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                        {{-- Pet Friendly --}}
                        <div class="flex-grow min-w-[150px]">
                            <label for="petFriendlyOption" class="block text-sm font-medium text-gray-700">{{ __('Pet Friendly') }}</label>
                            <select name="petFriendlyOption" id="petFriendlyOption" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($petFriendlyOptions as $petFriendlyOption)
                                <option value="{{ $petFriendlyOption }}" {{ request('petFriendlyOption') == $petFriendlyOption ? 'selected' : '' }}>
                                    {{ __($petFriendlyOption) }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Area Range with Input Fields --}}
                        <div class="flex-grow min-w-[150px] relative">
                            <label for="min_area" class="block text-sm font-medium text-gray-700">{{ __('Living space') }}</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_area" value="{{ request('min_area') }}" placeholder="from" class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_area" value="{{ request('max_area') }}" placeholder="to" class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>

                        {{-- Year of Construction Filter yearConstraction --}}
                        <div class="flex-grow min-w-[150px] relative">
                            <label for="min_area" class="block text-sm font-medium text-gray-700">{{ __('Year of construction of property') }}</label>
                            <div class="flex items-center mt-1">
                                <input type="number" name="min_year" value="{{ request('min_year') }}" placeholder="from" class="w-1/2 rounded-l-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                <input type="number" name="max_year" value="{{ request('max_year') }}" placeholder="to" class="w-1/2 rounded-r-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>




                        {{-- Sort By Dropdown --}}
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">{{ __('Sort by') }}</label>
                            <select name="sort_by" id="sort_by" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>{{ __('Last') }}</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>{{ __('Price: Cheapest first') }}</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>{{ __('Price: Most expensive first') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Real Estate Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            @forelse($realEstateAds as $realEstate)
            <a href="{{ route('ads.real-estate.show', $realEstate->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                @if($realEstate->images->count())
                <img src="{{ asset('storage/' . $realEstate->images->first()->image_path) }}" alt="{{ $realEstate->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                    Δεν υπάρχει εικόνα
                </div>
                @endif

                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $realEstate->title }}</h2>
                    <p class="text-gray-500 mt-1"> {{ $realEstate->propertyTypeOptions ?? 'Δ/Α' }}</p>
                    <p class="text-gray-600 mt-1">{{ $realEstate->location ?? 'Δ/Α' }}</p>
                    <p class="text-gray-500 mt-1">{{ $realEstate->anzahl_zimmer }} Δωμάτια</p>

                    @if($realEstate->price)
                    <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($realEstate->price, 2) }}</p>
                    @else
                    <p class="text-gray-500 italic mt-2">{{ __('price_on_request') }}</p>
                    @endif
                </div>
            </a>
            @empty
            <p class="text-gray-600 col-span-full">{{ __('No real estate ads found.') }}</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $realEstateAds->links() }}
        </div>
    </div>
</x-app-layout>