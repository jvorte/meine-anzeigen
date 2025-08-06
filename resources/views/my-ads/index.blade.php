<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Meine Anzeigen</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">
        @php
            $sections = [
                ['title' => 'Fahrzeuge', 'items' => $carAds, 'route' => 'ads.cars.show'],
                ['title' => 'Immobilien', 'items' => $realEstates, 'route' => 'ads.realestates.show'],
                ['title' => 'Dienstleistungen', 'items' => $services, 'route' => 'ads.services.show'],
                // Πρόσθεσε κι άλλες ενότητες αν χρειάζεται
            ];
        @endphp

        {{-- Grid 2 στηλών για τις κατηγορίες --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($sections as $section)
                <div>
                    <h3 class="text-1xl font-semibold text-gray-800 mb-4 border-b pb-1">{{ $section['title'] }}</h3>

                    @if($section['items']->count())
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
                    @else
                        <p class="text-gray-500 italic">Keine {{ $section['title'] }} Anzeigen vorhanden.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
