<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
                {{-- Breadcrumbs component --}}
                <x-breadcrumbs :items="[
                    ['label' => 'Anzeige erstellen', 'url' => route('ads.index')],
                ]" />
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-3 lg:py-2">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

                {{-- Cars --}}
                <a href="{{ route('ads.cars.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/car.jpg') }}" alt="Cars" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>
                            Cars
                        </h3>
                        <p class="text-sm text-gray-500">Verkaufe oder suche ein Auto.</p>
                    </div>
                </a>


                {{-- Motorcycles --}}
                <a href="{{ route('ads.motorrads.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/motorcycle.jpg') }}" alt="Motorcycles" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>
                            Motorcycles
                        </h3>
                        <p class="text-sm text-gray-500">Finde dein neues Motorrad.</p>
                    </div>
                </a>

                {{-- Commercial Vehicles --}}
                <a href="{{ route('ads.commercial-vehicles.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/trucks.jpg') }}" alt="Commercial Vehicles" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Commercial Vehicles
                        </h3>
                        <p class="text-sm text-gray-500">Anzeigen für Transporter und LKW.</p>
                    </div>
                </a>

                {{-- Campers --}}
                <a href="{{ route('ads.campers.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/camper.jpg') }}" alt="Campers" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Campers
                        </h3>
                        <p class="text-sm text-gray-500">Verkaufe oder miete ein Wohnmobil.</p>
                    </div>
                </a>

                {{-- Vehicle Parts --}}
                <a href="{{ route('ads.vehicles-parts.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/parts.jpg') }}" alt="Vehicle Parts" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Vehicle Parts
                        </h3>
                        <p class="text-sm text-gray-500">Teile und Zubehör für dein Fahrzeug.</p>
                    </div>
                </a>

                {{-- Boats --}}
                <a href="{{ route('ads.boats.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/boats.jpg') }}" alt="Boats" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Boats
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Electronics --}}
                <a href="{{ route('ads.electronics.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/tv.jpg') }}" alt="Electronics" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Electronics
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Household --}}
                <a href="{{ route('ads.household.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/chairs.jpg') }}" alt="Household" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Household
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Real Estate --}}
                <a href="{{ route('ads.real-estate.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/real.jpg') }}" alt="Real Estate" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Real Estate
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Services --}}
                <a href="{{ route('ads.services.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/worker.jpg') }}" alt="Services" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Services
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Others --}}
                <a href="{{ route('ads.others.create') }}"
                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/boxes.jpg') }}" alt="Others" class="h-48 w-full object-cover rounded-t-lg">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-plus2-icon text-green-500">
                                <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M3 15h6" />
                                <path d="M6 12v6" />
                            </svg>Others
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>