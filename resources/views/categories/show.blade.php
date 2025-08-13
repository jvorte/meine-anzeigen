<x-app-layout>
    <x-slot name="header">
        <div class="px-4 py-1 md:py-1 flex justify-end items-center">
            <a href="{{ route('ads.create') }}" class="c-button">
                <span class="c-main">
                    <span class="c-ico">
                        <span class="c-blur"></span>
                        <span class="ico-text">+</span>
                    </span>
                    New Ad
                </span>
            </a>
        </div>
        <div class="py-1">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
                {{-- Breadcrumbs component --}}
                <x-breadcrumbs :items="[
                    ['label' => __('Home'), 'url' => route('dashboard')],
                    ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                    ['label' => $category->name, 'url' => route('categories.show', ['category' => $category->slug])],
                ]" />
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            {{ $category->name }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-5 bg-gray-50 dark:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-700">Alle {{ $category->name }} Anzeigen</h3>
                    <p class="text-lg text-gray-700 dark:text-gray-800">
                        Hier findest du alle verfügbaren Anzeigen in der Kategorie {{ $category->name }}.
                    </p>
                </div>

                @if ($ads->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center text-lg py-10">Es sind noch keine Anzeigen in dieser Kategorie verfügbar.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
                        @foreach ($ads as $ad)
                            @php
                                $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image'; // Default placeholder

                                if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
                                    $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);
                                    if ($thumbnailImage && $thumbnailImage->image_path) {
                                        $imageUrl = asset('storage/' . $thumbnailImage->image_path);
                                    } elseif ($ad->images->first() && $ad->images->first()->image_path) {
                                        $imageUrl = asset('storage/' . $ad->images->first()->image_path);
                                    }
                                } elseif (isset($ad->image_path) && !empty($ad->image_path)) {
                                    $imageUrl = asset('storage/' . $ad->image_path);
                                }
                            @endphp

                            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                {{-- Use a single, dynamic route based on the category and ad ID --}}
                                <a href="{{ route('categories.show', ['category' => $category->slug, 'ad' => $ad->id]) }}" class="block">
                                    <img src="{{ $imageUrl }}" alt="{{ $ad->title ?? 'Anzeige' }}" class="w-full h-40 object-cover rounded-t-lg">
                                    <div class="p-4">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-900 mb-1 truncate">{{ $ad->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-700 mb-2 line-clamp-2">{{ $ad->description }}</p>
                                        @if (isset($ad->price) && $ad->price !== null)
                                            <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->price, 2, ',', '.') }} €</p>
                                        @elseif (isset($ad->price_from) && $ad->price_from !== null)
                                            <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->price_from, 2, ',', '.') }} €</p>
                                        @elseif (isset($ad->gesamtmiete) && $ad->gesamtmiete !== null)
                                            <p class="text-xl font-extrabold text-blue-600 dark:text-blue-600 mb-2">{{ number_format($ad->gesamtmiete, 2, ',', '.') }} €</p>
                                        @else
                                            <p class="text-base text-gray-500 dark:text-gray-600 mb-2">Preis auf Anfrage</p>
                                        @endif

                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>{{ $ad->location ?? $ad->location ?? $ad->region ?? 'Unbekannter Ort' }}</span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-700 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{-- Pagination Links --}}
                    <div class="mt-8">
                        {{ $ads->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>