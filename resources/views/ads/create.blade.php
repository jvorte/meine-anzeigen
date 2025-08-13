<x-app-layout>

    <x-slot name="header">

        <div class="py-1">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
                {{-- Breadcrumbs component --}}
                <x-breadcrumbs :items="[
                ['label' => 'Anzeige erstellen', 'url' => route('ads.index')], // Assuming an 'ads.index' route
                // ['label' => 'Neue Anzeige', 'url' => route('ads.create')],
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




    <div class="py-3 lg:py-2" x-data="{
        showModal: false,
        openModal() {
            this.showModal = true;
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = ''; // Restore scrolling
        }
    }">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                {{-- Modal-triggering card for Fahrzeuge --}}
                <div @click="openModal"
                    class="flex items-center cursor-pointer bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group ">
                    <img class="w-48 h-48 object-cover rounded-s-lg me-4" src="{{ asset('storage/images/car.jpg') }}"
                        alt="Fahrzeuge">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Vehicles
                            {{-- Plus icon for the "Fahrzeuge" modal trigger --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Wähle eine passende Unterkategorie.</p>
                    </div>
                </div>

                {{-- Static category cards (remaining as direct links) --}}
                <a href="{{ route('ads.vehicles-parts.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group ">
                    <img src="{{ asset('storage/images/parts.jpg') }}" dir="ltr" alt="Fahrzeugteile"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Vehicles parts
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Teile und Zubehör für dein Fahrzeug.</p>
                    </div>
                </a>

                <a href="{{ route('ads.boats.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/boats.jpg') }}" dir="ltr" alt="boat"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Boats
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                <a href="{{ route('ads.electronics.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/tv.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Electronics
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                <a href="{{ route('ads.household.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/chairs.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Household
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                <a href="{{ route('ads.real-estate.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/real.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Real Estate
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                <a href="{{ route('ads.services.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/worker.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Services
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                <a href="{{ route('ads.others.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/boxes.jpg') }}" dir="ltr" alt="Sonstiges"
                        class="w-48 h-48 object-cover rounded-s-lg me-4">
                    <div>
                        <h3
                            class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 flex items-center gap-2">
                            Others
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600 group-hover:text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

            </div>
        </div>

        {{-- The Modal for Fahrzeugkategorien --}}
        <div x-show="showModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50 overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="rounded-xl w-full max-w-2xl max-h-[95vh] overflow-y-auto p-8 relative shadow-2xl transform transition-all duration-300"
                @click.away="closeModal" x-trap.noscroll="showModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <button @click="closeModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="rounded-2xl w-full max-w-md space-y-4 mx-auto">
                    <!-- <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-800 text-center mb-4 ">Categories</h2> -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">

                        <a href="{{ route('ads.cars.create') }}"
                            class="block  bg-gray-100 dark:bg-slate-200 rounded-lg shadow-lg hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-200">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('storage/images/car.jpg') }}" alt="Auto" class="h-40 w-full object-cover rounded-md mb-2">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900">Cars</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-800 mb-2">Verkaufe oder suche ein Auto.</p>
                            </div>
                        </a>

                        <a href="{{ route('ads.motorcycles.create') }}"
                            class="block bg-gray-100 dark:bg-slate-200  rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-200">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('storage/images/motorcycle.jpg') }}" alt="Motorrad" class="h-40 w-full object-cover rounded-md mb-2">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900">Motorräder</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-800">Finde dein neues Motorrad.</p>
                            </div>
                        </a>

                        <a href="{{ route('ads.commercial-vehicles.create') }}"
                              class="block  bg-gray-100 dark:bg-slate-200 rounded-lg shadow-lg hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-200">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('storage/images/trucks.jpg') }}" alt="Nutzfahrzeuge" class="h-40 w-full object-cover rounded-md mb-2">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900">Nutzfahrzeuge</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-800">Anzeigen für Transporter und LKW.</p>
                            </div>
                        </a>

                        <a href="{{ route('ads.campers.create') }}"
                            class="block  bg-gray-100 dark:bg-slate-200 rounded-lg shadow-lg hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-200">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('storage/images/camper.jpg') }}" alt="Wohnmobile" class="h-40 w-full object-cover rounded-md mb-2">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900">Wohnmobile</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-800 ">Verkaufe oder miete ein Wohnmobil.</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>