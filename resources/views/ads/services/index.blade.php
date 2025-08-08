{{-- resources/views/ads/services/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Όλες οι Υπηρεσίες</h1>
                <p class="mt-1 text-gray-600">Περιηγηθείτε σε όλες τις διαθέσιμες υπηρεσίες που προσφέρονται από τους χρήστες.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                {{-- Διόρθωση: Σύνδεσμος για δημιουργία αγγελίας υπηρεσίας --}}
                <a href="{{ route('ads.services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    + Νέα Καταχώρηση
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-breadcrumbs :items="[
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            {{-- Διόρθωση: Σύνδεσμος breadcrumb για τις υπηρεσίες --}}
            ['label' => 'Υπηρεσίες', 'url' => route('categories.services.index')],
        ]" class="mb-6" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            {{-- Η μεταβλητή για την επανάληψη είναι `$serviceAds` --}}
            @forelse($serviceAds as $service)
                {{-- Στυλ κάρτας με hover effect --}}
                <a href="{{ route('ads.services.show', $service->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    {{-- Οι υπηρεσίες μπορεί να μην έχουν εικόνες --}}
                    @if($service->images->count())
                        {{-- Διόρθωση: `image_path` αντί για `path` --}}
                        <img src="{{ asset('storage/' . $service->images->first()->image_path) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Δεν υπάρχει εικόνα
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $service->title }}</h2>
                        {{-- Διόρθωση: Εμφάνιση του `service_type` --}}
                        <p class="text-gray-600 mt-1">Είδος: {{ $service->service_type ?? 'Δ/Α' }}</p>
                        @if($service->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($service->price, 2) }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">Τιμή κατόπιν συνεννόησης</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-600 col-span-full">Δεν βρέθηκαν υπηρεσίες.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{-- Διόρθωση: Σύνδεση pagination με τη μεταβλητή `$serviceAds` --}}
            {{ $serviceAds->links() }}
        </div>
    </div>
</x-app-layout>