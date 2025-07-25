<x-app-layout>
  {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
         Autos Anzeigen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'Autos Anzeigen', 'url' => route('ads.create')],
        // ['label' => 'Neue Auto Anzeige', 'url' => route('ads.create')],
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
                    if ($category->slug == 'fahrzeuge') {
                        $ads = \App\Models\Vehicle::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'boote') {
                        $ads = \App\Models\Boat::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'fahrzeugeteile') {
                        $ads = \App\Models\Part::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'elektronik') {
                        $ads = \App\Models\Electronic::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'haushalt') {
                        $ads = \App\Models\HouseholdItem::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'immobilien') {
                        $ads = \App\Models\RealEstate::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'dienstleistungen') {
                        $ads = \App\Models\Service::orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'sonstiges') {
                        $ads = \App\Models\Other::orderBy('created_at', 'desc')->paginate(12);
                    }elseif ($category->slug == 'motorrad') { // Using 'motorrad' as per your INSERT
    $ads = \App\Models\Motorcycle::orderBy('created_at', 'desc')->paginate(12); // Adjust 'Motorcycle' to your actual model name
} elseif ($category->slug == 'nutzfahrzeuge') {
    $ads = \App\Models\CommercialVehicle::orderBy('created_at', 'desc')->paginate(12); // Adjust 'CommercialVehicle'
} elseif ($category->slug == 'wohnmobile') {
    $ads = \App\Models\RV::orderBy('created_at', 'desc')->paginate(12); // Adjust 'RV' or 'Camper'
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

                            // Check if the 'images' relationship is loaded and contains images
                            if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
                                // Option 1: Try to find an image marked as a thumbnail first
                                $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);

                                if ($thumbnailImage) {
                                    $imageUrl = asset('storage/' . $thumbnailImage->path);
                                } else {
                                    // Option 2: If no thumbnail, just use the first available image
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
                                            if ($category->slug == 'fahrzeuge') {
                                                $detailRoute = route('categories.fahrzeuge.show', $ad);
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