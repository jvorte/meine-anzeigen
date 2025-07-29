{{-- resources/views/electronics/show.blade.php --}}

<x-app-layout>
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
            Electronic Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Informationen zur elektronischen Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component - Adjusted for better logic --}}
            <x-breadcrumbs :items="[
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')], // Link to general ads index
                // Assuming 'elektronik' is the slug for the electronics category
                ['label' => 'Elektronik Anzeigen', 'url' => route('categories.show', 'elektronik')],
                ['label' => $electronic->title, 'url' => null], // Current page, display title
            ]" />
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-5 bg-white dark:bg-gray-100 border-b border-gray-200 dark:border-gray-300">
                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-800 mb-2 leading-tight">{{ $electronic->title }}</h3>
                    <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                        {{ number_format($electronic->price ?? 0, 2, ',', '.') }} €
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if (isset($electronic->user_id))
                            <a href="{{ route('messages.create', $electronic->user->id) }}" class="inline-flex items-center text-base font-medium text-green-600
                                        hover:text-green-800 hover:underline
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                                        transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Verkäufer kontaktieren
                            </a>
                        @else
                            <p class="text-red-800 dark:text-red-700 italic">Informationen zum Verkäufer nicht verfügbar.</p>
                        @endif

                        <div class="flex-grow flex justify-end items-center space-x-2 sm:space-x-4 mt-3 sm:mt-0">
                            @auth
                                @if (auth()->id() === $electronic->user_id || (auth()->user() && auth()->user()->isAdmin()))
                                    <a href="{{ route('ads.electronics.edit', $electronic->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                                                hover:bg-blue-50 hover:text-blue-700
                                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                                transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.586 3.586L10.586 7l-7 7V17h3l7-7.001z" />
                                        </svg>
                                        Anzeige bearbeiten
                                    </a>

                                    <form action="{{ route('ads.electronics.destroy', $electronic->id) }}" method="POST"
                                        onsubmit="return confirm('Bist du sicher, dass du diese Anzeige löschen möchtest?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 bg-transparent
                                                    hover:bg-red-50 hover:text-red-700
                                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                                    transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                                                <path fill-rule="evenodd"
                                                    d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Anzeige löschen
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $electronic->description }}</p>

                    <h4 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">Elektronikdetails</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        {{-- Use a consistent structure for each detail item --}}

                        {{-- Corrected Brand access --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Marke:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->electronicBrand->name ?? 'N/A' }}</span>
                        </div>

                        {{-- Corrected Model access --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Modell:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->electronicModel->name ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Zustand:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->condition ?? 'N/A' }}</span>
                        </div>

                        {{-- Added Year of Purchase --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Kaufjahr:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->year_of_purchase ?? 'N/A' }}</span>
                        </div>

                        {{-- Corrected Warranty Status access --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Garantie-Status:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->warranty_status ?? 'N/A' }}</span>
                        </div>

                        {{-- Remaining specific fields - These were mostly correct but `?? 'N/A'` is good practice --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Farbe:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->color ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Nutzungsdauer:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->usage_time ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Leistung:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->power ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Betriebssystem:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->operating_system ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Speicherkapazität:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->storage_capacity ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Bildschirmgröße:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->screen_size ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Prozessor:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->processor ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">RAM:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->ram ?? 'N/A' }}</span>
                        </div>

                        {{-- Display accessories as a block, as it's a longer text field --}}
                        @if ($electronic->accessories)
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md lg:col-span-3">
                                <span class="font-semibold text-gray-500 dark:text-gray-600">Zubehör:</span>
                                <span class="text-gray-700 dark:text-gray-800">{{ $electronic->accessories }}</span>
                            </div>
                        @endif

                        {{-- Posting date --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Anzeigedatum:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $electronic->created_at->format('d.m.Y H:i') ?? 'N/A' }}</span>
                        </div>
                    </div>

                    {{-- Example for displaying images if you have a relationship --}}
                    @if ($electronic->images->count() > 0) {{-- Directly check count after eager loading --}}
                        <div class="mt-6">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($electronic->images as $image)
                                    {{-- Corrected: Use $image->image_path as per your assumed ElectronicImage model --}}
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Elektronikbild" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>