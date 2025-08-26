<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900">
            {{ __('my_ads') }}
        </h2>
        <p class="mt-2 text-gray-600 dark:text-gray-700">{{ __('my_ads_intro') }}</p>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-100 shadow-xl rounded-2xl p-6">
                @php
                // Combine all ad collections into a single, flat array
                $allAds = collect($carAds)
                ->concat($boats)
                ->concat($electronicAds)
                ->concat($householdAds)
                ->concat($realEstates)
                ->concat($services)
                ->concat($others)
                ->concat($motorcycles)
                ->concat($commercialVehicles)
                ->concat($campers)
                ->concat($usedVehicleParts);

                // Create a mapping of models to their correct routes
                $routeMap = [
                'Car' => 'categories.cars.show',
                'Boat' => 'categories.boats.show',
                'Electronic' => 'categories.electronics.show',
                'HouseholdItem' => 'categories.household.show',
                'RealEstate' => 'categories.real-estate.show',
                'Service' => 'categories.services.show',
                'Other' => 'categories.others.show',
                'MotorradAd' => 'categories.motorrads.show',
                'CommercialVehicle' => 'categories.commercial-vehicles.show',
                'Camper' => 'categories.campers.show',
                'UsedVehiclePart' => 'categories.vehicles-parts.show',
                ];

                // Add a mapping for image path column names
                $imagePathMap = [
                    'Car' => 'path',
                    'Boat' => 'path',
                    'Electronic' => 'image_path',
                    'HouseholdItem' => 'path',
                    'RealEstate' => 'image_path', // Corrected
                    'Service' => 'path',
                    'Other' => 'path',
                    'MotorradAd' => 'path',
                    'CommercialVehicle' => 'path',
                    'Camper' => 'path',
                    'UsedVehiclePart' => 'path',
                ];
                @endphp

                @if ($allAds->isEmpty())
                <div class="flex flex-col items-center justify-center py-10">
                    <svg class="w-20 h-20 text-gray-400 dark:text-gray-600 mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM5 10a1 1 0 112 0 1 1 0 01-2 0zm3-3a1 1 0 100 2 1 1 0 000-2zm4 0a1 1 0 100 2 1 1 0 000-2zm3 3a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-lg text-gray-600 dark:text-gray-400 font-medium">{{ __('Noch keine Anzeigen hinzugefügt.') }}</p>
                </div>
                @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($allAds as $ad)
                    @php
                    $modelName = class_basename($ad);
                    $route = $routeMap[$modelName] ?? null;
                    $imagePathColumn = $imagePathMap[$modelName] ?? 'path'; // Get the correct column name
                    @endphp

                    @if ($route)
                    <a href="{{ route($route, $ad->id) }}"
                        class="group block bg-white rounded-2xl shadow hover:shadow-lg transition transform hover:-translate-y-1">

                        {{-- Image --}}
                        <div class="h-48 w-full bg-gray-200 rounded-t-2xl overflow-hidden">
                            @if (!empty($ad->images) && count($ad->images) > 0)
                            {{-- Use the dynamic column name --}}
                            <img src="{{ asset('storage/' . $ad->images[0]->$imagePathColumn) }}"
                                alt="{{ $ad->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-900 truncate">
                                {{ $ad->title }}
                            </h4>
                            <p class="text-sm text-gray-600 line-clamp-2 mt-1">
                                {{ $ad->description }}
                            </p>

                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $ad->created_at->diffForHumans() }}
                                </span>
                                <span class="text-lg font-semibold text-green-600">
                                    {{ $ad->price ? number_format($ad->price, 2, ',', '.') . ' €' : __('price_on_request') }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>