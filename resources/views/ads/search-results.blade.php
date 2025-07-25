<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :items="[
            ['label' => __('Home'), 'url' => route('dashboard')],
            ['label' => __('Search Results'), 'url' => route('ads.search', ['query' => $query])],
        ]" />
        <h1 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight my-4">
            Suchergebnisse für: "<span class="text-blue-600 dark:text-blue-400">{{ $query }}</span>"
        </h1>
    </x-slot>

    <div class="py-6"> {{-- Slightly reduced padding --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-300 overflow-hidden shadow-xl sm:rounded-lg p-8 text-gray-900 dark:text-gray-800"> {{-- Increased padding, added stronger shadow --}}

                @if (empty($query))
                    <div class="text-center py-10">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Kein Suchbegriff</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Bitte geben Sie einen Suchbegriff ein, um Ergebnisse zu sehen.
                        </p>
                    </div>
                @else
                    {{-- Calculate total results to show "no results" message if nothing is found --}}
                    @php
                        $totalResultsFound = 0;
                        foreach ($results as $type => $collection) {
                            $totalResultsFound += $collection->count();
                        }
                    @endphp

                    @if ($totalResultsFound === 0)
                        <div class="text-center py-10">
                            <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Keine Ergebnisse</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Wir konnten keine Ergebnisse für "<span class="font-semibold">{{ $query }}</span>" finden. Bitte versuchen Sie es mit einem anderen Suchbegriff.
                            </p>
                            <div class="mt-6">
                                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 001.414 1.414L5.414 9H17a1 1 0 110 2H5.414l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Zurück
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Helper for section titles --}}
                        @php
                            $sectionTitles = [
                                'vehicles' => 'Fahrzeuge (Autos etc.)',
                                'motorrad_ads' => 'Motorräder',
                                'boats' => 'Boote',
                                'campers' => 'Wohnmobile',
                                'commercial_vehicles' => 'Nutzfahrzeuge',
                                'electronics' => 'Elektronik',
                                'household_items' => 'Haushaltsartikel',
                                'real_estates' => 'Immobilien',
                                'services' => 'Dienstleistungen',
                                'used_vehicle_parts' => 'Gebrauchte Fahrzeugteile',
                                'others' => 'Sonstiges',
                                'categories' => 'Kategorien',
                                'users' => 'Benutzer',
                            ];

                            $itemShowRoutes = [
                                'vehicles' => 'categories.fahrzeuge.show',
                                'motorrad_ads' => 'categories.motorrad.show',
                                'boats' => 'categories.boote.show',
                                'campers' => 'categories.wohnmobile.show',
                                'commercial_vehicles' => 'categories.nutzfahrzeuge.show',
                                'electronics' => 'categories.elektronik.show',
                                'household_items' => 'categories.haushalt.show',
                                'real_estates' => 'categories.immobilien.show',
                                'services' => 'categories.dienstleistungen.show',
                                'used_vehicle_parts' => 'categories.fahrzeugeteile.show',
                                'others' => 'categories.sonstiges.show',
                                'categories' => 'categories.show',
                                'users' => 'profile.edit',
                            ];
                        @endphp

                        {{-- Loop through each type of result --}}
                        @foreach ($results as $type => $collection)
                            @if ($collection->count() > 0)
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mb-6 mt-8">
                                    {{ $sectionTitles[$type] ?? ucfirst($type) }} ({{ $collection->count() }})
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8"> {{-- Adjusted grid for more columns on larger screens --}}
                                    @foreach ($collection as $item)
                                        @php
                                            $paramName = match($type) {
                                                'vehicles' => 'vehicle',
                                                'boats' => 'boat',
                                                'used_vehicle_parts' => 'usedVehiclePart',
                                                'electronics' => 'electronic',
                                                'household_items' => 'householdItem',
                                                'real_estates' => 'realEstate',
                                                'services' => 'service',
                                                'others' => 'other',
                                                'motorrad_ads' => 'motorradAd',
                                                'commercial_vehicles' => 'commercialVehicle',
                                                'campers' => 'camper',
                                                'categories' => 'slug',
                                                'users' => 'user',
                                                default => 'id',
                                            };
                                            $routeParam = ($paramName === 'slug' && isset($item->slug)) ? $item->slug : $item->id;
                                            $itemLink = isset($itemShowRoutes[$type]) ? route($itemShowRoutes[$type], [$paramName => $routeParam]) : null;

                                            // Determine image source if available
                                            $imageUrl = null;
                                            if (isset($item->image_path) && !empty($item->image_path)) {
                                                // Assuming image_path is a full URL or relative path from public
                                                $imageUrl = asset('storage/' . $item->image_path); // Adjust if your image paths are different
                                            } elseif (isset($item->images) && is_array($item->images) && count($item->images) > 0) {
                                                $imageUrl = asset('storage/' . $item->images[0]); // For multiple images, take the first
                                            } elseif (isset($item->profile_photo_path)) { // For users
                                                $imageUrl = $item->profile_photo_url; // Assuming Fortify/Jetstream user profile photos
                                            }
                                        @endphp

                                        <div class="relative group bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200 ease-in-out">
                                            @if ($itemLink)
                                                <a href="{{ $itemLink }}" class="block">
                                            @endif

                                            @if ($imageUrl)
                                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 rounded-t-lg overflow-hidden flex items-center justify-center">
                                                    <img src="{{ $imageUrl }}" alt="{{ $item->title ?? $item->name ?? 'Image' }}" class="object-cover w-full h-full">
                                                </div>
                                            @else
                                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 rounded-t-lg flex items-center justify-center">
                                                    <svg class="h-24 w-24 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif

                                            <div class="p-4 flex flex-col justify-between h-48"> {{-- Fixed height for content area --}}
                                                @if ($type === 'categories')
                                                    <h4 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-2 truncate">
                                                        {{ $item->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex-grow">
                                                        Kategorie-ID: {{ $item->id }}
                                                    </p>
                                                @elseif ($type === 'users')
                                                    <h4 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-2 truncate">
                                                        {{ $item->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex-grow">
                                                        {{ $item->email }}
                                                    </p>
                                                @else
                                                    <h4 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-2 line-clamp-2">
                                                        {{ $item->title ?? 'Kein Titel' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 flex-grow mb-2"> {{-- More lines for description --}}
                                                        {{ $item->description ?? 'Keine Beschreibung vorhanden.' }}
                                                    </p>
                                                    @if (isset($item->price)) {{-- Assuming 'price' field exists for most ads --}}
                                                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mt-2">
                                                            {{ number_format($item->price, 0, ',', '.') }} € {{-- Format price for Euro --}}
                                                        </p>
                                                    @endif
                                                    {{-- Add more specific fields if they exist, e.g., location, year for vehicles --}}
                                                    @if (isset($item->location))
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $item->location }}
                                                        </p>
                                                    @endif
                                                    @if (isset($item->mileage) && $type === 'vehicles') {{-- Example for vehicles only --}}
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            <i class="fas fa-tachometer-alt mr-1"></i> {{ number_format($item->mileage, 0, ',', '.') }} km
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>

                                            @if ($itemLink)
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif {{-- End if totalResultsFound === 0 --}}

                @endif {{-- End if empty($query) --}}

                <div class="mt-8 text-center"> {{-- Centered back button --}}
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 001.414 1.414L5.414 9H17a1 1 0 110 2H5.414l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Zurück zur vorherigen Seite
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>