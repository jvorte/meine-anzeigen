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
                            {{ $car->title }}
                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $car->description }}</p>
                        <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                            {{ number_format($car->price, 2, ',', '.') }} €
                        </p>
                        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            @if ($car->user) {{-- Only show the button if a user exists for the car --}}
                                <a href="{{ route('messages.create', $car->user->id) }}" class="inline-flex items-center text-base font-medium text-green-600
                                          hover:text-green-800 hover:underline
                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                                          transition ease-in-out duration-150">
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

                            <div class="flex-grow flex justify-end items-center space-x-2 sm:space-x-4 mt-3 sm:mt-0">
                                @auth
                                    @if (auth()->id() === $car->user_id || (auth()->user() && auth()->user()->isAdmin()))


                                        <a href="{{ route('ads.cars.edit', $car->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                                                      hover:bg-blue-50 hover:text-blue-700
                                                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                                      transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.586 3.586L10.586 7l-7 7V17h3l7-7.001z" />
                                            </svg>
                                            Anzeige bearbeiten
                                        </a>



                                        <form action="{{ route('ads.cars.destroy', $car->id) }}" method="POST"
                                            onsubmit="return confirm('Bist du sicher, dass du diese Anzeige löschen möchtest?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-600 bg-transparent
                                                               hover:bg-red-50 hover:text-red-700
                                                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                                               transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                    viewBox="0 0 20 20" fill="currentColor">
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
                    </div>

                    <h4
                        class="text-xl font-semibold text-gray-600 my-3 border-b pb-2 border-gray-200 dark:border-gray-300">
                        Fahrzeugdetails</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        @foreach([
                                'Marke' => $car->brand->name ?? 'N/A',
                                'Modell' => $car->carModel->name ?? 'N/A',
                                'Baujahr' => $car->registration ?? 'N/A',
                                'Kilometerstand' => number_format($car->mileage, 0, ',', '.') . ' km',
                                'Fahrzeugtyp' => $car->vehicle_type ?? 'N/A',
                                'Zustand' => $car->condition ?? 'N/A',
                                'Garantie' => $car->warranty ? 'Ja' : 'Nein',
                                'Leistung' => ($car->power ?? 'N/A') . ' PS',
                                'Kraftstoffart' => $car->fuel_type ?? 'N/A',
                                'Getriebe' => $car->transmission ?? 'N/A',
                                'Antrieb' => $car->drive ?? 'N/A',
                                'Farbe' => $car->color ?? 'N/A',
                                'Türen' => $car->doors ?? 'N/A',
                                'Sitze' => $car->seats ?? 'N/A',
                                'Verkäufertyp' => $car->seller_type ?? 'N/A'
                            ] as $label => $value)
                                <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                                        <span class="font-semibold text-gray-500 dark:text-gray-600">{{ $label }}:</span>
                                        <span class="text-gray-700 dark:text-gray-800">{{ $value }}</span>
                                    </div>


                          @endforeach
                    </div>

                    @if ($car->images->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($car->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="car" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- <div class="mt-8 text-center">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-blue-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-500 focus:outline-none focus:border-blue-600 focus:ring ring-blue-100 disabled:opacity-25 transition ease-in-out duration-150">
                            Zurück zur Suche
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
