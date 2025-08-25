<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">
            {{ __('Meine Favoriten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($favorites->isEmpty())
                        <p>{{ __('Noch keine Favoriten hinzugefügt.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($favorites as $favorite)
                                @php
                                    // Get the specific ad model instance (e.g., Boat, Car, etc.)
                                    $ad = $favorite->favoriteable;

                                    // Create a mapping of model names to their correct plural route names.
                                    // This is the correct, permanent solution to your naming inconsistencies.
                                    $routeMap = [
                                        'car' => 'cars',
                                        'boat' => 'boats',
                                        'usedvehiclepart' => 'vehicles-parts',
                                        'electronic' => 'electronics',
                                        'householditem' => 'household', // The singular is correct for this route
                                        'realestate' => 'real-estate',
                                        'service' => 'services',
                                        'other' => 'others',
                                        'motorradad' => 'motorrads',
                                        'commercialvehicle' => 'commercial-vehicles',
                                        'camper' => 'campers',
                                    ];

                                    // Get the base name from the model's class name
                                    $modelName = strtolower(class_basename($ad));
                                    $routeBaseName = $routeMap[$modelName] ?? '';
                                @endphp

                                @if ($ad)
                                    <div class="border p-4 rounded-lg">
                                        <h3 class="font-bold text-lg">{{ $ad->title }}</h3>
                                        <p class="text-gray-600">{{ $ad->description }}</p>
                                        <p class="mt-2 text-xl font-semibold text-green-600">€{{ number_format($ad->price, 2) }}</p>

                                        {{-- Use the correct route names from the map --}}
                                        <a href="{{ route('categories.' . $routeBaseName . '.show', $ad) }}" class="mt-4 inline-block text-blue-500 hover:underline">
                                            {{ __('Anzeige ansehen') }}
                                        </a>

                                        {{-- Use the correct route names from the map for the form action --}}
                                        <form action="{{ route('ads.' . $routeBaseName . '.favorite', $ad) }}" method="POST" class="mt-2">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                {{ __('Aus Favoriten entfernen') }}
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
