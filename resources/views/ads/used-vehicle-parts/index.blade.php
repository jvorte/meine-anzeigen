<x-app-layout>
     <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    All parts
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.vehicles-parts.create') }}" class="c-button">
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
            ['label' => 'Commercial Vehicles', 'url' => route('ads.vehicles-parts.index')],
        ]" class="mb-8" />

        {{-- Ads Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 my-5 gap-6">
            @foreach ($usedVehicleParts as $usedVehiclePart)
                <a href="{{ route('ads.used-vehicle-parts.show', $usedVehiclePart->id) }}" class="block bg-white border rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    @if($usedVehiclePart->images && $usedVehiclePart->images->first())
                        <img src="{{ asset('storage/' . $usedVehiclePart->images->first()->image_path) }}"
                             alt="{{ $usedVehiclePart->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $usedVehiclePart->title }}</h2>
                        <p class="text-sm text-gray-600 mt-1">
                  
                        </p>
                        <p class="text-sm text-gray-500 mt-2">{{ $usedVehiclePart->price }} €</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $usedVehicleParts->links() }}
        </div>
    </div>
</x-app-layout>
