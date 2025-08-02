{{-- resources/views/ads/services/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        {{-- "Neu Anzeige" button --}}
        <div class="px-4 py-1 md:py-1 flex justify-end items-center">
            <a href="{{ route('ads.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Neu Anzeige
            </a>
        </div>
        {{-- Main page title --}}
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Dienstleistung Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Dienstleistungsanzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                ['label' => 'Dienstleistungen', 'url' => route('categories.show', 'services')], {{-- Assuming 'services' is the slug for services --}}
                ['label' => $service->title, 'url' => null],
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
<div class="max-w-6xl mx-auto my-5 flex justify-between items-center">
    <!-- Αριστερό κουμπί -->
    <div>
  

<a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-700 hover:text-indigo-600 transition duration-200">
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    {{ __('Back') }}
</a>


    </div>

    <!-- Δεξιό μπλοκ κουμπιών -->
    <div class="flex space-x-4 items-center">
 

        @auth
            @if (auth()->id() === $service->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.services.edit', $service->id) }}" class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 text-xs rounded-md hover:bg-blue-50 transition">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.services.destroy', $service->id) }}" method="POST"
                    onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-600 text-red-600 text-xs rounded-md hover:bg-red-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z" clip-rule="evenodd" />
                        </svg>
                        Anzeige löschen
                    </button>
                </form>
            @endif
        @endauth
    </div>
</div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        {{-- Main Title of the Ad --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $service->title }}</h1>

  <div x-data="{
        images: @js($service->images->pluck('path')),
        activeImage: '{{ $service->images->first()->path ?? '' }}',
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
    class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12"
>
    {{-- Κεντρική Εικόνα --}}
    <div class="flex flex-col items-center">
        <div class="relative w-full h-96 overflow-hidden rounded-lg cursor-pointer" @click="openModal">
            <template x-if="activeImage">
                <img 
                    :src="'{{ Storage::url('') }}' + activeImage" 
                    class="absolute inset-0 w-full h-full object-cover rounded-lg shadow transition duration-500 ease-in-out transform"
                    :class="{ 'scale-105 opacity-100': scaleUp, 'opacity-0': !scaleUp }"
                    @load="scaleUp = true"
                    alt="Selected"
                >
            </template>
        </div>

        {{-- Thumbnails --}}
        <div class="flex mt-4 gap-3 overflow-x-auto">
            @foreach ($service->images as $image)
                <img 
                    src="{{ Storage::url($image->path) }}" 
                    @click="changeImage('{{ $image->path }}')" 
                    class="w-24 h-24 object-cover rounded cursor-pointer border-2 transition" 
                    :class="{ 'border-rose-500': activeImage === '{{ $image->path }}' }"
                    alt="Thumb"
                >
            @endforeach
        </div>
    </div>

    {{-- Πληροφορίες Πωλητή --}}
    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Anbieterinformationen</h3>

        @if($service->user)
            <p><span class="font-semibold">Name:</span> {{ $service->user->name }}</p>
            <p><span class="font-semibold">E-Mail:</span> {{ $service->user->email }}</p>
            <a href="{{ route('messages.create', $service->user->id) }}" class="mt-4 inline-block bg-rose-600 text-white px-4 py-2 rounded hover:bg-rose-700 transition">
                Kontakt aufnehmen
            </a>
        @else
            <p class="text-red-600 italic">Anbieterinformationen nicht verfügbar.</p>
        @endif
    </div>

    {{-- Fullscreen Modal --}}
    <div 
        x-show="showModal" 
        x-transition.opacity 
        class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center"
        style="display: none;"
    >
        <button @click="closeModal" class="absolute top-6 right-6 text-white text-3xl font-bold">&times;</button>

        <div class="relative max-w-4xl w-full px-4">
            <button @click="prevImage" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white text-4xl px-4">&#10094;</button>
            <img 
                :src="'{{ Storage::url('') }}' + activeImage" 
                class="mx-auto max-h-[90vh] object-contain transition duration-500 ease-in-out transform scale-100 opacity-100" 
                alt="Fullscreen"
            >
            <button @click="nextImage" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white text-4xl px-4">&#10095;</button>
        </div>
    </div>
</div>


        {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">
                    @if ($service->price)
                        &euro;{{ number_format($service->price, 2, ',', '.') }}
                    @else
                        Nach Absprache
                    @endif
                </p>
            </div>
        </section>

 

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $service->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section>



        {{-- Service Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Dienstleistungsdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($service->service_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Art der Dienstleistung:</p>
                    <p class="text-gray-700">{{ $service->service_type }}</p>
                </div>
                @endif
                @if($service->availability)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Verfügbarkeit:</p>
                    <p class="text-gray-700">{{ $service->availability }}</p>
                </div>
                @endif
                @if($service->location)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Standort / Region:</p>
                    <p class="text-gray-700">{{ $service->location }}</p>
                </div>
                @endif 

            </div>
        </section>

        {{-- Photos & Documents Section --}}
        {{-- <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (isset($service->images) && $service->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($service->images as $image)
                                <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->path) }}" alt="Dienstleistungsbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic">Es sind keine Bilder für diese Dienstleistung verfügbar.</p>
                @endif
             
            </div>
        </section> --}}

 

      
    </div>
</x-app-layout>