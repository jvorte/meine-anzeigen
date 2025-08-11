<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">My Ads</h2>
        <p>Connect the dots for reviewers by linking PRs to related tickets and retrieving</p>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">
        @php
        $sections = [
        ['title' => 'Cars', 'items' => $carAds, 'route' => 'ads.cars.show'],
        ['title' => 'Boats', 'items' => $boats, 'route' => 'ads.boats.show'],
        ['title' => 'Electronics', 'items' => $electronicAds, 'route' => 'ads.electronics.show'],
        ['title' => 'Household', 'items' => $householdAds, 'route' => 'ads.household.show'],
        ['title' => 'Real Estate', 'items' => $realEstates, 'route' => 'ads.real-estate.show'],
        ['title' => 'Services', 'items' => $services, 'route' => 'ads.services.show'],
        ['title' => 'Others', 'items' => $others, 'route' => 'ads.others.show'],
        ['title' => 'Motorcycles', 'items' => $motorcycles, 'route' => 'ads.motorcycles.show'],
        ['title' => 'Commercial Vehicles', 'items' => $commercialVehicles, 'route' => 'ads.commercial-vehicles.show'],
        ['title' => 'Campers', 'items' => $campers, 'route' => 'ads.campers.show'],
        ['title' => 'Used Vehicle Parts', 'items' => $usedVehicleParts, 'route' => 'ads.used-vehicle-parts.show'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-400 p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
                @foreach($sections as $section)
                @if($section['items']->count())
                <div>
                    <h3 class="text-1xl font-semibold text-gray-800 mb-4 border-b pb-1">{{ $section['title'] }}</h3>

                    <div class="space-y-4">
                        @foreach($section['items'] as $ad)
                        <a href="{{ route($section['route'], $ad->id) }}"
                            class="block border rounded-lg overflow-hidden shadow-sm hover:shadow-md bg-white transition transform hover:scale-[1.01]">
                            <div class="p-4">
                                <h4 class="text-lg font-bold text-gray-900 truncate mb-1">
                                    {{ $ad->title }}
                                </h4>
                                <p class="text-sm text-gray-600 mb-1">
                                    {{ $ad->price ? number_format($ad->price, 2, ',', '.') . ' €' : 'Preis auf Anfrage' }}
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