<x-app-layout>
    <x-slot name="header">

        <div class="px-4 py-1 md:py-1 flex justify-end items-center">
            <a href="{{ route('ads.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Neu Anzeige
            </a>
        </div>
    <div class="py-1">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
    
    ]" />

        </div>
    </x-slot>

    <div class="py-5 bg-gray-50 dark:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-700">Neueste Anzeigen nach Kategorie
                </h2>
                <p class="text-md text-gray-500 dark:text-gray-800 mb-4">
                    Entdecke die neuesten Angebote, übersichtlich nach Kategorien geordnet.
                </p>

                @php
                    $categoryBackgrounds = [
                        'cars' => asset('storage/images/cars.jpg'),
                        'fahrzeugeteile' => asset('storage/images/parts.jpg'),
                        'boats' => asset('storage/images/boats.jpg'),
                        'electronics' => asset('storage/images/tv.jpg'),
                        'household' => asset('storage/images/car.jpg'), // Consider changing these placeholders
                        'realestate' => asset('storage/images/car.jpg'), // Consider changing these placeholders
                        'services' => asset('storage/images/car.jpg'), // Consider changing these placeholders
                        'sonstiges' => asset('storage/images/car.jpg'), // Consider changing these placeholders
                        'motorcycles' => asset('storage/images/motorcycle.jpg'), // Added new
                        'commercial-vehicle' => asset('storage/images/trucks.jpg'), // Added new
                        'campers' => asset('storage/images/camper.jpg'), // Added new
                    ];
                @endphp

                @forelse ($adsByCategory as $categorySlug => $ads)

                    {{-- Defensive check: Ensure $ads is an object and an instance of Collection --}}
                    {{-- This prevents calling isNotEmpty() on null or a non-object --}}
                    @if (is_object($ads) && $ads instanceof \Illuminate\Support\Collection && $ads->isNotEmpty())
                        @php
                        
                            $categoryName = $categories->firstWhere('slug', $categorySlug)->name ?? ucfirst($categorySlug);
                            $backgroundImage = $categoryBackgrounds[$categorySlug] ?? 'https://placehold.co/1200x200/F0F0F0/8C8C8C?text=Category+Banner';
                        @endphp
                        <div class="mb-12 pb-8 last:border-b-0 last:pb-0 relative overflow-hidden rounded-lg shadow-md">
                            {{-- Thin navbar with background image --}}
                            <div class="relative h-24 bg-cover bg-center flex items-center p-6 rounded-t-lg"
                                style="background-image: url('{{ $backgroundImage }}');">
                                <div class="absolute inset-0 bg-black opacity-30 rounded-t-lg"></div> {{-- Dark overlay --}}
                                <h4 class="relative z-10 text-2xl font-bold text-white capitalize flex items-center w-full">
                                    {{ $categoryName }}
                                    <a href="{{ route('categories.show', $categorySlug) }}"
                                        class="ml-auto text-white hover:text-blue-200 text-base font-semibold transition-colors duration-200 flex items-center gap-1">
                                        Alle anzeigen
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                        </svg>
                                    </a>
                                </h4>
                            </div>
                            <div class="bg-white dark:bg-white p-3 rounded-b-lg"> {{-- Content below the navbar --}}

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                    @foreach ($ads as $ad)
                                        <div
                                            class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                           @php
                                                $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image'; // Default placeholder

                                                // Inner image check: also defensive
                                                if (is_object($ad->images) && $ad->images instanceof \Illuminate\Support\Collection && $ad->images->isNotEmpty()) {
                                                    $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);

                                                    if ($thumbnailImage) {
                                                        $imageUrl = asset('storage/' . $thumbnailImage->image_path);
                                                    } else {
                                                        $imageUrl = asset('storage/' . $ad->images->first()->image_path);
                                                    }
                                                }
                                            @endphp
                                            
                                            <img src="{{ $imageUrl }}" alt="{{ $ad->title ?? 'Anzeige' }}" class="w-full h-40 object-cover rounded-t-lg">
                                            <div class="p-1">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-900 mb-1 truncate">
                                                    {{ $ad->title }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-700 mb-2 line-clamp-2">
                                                    {{ $ad->description }}</p>
                                                @if (isset($ad->price) && $ad->price !== null)
                                                    <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">
                                                        {{ number_format($ad->price, 2, ',', '.') }} €</p>
                                                @elseif (isset($ad->price_from) && $ad->price_from !== null)
                                                    <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">
                                                        {{ number_format($ad->price_from, 2, ',', '.') }} €</p>
                                                @elseif (isset($ad->gesamtmiete) && $ad->gesamtmiete !== null)
                                                    <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">
                                                        {{ number_format($ad->gesamtmiete, 2, ',', '.') }} €</p>
                                                @else
                                                    <p class="text-base text-gray-500 dark:text-gray-600 mb-2">Preis auf Anfrage</p>
                                                @endif

                                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>{{ $ad->ort ?? $ad->region ?? 'Unbekannter Ort' }}</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $ad->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="mt-4">
                                                    @php
                                                        $adRouteName = null;
                                                        $adParam = $ad->id;

                                                        if ($ad instanceof \App\Models\Car) { // Note: If you renamed Vehicle to Car, this should be \App\Models\Car
                                                            $adRouteName = 'categories.cars.show';
                                                            $adParamName = 'car';
                                                        } elseif ($ad instanceof \App\Models\Boat) {
                                                            $adRouteName = 'categories.boats.show';
                                                            $adParamName = 'boat';
                                                        } elseif ($ad instanceof \App\Models\Camper) {
                                                            $adRouteName = 'categories.campers.show';
                                                            $adParamName = 'camper';
                                                        } elseif ($ad instanceof \App\Models\CommercialVehicle) {
                                                            $adRouteName = 'categories.commercial-vehicles.show';
                                                            $adParamName = 'commercialVehicle';
                                                        } elseif ($ad instanceof \App\Models\Electronic) {
                                                            $adRouteName = 'categories.electronics.show';
                                                            $adParamName = 'electronic';
                                                        } elseif ($ad instanceof \App\Models\HouseholdItem) {
                                                            $adRouteName = 'categories.household.show';
                                                            $adParamName = 'householdItem'; 
                                                        } elseif ($ad instanceof \App\Models\MotorradAd) {
                                                            $adRouteName = 'categories.motorcycles.show';
                                                            $adParamName = 'motorcycles';
                                                        } elseif ($ad instanceof \App\Models\Other) {
                                                            $adRouteName = 'categories.sonstiges.show';
                                                            $adParamName = 'other';
                                                        } elseif ($ad instanceof \App\Models\RealEstate) {
                                                            $adRouteName = 'categories.real-estate.show';
                                                            $adParamName = 'realEstate';
                                                        } elseif ($ad instanceof \App\Models\Service) {
                                                            $adRouteName = 'categories.services.show';
                                                            $adParamName = 'service';
                                                        } elseif ($ad instanceof \App\Models\UsedVehiclePart) {
                                                            $adRouteName = 'categories.fahrzeugeteile.show';
                                                            $adParamName = 'usedVehiclePart';
                                                        } else {
                                                            $adRouteName = 'ads.show';
                                                            $adParamName = 'ad';
                                                        }
                                                    @endphp

                                                    @if ($adRouteName)
                                                        <a href="{{ route($adRouteName, [$adParamName => $adParam]) }}"
                                                            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-sm hover:shadow-md">Details
                                                            ansehen</a>
                                                    @else
                                                        <span
                                                            class="inline-block bg-gray-400 text-white px-4 py-2 rounded-md text-sm font-semibold">Details
                                                            (N/A)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-gray-600 dark:text-gray-400 text-center text-lg py-10">Es sind noch keine Anzeigen
                        verfügbar.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
