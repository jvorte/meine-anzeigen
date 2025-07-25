<x-app-layout>
    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
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
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
         {{ $category->name }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
          
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')], // A more general link for 'All Ads'
                ['label' => $category->name, 'url' => route('categories.show', $category->slug)], // Current category
            ]" />
        </div>
    </div>

{{-- ------------------------------------------------------------------------------------- --}}


    <div class="py-5 bg-gray-50 dark:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-700">Alle {{ $category->name }} Anzeigen</h3>
                    <p class="text-lg text-gray-700 dark:text-gray-800">
                        Hier findest du alle verfügbaren Anzeigen in der Kategorie {{ $category->name }}.
                    </p>
                </div>

                {{-- Conditional rendering based on the category slug --}}
                @php
                    $ads = collect(); // Initialize an empty collection

                    // --- IMPORTANT CHANGES HERE ---
                    // 1. Changed 'fahrzeuge' to 'cars' for the slug.
                    // 2. Changed \App\Models\Vehicle::class to \App\Models\Car::class.
                    // 3. Added ->with('images') to eager load images for all models,
                    //    as the loop later accesses $ad->images.
                    if ($category->slug == 'cars') { // Changed from 'fahrzeuge'
                        $ads = \App\Models\Car::with('images')->orderBy('created_at', 'desc')->paginate(12); // Changed from Vehicle
                    } elseif ($category->slug == 'boote') {
                        $ads = \App\Models\Boat::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'fahrzeugeteile') {
                        // Assuming Part is for generic parts, UsedVehiclePart is for specific "used vehicle parts"
                        // Based on your imports in DashboardController, UsedVehiclePart was explicitly used for 'fahrzeugeteile'
                        $ads = \App\Models\UsedVehiclePart::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'elektronik') {
                        $ads = \App\Models\Electronic::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'haushalt') {
                        $ads = \App\Models\HouseholdItem::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'immobilien') {
                        $ads = \App\Models\RealEstate::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'dienstleistungen') {
                        $ads = \App\Models\Service::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'sonstiges') {
                        $ads = \App\Models\Other::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'motorrad') {
                        // Changed from Motorcycle to MotorradAd as per your controller imports
                        $ads = \App\Models\MotorradAd::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'nutzfahrzeuge') {
                        $ads = \App\Models\CommercialVehicle::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'wohnmobile') {
                        // Changed from RV to Camper as per your controller imports
                        $ads = \App\Models\Camper::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    }
                @endphp

                @if ($ads->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center text-lg py-10">Es sind noch keine Anzeigen in dieser Kategorie verfügbar.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach ($ads as $ad)
                            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                @php
                                    $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image'; // Default placeholder

                                    if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
                                        $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);

                                        if ($thumbnailImage) {
                                            $imageUrl = asset('storage/' . $thumbnailImage->path);
                                        } else {
                                            $imageUrl = asset('storage/' . $ad->images->first()->path);
                                        }
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $ad->title ?? 'Anzeige' }}"
                                    class="w-full h-40 object-cover rounded-t-lg">
                                <div class="p-4">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-900 mb-1 truncate">{{ $ad->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-700 mb-2 line-clamp-2">{{ $ad->description }}</p>
                                    @if (isset($ad->price) && $ad->price !== null)
                                        <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->price, 2, ',', '.') }} €</p>
                                    @elseif (isset($ad->price_from) && $ad->price_from !== null)
                                        <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->price_from, 2, ',', '.') }} €</p>
                                    @elseif (isset($ad->gesamtmiete) && $ad->gesamtmiete !== null)
                                        <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->gesamtmiete, 2, ',', '.') }} €</p>
                                    @else
                                        <p class="text-base text-gray-500 dark:text-gray-600 mb-2">Preis auf Anfrage</p>
                                    @endif

                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>{{ $ad->ort ?? $ad->location ?? $ad->region ?? 'Unbekannter Ort' }}</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-4">
                                        {{-- Dynamic route for ad details based on category slug --}}
                                        @php
                                            $detailRoute = '#'; // Default fallback
                                            if ($category->slug == 'cars') { // Changed from 'fahrzeuge'
                                                $detailRoute = route('categories.cars.show', $ad); // Changed from 'fahrzeuge'
                                            } elseif ($category->slug == 'boote') {
                                                $detailRoute = route('categories.boote.show', $ad);
                                            } elseif ($category->slug == 'fahrzeugeteile') {
                                                $detailRoute = route('categories.fahrzeugeteile.show', $ad);
                                            } elseif ($category->slug == 'elektronik') {
                                                $detailRoute = route('categories.elektronik.show', $ad);
                                            } elseif ($category->slug == 'haushalt') {
                                                $detailRoute = route('categories.haushalt.show', $ad);
                                            } elseif ($category->slug == 'immobilien') {
                                                $detailRoute = route('categories.immobilien.show', $ad);
                                            } elseif ($category->slug == 'dienstleistungen') {
                                                $detailRoute = route('categories.dienstleistungen.show', $ad);
                                            } elseif ($category->slug == 'sonstiges') {
                                                $detailRoute = route('categories.sonstiges.show', $ad);
                                            } elseif ($category->slug == 'motorrad') {
                                                $detailRoute = route('categories.motorrad.show', $ad);
                                            } elseif ($category->slug == 'nutzfahrzeuge') {
                                                $detailRoute = route('categories.nutzfahrzeuge.show', $ad);
                                            } elseif ($category->slug == 'wohnmobile') {
                                                $detailRoute = route('categories.wohnmobile.show', $ad);
                                            }
                                        @endphp
                                        <a href="{{ $detailRoute }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-sm hover:shadow-md">Details ansehen</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Pagination Links --}}
                    <div class="mt-8">
                        {{ $ads->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>