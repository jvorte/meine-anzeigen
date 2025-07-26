{{-- resources/views/electronics/show.blade.php --}}

<x-app-layout>
 {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}

    <x-slot name="header">
        <div class="px-4 py-1 md:py-1 flex justify-end items-center">
            <a href="{{ route('ads.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Neu Anzeige
            </a>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            electronic Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'electronic Anzeigen', 'url' => route('ads.create')],
        ['label' => 'electronic Anzeige', 'url' => route('ads.create')],
    ]" />

        </div>
    </div>

    {{-- ------------------------------------------------------------------------------------- --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-5 bg-white dark:bg-gray-100 border-b border-gray-200 dark:border-gray-300">
                    <h3 class="text-4xl font-extrabold text-gray-700 dark:text-gray-800 mb-2 leading-tight">{{ $electronic->title }}</h3>
                    <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                        {{ number_format($electronic->price ?? 0, 2, ',', '.') }} €
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if (isset($electronic->user_id)) {{-- Assuming you have a user_id on your model --}}
                            {{-- <a href="{{ route('messages.create', $electronic->user_id) }}" --}}
                               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full sm:w-auto transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Verkäufer kontaktieren
                            </a>
                        @else
                            <p class="text-red-800 dark:text-red-700 italic">Informationen zum Verkäufer nicht verfügbar.</p>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $electronic->description }}</p>

                    <h4 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">Elektronikdetails</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        {{-- Use a consistent structure for each detail item --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Marke:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->brand ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Modell:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->model ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Zustand:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->condition ?? 'N/A' }}</span>
                        </div>
                        {{-- Add more electronic-specific details here based on your table --}}
                        {{-- For example: --}}
                        {{-- <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Garantie:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->warranty ?? 'N/A' }}</span>
                        </div> --}}
                        {{-- <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Farbe:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->color ?? 'N/A' }}</span>
                        </div> --}}
                    </div>

                    {{-- Example for displaying images if you have a relationship --}}
                    @if (isset($electronic->images) && $electronic->images->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($electronic->images as $image)
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Elektronikbild" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 text-center">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-500 focus:outline-none focus:border-blue-600 focus:ring ring-blue-100 disabled:opacity-25 transition ease-in-out duration-150">
                            Zurück zur Suche
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>