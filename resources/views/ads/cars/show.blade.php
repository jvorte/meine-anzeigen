{{-- resources/views/cars/show.blade.php --}}

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
            Auto Anzeigen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Auto-Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Cars Anzeigen', 'url' => route('categories.show', 'cars')], {{-- Adjusted URL to category show --}}
                ['label' => $car->title, 'url' => null], {{-- Dynamic label using car title --}}
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button --}}
        @if ($car->user) {{-- Only show the button if a user exists for the car --}}
            <a href="{{ route('messages.create', $car->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Contact
            </a>
        @else
            {{-- Optionally, display a message or a different button if no seller is available --}}
            <p class="text-red-800 dark:text-red-700 italic flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Informationen zum Verkäufer nicht verfügbar.
            </p>
        @endif
        {{-- Edit/Delete Buttons (Visible to owner or admin) --}}
        @auth
            @if (auth()->id() === $car->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.cars.edit', $car->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
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
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $car->title }}</h1>
    

        {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($car->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

        

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $car->description }}</p>
            </div>
        </section>

    

        {{-- Vehicle Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($car->carBrand)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Marke:</p>
                    <p class="text-gray-700">{{ $car->carBrand->name }}</p>
                </div>
                @endif
                @if($car->carModel)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modell:</p>
                    <p class="text-gray-700">{{ $car->carModel->name }}</p>
                </div>
                @endif
                @if($car->registration)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Baujahr:</p>
                    <p class="text-gray-700">{{ $car->registration }}</p>
                </div>
                @endif
                @if($car->mileage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kilometerstand:</p>
                    <p class="text-gray-700">{{ number_format($car->mileage, 0, ',', '.') }} km</p>
                </div>
                @endif
                @if($car->vehicle_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Fahrzeugtyp:</p>
                    <p class="text-gray-700">{{ $car->vehicle_type }}</p>
                </div>
                @endif
                @if($car->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $car->condition }}</p>
                </div>
                @endif
                <div>
                    <p class="text-sm font-semibold text-gray-800">Garantie:</p>
                    <p class="text-gray-700">{{ $car->warranty ? 'Ja' : 'Nein' }}</p>
                </div>
                @if($car->power)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Leistung:</p>
                    <p class="text-gray-700">{{ $car->power }} PS</p>
                </div>
                @endif
                @if($car->fuel_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kraftstoffart:</p>
                    <p class="text-gray-700">{{ $car->fuel_type }}</p>
                </div>
                @endif
                @if($car->transmission)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Getriebe:</p>
                    <p class="text-gray-700">{{ $car->transmission }}</p>
                </div>
                @endif
                @if($car->drive)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Antrieb:</p>
                    <p class="text-gray-700">{{ $car->drive }}</p>
                </div>
                @endif
                @if($car->color)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Farbe:</p>
                    <p class="text-gray-700">{{ $car->color }}</p>
                </div>
                @endif
                @if($car->doors)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Türen:</p>
                    <p class="text-gray-700">{{ $car->doors }}</p>
                </div>
                @endif
                @if($car->seats)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Sitze:</p>
                    <p class="text-gray-700">{{ $car->seats }}</p>
                </div>
                @endif
                @if($car->seller_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Verkäufertyp:</p>
                    <p class="text-gray-700">{{ $car->seller_type }}</p>
                </div>
                @endif
            </div>
        </section>

        

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($car->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($car->images as $image)
                                <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Autobild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic">Es sind keine Bilder für dieses Fahrzeug verfügbar.</p>
                @endif
                {{-- Add any other document links here if they exist on the $car model --}}
                {{-- Example: --}}
                {{-- @if($car->service_history_document_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Servicehistorie:</p>
                    <a href="{{ Storage::url($car->service_history_document_path) }}" target="_blank" class="text-blue-600 hover:underline">Ansehen</a>
                </div>
                @endif --}}
            </div>
        </section>


    </div>
</x-app-layout>