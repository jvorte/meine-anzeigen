{{-- resources/views/ads/boats/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ $boat->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-3xl font-bold mb-4">{{ $boat->title }}</h3>

                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $boat->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-semibold">Preis:</p>
                        <p>{{ $boat->price ?? 'N/A' }} €</p>
                    </div>
                    <div>
                        <p class="font-semibold">Marke:</p>
                        <p>{{ $boat->brand ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Baujahr:</p>
                        <p>{{ $boat->year ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Länge:</p>
                        <p>{{ $boat->length ?? 'N/A' }} Meter</p>
                    </div>
                    <div>
                        <p class="font-semibold">Motor:</p>
                        <p>{{ $boat->engine_type ?? 'N/A' }}</p>
                    </div>
                    {{-- Add more boat-specific details here based on your 'boats' table columns --}}
                </div>

                {{-- Example for displaying images if you have a relationship --}}
                {{-- Make sure you have an 'images' relationship defined in your Boat model --}}
                @if (isset($boat->images) && $boat->images->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold mb-3">Bilder</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($boat->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Bootsbild" class="w-full h-48 object-cover rounded-lg shadow-md">
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