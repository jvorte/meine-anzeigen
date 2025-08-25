<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ad: {{ $realEstate->title }}</title>
            <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <button class="print-button" onclick="window.print()">Print this page</button>

 
            <article class="max-w-6xl mx-auto bg-white rounded-2xl shadow-2xl p-8 lg:p-14 py-8">
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
                        </p>
                        @else
                        <p class="text-xl italic text-gray-500">{{ __('price_on_request') }}</p>
                        @endif
                    </div>

                    {{-- Main Description --}}
                    <div class="prose prose-lg max-w-none text-gray-700">
                        @if ($realEstate->description)
                            {!! nl2br(e($realEstate->description)) !!}
                        @else
                            <p class="italic text-gray-400">{{ __('No description available') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Seller / Anbieter Info --}}
                <div class="border-t border-gray-300 pt-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">{{ __('Seller details')}}</h3>

                    @if ($realEstate->user)
                    <dl class="space-y-2 text-gray-900">
                        <div>
                            <dt class="inline font-semibold">Name:</dt>
                            <dd class="inline">{{ $realEstate->user->name }}</dd>
                        </div>

                        <div>
                            @if($realEstate->show_phone && !empty($realEstate->user->phone))
                            <dt class="inline font-semibold">Phone:</dt>
                            <dd class="inline">{{ $realEstate->user->phone }}</dd>
                            @endif

                            @if($realEstate->show_mobile_phone && !empty($realEstate->user->mobile_phone))
                            <dt class="inline font-semibold">Mobile:</dt>
                            <dd class="inline">{{ $realEstate->user->mobile_phone }}</dd>
                            @endif
                        </div>

                        <div>
                            @if($realEstate->show_email && !empty($realEstate->user->email))
                            <dt class="inline font-semibold">E-Mail:</dt>
                            <dd class="inline">{{ $realEstate->user->email }}</dd>
                            @endif
                        </div>
                        @if($realEstate->user->city)
                        <div>
                            <dt class="inline font-semibold">{{ __('location') }}:</dt>
                            <dd class="inline">{{ $realEstate->user->city }}</dd>
                        </div>
                        @endif
                    </dl>

              
                    @else
                    {{-- No user data --}}
                    <p class="italic text-red-600">{{ __('Seller information not available') }}</p>
                    @endif
                </div>
            </section> {{-- End of Right Column --}}
        </div> {{-- End of grid wrapper div --}}

        <hr class="my-8 border-t border-gray-300">

        {{-- Consolidated Details Section --}}
        <section>
            <h4 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">{{ __('Details') }}</h4>
            <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
                {{-- Price & Area --}}
                @if ($realEstate->price)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('price') }}:</dt>
                    <dd class="text-gray-700 mt-1">&euro;{{ number_format($realEstate->price, 2, ',', '.') }}</dd>
                </div>
                @endif
                @if ($realEstate->livingSpace)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Living space') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ number_format($realEstate->livingSpace, 2, ',', '.') }} m&sup2;</dd>
                </div>
                @endif
                @if ($realEstate->grundflaeche)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Floor area') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ number_format($realEstate->grundflaeche, 2, ',', '.') }} m&sup2;</dd>
                </div>
                @endif
                @if ($realEstate->kaution)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Warranty') }}:</dt>
                    <dd class="text-gray-700 mt-1">&euro;{{ number_format($realEstate->kaution, 2, ',', '.') }}</dd>
                </div>
                @endif
                @if ($realEstate->maklerprovision)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Brokerage commission') }}:</dt>
                    <dd class="text-gray-700 mt-1">&euro;{{ number_format($realEstate->maklerprovision, 2, ',', '.') }}</dd>
                </div>
                @endif
                @if ($realEstate->abloese)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Transfer fee') }}:</dt>
                    <dd class="text-gray-700 mt-1">&euro;{{ number_format($realEstate->abloese, 2, ',', '.') }}</dd>
                </div>
                @endif
            </dl>
            

            <hr class="my-8 border-t border-gray-300">

            <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
                {{-- Basic Data --}}
                @if ($realEstate->year_of_construction)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Year of construction of property') }}</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->year_of_construction }}</dd>
                </div>
                @endif

                @if ($realEstate->propertyTypeOptions)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Object type') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->propertyTypeOptions) }}</dd>
                </div>
                @endif
                @if ($realEstate->objekttyp)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Options') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->objekttyp) }}</dd>
                </div>
                @endif
                @if ($realEstate->condition)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('condition') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->condition) }}</dd>
                </div>
                @endif
                @if ($realEstate->anzahl_zimmer)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Number of Rooms') }}</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->anzahl_zimmer }}</dd>
                </div>
                @endif
                @if ($realEstate->constructionTypeOption)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('ConstructionType') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->constructionTypeOption) }}</dd>
                </div>
                @endif
                @if ($realEstate->verfugbarkeit)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Availability') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->verfugbarkeit) }}</dd>
                </div>
                @endif
                @if ($realEstate->befristung)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Term Contract Option') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->befristung) }}</dd>
                </div>
                @endif
                @if (!is_null($realEstate->pet_friendly))
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Pet Friendly') }}</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ $realEstate->pet_friendly ? __('Yes') : __('No') }}</dd>
                </div>
                @endif
                @if ($realEstate->befristung_ende)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('End of term') }}</dt>
                    <dd class="text-gray-700 mt-1">{{ \Carbon\Carbon::parse($realEstate->befristung_ende)->format('d.m.Y') }}</dd>
                </div>
                @endif
            </dl>

            <hr class="my-8 border-t border-gray-300">

            {{-- Location Details --}}
            <h4 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">{{ __('Location') }}</h4>
            <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Country') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->land }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Postal code') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->postcode }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('location') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->location }}</dd>
                </div>
                @if ($realEstate->strasse)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Street') }}:</dt>
                    <dd class="text-gray-700 mt-1">{{ $realEstate->strasse }}</dd>
                </div>
                @endif
            </dl>
            
            <hr class="my-8 border-t border-gray-300">

            {{-- Equipment & Heating --}}
            <h4 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">{{ __('Equipment & Heating') }}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
                @if ($realEstate->heating)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Heating Options') }}:</dt>
                    {{-- THIS LINE IS UPDATED --}}
                    <dd class="text-gray-700 mt-1">{{ __($realEstate->heating) }}</dd>
                </div>
                @endif
                @if ($realEstate->ausstattung && count($realEstate->ausstattung) > 0)
                <div class="md:col-span-2 lg:col-span-3">
                    <dt class="font-semibold text-gray-800 mb-2">{{ __('Equipment') }}:</dt>
                    <ul class="list-disc list-inside text-gray-700 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1">
                        @foreach ($realEstate->ausstattung as $item)
                            {{-- THIS LINE IS UPDATED --}}
                            <li>{{ __($item) }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <hr class="my-8 border-t border-gray-300">
            
            {{-- Documents --}}
            <h4 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">{{ __('Documents') }}</h4>
            <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
                @if ($realEstate->grundriss_path)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Floor plan') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ Storage::url($realEstate->grundriss_path) }}" target="_blank" class="text-blue-600 hover:underline"> (PDF/Bild)</a>
                    </dd>
                </div>
                @endif
                @if ($realEstate->energieausweis_path)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Energy certificate') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ Storage::url($realEstate->energieausweis_path) }}" target="_blank" class="text-blue-600 hover:underline">(PDF/Bild)</a>
                    </dd>
                </div>
                @endif
                @if ($realEstate->rundgang_link)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('360° Tour Link') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ $realEstate->rundgang_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->rundgang_link }}</a>
                    </dd>
                </div>
                @endif
                @if ($realEstate->objektinformationen_link)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Property information link') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ $realEstate->objektinformationen_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->objektinformationen_link }}</a>
                    </dd>
                </div>
                @endif
                @if ($realEstate->zustandsbericht_link)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Status report link') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ $realEstate->zustandsbericht_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->zustandsbericht_link }}</a>
                    </dd>
                </div>
                @endif
                @if ($realEstate->verkaufsbericht_link)
                <div>
                    <dt class="font-semibold text-gray-800">{{ __('Sales Report Link') }}:</dt>
                    <dd class="text-gray-700 mt-1">
                        <a href="{{ $realEstate->verkaufsbericht_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->verkaufsbericht_link }}</a>
                    </dd>
                </div>
                @endif
            </dl>
        </section>
    </article>
                    
    <script>
        // Automatically trigger the print dialog when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>