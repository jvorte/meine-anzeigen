<x-app-layout>
    <x-slot name="header">
        <x-breadcrumbs :items="[
            ['label' => __('Home'), 'url' => route('dashboard')],
            ['label' => __('Search Results'), 'url' => route('ads.search', ['query' => $query])],
        ]" />
        <h1 class="font-bold text-3xl text-gray-800 leading-tight my-4"> {{-- Removed dark:text-gray-200 --}}
            Suchergebnisse für: "<span class="text-blue-600">{{ $query }}</span>" {{-- Removed dark:text-blue-400 --}}
        </h1>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-gray-900"> {{-- Changed dark:bg-gray-300 and dark:text-gray-800 --}}

                @if (empty($query))
                    <div class="text-center py-10">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> {{-- Removed dark:text-gray-600 --}}
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Kein Suchbegriff</h3> {{-- Removed dark:text-gray-100 --}}
                        <p class="mt-1 text-sm text-gray-500"> {{-- Removed dark:text-gray-400 --}}
                            Bitte geben Sie einen Suchbegriff ein, um Ergebnisse zu sehen.
                        </p>
                    </div>
                @else
                    @php
                        $totalResultsFound = 0;
                        foreach ($results as $type => $collection) {
                            $totalResultsFound += $collection->count();
                        }
                    @endphp

                    @if ($totalResultsFound === 0)
                        <div class="text-center py-10">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> {{-- Removed dark:text-gray-600 --}}
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Keine Ergebnisse</h3> {{-- Removed dark:text-gray-100 --}}
                            <p class="mt-1 text-sm text-gray-500"> {{-- Removed dark:text-gray-400 --}}
                                Wir konnten keine Ergebnisse für "<span class="font-semibold">{{ $query }}</span>" finden. Bitte versuchen Sie es mit einem anderen Suchbegriff.
                            </p>
                            <div class="mt-6">
                                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"> {{-- Removed dark:bg-blue-700 and dark:hover:bg-blue-600 --}}
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
                                'cars' => 'Fahrzeuge (Autos etc.)',
                                'motorcycles' => 'Motorräder',
                                'boats' => 'Boote',
                                'campers' => 'Wohnmobile',
                                'commercial-vehicle' => 'Nutzfahrzeuge',
                                'electronics' => 'Elektronik',
                                'household' => 'Haushaltsartikel',
                                'real-estate' => 'Immobilien',
                                'services' => 'Dienstleistungen',
                                'vehicles-parts' => 'Gebrauchte Fahrzeugteile',
                                'others' => 'Sonstiges',
                                'categories' => 'Kategorien',
                                'users' => 'Benutzer',
                            ];

                            $itemShowRoutes = [
                                'cars' => 'categories.cars.show',
                                'motorcycles' => 'categories.motorcycles.show',
                                'boats' => 'categories.boats.show',
                                'campers' => 'categories.campers.show',
                                'commercial-vehicle' => 'categories.commercial-vehicle.show',
                                'electronics' => 'categories.electronics.show',
                                'household' => 'categories.household.show',
                                'real-estate' => 'categories.real-estate.show',
                                'services' => 'categories.services.show',
                                'vehicles-parts' => 'categories.vehicles-parts.show',
                                'others' => 'categories.others.show',
                                'categories' => 'categories.show',
                                'users' => 'profile.edit',
                            ];
                        @endphp

                        {{-- Loop through each type of result --}}
                        @foreach ($results as $type => $collection)
                            @if ($collection->count() > 0)
                                <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-200 pb-2 mb-6 mt-8"> {{-- Removed dark:text-gray-200 and dark:border-gray-100 --}}
                                    {{ $sectionTitles[$type] ?? ucfirst($type) }} ({{ $collection->count() }})
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                                    @foreach ($collection as $item)
                                        @php
                                            $paramName = match($type) {
                                                'cars' => 'car',
                                                'motorcycles' => 'motorcycle',
                                                'boats' => 'boat',
                                                'campers' => 'camper',
                                                'commercial-vehicle' => 'commercialVehicle',
                                                'electronics' => 'electronic',
                                                'household' => 'household',
                                                'real-estate' => 'realEstate',
                                                'services' => 'service',
                                                'vehicles-parts' => 'usedVehiclePart',
                                                'others' => 'other',
                                                'categories' => 'category',
                                                'users' => 'user',
                                                default => 'id',
                                            };
                                            $routeParam = ($paramName === 'category' || ($paramName === 'slug' && isset($item->slug))) ? $item->slug : $item->id;
                                            $itemLink = isset($itemShowRoutes[$type]) ? route($itemShowRoutes[$type], [$paramName => $routeParam]) : null;

                                            $imageUrl = null;
                                            if ($type === 'users' && isset($item->profile_photo_path)) {
                                                $imageUrl = $item->profile_photo_url;
                                            } elseif (isset($item->images) && $item->images->isNotEmpty()) {
                                                $thumbnailImage = $item->images->firstWhere('is_thumbnail', true);

                                                if ($thumbnailImage && $thumbnailImage->image_path) {
                                                    $imageUrl = asset('storage/' . $thumbnailImage->image_path);
                                                } else if ($item->images->first() && $item->images->first()->image_path) {
                                                    $imageUrl = asset('storage/' . $item->images->first()->image_path);
                                                }
                                            } elseif (isset($item->image_path) && !empty($item->image_path)) {
                                                $imageUrl = asset('storage/' . $item->image_path);
                                            }
                                        @endphp

                                        <div class="relative group bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200 ease-in-out"> {{-- Changed dark:bg-gray-100 and dark:border-gray-100 --}}
                                            @if ($itemLink)
                                                <a href="{{ $itemLink }}" class="block">
                                            @endif

                                            @if ($imageUrl)
                                                <div class="w-full h-48 bg-gray-200 rounded-t-lg overflow-hidden flex items-center justify-center"> {{-- Removed dark:bg-gray-600 --}}
                                                    <img src="{{ $imageUrl }}" alt="{{ $item->title ?? $item->name ?? 'Image' }}" class="object-cover w-full h-full">
                                                </div>
                                            @else
                                                <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center"> {{-- Removed dark:bg-gray-600 --}}
                                                    <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"> {{-- Removed dark:text-gray-500 --}}
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif

                                            <div class="p-4 flex flex-col justify-between h-48">
                                                @if ($type === 'categories')
                                                    <h4 class="font-bold text-xl text-gray-900 mb-2 truncate"> {{-- Removed dark:text-gray-100 --}}
                                                        {{ $item->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 flex-grow"> {{-- Removed dark:text-gray-400 --}}
                                                        Kategorie-ID: {{ $item->id }}
                                                    </p>
                                                @elseif ($type === 'users')
                                                    <h4 class="font-bold text-xl text-gray-900 mb-2 truncate"> {{-- Removed dark:text-gray-100 --}}
                                                        {{ $item->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 flex-grow"> {{-- Removed dark:text-gray-400 --}}
                                                        {{ $item->email }}
                                                    </p>
                                                @else
                                                    <h4 class="font-bold text-xl text-gray-900 mb-2 line-clamp-2"> {{-- Removed dark:text-gray-100 --}}
                                                        {{ $item->title ?? 'Kein Titel' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 line-clamp-3 flex-grow mb-2"> {{-- Removed dark:text-gray-400 --}}
                                                        {{ $item->description ?? 'Keine Beschreibung vorhanden.' }}
                                                    </p>
                                                    @if (isset($item->price))
                                                        <p class="text-lg font-bold text-blue-600 mt-2"> {{-- Removed dark:text-blue-400 --}}
                                                            {{ number_format($item->price, 0, ',', '.') }} €
                                                        </p>
                                                    @endif
                                                    @if (isset($item->location))
                                                        <p class="text-xs text-gray-500 mt-1"> {{-- Removed dark:text-gray-400 --}}
                                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $item->location }}
                                                        </p>
                                                    @endif
                                                    @if (isset($item->mileage) && $type === 'vehicles')
                                                        <p class="text-xs text-gray-500"> {{-- Removed dark:text-gray-400 --}}
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

                <div class="mt-8 text-center">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150"> {{-- Changed dark:border-gray-00, dark:text-gray-300, dark:bg-gray-700, dark:hover:bg-gray-600 --}}
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