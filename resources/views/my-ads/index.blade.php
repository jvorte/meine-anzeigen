<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">
            {{ __('my_ads') }}
        </h2>
        <p>{{ __('my_ads_intro') }}</p>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">
        @php
        $sections = [
            ['title' => 'cars', 'items' => $carAds, 'route' => 'ads.cars.show'],
            ['title' => 'boats', 'items' => $boats, 'route' => 'ads.boats.show'],
            ['title' => 'electronics', 'items' => $electronicAds, 'route' => 'ads.electronics.show'],
            ['title' => 'household', 'items' => $householdAds, 'route' => 'ads.household.show'],
            ['title' => 'real_estate', 'items' => $realEstates, 'route' => 'ads.real-estate.show'],
            ['title' => 'services', 'items' => $services, 'route' => 'ads.services.show'],
            ['title' => 'others', 'items' => $others, 'route' => 'ads.others.show'],
            ['title' => 'motorcycles', 'items' => $motorcycles, 'route' => 'ads.motorcycles.show'],
            ['title' => 'commercial_vehicles', 'items' => $commercialVehicles, 'route' => 'ads.commercial-vehicles.show'],
            ['title' => 'campers', 'items' => $campers, 'route' => 'ads.campers.show'],
            ['title' => 'used_vehicle_parts', 'items' => $usedVehicleParts, 'route' => 'ads.used-vehicle-parts.show'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-800 p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($sections as $section)
                    @if($section['items']->count())
                        <div>
                            <h3 class="text-1xl font-semibold text-gray-100 mb-4 border-b pb-1">
                                {{ __('sections.' . $section['title']) }}
                            </h3>

                            <div class="space-y-4">
                                @foreach($section['items'] as $ad)
                                    <a href="{{ route($section['route'], $ad->id) }}"
                                        class="block border rounded-lg overflow-hidden shadow-sm hover:shadow-md bg-white transition transform hover:scale-[1.01]">
                                        <div class="p-4">
                                            <h4 class="text-lg font-bold text-gray-900 truncate mb-1">
                                                {{ $ad->title }}
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-1">
                                                {{ $ad->price ? number_format($ad->price, 2, ',', '.') . ' €' : __('price_on_request') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $ad->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
