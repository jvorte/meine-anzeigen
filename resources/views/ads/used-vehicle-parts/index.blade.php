<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    {{ __('Vehicle spare parts') }}
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    {{ __('Browse all available ads for spare parts.') }}
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.vehicles-parts.create') }}" class="c-button">
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
   
            ['label' => __('All ads'), 'url' => route('ads.vehicles-parts.index')],
        ]" class="mb-8" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.vehicles-parts.index') }}" method="GET" x-data="{ showMoreFilters: false }">
            <div class="p-6 rounded-xl bg-gray-50 border border-gray-200">
                {{-- Primary Filters --}}
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    {{-- Text Input for 'Τίτλος' --}}
                    <div class="flex-grow min-w-[200px]">
                        <label for="title" class="sr-only">{{ __('search') }} </label>
                        <input type="text" name="title" id="title" value="{{ request('title') }}" placeholder="{{ __('search') }}..." class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
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



                    {{-- Submit and Reset Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="hidden sm:inline">{{ __('search') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('ads.vehicles-parts.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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



                        {{-- Part Category --}}
                        <div>
                            <label for="part_category" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                            <select name="part_category" id="part_category" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($partCategories as $category)
                                <option value="{{ $category }}" {{ old('part_category') == $category ? 'selected' : '' }}>{{ __($category) }}</option>
                                @endforeach
                            </select>
                            @error('part_category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        {{-- Vehicle Type Dropdown --}}
                        <div>
                            <label for="vehicle_type" class="block text-sm font-medium text-gray-700">{{ __('Τype') }}</label>
                            <select name="vehicle_type" id="vehicle_type" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                @foreach($vehicleTypes as $category)
                                <option value="{{ $category }}" {{ old('part_category') == $category ? 'selected' : '' }}>{{ __($category) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Condition Dropdown --}}
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700">{{ __('condition') }}</label>
                            <select name="condition" id="condition" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">{{ __('select') }}</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>{{ __('new') }}</option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>{{ __('used') }}</option>
                                <option value="refurbished" {{ request('condition') == 'refurbished' ? 'selected' : '' }}>{{ __('Accident vehicle') }}</option>
                                <option value="broken" {{ request('condition') == 'broken' ? 'selected' : '' }}>{{ __('Damaged vehicle') }}</option>
                            </select>
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

        {{-- Parts Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 my-5 gap-6">
            @foreach ($usedVehicleParts as $usedVehiclePart)
            <a href="{{ route('ads.vehicles-parts.show', $usedVehiclePart->id) }}" class="block bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                @if($usedVehiclePart->images && $usedVehiclePart->images->first())
                <img src="{{ asset('storage/' . $usedVehiclePart->images->first()->image_path) }}"
                    alt="{{ $usedVehiclePart->title }}"
                    class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                    No Image
                </div>
                @endif

                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $usedVehiclePart->title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $usedVehiclePart->part_name }} ({{ $usedVehiclePart->part_category }})
                    </p>
                    <p class="text-sm text-gray-500 mt-2">{{ number_format($usedVehiclePart->price, 0, ',', '.') }} €</p>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $usedVehicleParts->links() }}
        </div>
    </div>
</x-app-layout>