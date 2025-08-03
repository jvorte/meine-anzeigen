{{-- resources/views/ads/used-vehicle-parts/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            {{-- Main page title and description --}}
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
                    Gebrauchtfahrzeugteile Anzeige
                </h2>
                <p class="text-md text-gray-700 dark:text-gray-500">
                    Detaillierte Ansicht Ihrer Gebrauchtfahrzeugteile-Anzeige.
                </p>
            </div>
            {{-- "Neu Anzeige" button --}}
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('ads.create') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Neu Anzeige
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                ['label' => 'Gebrauchtfahrzeugteile', 'url' => route('categories.show', 'used-vehicle-parts')],
                ['label' => $usedVehiclePart->title, 'url' => null],
            ]" />
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5 flex flex-wrap justify-end gap-3">
        {{-- Back to Dashboard Button --}}
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>

        {{-- Contact Seller Button --}}
        @if ($usedVehiclePart->user)
            <a href="{{ route('messages.create', $usedVehiclePart->user->id) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Kontakt aufnehmen
            </a>
        @else
            <p class="text-red-800 dark:text-red-700 italic flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                Informationen zum Anbieter nicht verfügbar.
            </p>
        @endif

        {{-- Edit/Delete Buttons (Visible to owner or admin) --}}
        @auth
            @if (auth()->id() === $usedVehiclePart->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.used-vehicle-parts.edit', $usedVehiclePart->id) }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                                 hover:bg-blue-50 hover:text-blue-700
                                 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                 transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.used-vehicle-parts.destroy', $usedVehiclePart->id) }}" method="POST"
                    onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 bg-transparent
                                         hover:bg-red-50 hover:text-red-700
                                         focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                         transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20"
                            fill="currentColor">
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

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 bg-white rounded-lg shadow-xl my-6">
        <article class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Left Column: Main Image Gallery --}}
            <section x-data="{
                images: @js($usedVehiclePart->images->pluck('path')),
                activeImage: '{{ $usedVehiclePart->images->first()->path ?? '' }}',
                showModal: false,
                modalActiveImage: '',
                currentIndex: 0,
            
                openModal(imagePath) {
                    this.modalActiveImage = imagePath;
                    this.currentIndex = this.images.findIndex(img => img === imagePath);
                    this.showModal = true;
                },
            
                closeModal() {
                    this.showModal = false;
                    this.modalActiveImage = '';
                },
            
                nextImage() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    this.modalActiveImage = this.images[this.currentIndex];
                },
            
                prevImage() {
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    this.modalActiveImage = this.images[this.currentIndex];
                }
            }" class="space-y-4">
                <h3 class="sr-only">Bildergalerie</h3> {{-- Screen reader only heading --}}
                @if (isset($usedVehiclePart->images) && $usedVehiclePart->images->count() > 0)
                    {{-- Main Image Display --}}
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-md">
                        <img :src="activeImage ? '{{ Storage::url('') }}' + activeImage : '{{ asset('images/placeholder.webp') }}'"
                            alt="Hauptbild des Ersatzteils" class="w-full h-96 object-contain cursor-pointer"
                            @click="openModal(activeImage)">
                        <div x-cloak x-show="!activeImage"
                            class="absolute inset-0 flex items-center justify-center text-gray-500">
                            Kein Bild verfügbar
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    <div class="flex space-x-2 overflow-x-auto pb-2 no-scrollbar">
                        <template x-for="(image, index) in images" :key="index">
                            <img :src="'{{ Storage::url('') }}' + image" alt="Vorschaubild"
                                class="w-24 h-24 object-cover rounded-md cursor-pointer border-2 transition-all duration-200"
                                :class="{ 'border-blue-500 shadow-md': image === activeImage, 'border-transparent': image !== activeImage }"
                                @click="activeImage = image">
                        </template>
                    </div>

                    {{-- Fullscreen Modal --}}
                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4"
                        @click.self="closeModal">
                        <div class="relative w-full max-w-5xl max-h-full overflow-hidden flex items-center justify-center">
                            {{-- Previous Button --}}
                            <button @click.stop="prevImage()"
                                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full shadow-lg z-10 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            {{-- Image --}}
                            <img :src="'{{ Storage::url('') }}' + modalActiveImage" alt="Vollbild Bild des Ersatzteils"
                                class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-lg">
                            {{-- Next Button --}}
                            <button @click.stop="nextImage()"
                                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full shadow-lg z-10 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            {{-- Close Button --}}
                            <button @click="closeModal()"
                                class="absolute top-4 right-4 bg-gray-800 text-white p-2 rounded-full shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center h-96 bg-gray-100 rounded-lg text-gray-500">
                        <p>Keine Bilder für dieses Ersatzteil verfügbar.</p>
                    </div>
                @endif
            </section>

            {{-- Right Column: Basic Details & Seller Info --}}
            <section class="space-y-6">
                {{-- Ad Title --}}
                <h1 class="text-4xl font-extrabold text-gray-800">{{ $usedVehiclePart->title }}</h1>

                {{-- Prices Section --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-4">Preise</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-2">
                        <div class="col-span-1">
                            <dt class="text-sm font-semibold text-gray-800">Preis:</dt>
                            <dd class="text-gray-700">
                                @if ($usedVehiclePart->price)
                                    &euro;{{ number_format($usedVehiclePart->price, 2, ',', '.') }}
                                @else
                                    Preis auf Anfrage
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Seller Information Section --}}
                <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-4">Anbieterinformationen</h4>
                    @if ($usedVehiclePart->user)
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2">
                            <div class="col-span-1">
                                <dt class="text-sm font-semibold text-gray-800">Anbieter:</dt>
                                <dd class="text-gray-700">{{ $usedVehiclePart->user->name }}</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-semibold text-gray-800">Ort:</dt>
                                <dd class="text-gray-700">
                                    {{ $usedVehiclePart->user->city ?? 'Nicht angegeben' }}
                                    @if ($usedVehiclePart->user->zip_code)
                                        ({{ $usedVehiclePart->user->zip_code }})
                                    @endif
                                </dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-sm font-semibold text-gray-800">E-Mail:</dt>
                                <dd class="text-gray-700">
                                    <a href="mailto:{{ $usedVehiclePart->user->email }}"
                                        class="text-blue-600 hover:underline">{{ $usedVehiclePart->user->email }}</a>
                                </dd>
                            </div>
                            @if ($usedVehiclePart->user->phone_number)
                                <div class="col-span-1">
                                    <dt class="text-sm font-semibold text-gray-800">Telefon:</dt>
                                    <dd class="text-gray-700">
                                        <a href="tel:{{ $usedVehiclePart->user->phone_number }}"
                                            class="text-blue-600 hover:underline">{{ $usedVehiclePart->user->phone_number }}</a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    @else
                        <p class="text-gray-600 italic">Informationen zum Anbieter sind nicht verfügbar.</p>
                    @endif
                </div>
            </section>
        </article>

        <hr class="my-8 border-gray-200" />

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-gray-700 leading-relaxed">{{ $usedVehiclePart->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section>

        {{-- Part Details Section (Updated for broader vehicle types) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Teiledetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($usedVehiclePart->part_name)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Teilname:</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->part_name }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->part_category)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Teilekategorie:</p>
                        {{-- Assuming part_category is now a relationship to a PartCategory model --}}
                        <p class="text-gray-700">{{ $usedVehiclePart->part_category->name ?? $usedVehiclePart->part_category }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->manufacturer_part_number)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Hersteller-Teilenummer:</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->manufacturer_part_number }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->condition)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->condition }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->manufacturer)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Hersteller:</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->manufacturer }}</p>
                    </div>
                @endif

                {{-- Vehicle Compatibility Details --}}
                @if ($usedVehiclePart->compatible_brand_id)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kompatible Marke:</p>
                        {{-- Assuming compatible_brand_id now relates to a Brand model --}}
                        <p class="text-gray-700">{{ $usedVehiclePart->compatibleBrand->name ?? $usedVehiclePart->compatible_brand_id }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->compatible_model_id) {{-- Renamed from compatible_car_model_id --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kompatibles Modell:</p>
                        {{-- Assuming compatible_model_id now relates to a Model model --}}
                        <p class="text-gray-700">{{ $usedVehiclePart->compatibleModel->name ?? $usedVehiclePart->compatible_model_id }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->compatible_year_from)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kompatibles Baujahr (von):</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->compatible_year_from }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->compatible_year_to)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kompatibles Baujahr (bis):</p>
                        <p class="text-gray-700">{{ $usedVehiclePart->compatible_year_to }}</p>
                    </div>
                @endif
                @if ($usedVehiclePart->vehicle_type) {{-- New field for general vehicle type --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Fahrzeugtyp:</p>
                        <p class="text-gray-700">{{ ucfirst($usedVehiclePart->vehicle_type) }}</p>
                    </div>
                @endif
            </div>
        </section>

    </div>
</x-app-layout>