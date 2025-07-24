{{-- resources/views/ads/services/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        {{-- Updated Header Section with Gradient and Prominent CTA --}}
        <div class="relative flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 p-6 bg-cover bg-center shadow-lg rounded-lg"
            style="background-image: url('/storage/images/2.jpg');"> {{-- Replaced with a stable placeholder image --}}
            {{-- Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black opacity-20 rounded-lg"></div> {{-- Adjust opacity (e.g., 10 to 40) --}}

            {{-- Main Heading and Description (ensure z-index to be above overlay) --}}
            <div class="relative z-10 text-center md:text-left flex-grow">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight mb-2">
                    Finde deine nächste Anzeige
                </h2>
                <p class="text-md text-gray-600 dark:text-gray-100">
                    Durchsuche Tausende von Anzeigen oder erstelle deine eigene.
                </p>
            </div>

            {{-- Prominent Search Bar (ensure z-index to be above overlay) --}}
            <div class="relative z-10 w-full md:w-1/2 lg:w-2/5">
                <form action="{{ route('ads.search') }}" method="GET">

                    <input type="text" name="query" placeholder="Was suchst du? z.B. iPhone, Wohnung, Fahrrad..."
                        class="w-full p-3 pl-10 border border-gray-300 rounded-full shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-black dark:bg-gray-100 dark:text-gray-900 dark:border-gray-600"
                        aria-label="Search ads">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </div>

        {{-- Category Navigation Links (moved below main header for better flow) --}}
        <nav
            class="p-4 flex flex-wrap justify-center md:justify-start gap-x-4 gap-y-2 mt-4 pb-2 border-b border-gray-200 dark:border-gray-700">
            {{-- Removed ps-4, space-x-4, overflow-x-auto, added flex-wrap, justify-center, gap-x-4, gap-y-2 --}}
            <a href="{{ route('categories.show', 'fahrzeuge') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                {{-- Added padding, rounded, and background for each link --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-car-icon lucide-car">
                    <path
                        d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                    <circle cx="7" cy="17" r="2" />
                    <path d="M9 17h6" />
                    <circle cx="17" cy="17" r="2" />
                </svg>
                <span>Fahrzeuge</span>
            </a>
            <a href="{{ route('categories.show', 'fahrzeugeteile') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-bolt-icon lucide-bolt">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <circle cx="12" cy="12" r="4" />
                </svg>
                <span>Fahrzeugeteile</span>
            </a>
            <a href="{{ route('categories.show', 'boote') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-boat">
                    <path d="M2 20a2.43 2.43 0 0 1 2-2h16a2.43 2.43 0 0 1 2 2Z" />
                    <path d="M18 10H6" />
                    <path d="M2 12h20" />
                    <path d="M12 2v10" />
                </svg>
                <span>Boote</span>
            </a>
            <a href="{{ route('categories.show', 'elektronik') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-cable-icon lucide-cable">
                    <path d="M17 19a1 1 0 0 1-1-1v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a1 1 0 0 1-1 1z" />
                    <path d="M17 21v-2" />
                    <path d="M19 14V6.5a1 1 0 0 0-7 0v11a1 1 0 0 1-7 0V10" />
                    <path d="M21 21v-2" />
                    <path d="M3 5V3" />
                    <path d="M4 10a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2z" />
                    <path d="M7 5V3" />
                </svg>
                <span>Elektronik</span>
            </a>
            <a href="{{ route('categories.show', 'haushalt') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-sofa-icon lucide-sofa">
                    <path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3" />
                    <path
                        d="M2 16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z" />
                    <path d="M4 18v2" />
                    <path d="M20 18v2" />
                    <path d="M12 4v9" />
                </svg>
                <span>Haushalt</span>
            </a>
            <a href="{{ route('categories.show', 'immobilien') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house-icon lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                        d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                <span>Immobilien</span>
            </a>
            <a href="{{ route('categories.show', 'dienstleistungen') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-hand-platter-icon lucide-hand-platter">
                    <path d="M12 3V2" />
                    <path
                        d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5" />
                    <path d="M2 14h12a2 2 0 0 1 0 4h-2" />
                    <path d="M4 10h16" />
                    <path d="M5 10a7 7 0 0 1 14 0" />
                    <path d="M5 14v6a1 1 0 0 1-1 1H2" />
                </svg>
                <span>Dienstleistunge</span>
            </a>
            <a href="{{ route('categories.show', 'sonstiges') }}"
                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-more-horizontal">
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="19" cy="12" r="1" />
                    <circle cx="5" cy="12" r="1" />
                </svg>
                <span>Sonstiges</span>
            </a>
        </nav>

        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-5">
            {{ $vehicle->title }}
        </h2> --}}
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-3xl font-bold mb-4">{{ $service->title }}</h3>

                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $service->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-semibold">Preis / Kosten:</p>
                        <p>{{ $service->price ?? 'Nach Absprache' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Art der Dienstleistung:</p>
                        <p>{{ $service->service_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Verfügbarkeit:</p>
                        <p>{{ $service->availability ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Standort / Region:</p>
                        <p>{{ $service->location ?? 'N/A' }}</p>
                    </div>
                    {{-- Add more service-specific details here based on your table --}}
                </div>

                {{-- Example for displaying images if you have a relationship --}}
                {{-- Make sure you have an 'images' relationship defined in your Service model --}}
                @if (isset($service->images) && $service->images->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold mb-3">Bilder</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($service->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Dienstleistungsbild" class="w-full h-48 object-cover rounded-lg shadow-md">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline dark:text-blue-400">Zurück zur Suche</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>