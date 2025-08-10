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

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
        <a href="{{ route('ads.create') }}" class="c-button">
            <span class="c-main">
                <span class="c-ico">
                    <span class="c-blur"></span>
                    <span class="ico-text">+</span>
                </span>
                New Add
            </span>
        </a>
    </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
      <x-breadcrumbs :items="[
    ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
    ['label' => 'Gebrauchtfahrzeugteile', 'url' => route('categories.vehicles-parts.index')], // Use the new route name
    ['label' => $usedVehiclePart->title, 'url' => null],
]" />


           {{-- Action Buttons and Back link --}}
   <div class="flex flex-col sm:flex-row justify-between my-4 gap-4">
    <a href="javascript:history.back()" 
        class="inline-flex items-center text-gray-700 hover:text-gray-900 transition duration-300 font-medium space-x-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Zurück</span>
    </a>


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

   <div class="max-w-7xl mx-auto px-0 py-6 ps-2 bg-white rounded-lg shadow-xl my-6">

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
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-md ">
                       <img :src="activeImage ? '{{ Storage::url('') }}' + activeImage : '{{ asset('images/placeholder.webp') }}'"
    alt="Hauptbild des Ersatzteils" class="w-full h-96 object-cover cursor-pointer"
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

           {{-- Right Column: Details & Seller info and other sections --}}
            <section class="flex flex-col justify-between gap-10">

                {{-- Title and Pricing --}}
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $usedVehiclePart->title }}
                    </h2>

                    <div class="flex items-baseline space-x-3 mb-6">
                        @if ($usedVehiclePart->price)
                            <p
                                class="text-3xl text-gray-700 font-extrabold [&>span]:text-base [&>span]:font-normal [&>span]:ml-1">
                                &euro;{{ number_format($usedVehiclePart->price, 2, ',', '.') }}
                                <span> / Einheit</span>
                            </p>
                        @else
                            <p class="text-xl italic text-gray-500">Preis auf Anfrage</p>
                        @endif
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-700">
                        @if ($usedVehiclePart->description)
                            {!! nl2br(e($usedVehiclePart->description)) !!}
                        @else
                            <p class="italic text-gray-400">Keine Beschreibung verfügbar.</p>
                        @endif
                    </div>
                </div>

          {{-- Seller / Anbieter Info --}}
<div class="border-t border-gray-300 pt-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-3">Anbieterinformationen</h3>

    @if ($usedVehiclePart->user)
        <dl class="space-y-2 text-gray-900">
            <div>
                <dt class="inline font-semibold">Name:</dt>
                <dd class="inline">{{ $usedVehiclePart->user->name }}</dd>
            </div>
            <div>
                <dt class="inline font-semibold">E-Mail:</dt>
                <dd class="inline">{{ $usedVehiclePart->user->email }}</dd>
            </div>
            @if($usedVehiclePart->user->city)
                <div>
                    <dt class="inline font-semibold">Stadt:</dt>
                    <dd class="inline">{{ $usedVehiclePart->user->city }}</dd>
                </div>
            @endif
        </dl>

        <div class="flex flex-wrap justify-center sm:justify-start items-center space-x-0 sm:space-x-3 pt-4 my-3 sm:pt-0">
            @auth
                @if (auth()->id() === $usedVehiclePart->user_id || auth()->user()->isAdmin())
                    {{-- Edit & Delete --}}
                    <a href="{{ route('ads.used-vehicle-parts.edit', $usedVehiclePart->id) }}" 
                        class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Anzeige bearbeiten
                    </a>
                    <form action="{{ route('ads.used-vehicle-parts.destroy', $usedVehiclePart->id) }}" method="POST"
                        onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="px-5 py-2 bg-red-600 hover:bg-gray-700 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                                <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z" clip-rule="evenodd" />
                            </svg>
                            <span>Anzeige löschen</span>
                        </button>
                    </form>
                @else
                    {{-- Contact button for logged-in non-owners --}}
              <a href="{{ route('messages.start.redirect', [
                                        'ad' => $usedVehiclePart->id,
                                        'receiver' => $usedVehiclePart->user->id,
                                        'category' => 'vehicles-parts'
                                    ]) }}"
                                                    class="mt-6 block w-full text-center bg-red-700 text-white font-semibold py-3 rounded-full shadow-lg hover:bg-gray-800 transition focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75">
                                                    Contact with seller
                                                </a>
                @endif
            @endauth

            @guest
                {{-- Contact button for guests --}}
       <a href="{{ route('login') }}" 
       class="mt-6 block w-full text-center bg-blue-600 text-white font-semibold py-3 rounded-full shadow-lg hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-500 focus:ring-opacity-75">
       contact with seller
    </a>
     
            @endguest
        </div>

    @else
        {{-- No user data --}}
        <p class="italic text-red-600">Anbieterinformationen nicht verfügbar.</p>
    @endif
</div>


              

            </section> {{-- End of Right Column --}}
        </article>

        <hr class="my-8 border-gray-200" />

        {{-- Description Section --}}
        {{-- <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-gray-700 leading-relaxed">{{ $usedVehiclePart->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section> --}}

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