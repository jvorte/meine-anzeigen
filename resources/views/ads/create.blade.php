<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-8 lg:py-12" x-data="{
            showModal: false,
            openModal() {
                this.showModal = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.showModal = false;
                document.body.style.overflow = '';
            }
        }">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                {{-- Modal-triggering card --}}
                <div @click="openModal"
                    class="flex items-center cursor-pointer bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group ">
                    <img class="w-48 h-48 object-cover rounded-s-lg  me-4" src="{{ asset('storage/images/car.jpg') }}"
                        alt="Fahrzeuge">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Fahrzeuge</h3>
                        <p class="text-sm text-gray-500">Wähle eine passende Unterkategorie.</p>
                    </div>
                </div>

                {{-- Static category cards --}}
                <a href="{{ route('ads.used-vehicle-parts.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group ">
                    <img src="{{ asset('storage/images/parts.jpg') }}" dir="ltr" alt="Fahrzeugteile"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Fahrzeugteile</h3>
                        <p class="text-sm text-gray-500">Teile und Zubehör für dein Fahrzeug.</p>
                    </div>
                </a>

                <a href="{{ route('ads.boats.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/boats.jpg') }}" dir="ltr" alt="boat"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Boote</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>



                <a href="{{ route('ads.electronics.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                    <img src="{{ asset('storage/images/tv.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Elektronik</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>



                <a href="{{ route('ads.household.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                        <img src="{{ asset('storage/images/chairs.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Haushalt</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>



                <a href="{{ route('ads.realestate.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                     <img src="{{ asset('storage/images/real.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Immobilien</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>



                <a href="{{ route('ads.servises.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                       <img src="{{ asset('storage/images/worker.jpg') }}" dir="ltr" alt="electronics"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Dienstleistunge</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>



                <a href="{{ route('ads.others.create') }}"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 transition group">
                     <img src="{{ asset('storage/images/boxes.jpg') }}" dir="ltr" alt="Sonstiges"
                        class="w-48 h-48 object-cover rounded-s-lg  me-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">Sonstiges</h3>
                        <p class="text-sm text-gray-500">Geräte, Zubehör und mehr.</p>
                    </div>
                </a>

                {{-- Προσθέτεις όσες θέλεις... --}}
            </div>
        </div>

        <!-- Modal -->
    <!-- Modal -->
<div x-show="showModal" x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50 overflow-y-auto"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white rounded-xl w-full max-w-2xl max-h-[95vh] overflow-y-auto p-8 relative shadow-2xl transform transition-all duration-300"
                @click.away="closeModal" x-trap.noscroll="showModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <button @click="closeModal"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-3xl font-bold p-1 rounded-full hover:bg-gray-100 transition-colors"
                    aria-label="Modal schließen">
                    &times;
                </button>

                <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg space-y-2">
                    <h2 class="text-2xl font-bold text-gray-800 text-center">Unterkategorie wählen</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('ads.autos.create') }}"
                           class="flex items-center justify-center gap-2 text-center px-4 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition font-medium">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-car-icon lucide-car"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg> Autos
                        </a>
                        <a href="{{ route('ads.motorrad.create') }}"
                          class="flex items-center justify-center gap-2 text-center px-4 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition font-medium">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bike-icon lucide-bike"><circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg> Motorräder
                        </a>
                        <a href="{{ route('ads.commercial-vehicles.create') }}"
                          class="flex items-center justify-center gap-2 text-center px-4 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck-icon lucide-truck"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> Nutzfahrzeuge
                        </a>
                        <a href="{{ route('ads.camper.create') }}"
                             class="flex items-center justify-center gap-2 text-center px-4 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bus-icon lucide-bus"><path d="M8 6v6"/><path d="M15 6v6"/><path d="M2 12h19.6"/><path d="M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H4a2 2 0 0 0-2 2v10h3"/><circle cx="7" cy="18" r="2"/><path d="M9 18h5"/><circle cx="16" cy="18" r="2"/></svg> Wohnmobile
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>