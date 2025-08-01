{{-- resources/views/commercial_vehicles/show.blade.php --}}

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
            Nutzfahrzeug Anzeigen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Nutzfahrzeug-Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Nutzfahrzeuge Anzeigen', 'url' => route('categories.show', 'commercial-vehicles')], {{-- Adjusted URL to category show --}}
                ['label' => $commercialVehicle->title, 'url' => null], {{-- Dynamic label using commercial vehicle title --}}
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button --}}
        @if ($commercialVehicle->user) {{-- Only show the button if a user exists for the commercial vehicle --}}
            <a href="{{ route('messages.create', $commercialVehicle->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
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
            @if (auth()->id() === $commercialVehicle->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.commercial-vehicles.edit', $commercialVehicle->id) }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                          hover:bg-blue-50 hover:text-blue-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                          transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.commercial-vehicles.destroy', $commercialVehicle->id) }}" method="POST"
                      onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 bg-transparent
                                                 hover:bg-red-50 hover:text-red-700
                                                 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                                 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                            <path fill-rule="evenodd"
                                  d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2 0v10h8V5H6z"
                                  clip-rule="evenodd" />
                        </svg>
                        Anzeige löschen
                    </button>
                </form>
            @endif
        @endauth
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        {{-- Main Title of the Ad --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $commercialVehicle->title }}</h1>

            {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($commercialVehicle->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

     
        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $commercialVehicle->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section>

       

        {{-- Vehicle Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
           @if($commercialVehicle->commercialBrand) {{-- Check if the brand relationship exists --}}
    <div>
        <p class="text-sm font-semibold text-gray-800">Marke:</p>
        <p class="text-gray-700">{{ $commercialVehicle->commercialBrand->name }}</p>
    </div>
@endif

@if($commercialVehicle->commercialModel) {{-- Check if the model relationship exists --}}
    <div>
        <p class="text-sm font-semibold text-gray-800">Modell:</p>
        <p class="text-gray-700">{{ $commercialVehicle->commercialModel->name }}</p>
    </div>
@endif
                @if($commercialVehicle->first_registration)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Erstzulassung:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->first_registration }}</p>
                </div>
                @endif
                @if($commercialVehicle->mileage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kilometerstand:</p>
                    <p class="text-gray-700">{{ number_format($commercialVehicle->mileage, 0, ',', '.') }} km</p>
                </div>
                @endif
                @if($commercialVehicle->power)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Leistung:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->power }} PS</p>
                </div>
                @endif
                @if($commercialVehicle->color)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Farbe:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->color }}</p>
                </div>
                @endif
                @if($commercialVehicle->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ ucfirst($commercialVehicle->condition) }}</p>
                </div>
                @endif
                @if($commercialVehicle->commercial_vehicle_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Fahrzeugtyp:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->commercial_vehicle_type }}</p>
                </div>
                @endif
                @if($commercialVehicle->fuel_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kraftstoffart:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->fuel_type }}</p>
                </div>
                @endif
                @if($commercialVehicle->transmission)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Getriebe:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->transmission }}</p>
                </div>
                @endif
                @if($commercialVehicle->payload_capacity)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Nutzlast:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->payload_capacity }} kg</p>
                </div>
                @endif
                @if($commercialVehicle->gross_vehicle_weight)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zulässiges Gesamtgewicht:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->gross_vehicle_weight }} kg</p>
                </div>
                @endif
                @if($commercialVehicle->number_of_axles)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Anzahl der Achsen:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->number_of_axles }}</p>
                </div>
                @endif
                @if($commercialVehicle->emission_class)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Emissionsklasse:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->emission_class }}</p>
                </div>
                @endif
                @if($commercialVehicle->seats)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Sitze:</p>
                    <p class="text-gray-700">{{ $commercialVehicle->seats }}</p>
                </div>
                @endif
            </div>
        </section>

   

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (isset($commercialVehicle->images) && $commercialVehicle->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($commercialVehicle->images as $image)
                                <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->path) }}" alt="Nutzfahrzeugbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic">Es sind keine Bilder für dieses Fahrzeug verfügbar.</p>
                @endif
         
            </div>
        </section>



    </div>
</x-app-layout>