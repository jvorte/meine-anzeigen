{{-- resources/views/ads/boats/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        {{-- Header with "Neu Anzeige" button on top right --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                {{-- Changed "Immobilie" to "Real Estate" for consistency, assuming future refactor --}}
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Real Estate
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    View Real Estate Listing
                </p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('ads.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full shadow-lg hover:bg-gray-800 focus:ring-4 focus:ring-gray-400 focus:ring-opacity-50 transition transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{-- Changed "Neu Anzeige" to "New Listing" --}}
                    New Listing
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-3">
        {{-- Breadcrumbs component --}}
        <x-breadcrumbs :items="[
            {{-- Changed "Immobilien Anzeigen" to "Real Estate Listings" --}}
            ['label' => 'Real Estate Listings', 'url' => route('categories.show', 'immobilien')],
            ['label' => $realEstate->title, 'url' => null],
        ]" />
    </div>

    {{-- Action Buttons and Back link - Moved into the max-w-7xl container for consistent centering --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Added this wrapper div --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center text-gray-700 hover:text-gray-900 transition duration-300 font-medium space-x-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Zurück</span> {{-- Keep "Zurück" for now, as it's a simple display string --}}
            </a>

            <div class="flex items-center space-x-3 pt-3">
                @auth
                    @if (auth()->id() === $realEstate->user_id || (auth()->user() && auth()->user()->isAdmin()))
                        <a href="{{ route('ads.real-estate.edit', $realEstate->id) }}"
                            class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Anzeige bearbeiten {{-- Keep "Anzeige bearbeiten" for now --}}
                        </a>
                        <form action="{{ route('ads.real-estate.destroy', $realEstate->id) }}" method="POST"
                            onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2 bg-red-600 hover:bg-gray-700 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-500 focus:ring-offset-2 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
                                    class="w-5 h-5">
                                    <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Anzeige löschen</span> {{-- Keep "Anzeige löschen" for now --}}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div> {{-- End of new wrapper div --}}

    {{-- Main content article - This is where all the detail sections should live --}}
    <article class="max-w-7xl mx-auto bg-white rounded-2xl shadow-2xl p-8 lg:p-14 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12"> {{-- This div now wraps the two main columns --}}

            {{-- Left Column: Images and Thumbnails --}}
            <section x-data="{
                images: @js($realEstate->images->pluck('path')),
                activeImage: '{{ $realEstate->images->first()->path ?? '' }}',
                showModal: false,
                scaleUp: false,
                currentIndex: 0,
                init() {
                    this.currentIndex = this.images.indexOf(this.activeImage);
                },
                changeImage(path) {
                    this.scaleUp = false;
                    this.activeImage = path;
                    this.currentIndex = this.images.indexOf(path);
                    setTimeout(() => this.scaleUp = true, 50);
                },
                openModal() {
                    this.showModal = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeModal() {
                    this.showModal = false;
                    document.body.classList.remove('overflow-hidden');
                },
                nextImage() {
                    if (this.currentIndex < this.images.length - 1) {
                        this.changeImage(this.images[++this.currentIndex]);
                    }
                },
                prevImage() {
                    if (this.currentIndex > 0) {
                        this.changeImage(this.images[--this.currentIndex]);
                    }
                }
            }" x-init="init" @keydown.escape.window="closeModal"
                class="flex flex-col items-center space-y-6">

                {{-- Main Image Container --}}
                <div class="relative w-full rounded-3xl cursor-pointer shadow-lg overflow-hidden" @click="openModal"
                    style="aspect-ratio: 4 / 3;">
                    <template x-if="activeImage">
                        <img :src="'{{ Storage::url('') }}' + activeImage" alt="Hauptbild"
                            class="object-cover w-full h-full transition-transform duration-700 ease-in-out rounded-3xl"
                            :class="{ 'scale-105 opacity-100': scaleUp, 'opacity-0': !scaleUp }" @load="scaleUp = true"
                            loading="lazy" draggable="false">
                    </template>

                    {{-- Overlay icon for fullscreen preview (magnifier) --}}
                    <div
                        class="absolute bottom-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-6 h-6 text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 15l5 5m-1-10a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Thumbnails --}}
                <div class="flex space-x-4 overflow-x-auto no-scrollbar w-full max-w-xl px-2">
                    @foreach ($realEstate->images as $image)
                        <img src="{{ Storage::url($image->path) }}" alt="Thumbnail"
                            @click="changeImage('{{ $image->path }}')"
                            class="flex-shrink-0 w-20 h-20 rounded-xl object-cover cursor-pointer shadow-md transform transition duration-300 hover:scale-105 ring-2 focus:ring-4 focus:ring-gray-700 focus:outline-none"
                            :class="activeImage === '{{ $image->path }}' ? 'ring-gray-700 ring-4' : 'ring-transparent'"
                            loading="lazy" draggable="false">
                    @endforeach
                </div>

                {{-- Fullscreen Modal --}}
                <div x-show="showModal" x-transition.opacity
                    class="fixed inset-0 z-[60] bg-white bg-opacity-95 flex items-center justify-center p-4"
                    style="display: none;" aria-modal="true" role="dialog">

                    {{-- Close Button --}}
                    <button @click="closeModal" aria-label="Schließen"
                        class="absolute top-8 right-8 text-gray-700 text-4xl font-extrabold hover:text-gray-900 transition focus:outline-none focus:ring-4 focus:ring-gray-400 rounded">
                        &times;
                    </button>

                    {{-- Previous Button --}}
                    <button @click="prevImage" :disabled="currentIndex === 0"
                        :class="{'opacity-50 cursor-not-allowed': currentIndex === 0}" aria-label="Vorheriges Bild"
                        class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-700 bg-white rounded-full p-3 shadow-md hover:bg-gray-100 disabled:pointer-events-none transition focus:outline-none focus:ring-4 focus:ring-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                            <path d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Image in Modal --}}
                    <img :src="'{{ Storage::url('') }}' + activeImage" alt="Vergrößertes Bild"
                        class="max-h-[90vh] max-w-full rounded-3xl shadow-xl object-contain select-none"
                        draggable="false">

                    {{-- Next Button --}}
                    <button @click="nextImage" :disabled="currentIndex === images.length - 1"
                        :class="{'opacity-50 cursor-not-allowed': currentIndex === images.length - 1}"
                        aria-label="Nächstes Bild"
                        class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-700 bg-white rounded-full p-3 shadow-md hover:bg-gray-100 disabled:pointer-events-none transition focus:outline-none focus:ring-4 focus:ring-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

            </section>

            {{-- Right Column: Details & Seller info and other sections --}}
            <section class="flex flex-col justify-between gap-10">

                {{-- Title and Pricing --}}
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $realEstate->title }}
                    </h2>

                    <div class="flex items-baseline space-x-3 mb-6">
                        @if ($realEstate->price)
                            <p
                                class="text-3xl text-gray-700 font-extrabold [&>span]:text-base [&>span]:font-normal [&>span]:ml-1">
                                &euro;{{ number_format($realEstate->price, 2, ',', '.') }}
                                <span> / Einheit</span>
                            </p>
                        @else
                            <p class="text-xl italic text-gray-500">Preis auf Anfrage</p>
                        @endif
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-700">
                        @if ($realEstate->description)
                            {!! nl2br(e($realEstate->description)) !!}
                        @else
                            <p class="italic text-gray-400">Keine Beschreibung verfügbar.</p>
                        @endif
                    </div>
                </div>

                {{-- Seller / Anbieter Info --}}
                <div class="border-t border-gray-300 pt-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Anbieterinformationen</h3>
                    @if ($realEstate->user)
                        <dl class="space-y-2 text-gray-900">
                            <div>
                                <dt class="inline font-semibold">Name:</dt>
                                <dd class="inline">{{ $realEstate->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="inline font-semibold">E-Mail:</dt>
                                <dd class="inline">{{ $realEstate->user->email }}</dd>
                            </div>
                            @if ($realEstate->user->city)
                                <div>
                                    <dt class="inline font-semibold">Stadt:</dt>
                                    <dd class="inline">{{ $realEstate->user->city }}</dd>
                                </div>
                            @endif
                        </dl>
                        <a href="{{ route('messages.create', $realEstate->user->id) }}"
                            class="mt-6 block w-full text-center bg-red-700 text-white font-semibold py-3 rounded-full shadow-lg hover:bg-gray-800 transition focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75">
                            Kontakt aufnehmen
                        </a>
                    @else
                        <p class="italic text-red-600">Anbieterinformationen nicht verfügbar.</p>
                    @endif
                </div>

              

            </section> {{-- End of Right Column --}}
        </div> {{-- End of grid wrapper div --}}

        {{-- These sections were previously outside the main article, now correctly placed inside it --}}

        {{-- Description Section --}}

        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> 
                <div>
                
                 
                         <h4 class="text-xl font-semibold text-gray-700 mb-6">Hauptbeschreibung</h4>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->description }}</p>
                </div>
        </section>
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> 
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
                @if ($realEstate->objektbeschreibung)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Objektbeschreibung:</p>
                        <p class="text-gray-700 leading-relaxed">{{ $realEstate->objektbeschreibung }}</p>
                    </div>
                @endif
                @if ($realEstate->lage)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Lagebeschreibung:</p>
                        <p class="text-gray-700 leading-relaxed">{{ $realEstate->lage }}</p>
                    </div>
                @endif
                @if ($realEstate->sonstiges)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Sonstiges:</p>
                        <p class="text-gray-700 leading-relaxed">{{ $realEstate->sonstiges }}</p>
                    </div>
                @endif
                @if ($realEstate->zusatzinformation)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Zusatzinformation:</p>
                        <p class="text-gray-700 leading-relaxed">{{ $realEstate->zusatzinformation }}</p>
                    </div>
                @endif
                 <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Immobilientyp:</p>
                        <p class="text-gray-700">{{ $realEstate->immobilientyp }}</p>
                    </div>
                    @if ($realEstate->objekttyp)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Objekttyp:</p>
                            <p class="text-gray-700">{{ $realEstate->objekttyp }}</p>
                        </div>
                    @endif
                    @if ($realEstate->zustand)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                            <p class="text-gray-700">{{ $realEstate->zustand }}</p>
                        </div>
                    @endif
                    @if ($realEstate->anzahl_zimmer)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Anzahl Zimmer:</p>
                            <p class="text-gray-700">{{ $realEstate->anzahl_zimmer }}</p>
                        </div>
                    @endif
                    @if ($realEstate->bautyp)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Bautyp:</p>
                            <p class="text-gray-700">{{ $realEstate->bautyp }}</p>
                        </div>
                    @endif
                    @if ($realEstate->verfugbarkeit)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Verfügbarkeit:</p>
                            <p class="text-gray-700">{{ $realEstate->verfugbarkeit }}</p>
                        </div>
                    @endif
                    @if ($realEstate->befristung)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Befristung:</p>
                            <p class="text-gray-700">{{ $realEstate->befristung }}</p>
                        </div>
                    @endif
                    @if ($realEstate->befristung_ende)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Befristung Ende:</p>
                            <p class="text-gray-700">{{ \Carbon\Carbon::parse($realEstate->befristung_ende)->format('d.m.Y') }}</p>
                        </div>
                    @endif
            </div>


        </section>

        {{-- Location Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> 
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Standort</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Land:</p>
                    <p class="text-gray-700">{{ $realEstate->land }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Postleitzahl:</p>
                    <p class="text-gray-700">{{ $realEstate->plz }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Ort:</p>
                    <p class="text-gray-700">{{ $realEstate->ort }}</p>
                </div>
                @if ($realEstate->strasse)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Straße:</p>
                        <p class="text-gray-700">{{ $realEstate->strasse }}</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Prices & Areas Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> {{-- Added mt-8 for spacing --}}
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise & Flächen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($realEstate->price)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Gesamtmiete:</p>
                        <p class="text-gray-700">&euro;{{ number_format($realEstate->price, 2, ',', '.') }}</p>
                    </div>
                @endif
                @if ($realEstate->wohnflaeche)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Wohnfläche:</p>
                        <p class="text-gray-700">{{ number_format($realEstate->wohnflaeche, 2, ',', '.') }} m&sup2;</p>
                    </div>
                @endif
                @if ($realEstate->grundflaeche)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Grundfläche:</p>
                        <p class="text-gray-700">{{ number_format($realEstate->grundflaeche, 2, ',', '.') }} m&sup2;</p>
                    </div>
                @endif
                @if ($realEstate->kaution)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kaution:</p>
                        <p class="text-gray-700">&euro;{{ number_format($realEstate->kaution, 2, ',', '.') }}</p>
                    </div>
                @endif
                @if ($realEstate->maklerprovision)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Maklerprovision:</p>
                        <p class="text-gray-700">&euro;{{ number_format($realEstate->maklerprovision, 2, ',', '.') }}</p>
                    </div>
                @endif
                @if ($realEstate->abloese)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Ablöse:</p>
                        <p class="text-gray-700">&euro;{{ number_format($realEstate->abloese, 2, ',', '.') }}</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Ausstattung & Heating Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> {{-- Added mt-8 for spacing --}}
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung & Heizung</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($realEstate->heizung)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Heizung:</p>
                        <p class="text-gray-700">{{ $realEstate->heizung }}</p>
                    </div>
                @endif

                @if ($realEstate->ausstattung && count($realEstate->ausstattung) > 0)
                    <div class="md:col-span-2 lg:col-span-3">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Ausstattung:</p>
                        <ul class="list-disc list-inside text-gray-700 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1">
                            @foreach ($realEstate->ausstattung as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mt-8"> {{-- Added mt-8 for spacing --}}
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               

                @if ($realEstate->grundriss_path)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Grundriss:</p>
                        <a href="{{ Storage::url($realEstate->grundriss_path) }}" target="_blank"
                            class="text-blue-600 hover:underline">Ansehen (PDF/Bild)</a>
                    </div>
                @endif

                @if ($realEstate->energieausweis_path)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Energieausweis:</p>
                        <a href="{{ Storage::url($realEstate->energieausweis_path) }}" target="_blank"
                            class="text-blue-600 hover:underline">Ansehen (PDF/Bild)</a>
                    </div>
                @endif

                @if ($realEstate->rundgang_link)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">360° Rundgang Link:</p>
                        <a href="{{ $realEstate->rundgang_link }}" target="_blank"
                            class="text-blue-600 hover:underline">{{ $realEstate->rundgang_link }}</a>
                    </div>
                @endif

                @if ($realEstate->objektinformationen_link)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Objektinformationen Link:</p>
                        <a href="{{ $realEstate->objektinformationen_link }}" target="_blank"
                            class="text-blue-600 hover:underline">{{ $realEstate->objektinformationen_link }}</a>
                    </div>
                @endif

                @if ($realEstate->zustandsbericht_link)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Zustandsbericht Link:</p>
                        <a href="{{ $realEstate->zustandsbericht_link }}" target="_blank"
                            class="text-blue-600 hover:underline">{{ $realEstate->zustandsbericht_link }}</a>
                    </div>
                @endif

                @if ($realEstate->verkaufsbericht_link)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Verkaufsbericht Link:</p>
                        <a href="{{ $realEstate->verkaufsbericht_link }}" target="_blank"
                            class="text-blue-600 hover:underline">{{ $realEstate->verkaufsbericht_link }}</a>
                    </div>
                @endif
            </div>
        </section>

 
    </article> {{-- End of main content article --}}

  
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</x-app-layout>