<x-app-layout>

    {{-- Header Section --}}
    <x-slot name="header">
   
              <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        {{  __('new_ad') }}
                    </span>
                </a>
            </div>
    </x-slot>

    {{-- Main Content --}}
    <div class="py-2 bg-white  min-h-screen  ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-100 overflow-hidden shadow-xl sm:rounded-2xl p-6 md:p-8">
                <div class="mb-10 text-center">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-black">
                        {{ __('latest_ads_by_category') }}
                    </h2>
                    <p class="text-lg text-gray-500 dark:text-gray-600 mt-2 italic">
                        {{ __('discover_latest_offers') }}
                    </p>
                </div>

                @php
                    $categoryBackgrounds = [
                        'cars' => asset('storage/images/cars.jpg'),
                        'vehicles-parts' => asset('storage/images/parts.jpg'),
                        'boats' => asset('storage/images/boats.jpg'),
                        'electronics' => asset('storage/images/tv.jpg'),
                        'household' => asset('storage/images/real-estate.jpg'),
                        'real-estate' => asset('storage/images/real-estate.jpg'),
                        'services' => asset('storage/images/store.jpg'),
                        'others' => asset('storage/images/room.jpg'),
                        'motorrads' => asset('storage/images/motorcycle.jpg'),
                        'commercial-vehicles' => asset('storage/images/trucks.jpg'),
                        'campers' => asset('storage/images/camper.jpg'),
                    ];
                @endphp

                <div class="space-y-12">
                    @forelse ($adsByCategory as $categorySlug => $ads)
                        @if ($ads->isNotEmpty())
                            @php
                                $categoryName = $categories->firstWhere('slug', $categorySlug)->name ?? ucfirst(str_replace('-', ' ', $categorySlug));
                                $backgroundImage = $categoryBackgrounds[$categorySlug] ?? 'https://placehold.co/1200x200/374151/FFFFFF?text=Explore';
                            @endphp

                            <section class="rounded-xl shadow-lg overflow-hidden">
                                <div class="relative h-12 bg-cover bg-center flex items-center p-6" style="background-image: url('{{ $backgroundImage }}');">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-black/20"></div>
                                    <div class="relative z-10 flex items-center justify-between w-full">
                                        <h3 class="text-3xl font-bold text-white capitalize">{{ $categoryName }}</h3>
                                        <a href="{{ route('categories.' . $categorySlug . '.index') }}"
                                           class="hidden sm:inline-flex items-center gap-2 text-white bg-white/20 hover:bg-white/30 backdrop-blur-sm font-semibold py-2 px-4 rounded-lg transition-colors duration-300">
                                            {{ __('view_all') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                <div class="p-2 md:p-2">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-5 gap-4">
                                        @foreach ($ads as $ad)
                                            @php
                                                $adRouteName = 'ads.show';
                                                $adParamName = 'ad';
                                                $routeParam = $ad;

                                                if ($ad instanceof \App\Models\Car) { $adRouteName = 'categories.cars.show'; $adParamName = 'car'; }
                                                elseif ($ad instanceof \App\Models\Boat) { $adRouteName = 'categories.boats.show'; $adParamName = 'boat'; }
                                                elseif ($ad instanceof \App\Models\Camper) { $adRouteName = 'categories.campers.show'; $adParamName = 'camper'; }
                                                elseif ($ad instanceof \App\Models\CommercialVehicle) { $adRouteName = 'categories.commercial-vehicles.show'; $adParamName = 'commercialVehicle'; }
                                                elseif ($ad instanceof \App\Models\Electronic) { $adRouteName = 'categories.electronics.show'; $adParamName = 'electronic'; }
                                                elseif ($ad instanceof \App\Models\HouseholdItem) { $adRouteName = 'categories.household.show'; $adParamName = 'householdItem'; }
                                                elseif ($ad instanceof \App\Models\MotorradAd) { $adRouteName = 'categories.motorrads.show'; $adParamName = 'motorrad'; }
                                                elseif ($ad instanceof \App\Models\Other) { $adRouteName = 'categories.others.show'; $adParamName = 'other'; }
                                                elseif ($ad instanceof \App\Models\RealEstate) { $adRouteName = 'categories.real-estate.show'; $adParamName = 'realEstate'; }
                                                elseif ($ad instanceof \App\Models\Service) { $adRouteName = 'categories.services.show'; $adParamName = 'service'; }
                                                elseif ($ad instanceof \App\Models\UsedVehiclePart) { $adRouteName = 'categories.vehicles-parts.show'; $adParamName = 'usedVehiclePart'; }

                                                $imageUrl = 'https://placehold.co/400x300/E2E8F0/4A5568?text=No+Image';
                                                if ($ad->images && $ad->images->isNotEmpty()) {
                                                    $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);
                                                    if ($thumbnailImage && $thumbnailImage->image_path) {
                                                        $imageUrl = asset('storage/' . $thumbnailImage->image_path);
                                                    } else if ($ad->images->first() && $ad->images->first()->image_path) {
                                                        $imageUrl = asset('storage/' . $ad->images->first()->image_path);
                                                    }
                                                }
                                            @endphp

                                            <a href="{{ $adRouteName ? route($adRouteName, [$adParamName => $routeParam]) : '#' }}"
                                               class="group block bg-white dark:bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                                                <div class="relative">
                                                    <img src="{{ $imageUrl }}" alt="{{ $ad->title ?? 'Ad' }}"
                                                         class="w-full h-36 object-cover"
                                                         onerror="this.onerror=null;this.src='https://placehold.co/400x300/E2E8F0/4A5568?text=Error';">
                                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                </div>

                                                <div class="p-2 md:p-3">
                                                    <h4 class="text-xl font-bold text-gray-900 mb-1 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                        {{ $ad->title }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-900 mb-1 line-clamp-2">
                                                        {{ $ad->description }}
                                                    </p>

                                                    <div class="mb-2">
                                                        @if (isset($ad->price) && $ad->price !== null)
                                                            <p class="text-lg font-extrabold text-blue-600 dark:text-blue-400">
                                                                {{ number_format($ad->price, 2, ',', '.') }} €
                                                            </p>
                                                        @elseif (isset($ad->price_from) && $ad->price_from !== null)
                                                            <p class="text-lg font-extrabold text-blue-600 dark:text-blue-400">
                                                                {{ number_format($ad->price_from, 2, ',', '.') }} €
                                                            </p>
                                                        @elseif (isset($ad->gesamtmiete) && $ad->gesamtmiete !== null)
                                                            <p class="text-lg font-extrabold text-blue-600 dark:text-blue-400">
                                                                {{ number_format($ad->gesamtmiete, 2, ',', '.') }} €
                                                            </p>
                                                        @else
                                                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                                {{ __('on_request') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="border-t dark:border-gray-600 pt-2 flex flex-col space-y-1 text-xs text-gray-500 dark:text-gray-400">
                                                        <div class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            <span>{{ $ad->ort ?? $ad->region ?? __('location_unknown') }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                    @empty
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-xl font-medium text-gray-900 dark:text-white">
                                {{ __('no_ads_yet') }}
                            </h3>
                            <p class="mt-1 text-md text-gray-500 dark:text-gray-400">
                                {{ __('no_ads_available') }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
