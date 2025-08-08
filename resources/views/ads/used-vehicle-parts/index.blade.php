<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Όλα τα Ανταλλακτικά
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες για ανταλλακτικά.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.vehicles-parts.create') }}" class="c-button">
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
            ['label' => 'Ανταλλακτικά Οχημάτων', 'url' => route('ads.vehicles-parts.index')],
        ]" class="mb-8" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.vehicles-parts.index') }}" method="GET">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Κατηγορία' --}}
                <div class="relative flex-shrink-0">
                    <select name="part_category" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατηγορία</option>
                        @foreach(['engine' => 'Κινητήρας', 'brakes' => 'Φρένα', 'transmission' => 'Μετάδοση', 'body' => 'Φανοποιία'] as $value => $label)
                            <option value="{{ $value }}" {{ request('part_category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="compatible_brand" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        {{-- Assuming a Brands table exists. If not, this needs to be static or dynamically fetched. --}}
                        @foreach(['Mercedes', 'BMW', 'Volkswagen'] as $brand)
                            <option value="{{ $brand }}" {{ request('compatible_brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dropdown Filter for 'Τύπος Οχήματος' --}}
                <div class="relative flex-shrink-0">
                    <select name="vehicle_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τύπος Οχήματος</option>
                        @foreach(['car' => 'Επιβατικό', 'motorcycle' => 'Μοτοσυκλέτα', 'commercial_vehicle' => 'Επαγγελματικό'] as $value => $label)
                            <option value="{{ $value }}" {{ request('vehicle_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τιμή' --}}
                <div class="relative flex-shrink-0">
                    <select name="price" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τιμή</option>
                        <option value="0-50" {{ request('price') == '0-50' ? 'selected' : '' }}>€0 - €50</option>
                        <option value="51-200" {{ request('price') == '51-200' ? 'selected' : '' }}>€51 - €200</option>
                        <option value="201-999999" {{ request('price') == '201-999999' ? 'selected' : '' }}>€201+</option>
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
                <a href="{{ route('ads.vehicles-parts.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        {{-- Parts Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 my-5 gap-6">
            @foreach ($usedVehicleParts as $usedVehiclePart)
                <a href="{{ route('ads.used-vehicle-parts.show', $usedVehiclePart->id) }}" class="block bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden">
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
