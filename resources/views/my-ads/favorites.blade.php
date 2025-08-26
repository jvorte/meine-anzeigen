<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">
            {{ __('Meine Favoriten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($favorites->isEmpty())
                <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-700">
                    {{ __('Noch keine Favoriten hinzugefügt.') }}
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($favorites as $favorite)
                        @php
                            $ad = $favorite->favoriteable;
                            $routeMap = [
                                'car' => 'cars',
                                'boat' => 'boats',
                                'usedvehiclepart' => 'vehicles-parts',
                                'electronic' => 'electronics',
                                'householditem' => 'household',
                                'realestate' => 'real-estate',
                                'service' => 'services',
                                'other' => 'others',
                                'motorradad' => 'motorrads',
                                'commercialvehicle' => 'commercial-vehicles',
                                'camper' => 'campers',
                            ];
                            $modelName = strtolower(class_basename($ad));
                            $routeBaseName = $routeMap[$modelName] ?? '';
                        @endphp

                        @if ($ad)
                            <div class="relative group bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                
                                {{-- Image with zoom effect --}}
                                @if($ad->images->first())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                        {{ __('Kein Bild') }}
                                    </div>
                                @endif

                                {{-- Overlay on hover --}}
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('categories.' . $routeBaseName . '.show', $ad) }}" 
                                       class="mb-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-medium">
                                        {{ __('Anzeige ansehen') }}
                                    </a>
                                    <form action="{{ route('ads.' . $routeBaseName . '.favorite', $ad) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 font-medium">
                                            {{ __('Aus Favoriten entfernen') }}
                                        </button>
                                    </form>
                                </div>

                                {{-- Info below image --}}
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-900 truncate">{{ $ad->title }}</h3>
                                    <p class="text-gray-600 mt-1 line-clamp-3">{{ $ad->description }}</p>
                                    <p class="mt-2 text-xl font-semibold text-green-600">€{{ number_format($ad->price, 2) }}</p>
                                </div>

                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
