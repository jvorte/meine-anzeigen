{{-- resources/views/campers/show.blade.php --}}

<x-app-layout>

    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}

    <x-slot name="header">
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
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Campers Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Campers Anzeigen', 'url' => route('ads.create')],
                ['label' => 'Campers Anzeige', 'url' => route('ads.create')],
            ]" />

        </div>
    </div>

    {{-- ------------------------------------------------------------------------------------- --}}
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-5 bg-white dark:bg-gray-100 border-b border-gray-200 dark:border-gray-300">
                    <h3 class="text-4xl font-extrabold text-gray-700 dark:text-gray-800 mb-2 leading-tight">{{ $camper->title }}</h3>
                    <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                        {{ number_format($camper->price ?? 0, 2, ',', '.') }} €
                    </p>

                    {{-- Seller Information Section --}}
                        {{-- Check if a user is associated with the camper --}}
                    {{-- @if ($camper->user) 
                
                        <div class="mt-4 mb-4 text-gray-700 dark:text-gray-800">
                            <h4 class="text-lg font-semibold mb-1">Verkäufer:</h4>
                            <p><strong>Name:</strong> {{ $camper->user->name }}</p>
                            <p><strong>E-Mail:</strong> <a href="mailto:{{ $camper->user->email }}" class="text-blue-600 hover:underline">{{ $camper->user->email }}</a></p>
                          
                            <p><strong>Telefon:</strong> {{ $camper->user->seller_phone ?? 'N/A' }}</p>
                            <p><strong>Standort:</strong> {{ $camper->user->city ?? 'N/A' }}</p>
                        </div>
                    @else
                        <p class="text-red-800 dark:text-red-700 italic mt-4">Informationen zum Verkäufer nicht verfügbar.</p>
                    @endif --}}


                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if (isset($camper->user_id))
                            <a href="{{ route('messages.create', $camper->user_id) }}"
                               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full sm:w-auto transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Verkäufer kontaktieren
                            </a>
                        @endif {{-- Removed the else block here, as seller info is handled above --}}

                        {{-- Edit/Delete Buttons (already existing) --}}
                        @auth
                            @if (auth()->id() === $camper->user_id || (auth()->user() && auth()->user()->isAdmin()))
                                <a href="{{ route('ads.camper.edit', $camper->id) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.586 3.586L10.586 7l-7 7V17h3l7-7.001z" />
                                    </svg>
                                    Anzeige bearbeiten
                                </a>
                                <form action="{{ route('ads.camper.destroy', $camper->id) }}" method="POST"
                                    onsubmit="return confirm('Bist du sicher, dass du diese Anzeige löschen möchtest?');"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full sm:w-auto transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
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
                </div>

                <div class="p-6">
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $camper->description }}</p>

                    <h4 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">Wohnmobildetails</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        {{-- Existing and new fields as added in the previous response --}}
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Marke:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->brand ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Baujahr:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->year ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Kilometerstand:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->mileage ?? 'N/A' }} km</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Anzahl Schlafplätze:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->berths ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Kraftstoffart:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->fuel_type ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Modell:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->model ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Zustand:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->condition ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Getriebe:</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->transmission ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Motorleistung (PS):</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->engine_power_hp ?? 'N/A' }} PS</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Länge (m):</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->length_m ?? 'N/A' }} m</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Breite (m):</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->width_m ?? 'N/A' }} m</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Höhe (m):</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->height_m ?? 'N/A' }} m</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                            <span class="font-semibold text-gray-500 dark:text-gray-600">Zul. Gesamtgewicht (kg):</span>
                            <span class="text-gray-700 dark:text-gray-800">{{ $camper->gross_vehicle_weight_kg ?? 'N/A' }} kg</span>
                        </div>
                    </div>

                    {{-- Features/Amenities section --}}
                    @if (isset($camper->features) && !empty($camper->features))
                        <h4 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">Ausstattung</h4>
                        <div class="bg-gray-50 dark:bg-gray-100 p-4 rounded-md mb-6">
                            <p class="text-gray-700 dark:text-gray-800 whitespace-pre-wrap">{{ $camper->features }}</p>
                        </div>
                    @endif

                    {{-- Example for displaying images if you have a relationship --}}
                    @if (isset($camper->images) && $camper->images->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($camper->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Wohnmobilbild" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 text-center">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-500 focus:outline-none focus:border-blue-600 focus:ring ring-blue-100 disabled:opacity-25 transition ease-in-out duration-150">
                            Zurück zur Suche
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>