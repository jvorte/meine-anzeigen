{{-- resources/views/campers/show.blade.php --}}

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
            Campers Anzeigen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Camper-Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Campers Anzeigen', 'url' => route('categories.show', 'campers')],
                ['label' => $camper->title, 'url' => null], {{-- Dynamic label using camper title --}}
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button --}}
        @if ($camper->user)
            <a href="{{ route('messages.create', $camper->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Contact
            </a>
        @endif
        {{-- Edit/Delete Buttons (Visible to owner or admin) --}}
        @auth
            @if (auth()->id() === $camper->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.camper.edit', $camper->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.camper.destroy', $camper->id) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Anzeige löschen
                    </button>
                </form>
            @endif
        @endauth
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        {{-- Main Title of the Ad --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $camper->title }}</h1>

    

        {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($camper->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

    

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $camper->description }}</p>
            </div>
        </section>

           {{-- Camper Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Wohnmobildetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($camper->camper_brand_id)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Marke:</p>
                    <p class="text-gray-700">{{ $camper->camperBrand->name  }}</p>
                </div>
                @endif
                @if($camper->camper_model_id)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modell:</p>
                    <p class="text-gray-700">{{ $camper->camperModel->name }}</p>
                </div>
                @endif
                     @if($camper->color)
                <div>
                    <p class="text-sm font-semibold text-gray-800">	color:</p>
                    <p class="text-gray-700">{{ $camper->color }}</p>
                </div>
                @endif

                     @if($camper->emission_class)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Euro Class:</p>
                    <p class="text-gray-700">{{ $camper->emission_class }}</p>
                </div>
                @endif


                @if($camper->first_registration)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Baujahr:</p>
                    <p class="text-gray-700">{{ $camper->first_registration->format('d.m.Y') }}</p>
                </div>
                @endif
                 @if($camper->camper_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">camper_type:</p>
                    <p class="text-gray-700">{{ $camper->camper_type }}</p>
                </div>
                @endif

                
                @if($camper->mileage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kilometerstand:</p>
                    <p class="text-gray-700">{{ number_format($camper->mileage, 0, ',', '.') }} km</p>
                </div>
                @endif
                
                @if($camper->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $camper->condition }}</p>
                </div>
                @endif
                @if($camper->berths)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Anzahl Schlafplätze:</p>
                    <p class="text-gray-700">{{ $camper->berths }}</p>
                </div>
                @endif
                @if($camper->fuel_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kraftstoffart:</p>
                    <p class="text-gray-700">{{ $camper->fuel_type }}</p>
                </div>
                @endif
                @if($camper->transmission)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Getriebe:</p>
                    <p class="text-gray-700">{{ $camper->transmission }}</p>
                </div>
                @endif
                @if($camper->power)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Motorleistung:</p>
                    <p class="text-gray-700">{{ $camper->power }} PS</p>
                </div>
                @endif
               @if($camper->total_length)
    <div>
        <p class="text-sm font-semibold text-gray-800">Länge:</p>
        <p class="text-gray-700">{{ $camper->total_length }} m</p>
    </div>
@endif

@if($camper->total_width)
    <div>
        <p class="text-sm font-semibold text-gray-800">Breite:</p>
        <p class="text-gray-700">{{ $camper->total_width }} m</p>
    </div>
@endif

@if($camper->total_height)
    <div>
        <p class="text-sm font-semibold text-gray-800">Höhe:</p>
        <p class="text-gray-700">{{ $camper->total_height }} m</p>
    </div>
@endif
           
                @if($camper->gross_vehicle_weight)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zul. Gesamtgewicht:</p>
                    <p class="text-gray-700">{{ number_format($camper->gross_vehicle_weight_kg, 0, ',', '.') }} kg</p>
                </div>
                @endif
            </div>
        </section>

      

        {{-- Features/Amenities Section --}}
        @if (isset($camper->features) && !empty($camper->features))
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Ausstattungsdetails:</p>
                {{-- Using whitespace-pre-wrap to maintain formatting from input --}}
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $camper->features }}</p>
            </div>
        </section>
        @endif



        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (isset($camper->images) && $camper->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($camper->images as $image)
                                <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Wohnmobilbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
          
            </div>
        </section>

      

     

    </div>
</x-app-layout>