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
            Auto Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'Autos Anzeigen', 'url' => route('ads.create')],
        ['label' => 'Auto Anzeige', 'url' => route('ads.create')],
    ]" />

        </div>
    </div>

    {{-- ------------------------------------------------------------------------------------- --}}

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden">


                <div class="p-6">

                    <div class="px-6 py-5 bg-white dark:bg-gray-100 border-b border-gray-200 dark:border-gray-300">
                        <h3 class="text-2xl font-extrabold text-gray-700 dark:text-gray-800 mb-2 leading-tight">
                            {{ $vehicle->title }}
                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $vehicle->description }}</p>
                        <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                            {{ number_format($vehicle->price, 2, ',', '.') }} €
                        </p>
                        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            @if ($vehicle->user) {{-- Only show the button if a user exists for the vehicle --}}
                                <a href="{{ route('messages.create', $vehicle->user->id) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full sm:w-auto transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    Verkäufer kontaktieren
                                </a>
                            @else
                                {{-- Optionally, display a message or a different button if no seller is available --}}
                                <p class="text-red-800 dark:text-red-700 italic">Informationen zum Verkäufer nicht
                                    verfügbar.
                                </p>
                            @endif
                        </div>
                    </div>

                    <h4
                        class="text-xl font-semibold text-gray-600 my-3 border-b pb-2 border-gray-200 dark:border-gray-300">
                        Fahrzeugdetails</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        @foreach([
                                'Marke' => $vehicle->brand->name ?? 'N/A',
                                'Modell' => $vehicle->carModel->name ?? 'N/A',
                                'Baujahr' => $vehicle->registration ?? 'N/A',
                                'Kilometerstand' => number_format($vehicle->mileage, 0, ',', '.') . ' km',
                                'Fahrzeugtyp' => $vehicle->vehicle_type ?? 'N/A',
                                'Zustand' => $vehicle->condition ?? 'N/A',
                                'Garantie' => $vehicle->warranty ? 'Ja' : 'Nein',
                                'Leistung' => ($vehicle->power ?? 'N/A') . ' PS',
                                'Kraftstoffart' => $vehicle->fuel_type ?? 'N/A',
                                'Getriebe' => $vehicle->transmission ?? 'N/A',
                                'Antrieb' => $vehicle->drive ?? 'N/A',
                                'Farbe' => $vehicle->color ?? 'N/A',
                                'Türen' => $vehicle->doors ?? 'N/A',
                                'Sitze' => $vehicle->seats ?? 'N/A',
                                'Verkäufertyp' => $vehicle->seller_type ?? 'N/A'
                            ] as $label => $value)
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                                <span class="font-semibold text-gray-500 dark:text-gray-600">{{ $label }}:</span>
                                        <span class="text-gray-700 dark:text-gray-800">{{ $value }}</span>
                                        </div>


                         @endforeach
                        </div>
    
                            @if ($vehicle->images->count() > 0)
                                        <div class="mt-6">
                                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach ($vehicle->images as $image)
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Fahrzeugbild" class="w-full h-48 object-cover rounded-lg shadow-sm">
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