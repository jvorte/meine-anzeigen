{{-- resources/views/ads/others/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Όλες οι Λοιπές Αγγελίες</h1>
                <p class="mt-1 text-gray-600">Περιηγηθείτε σε όλες τις αγγελίες που δεν ανήκουν σε άλλη κατηγορία.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('ads.others.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    + Νέα Καταχώρηση
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-breadcrumbs :items="[
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            ['label' => 'Λοιπές', 'url' => route('categories.others.index')],
        ]" class="mb-6" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            @forelse($otherAds as $other)
                <a href="{{ route('ads.others.show', $other->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    @if($other->images->count())
                        {{-- Διόρθωση: `image_path` αντί για `path` --}}
                        <img src="{{ asset('storage/' . $other->images->first()->image_path) }}" alt="{{ $other->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Δεν υπάρχει εικόνα
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $other->title }}</h2>
                        {{-- Εμφάνιση της περιγραφής ή άλλου σχετικού πεδίου --}}
                        <p class="text-gray-600 mt-1">{{ Str::limit($other->description ?? 'Δ/Α', 50) }}</p>
                        @if($other->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($other->price, 2) }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">Τιμή κατόπιν συνεννόησης</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-600 col-span-full">Δεν βρέθηκαν λοιπές αγγελίες.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $otherAds->links() }}
        </div>
    </div>
</x-app-layout>