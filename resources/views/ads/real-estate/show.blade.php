{{-- resources/views/ads/real-estate/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ $realEstate->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-3xl font-bold mb-4">{{ $realEstate->title }}</h3>

                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $realEstate->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-semibold">Preis:</p>
                        <p>{{ $realEstate->price ?? 'N/A' }} €</p>
                    </div>
                    <div>
                        <p class="font-semibold">Immobilientyp:</p>
                        <p>{{ $realEstate->property_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Adresse:</p>
                        <p>{{ $realEstate->address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Wohnfläche:</p>
                        <p>{{ $realEstate->area_sqm ?? 'N/A' }} m²</p>
                    </div>
                    <div>
                        <p class="font-semibold">Anzahl Zimmer:</p>
                        <p>{{ $realEstate->num_rooms ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Baujahr:</p>
                        <p>{{ $realEstate->year_built ?? 'N/A' }}</p>
                    </div>
                    {{-- Add more real estate-specific details here based on your table --}}
                </div>

                {{-- Example for displaying images if you have a relationship --}}
                {{-- Make sure you have an 'images' relationship defined in your RealEstate model --}}
                @if (isset($realEstate->images) && $realEstate->images->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold mb-3">Bilder</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($realEstate->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Immobilienbild" class="w-full h-48 object-cover rounded-lg shadow-md">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline dark:text-blue-400">Zurück zur Suche</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>