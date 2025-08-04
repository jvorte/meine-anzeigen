<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Meine Anzeigen</h2>
    </x-slot>

    <div class="py-6 px-4 space-y-10">

        {{-- Fahrzeuge --}}
        <div>
            <h3 class="text-lg font-bold mb-2">Fahrzeuge</h3>
            @if($carAds->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($carAds as $car)
                        <a href="{{ route('ads.cars.show', $car->id) }}" class="block p-4 border rounded shadow-sm bg-white hover:bg-gray-50 transition">
                            <h4 class="font-bold text-gray-800">{{ $car->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $car->price }} €</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Keine Fahrzeuge Anzeigen.</p>
            @endif
        </div>

        {{-- Elektronik --}}
        {{-- <div>
            <h3 class="text-lg font-bold mb-2">Elektronik</h3>
            @if($electronicAds->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($electronicAds as $ad)
                        <a href="{{ route('ads.electronics.show', $ad->id) }}" class="block p-4 border rounded shadow-sm bg-white hover:bg-gray-50 transition">
                            <h4 class="font-bold text-gray-800">{{ $ad->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $ad->price }} €</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Keine Elektronik Anzeigen.</p>
            @endif
        </div> --}}

        {{-- Immobilien --}}
        <div>
            <h3 class="text-lg font-bold mb-2">Immobilien</h3>
            @if($realEstates->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($realEstates as $ad)
                        <a href="{{ route('ads.realestates.show', $ad->id) }}" class="block p-4 border rounded shadow-sm bg-white hover:bg-gray-50 transition">
                            <h4 class="font-bold text-gray-800">{{ $ad->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $ad->price }} €</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Keine Immobilien Anzeigen.</p>
            @endif
        </div>

        {{-- Dienstleistungen --}}
        <div>
            <h3 class="text-lg font-bold mb-2">Dienstleistungen</h3>
            @if($services->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $ad)
                        <a href="{{ route('ads.services.show', $ad->id) }}" class="block p-4 border rounded shadow-sm bg-white hover:bg-gray-50 transition">
                            <h4 class="font-bold text-gray-800">{{ $ad->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $ad->price ?? '-' }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Keine Dienstleistungen Anzeigen.</p>
            @endif
        </div>

    </div>
</x-app-layout>
