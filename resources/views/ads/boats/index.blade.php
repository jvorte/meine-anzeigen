<x-app-layout>
   <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    All Boats
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.boats.create') }}" class="c-button">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-breadcrumbs :items="[
            ['label' => 'All Ads', 'url' => route('ads.index')],
            ['label' => 'Boats', 'url' => route('categories.boats.index')],
        ]" class="mb-6" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            @forelse($boatAds as $boat)
                <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300">
                    @if($boat->images->count())
                        <img src="{{ asset('storage/' . $boat->images->first()->path) }}" alt="{{ $boat->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No image
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $boat->title }}</h2>
                        <p class="text-gray-600 mt-1">{{ $boat->brand }} {{ $boat->model }} ({{ $boat->year_of_construction }})</p>
                        <p class="text-gray-500 mt-1">{{ $boat->boat_type }} | {{ $boat->condition }}</p>
                        @if($boat->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($boat->price, 2) }}</p>
                        @endif
                        <a href="{{ route('ads.boats.show', $boat->id) }}" class="inline-block mt-4 text-blue-600 hover:underline text-sm font-medium">View details →</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No boats found.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $boatAds->links() }}
        </div>
    </div>
</x-app-layout>
