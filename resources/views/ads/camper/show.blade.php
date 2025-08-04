{{-- resources/views/campers/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        {{-- Header with "Neu Anzeige" button on top right --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Camper Anzeige
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Detaillierte Ansicht Ihrer Camper-Anzeige
                </p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('ads.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-red-700 text-white rounded-full shadow-lg hover:bg-gray-800 focus:ring-4 focus:ring-gray-400 focus:ring-opacity-50 transition transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Neu Anzeige
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-10">
        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
        ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
        ['label' => 'Campers', 'url' => route('categories.show', 'campers')],
        ['label' => $camper->title, 'url' => null],
    ]" class="mb-8" />

        {{-- Action Buttons and Back link --}}
        <div class="flex flex-col sm:flex-row justify-between my-4 gap-4">
            <a href="javascript:history.back()"
                class="inline-flex items-center text-gray-700 hover:text-gray-900 transition duration-300 font-medium space-x-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Zurück</span>
            </a>

            <div
                class="flex flex-wrap justify-center sm:justify-start items-center space-x-0 sm:space-x-3 pt-4 sm:pt-0">
                @auth
                    @if (auth()->id() === $camper->user_id || (auth()->user() && auth()->user()->isAdmin()))
                        <a href="{{ route('ads.camper.edit', $camper->id) }}"
                            class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Anzeige bearbeiten
                        </a>
                        <form action="{{ route('ads.camper.destroy', $camper->id) }}" method="POST"
                            onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2 bg-red-600 hover:bg-gray-700 text-white rounded-full shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                                    <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Anzeige löschen</span>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        <article class="bg-white rounded-2xl shadow-2xl p-8 lg:p-14 grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- Left Column: Images and Thumbnails --}}
            <section x-data="{
                images: @js($camper->images->pluck('image_path')),
                activeImage: '{{ $camper->images->first()->image_path ?? '' }}',
                showModal: false,
                scaleUp: false,
                currentIndex: 0,
                init() {
                    this.currentIndex = this.images.indexOf(this.activeImage);
                },
                changeImage(image_path) {
                    this.scaleUp = false;
                    this.activeImage = image_path;
                    this.currentIndex = this.images.indexOf(image_path);
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
            }" x-init="init" @keydown.escape.window="closeModal" class="flex flex-col items-center space-y-6">

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
                    @foreach ($camper->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail"
                            @click="changeImage('{{ $image->image_path }}')"
                            class="flex-shrink-0 w-20 h-20 rounded-xl object-cover cursor-pointer shadow-md transform transition duration-300 hover:scale-105 ring-2 focus:ring-4 focus:ring-gray-700 focus:outline-none"
                            :class="activeImage === '{{ $image->image_path }}' ? 'ring-gray-700 ring-4' : 'ring-transparent'"
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

            {{-- Right Column: Details & Seller info --}}
            <section class="flex flex-col justify-between gap-10">

                {{-- Title and Pricing --}}
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $camper->title }}
                    </h2>

                    <div class="flex items-baseline space-x-3 mb-6">
                        @if ($camper->price)
                            <p
                                class="text-3xl text-gray-700 font-extrabold [&>span]:text-base [&>span]:font-normal [&>span]:ml-1">
                                &euro;{{ number_format($camper->price, 2, ',', '.') }}
                                <span> / Einheit</span>
                            </p>
                        @else
                            <p class="text-xl italic text-gray-500">Preis auf Anfrage</p>
                        @endif
                    </div>




                    <div class="prose prose-lg max-w-none text-gray-700">
                        @if ($camper->description)
                            {!! nl2br(e($camper->description)) !!}
                        @else
                            <p class="italic text-gray-400">Keine Beschreibung verfügbar.</p>
                        @endif
                    </div>
                </div>



                {{-- Seller / Anbieter Info --}}
                <div class="border-t border-gray-300 pt-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Anbieterinformationen</h3>
                    @if ($camper->user)
                        <dl class="space-y-2 text-gray-900">
                            <div>
                                <dt class="inline font-semibold">Name:</dt>
                                <dd class="inline">{{ $camper->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="inline font-semibold">E-Mail:</dt>
                                <dd class="inline">{{ $camper->user->email }}</dd>
                            </div>
                            @if($camper->user->city)
                                <div>
                                    <dt class="inline font-semibold">Stadt:</dt>
                                    <dd class="inline">{{ $camper->user->city }}</dd>
                                </div>
                            @endif
                        </dl>
                        <a href="{{ route('messages.create', $camper->user->id) }}"
                            class="mt-6 block w-full text-center bg-red-700 text-white font-semibold py-3 rounded-full shadow-lg hover:bg-gray-800 transition focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75">
                            Kontakt aufnehmen
                        </a>
                    @else
                        <p class="italic text-red-600">Anbieterinformationen nicht verfügbar.</p>
                    @endif
                </div>

                <div class="bg-gray-100 shadow-md rounded-2xl p-6 space-y-6">

                    {{-- Camper Details Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        @if ($camper->camper_brand_id)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Marke</dt>
                                <dd class="text-gray-900">{{ $camper->camperBrand->name }}</dd>
                            </dl>
                        @endif

                        @if ($camper->camper_model_id)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Modell</dt>
                                <dd class="text-gray-900">{{ $camper->camperModel->name }}</dd>
                            </dl>
                        @endif

                        @if ($camper->color)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Farbe</dt>
                                <dd class="text-gray-900">{{ $camper->color }}</dd>
                            </dl>
                        @endif

                        @if ($camper->emission_class)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Emissionsklasse</dt>
                                <dd class="text-gray-900">{{ $camper->emission_class }}</dd>
                            </dl>
                        @endif

                        @if ($camper->first_registration)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Erstzulassung</dt>
                                <dd class="text-gray-900">{{ $camper->first_registration->format('d.m.Y') }}</dd>
                            </dl>
                        @endif

                        @if ($camper->camper_type)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Typ</dt>
                                <dd class="text-gray-900">{{ $camper->camper_type }}</dd>
                            </dl>
                        @endif

                        @if ($camper->mileage)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Kilometerstand</dt>
                                <dd class="text-gray-900">{{ number_format($camper->mileage, 0, ',', '.') }} km</dd>
                            </dl>
                        @endif

                        @if ($camper->condition)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Zustand</dt>
                                <dd class="text-gray-900">{{ $camper->condition }}</dd>
                            </dl>
                        @endif

                        @if ($camper->berths)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Schlafplätze</dt>
                                <dd class="text-gray-900">{{ $camper->berths }}</dd>
                            </dl>
                        @endif

                        @if ($camper->fuel_type)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Kraftstoffart</dt>
                                <dd class="text-gray-900">{{ $camper->fuel_type }}</dd>
                            </dl>
                        @endif

                        @if ($camper->transmission)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Getriebe</dt>
                                <dd class="text-gray-900">{{ $camper->transmission }}</dd>
                            </dl>
                        @endif

                        @if ($camper->power)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Leistung</dt>
                                <dd class="text-gray-900">{{ $camper->power }} PS</dd>
                            </dl>
                        @endif

                        @if ($camper->total_length)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Länge</dt>
                                <dd class="text-gray-900">{{ $camper->total_length }} m</dd>
                            </dl>
                        @endif

                        @if ($camper->total_width)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Breite</dt>
                                <dd class="text-gray-900">{{ $camper->total_width }} m</dd>
                            </dl>
                        @endif

                        @if ($camper->total_height)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Höhe</dt>
                                <dd class="text-gray-900">{{ $camper->total_height }} m</dd>
                            </dl>
                        @endif

                        @if ($camper->gross_vehicle_weight)
                            <dl>
                                <dt class="font-semibold text-gray-700 mb-1">Zul. Gesamtgewicht</dt>
                                <dd class="text-gray-900">{{ number_format($camper->gross_vehicle_weight, 0, ',', '.') }} kg
                                </dd>
                            </dl>
                        @endif

                        @if (isset($camper->features) && !empty($camper->features))
                            <dl class="col-span-1 sm:col-span-2"> {{-- Spans full width if a larger description --}}
                                <dt class="font-semibold text-gray-700 mb-1">Ausstattung</dt>
                                <dd class="text-gray-900 leading-relaxed whitespace-pre-wrap">
                                    {!! nl2br(e($camper->features)) !!}</dd>
                            </dl>
                        @endif
                    </div>


                </div>
            </section>
        </article>
    </div>

    {{-- Styles for no-scrollbar --}}
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>