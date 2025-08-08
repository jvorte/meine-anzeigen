<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    All Motos
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.cars.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        New Add
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
            ['label' => 'All Ads', 'url' => route('ads.index')],
            ['label' => 'Cars', 'url' => route('ads.motorcycles.index')],
        ]" class="mb-8" />

 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 my-5 gap-6">
    @foreach($motorradAds as $motorradAd)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <a href="{{ route('ads.motorrad.show', $motorradAd->id) }}">
                  @if($motorradAd->images->count())
                        <img src="{{ asset('storage/' . $motorradAd->images->first()->image_path) }}" alt="{{ $motorradAd->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No image
                        </div>
                    @endif
            </a>
            
            
            <div class="p-4">
                <h2 class="text-lg font-semibold">
                    <a href="{{ route('ads.cars.show', $motorradAd->id) }}">
                        {{ $motorradAd->title }}
                    </a>
                </h2>
                <p class="text-gray-600 text-sm">
                    {{ $motorradAd->motorcycleBrand->name ?? '-' }} {{ $motorradAd->motorcycleModel->name ?? '' }}
                </p>
                <p class="text-gray-900 font-bold mt-2">
                    €{{ number_format($motorradAd->price, 0, ',', '.') }}
                </p>
            </div>
        </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $motorradAds->links() }}
</div>

    </div>
</x-app-layout>
