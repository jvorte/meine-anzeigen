{{-- resources/views/ads/household/index.blade.php --}}

<x-app-layout>
   <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                 Households
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Browse all available camper listings.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.household.create') }}" class="c-button">
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
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            ['label' => 'Είδη Σπιτιού', 'url' => route('categories.household.index')],
        ]" class="mb-6" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            {{-- Διόρθωση: Χρησιμοποιείται η μεταβλητή `$householdAds` όπως ήταν στο αρχικό σας αρχείο --}}
            @forelse($householdAds as $household)
                <a href="{{ route('ads.household.show', $household->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    @if($household->images->count())
                        {{-- Διόρθωση: `image_path` αντί για `path` --}}
                        <img src="{{ asset('storage/' . $household->images->first()->image_path) }}" alt="{{ $household->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Δεν υπάρχει εικόνα
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $household->title }}</h2>
                        <p class="text-gray-600 mt-1">Κατάσταση: {{ $household->condition ?? 'Δ/Α' }}</p>
                        <p class="text-gray-500 mt-1">Κατηγορία: {{ $household->category ?? 'Δ/Α' }}</p>
                        @if($household->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($household->price, 2) }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">Τιμή κατόπιν συνεννόησης</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-600 col-span-full">Δεν βρέθηκαν είδη σπιτιού.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{-- Διόρθωση: Χρησιμοποιείται η μεταβλητή `$householdAds` --}}
            {{ $householdAds->links() }}
        </div>
    </div>
</x-app-layout>