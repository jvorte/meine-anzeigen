<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    All Campers
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.camper.create') }}" class="c-button">
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
            ['label' => 'Campers', 'url' => route('ads.camper.index')],
        ]" class="mb-8" />

        @if ($campers->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($campers as $camper)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
                        <a href="{{ route('ads.camper.show', $camper->id) }}">
                            <div class="aspect-w-4 aspect-h-3 bg-gray-100">
                                @if ($camper->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $camper->images->first()->path) }}" alt="{{ $camper->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $camper->title }}
                                </h3>
                                <p class="text-sm text-gray-600 truncate">
                                    {{ $camper->camperBrand->name ?? '' }} {{ $camper->camperModel->name ?? '' }}
                                </p>
                                <div class="mt-2 text-blue-600 font-bold">
                                    € {{ number_format($camper->price, 2) }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $campers->links() }}
            </div>
        @else
            <div class="text-gray-600 text-center py-20">
                No campers found.
            </div>
        @endif
    </div>
</x-app-layout>
