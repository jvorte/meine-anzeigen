<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ad: {{ $commercialVehicle->title }}</title>
            <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <button class="print-button" onclick="window.print()">Print this page</button>

 
                <article class="bg-white rounded-2xl shadow-2xl p-8 lg:p-14 grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- Left Column: Images and Thumbnails --}}
            <section x-data="{
                images: @js($commercialVehicle->images->pluck('path')),
                activeImage: '{{ $commercialVehicle->images->first()->path ?? '' }}',
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
            }"
                x-init="init"
                @keydown.escape.window="closeModal"
                class="flex flex-col items-center space-y-6">

                {{-- Main Image Container --}}
                <div class="relative w-full rounded-3xl cursor-pointer shadow-lg overflow-hidden" @click="openModal" style="aspect-ratio: 4 / 3;">
                    <template x-if="activeImage">
                        <img
                            :src="'{{ Storage::url('') }}' + activeImage"
                            alt="Hauptbild"
                            class="object-cover w-full h-full transition-transform duration-700 ease-in-out rounded-3xl"
                            :class="{ 'scale-105 opacity-100': scaleUp, 'opacity-0': !scaleUp }"
                            @load="scaleUp = true"
                            loading="lazy"
                            draggable="false">
                    </template>

                    {{-- Overlay icon for fullscreen preview (magnifier) --}}
                    <div class="absolute bottom-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5 5m-1-10a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Thumbnails --}}
                <div class="flex space-x-4 overflow-x-auto no-scrollbar w-full max-w-xl px-2">
                    @foreach ($commercialVehicle->images as $image)
                    <img src="{{ Storage::url($image->path) }}" alt="Thumbnail"
                        @click="changeImage('{{ $image->path }}')"
                        class="flex-shrink-0 w-20 h-20 rounded-xl object-cover cursor-pointer shadow-md transform transition duration-300 hover:scale-105 ring-2 focus:ring-4 focus:ring-gray-700 focus:outline-none"
                        :class="activeImage === '{{ $image->path }}' ? 'ring-gray-700 ring-4' : 'ring-transparent'"
                        loading="lazy"
                        draggable="false">
                    @endforeach
                </div>

                {{-- Fullscreen Modal --}}
                <div
                    x-show="showModal"
                    x-transition.opacity
                    class="fixed inset-0 z-[60] bg-white bg-opacity-95 flex items-center justify-center p-4"
                    style="display: none;"
                    aria-modal="true" role="dialog">

                    {{-- Close Button --}}
                    <button @click="closeModal" aria-label="Schließen"
                        class="absolute top-8 right-8 text-gray-700 text-4xl font-extrabold hover:text-gray-900 transition focus:outline-none focus:ring-4 focus:ring-gray-400 rounded">
                        &times;
                    </button>

                    {{-- Previous Button --}}
                    <button
                        @click="prevImage"
                        :disabled="currentIndex === 0"
                        :class="{'opacity-50 cursor-not-allowed': currentIndex === 0}"
                        aria-label="Vorheriges Bild"
                        class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-700 bg-white rounded-full p-3 shadow-md hover:bg-gray-100 disabled:pointer-events-none transition focus:outline-none focus:ring-4 focus:ring-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                            <path d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Image in Modal --}}
                    <img
                        :src="'{{ Storage::url('') }}' + activeImage"
                        alt="Vergrößertes Bild"
                        class="max-h-[90vh] max-w-full rounded-3xl shadow-xl object-contain select-none"
                        draggable="false">

                    {{-- Next Button --}}
                    <button
                        @click="nextImage"
                        :disabled="currentIndex === images.length - 1"
                        :class="{'opacity-50 cursor-not-allowed': currentIndex === images.length - 1}"
                        aria-label="Nächstes Bild"
                        class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-700 bg-white rounded-full p-3 shadow-md hover:bg-gray-100 disabled:pointer-events-none transition focus:outline-none focus:ring-4 focus:ring-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
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
                        {{ $commercialVehicle->title }}
                    </h2>

                    <div class="flex items-baseline space-x-3 mb-6">
                        @if ($commercialVehicle->price)
                        <p class="text-3xl text-gray-700 font-extrabold [&>span]:text-base [&>span]:font-normal [&>span]:ml-1">
                            &euro;{{ number_format($commercialVehicle->price, 2, ',', '.') }}

                        </p>
                        @else
                        <p class="text-xl italic text-gray-500">{{ __('price_on_request') }}</p>
                        @endif
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-700">
                        @if ($commercialVehicle->description)
                        {!! nl2br(e($commercialVehicle->description)) !!}
                        @else
                        <p class="italic text-gray-400">{{ __('No description available') }}</p>
                        @endif
                    </div>
                </div>




                {{-- Seller / Anbieter Info --}}
                <div class="border-t border-gray-300 pt-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">{{ __('Seller details')}}</h3>

                    @if ($commercialVehicle->user)
                    <dl class="space-y-2 text-gray-900">
                        <div>
                            <dt class="inline font-semibold">Name:</dt>
                            <dd class="inline">{{ $commercialVehicle->user->name }}</dd>
                        </div>
                        <div>
                            @if($commercialVehicle->show_phone && !empty($commercialVehicle->user->phone))
                            <dt class="inline font-semibold">Phone:</dt>
                            <dd class="inline">{{ $commercialVehicle->user->phone }}</dd>
                            @endif

                            @if($commercialVehicle->show_mobile_phone && !empty($commercialVehicle->user->mobile_phone))
                            <dt class="inline font-semibold">Mobile:</dt>
                            <dd class="inline">{{ $commercialVehicle->user->mobile_phone }}</dd>
                            @endif
                        </div>


                        <div>
                            @if($commercialVehicle->show_email && !empty($commercialVehicle->user->email))
                            <dt class="inline font-semibold">E-Mail:</dt>
                            <dd class="inline">{{ $commercialVehicle->user->email }}</dd>
                            @endif
                        </div>
                        @if($commercialVehicle->user->city)
                        <div>
                            <dt class="inline font-semibold">{{ __('location') }}:</dt>
                            <dd class="inline">{{ $commercialVehicle->user->city }}</dd>
                        </div>
                        @endif
                    </dl>


                    @else
                    {{-- No user data --}}
                    <p class="italic text-red-600">{{ __('Seller information not available') }}</p>
                    @endif
                </div>




                <div class="bg-gray-100 shadow-md rounded-2xl p-6 space-y-6">

                    {{-- Boat Details Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        @if($commercialVehicle->commercialBrand) {{-- Check if the brand relationship exists --}}
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('brand') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->commercialBrand->name }}</p>
                        </div>
                        @endif

                        @if($commercialVehicle->commercialModel) {{-- Check if the model relationship exists --}}
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('model') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->commercialModel->name }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->first_registration)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('year_of_construction') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->first_registration }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->mileage)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Mileage') }}:</p>
                            <p class="text-gray-700">{{ number_format($commercialVehicle->mileage, 0, ',', '.') }} km</p>
                        </div>
                        @endif
                        @if($commercialVehicle->power)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Power') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->power }} PS</p>
                        </div>
                        @endif
                        @if($commercialVehicle->color)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Color') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->color }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->condition)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('condition_label') }}:</p>
                            <p class="text-gray-700">{{ ucfirst($commercialVehicle->condition) }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->commercial_vehicle_type)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Τype') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->commercial_vehicle_type }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->fuel_type)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('fuel') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->fuel_type }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->transmission)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('gearbox') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->transmission }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->payload_capacity)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Payload') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->payload_capacity }} kg</p>
                        </div>
                        @endif
                        @if($commercialVehicle->gross_vehicle_weight)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Total weight') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->gross_vehicle_weight }} kg</p>
                        </div>
                        @endif
                        @if($commercialVehicle->number_of_axles)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Number of axes') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->number_of_axles }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->emission_class)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Emission') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->emission_class }}</p>
                        </div>
                        @endif
                        @if($commercialVehicle->seats)
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ __('Seats') }}:</p>
                            <p class="text-gray-700">{{ $commercialVehicle->seats }}</p>
                        </div>
                        @endif
                    </div>
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