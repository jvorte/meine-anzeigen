<x-app-layout>
    <x-slot name="header">
   
 <x-breadcrumbs :items="[
    ['label' => __('Home'), 'url' => route('dashboard')],
    ['label' => __('Search Results'), 'url' => route('ads.search', ['query' => $query])],
]" />
     <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">
            Suchergebnisse für: "{{ $query }}"
        </h1>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                @if (empty($query))
                    <p>Bitte geben Sie einen Suchbegriff ein, um Ergebnisse zu sehen.</p>
                @else
                    {{-- Calculate total results to show "no results" message if nothing is found --}}
                    @php
                        $totalResultsFound = 0;
                        foreach ($results as $type => $collection) {
                            $totalResultsFound += $collection->count();
                        }
                    @endphp

                    @if ($totalResultsFound === 0)
                        <p>Keine Ergebnisse gefunden für "{{ $query }}".</p>
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

                            // IMPORTANT FIX: Update these route names to match your web.php
                            $itemShowRoutes = [
                                'vehicles' => 'categories.fahrzeuge.show',
                                'motorrad_ads' => 'categories.motorrad.show',
                                'boats' => 'categories.boote.show',
                                'campers' => 'categories.wohnmobile.show', // Corrected to match web.php
                                'commercial_vehicles' => 'categories.nutzfahrzeuge.show', // Corrected to match web.php
                                'electronics' => 'categories.elektronik.show',
                                'household_items' => 'categories.haushalt.show', // Corrected to match web.php
                                'real_estates' => 'categories.immobilien.show', // Corrected to match web.php
                                'services' => 'categories.dienstleistungen.show', // Corrected to match web.php
                                'used_vehicle_parts' => 'categories.fahrzeugeteile.show', // Corrected to match web.php
                                'others' => 'categories.sonstiges.show', // Corrected to match web.php
                                'categories' => 'categories.show', // This is for general category page
                                'users' => 'profile.edit', // Assuming you want to link to profile edit page, adjust if a public user profile exists
                            ];
                        @endphp

                        {{-- Loop through each type of result --}}
                        @foreach ($results as $type => $collection)
                            @if ($collection->count() > 0)
                                <h3 class="text-2xl font-bold mb-4 mt-8">{{ $sectionTitles[$type] ?? ucfirst($type) }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                    @foreach ($collection as $item)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm dark:bg-gray-700">
                                            {{-- Display specific fields based on item type --}}
                                            @if ($type === 'categories')
                                                <h4 class="font-semibold text-lg">{{ $item->name }}</h4>
                                                <p class="text-gray-600 dark:text-gray-400">Kategorie-ID: {{ $item->id }}</p>
                                            @elseif ($type === 'users')
                                                <h4 class="font-semibold text-lg">{{ $item->name }}</h4>
                                                <p class="text-gray-600 dark:text-gray-400">{{ $item->email }}</p>
                                            @else
                                                {{-- Assume 'title' and 'description' for all ad items --}}
                                                <h4 class="font-semibold text-lg">{{ $item->title ?? 'Kein Titel' }}</h4>
                                                <p class="text-gray-600 dark:text-gray-400 line-clamp-2">{{ $item->description ?? 'Keine Beschreibung' }}</p>
                                            @endif

                                            {{-- Link to view item details (check if route exists before linking) --}}
                                            @if (isset($itemShowRoutes[$type]))
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
                                                        'categories' => 'slug', // Use slug for categories route
                                                        'users' => 'user', // Assuming users route uses 'user' as param name, adjust if it's 'id'
                                                        default => 'id', // Fallback
                                                    };
                                                    // For categories.show, you're using 'slug', so we need to pass the category's slug.
                                                    // For others, it's usually 'id'.
                                                    $routeParam = ($paramName === 'slug' && isset($item->slug)) ? $item->slug : $item->id;
                                                @endphp
                                                <a href="{{ route($itemShowRoutes[$type], [$paramName => $routeParam]) }}" class="text-blue-600 hover:underline mt-2 inline-block">Ansehen</a>
                                            @else
                                                <span class="text-gray-500 mt-2 inline-block">Detailansicht nicht verfügbar</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif {{-- End if totalResultsFound === 0 --}}

                @endif {{-- End if empty($query) --}}

                <div class="mt-6">
                    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Zurück zur vorherigen Seite</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>