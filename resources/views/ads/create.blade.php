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
                <a href="{{ route('ads.used-vehicle-parts.create') }}"
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
                            Boote
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
                            Sonstiges
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

            <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-2xl max-h-[95vh] overflow-y-auto p-8 relative shadow-2xl transform transition-all duration-300"
                @click.away="closeModal" x-trap.noscroll="showModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">



                <button @click="closeModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-lg space-y-2 mx-auto"> {{--
                    Added mx-auto for centering --}}
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 text-center mb-4">Unterkategorie
                        wählen</h2>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Sub-category links for Fahrzeuge --}}
                        {{-- Note: These routes should lead to the *create* page for each specific vehicle type --}}
                        <a href="{{ route('ads.cars.create') }}"
                            class="flex flex-col items-center p-4 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-car-icon lucide-car mb-2">
                                <path
                                    d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                <circle cx="7" cy="17" r="2" />
                                <path d="M9 17h6" />
                                <circle cx="17" cy="17" r="2" />
                            </svg>
                            <span>+Cars</span>
                        </a>
                        <a href="{{ route('ads.motorrad.create') }}"
                            class="flex flex-col items-center p-4 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-motorbike mb-2">
                                <path d="M5 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M17 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M7.5 14h9l4 -2l-1.5 -4.5h-11.5l-4 2z" />
                                <path d="M18 5l-1.5 4.5" />
                                <path d="M9 6l-2 4" />
                                <path d="M12 7v4" />
                            </svg>
                            <span>+Motorräder</span>
                        </a>
                        <a href="{{ route('ads.commercial-vehicles.create') }}"
                            class="flex flex-col items-center p-4 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-truck mb-2">
                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                <path d="M15 18H9" />
                                <path
                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                <circle cx="17" cy="18" r="2" />
                                <circle cx="7" cy="18" r="2" />
                            </svg>
                            <span>+Commercial-vehicle</span>
                        </a>
                        <a href="{{ route('ads.camper.create') }}"
                            class="flex flex-col items-center p-4 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-caravan mb-2">
                                <path d="M6 10c-1.1 0-2 .9-2 2v6h3" />
                                <path d="M15 10h5a2 2 0 0 1 2 2v6h-3" />
                                <path d="M11 10V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4h8Z" />
                                <path d="M15 18H9a2 2 0 0 1-2-2v-4h10v4a2 2 0 0 1-2 2Z" />
                                <path d="M18 20v2" />
                                <path d="M14 14h.01" />
                                <path d="M12 10h.01" />
                                <path d="M20 20v2" />
                            </svg>
                            <span>+Campers</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>