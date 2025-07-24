<x-app-layout>
    <x-slot name="header">
        {{-- Updated Header Section with Gradient and Prominent CTA --}}
        <div class="relative flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 p-6 bg-cover bg-center shadow-lg rounded-lg"
            style="background-image: url('/storage/images/2.jpg');"> {{-- Replaced with a stable placeholder image --}}
            {{-- Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black opacity-20 rounded-lg"></div> {{-- Adjust opacity (e.g., 10 to 40) --}}

            {{-- Main Heading and Description (ensure z-index to be above overlay) --}}
            <div class="relative z-10 text-center md:text-left flex-grow">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight mb-2">
                    Finde deine nächste Anzeige
                </h2>
                <p class="text-md text-gray-600 dark:text-gray-100">
                    Durchsuche Tausende von Anzeigen oder erstelle deine eigene.
                </p>
            </div>

            {{-- Prominent Search Bar (ensure z-index to be above overlay) --}}
            <div class="relative z-10 w-full md:w-1/2 lg:w-2/5">
                <form action="{{ route('ads.search') }}" method="GET">

                    <input type="text" name="query" placeholder="Was suchst du? z.B. iPhone, Wohnung, Fahrrad..."
                        class="w-full p-3 pl-10 border border-gray-300 rounded-full shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-black dark:bg-gray-100 dark:text-gray-900 dark:border-gray-600"
                        aria-label="Search ads">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </div>

        {{-- Category Navigation Links (moved below main header for better flow) --}}
        <nav
            class="p-4 flex flex-wrap justify-center md:justify-start gap-x-4 gap-y-2 mt-4 pb-2 border-b border-gray-200 dark:border-gray-700">
            {{-- Removed ps-4, space-x-4, overflow-x-auto, added flex-wrap, justify-center, gap-x-4, gap-y-2 --}}
            <a href="{{ route('categories.show', 'fahrzeuge') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                {{-- Added padding, rounded, and background for each link --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-car-icon lucide-car">
                    <path
                        d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                    <circle cx="7" cy="17" r="2" />
                    <path d="M9 17h6" />
                    <circle cx="17" cy="17" r="2" />
                </svg>
                <span>Fahrzeuge</span>
            </a>
            <a href="{{ route('categories.show', 'fahrzeugeteile') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bolt-icon lucide-bolt">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <circle cx="12" cy="12" r="4" />
                </svg>
                <span>Fahrzeugeteile</span>
            </a>
            <a href="{{ route('categories.show', 'boote') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-boat">
                    <path d="M2 20a2.43 2.43 0 0 1 2-2h16a2.43 2.43 0 0 1 2 2Z" />
                    <path d="M18 10H6" />
                    <path d="M2 12h20" />
                    <path d="M12 2v10" />
                </svg>
                <span>Boote</span>
            </a>
            <a href="{{ route('categories.show', 'elektronik') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-cable-icon lucide-cable">
                    <path d="M17 19a1 1 0 0 1-1-1v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a1 1 0 0 1-1 1z" />
                    <path d="M17 21v-2" />
                    <path d="M19 14V6.5a1 1 0 0 0-7 0v11a1 1 0 0 1-7 0V10" />
                    <path d="M21 21v-2" />
                    <path d="M3 5V3" />
                    <path d="M4 10a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2z" />
                    <path d="M7 5V3" />
                </svg>
                <span>Elektronik</span>
            </a>
            <a href="{{ route('categories.show', 'haushalt') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-sofa-icon lucide-sofa">
                    <path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3" />
                    <path
                        d="M2 16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z" />
                    <path d="M4 18v2" />
                    <path d="M20 18v2" />
                    <path d="M12 4v9" />
                </svg>
                <span>Haushalt</span>
            </a>
            <a href="{{ route('categories.show', 'immobilien') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house-icon lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                        d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                <span>Immobilien</span>
            </a>
            <a href="{{ route('categories.show', 'dienstleistungen') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-hand-platter-icon lucide-hand-platter">
                    <path d="M12 3V2" />
                    <path
                        d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5" />
                    <path d="M2 14h12a2 2 0 0 1 0 4h-2" />
                    <path d="M4 10h16" />
                    <path d="M5 10a7 7 0 0 1 14 0" />
                    <path d="M5 14v6a1 1 0 0 1-1 1H2" />
                </svg>
                <span>Dienstleistunge</span>
            </a>
            <a href="{{ route('categories.show', 'sonstiges') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-more-horizontal">
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="19" cy="12" r="1" />
                    <circle cx="5" cy="12" r="1" />
                </svg>
                <span>Sonstiges</span>
            </a>
        </nav>



        <div class="px-4 py-4 md:py-2 flex justify-end items-center">
            <a href="{{ route('ads.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Neu Anzeige
            </a>
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
                        'fahrzeuge' => '/storage/images/cars.jpg',
                        'fahrzeugeteile' => '/storage/images/parts.jpg',
                        'boote' => '/storage/images/boats.jpg',
                        'elektronik' => '/storage/images/tv.jpg',
                        'haushalt' => '/storage/images/car.jpg',
                        'immobilien' => '/storage/images/car.jpg',
                        'dienstleistungen' => '/storage/images/car.jpg',
                        'sonstiges' => '/storage/images/car.jpg',
                        // Add more mappings for your other categories
                    ];
                @endphp

                @forelse ($adsByCategory as $categorySlug => $ads)
                    @if ($ads->isNotEmpty())
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
                            <div class="bg-white dark:bg-white p-6 rounded-b-lg"> {{-- Content below the navbar --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                    @foreach ($ads as $ad)
                                        <div
                                            class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                            @php
                                                $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image';
                                                if (!empty($ad->images) && is_array($ad->images) && count($ad->images) > 0) {
                                                    $imageUrl = asset('storage/' . $ad->images[0]);
                                                } elseif (!empty($ad->images) && is_string($ad->images)) {
                                                    $imageUrl = asset('storage/' . $ad->images);
                                                } elseif ($ad instanceof \App\Models\RealEstate) {
                                                    if (!empty($ad->grundriss_path)) {
                                                        $imageUrl = asset('storage/' . $ad->grundriss_path);
                                                    } elseif (!empty($ad->energieausweis_path)) {
                                                        $imageUrl = asset('storage/' . $ad->energieausweis_path);
                                                    }
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $ad->title ?? 'Anzeige' }}"
                                                class="w-full h-40 object-cover rounded-t-lg">
                                            <div class="p-4">
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

                                                        if ($ad instanceof \App\Models\Vehicle) {
                                                            $adRouteName = 'categories.fahrzeuge.show';
                                                            $adParamName = 'vehicle';
                                                        } elseif ($ad instanceof \App\Models\Boat) {
                                                            $adRouteName = 'categories.boote.show';
                                                            $adParamName = 'boat';
                                                        } elseif ($ad instanceof \App\Models\Camper) {
                                                            $adRouteName = 'categories.camper.show';
                                                            $adParamName = 'camper';
                                                        } elseif ($ad instanceof \App\Models\CommercialVehicle) {
                                                            $adRouteName = 'categories.commercial-vehicles.show';
                                                            $adParamName = 'commercial_vehicle';
                                                        } elseif ($ad instanceof \App\Models\Electronic) {
                                                            $adRouteName = 'categories.elektronik.show';
                                                            $adParamName = 'electronic';
                                                        } elseif ($ad instanceof \App\Models\HouseholdItem) {
                                                            $adRouteName = 'categories.haushalt.show';
                                                            $adParamName = 'householdItem'; 
                                                        } elseif ($ad instanceof \App\Models\MotorradAd) {
                                                            $adRouteName = 'categories.motorrad.show';
                                                            $adParamName = 'motorrad_ad';
                                                        } elseif ($ad instanceof \App\Models\Other) {
                                                            $adRouteName = 'categories.others.show';
                                                            $adParamName = 'other';
                                                        } elseif ($ad instanceof \App\Models\RealEstate) {
                                                            $adRouteName = 'categories.immobilien.show';
                                                            $adParamName = 'real_estate';
                                                        } elseif ($ad instanceof \App\Models\Service) {
                                                            $adRouteName = 'categories.dienstleistungen.show';
                                                            $adParamName = 'service';
                                                        } elseif ($ad instanceof \App\Models\UsedVehiclePart) {
                                                            $adRouteName = 'categories.used-vehicle-parts.show';
                                                            $adParamName = 'used_vehicle_part';
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