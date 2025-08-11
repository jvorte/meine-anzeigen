<x-app-layout>
  <x-slot name="header">
    <div class="px-4 py-1 md:py-1 flex justify-end items-center">
        <a href="{{ route('ads.create') }}" class="c-button">
            <span class="c-main">
                <span class="c-ico">
                    <span class="c-blur"></span>
                    <span class="ico-text">+</span>
                </span>
                New Add
            </span>
        </a>
    </div>
        <div class="py-1">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
                {{-- Breadcrumbs component --}}
                <x-breadcrumbs :items="[
                    ['label' => __('Home'), 'url' => route('dashboard')],
                    ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                    ['label' => $category->name, 'url' => route('categories.show', $category->slug)],
                ]" />
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            {{ $category->name }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-5 bg-gray-50 dark:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-700">Alle {{ $category->name }} Anzeigen</h3>
                    <p class="text-lg text-gray-700 dark:text-gray-800">
                        Hier findest du alle verfügbaren Anzeigen in der Kategorie {{ $category->name }}.
                    </p>
                </div>

                @php
                    $ads = collect(); // Initialize an empty collection

                    if ($category->slug == 'cars') {
                        $ads = \App\Models\Car::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'boats') {
                        $ads = \App\Models\Boat::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'vehicles-parts') {
                        $ads = \App\Models\UsedVehiclePart::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'electronics') {
                        $ads = \App\Models\Electronic::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'household') {
                        $ads = \App\Models\HouseholdItem::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'real-estate') {
                        $ads = \App\Models\RealEstate::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'services') {
                        $ads = \App\Models\Service::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'others') {
                        $ads = \App\Models\Other::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'motorcycles') { 
                        $ads = \App\Models\MotorradAd::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'commercial-vehicle') { 
                        // Corrected slug for Commercial Vehicles
                        $ads = \App\Models\CommercialVehicle::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    } elseif ($category->slug == 'campers') { 
                        $ads = \App\Models\Camper::with('images')->orderBy('created_at', 'desc')->paginate(12);
                    }
                @endphp

                @if ($ads->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center text-lg py-10">Es sind noch keine Anzeigen in dieser Kategorie verfügbar.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
                        @foreach ($ads as $ad)
                            @php
                                // Define $detailRoute ONCE here for the current ad
                                $detailRoute = '#'; // Default fallback
                                if ($category->slug == 'cars') {
                                    $detailRoute = route('categories.cars.show', $ad);
                                } elseif ($category->slug == 'boats') {
                                    $detailRoute = route('categories.boats.show', $ad);
                                } elseif ($category->slug == 'vehicles-parts') {
                                    $detailRoute = route('categories.vehicles-parts.show', $ad);
                                } elseif ($category->slug == 'electronics') {
                                    $detailRoute = route('categories.electronics.show', $ad);
                                } elseif ($category->slug == 'household') {
                                    $detailRoute = route('categories.household.show', $ad);
                                } elseif ($category->slug == 'real-estate') {
                                    $detailRoute = route('categories.real-estate.show', $ad);
                                } elseif ($category->slug == 'services') {
                                    $detailRoute = route('categories.services.show', $ad);
                                } elseif ($category->slug == 'others') {
                                    $detailRoute = route('categories.others.show', $ad);
                                } elseif ($category->slug == 'motorcycles') {
                                    $detailRoute = route('categories.motorcycles.show', $ad);
                                } elseif ($category->slug == 'commercial-vehicle') { 
                                    // Consistent slug for Commercial Vehicles
                                    $detailRoute = route('categories.commercial-vehicle.show', $ad);
                                } elseif ($category->slug == 'campers') {
                                    $detailRoute = route('categories.campers.show', $ad);
                                }

                                // --- Image logic from previous solution, now placed correctly and once per ad ---
                                $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image'; // Default placeholder

                                if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
                                    $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);

                                    if ($thumbnailImage && $thumbnailImage->image_path) {
                                        $imageUrl = asset('storage/' . $thumbnailImage->image_path);
                                    } else if ($ad->images->first() && $ad->images->first()->image_path) {
                                        $imageUrl = asset('storage/' . $ad->images->first()->image_path);
                                    }
                                } elseif (isset($ad->image_path) && !empty($ad->image_path)) {
                                    // Fallback for models that might just have a single image_path directly
                                    $imageUrl = asset('storage/' . $ad->image_path);
                                }
                            @endphp

                            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                {{-- The entire card content is now wrapped in the <a> tag --}}
                                <a href="{{ $detailRoute }}" class="block">
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
                                            <span>{{ $ad->location ?? $ad->location ?? $ad->region ?? 'Unbekannter Ort' }}</span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a> {{-- End of the <a> tag --}}
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