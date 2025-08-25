<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ad: {{ $car->title }}</title>
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
                images: @js($car->images->pluck('image_path')),
                activeImage: '{{ $car->images->first()->image_path ?? '' }}',
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
                @foreach ($car->images as $image)
                <img
                    src="{{ Storage::url($image->image_path) }}"
                    @click="changeImage('{{ $image->image_path }}')"
                    class="w-24 h-24 object-cover rounded cursor-pointer border-2 transition"
                    :class="{ 'border-rose-500': activeImage === '{{ $image->path }}' }"
                    alt="Thumb">
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
                    {{ $car->title }}
                </h2>

                <div class="flex items-baseline space-x-3 mb-6">
                    @if ($car->price)
                    <p class="text-3xl text-gray-700 font-extrabold [&>span]:text-base [&>span]:font-normal [&>span]:ml-1">
                        &euro;{{ number_format($car->price, 2, ',', '.') }}
                        <span> </span>
                    </p>
                    @else
                    <p class="text-xl italic text-gray-500">{{ __('price_on_request') }}</p>
                    @endif
                </div>

                <div class="prose prose-lg max-w-none text-gray-700">
                    @if ($car->description)
                    {!! nl2br(e($car->description)) !!}
                    @else
                    <p class="italic text-gray-400">{{ __('No description available') }}.</p>
                    @endif
                </div>
            </div>

            {{-- Seller / Anbieter Info --}}
            <div class="border-t border-gray-300 pt-6 mt-3">
                <h3 class="text-xl font-semibold text-gray-700 mb-3">{{ __('Seller details')}}</h3>

                @if ($car->user)
                <dl class="space-y-2 text-gray-900">
                    <div>
                        <dt class="inline font-semibold">Name:</dt>
                        <dd class="inline">{{ $car->user->name }}</dd>
                    </div>


                    <div>
                        @if($car->show_phone && !empty($car->user->phone))
                        <dt class="inline font-semibold">Phone:</dt>
                        <dd class="inline">{{ $car->user->phone }}</dd>
                        @endif

                        @if($car->show_mobile_phone && !empty($car->user->mobile_phone))
                        <dt class="inline font-semibold">Mobile:</dt>
                        <dd class="inline">{{ $car->user->mobile_phone }}</dd>
                        @endif
                    </div>


                    <div>
                        @if($car->show_email && !empty($car->user->email))
                        <dt class="inline font-semibold">E-Mail:</dt>
                        <dd class="inline">{{ $car->user->email }}</dd>
                        @endif
                    </div>


                    @if($car->user->city)
                    <div>
                        <dt class="inline font-semibold">{{ __('location') }}:</dt>
                        <dd class="inline">{{ $car->user->city }}</dd>
                    </div>
                    @endif
                </dl>

              

                @else
                {{-- No user data --}}
                <p class="italic text-red-600">{{ __('Seller information not available') }}</p>
                @endif
            </div>



            {{-- Vehicle Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('Vehicle details') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if($car->carBrand)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('brand') }}:</p>
                        <p class="text-gray-700">{{ $car->carBrand->name }}</p>
                    </div>
                    @endif
                    @if($car->carModel)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('model') }}:</p>
                        <p class="text-gray-700">{{ $car->carModel->name }}</p>
                    </div>
                    @endif
                    @if($car->registration)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('year_of_construction') }}:</p>
                        <p class="text-gray-700">{{ $car->registration }}</p>
                    </div>
                    @endif
                    @if($car->mileage)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Mileage') }}:</p>
                        <p class="text-gray-700">{{ number_format($car->mileage, 0, ',', '.') }} km</p>
                    </div>
                    @endif
                    @if($car->vehicle_type)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Τype') }}:</p>
                        <p class="text-gray-700">{{ $car->vehicle_type }}</p>
                    </div>
                    @endif
                    @if($car->condition)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('condition') }}:</p>
                        <p class="text-gray-700">{{ $car->condition }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Warranty') }}:</p>
                        <p class="text-gray-700">{{ $car->warranty ? 'Ja' : 'Nein' }}</p>
                    </div>
                    @if($car->power)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Power') }}:</p>
                        <p class="text-gray-700">{{ $car->power }} PS</p>
                    </div>
                    @endif
                    @if($car->fuel_type)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('fuel') }}:</p>
                        <p class="text-gray-700">{{ $car->fuel_type }}</p>
                    </div>
                    @endif
                    @if($car->transmission)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('gearbox') }}:</p>
                        <p class="text-gray-700">{{ $car->transmission }}</p>
                    </div>
                    @endif
                    @if($car->drive)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Wheel drive') }}:</p>
                        <p class="text-gray-700">{{ $car->drive }}</p>
                    </div>
                    @endif
                    @if($car->color)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Color') }}:</p>
                        <p class="text-gray-700">{{ $car->color }}</p>
                    </div>
                    @endif
                    @if($car->doors)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Doors') }}:</p>
                        <p class="text-gray-700">{{ $car->doors }}</p>
                    </div>
                    @endif
                    @if($car->seats)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Seats') }}:</p>
                        <p class="text-gray-700">{{ $car->seats }}</p>
                    </div>
                    @endif
                    @if($car->seller_type)
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ __('Provider') }}:</p>
                        <p class="text-gray-700">{{ $car->seller_type }}</p>
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