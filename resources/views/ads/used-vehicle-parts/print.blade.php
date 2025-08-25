<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ad: {{ $usedVehiclePart->title }}</title>
            <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <button class="print-button" onclick="window.print()">Print this page</button>

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
                  
                        @if (isset($usedVehiclePart->images) && $usedVehiclePart->images->count() > 0)



                        {{-- Main Image Display --}}
                        <div class="relative bg-gray-100 rounded-lg overflow-hidden shadow-md ">
                            <img :src="activeImage ? '{{ Storage::url('') }}' + activeImage : '{{ asset('images/placeholder.webp') }}'"
                                alt="Hauptbild des Ersatzteils" class="w-full h-96 object-cover cursor-pointer"
                                @click="openModal(activeImage)">

                            <div x-cloak x-show="!activeImage"
                                class="absolute inset-0 flex items-center justify-center text-gray-500">
                           {{ __('No image available') }}
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
                            <p>{{ __('No image available') }}</p>
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
                              
                                </p>
                                @else
                                <p class="text-xl italic text-gray-500">{{ __('price_on_request') }}</p>
                                @endif
                            </div>

                            <div class="prose prose-lg max-w-none text-gray-700">
                                @if ($usedVehiclePart->description)
                                {!! nl2br(e($usedVehiclePart->description)) !!}
                                @else
                                <p class="italic text-gray-400">{{ __('No description available') }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Seller / Anbieter Info --}}
                        <div class="border-t border-gray-300 pt-6">
                            <h3 class="text-xl font-semibold text-gray-700 mb-3">{{ __('Seller details')}}</h3>

                            @if ($usedVehiclePart->user)
                            <dl class="space-y-2 text-gray-900">
                                <div>
                                    <dt class="inline font-semibold">Name:</dt>
                                    <dd class="inline">{{ $usedVehiclePart->user->name }}</dd>
                                </div>
                                <div>
                                    @if($usedVehiclePart->show_phone && !empty($usedVehiclePart->user->phone))
                                    <dt class="inline font-semibold">Phone:</dt>
                                    <dd class="inline">{{ $usedVehiclePart->user->phone }}</dd>
                                    @endif

                                    @if($usedVehiclePart->show_mobile_phone && !empty($usedVehiclePart->user->mobile_phone))
                                    <dt class="inline font-semibold">Mobile:</dt>
                                    <dd class="inline">{{ $usedVehiclePart->user->mobile_phone }}</dd>
                                    @endif
                                </div>


                                <div>
                                    @if($usedVehiclePart->show_email && !empty($usedVehiclePart->user->email))
                                    <dt class="inline font-semibold">E-Mail:</dt>
                                    <dd class="inline">{{ $usedVehiclePart->user->email }}</dd>
                                    @endif
                                </div>

                                @if($usedVehiclePart->user->city)
                                <div>
                                    <dt class="inline font-semibold">{{ __('location') }}:</dt>
                                    <dd class="inline">{{ $usedVehiclePart->user->city }}</dd>
                                </div>
                                @endif
                            </dl>

                        

                            @else
                            {{-- No user data --}}
                            <p class="italic text-red-600">{{ __('Seller information not available') }}</p>
                            @endif
                        </div>




                    </section> {{-- End of Right Column --}}
                </article>
        
                    
    <script>
        // Automatically trigger the print dialog when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>