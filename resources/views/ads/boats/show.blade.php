{{-- resources/views/ads/boats/show.blade.php --}}

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
            Boats Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'Boats Anzeigen', 'url' => route('ads.create')],
        ['label' => 'Boats  Anzeige', 'url' => route('ads.create')],
    ]" />

        </div>
    </div>

    {{-- ------------------------------------------------------------------------------------- --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-5 bg-white dark:bg-gray-100 border-b border-gray-200 dark:border-gray-300">
                    <h3 class="text-4xl font-extrabold text-gray-700 dark:text-gray-800 mb-2 leading-tight">
                        {{ $boat->title }}</h3>
                    <p class="text-2xl font-bold text-indigo-500 dark:text-indigo-600">
                        {{ number_format($boat->price ?? 0, 2, ',', '.') }} €
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if ($boat->user) {{-- Assuming 'user' is a relationship to the boat's owner --}}
                            <a href="{{ route('messages.create', $boat->user->id) }}"
                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full sm:w-auto transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Verkäufer kontaktieren
                            </a>
                        @else
                            <p class="text-red-800 dark:text-red-700 italic">Informationen zum Verkäufer nicht verfügbar.
                            </p>
                        @endif
                              {{-- Edit Button (Visible to owner or admin) --}}
                            @auth
                                @if (auth()->id() === $boat->user_id || (auth()->user() && auth()->user()->isAdmin()))
                                    <a href="{{ route('ads.boats.edit', $boat->id) }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.586 3.586L10.586 7l-7 7V17h3l7-7.001z" />
                                        </svg>
                                        Anzeige bearbeiten
                                    </a>
                                    <form action="{{ route('ads.boats.destroy', $boat->id) }}" method="POST"
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
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $boat->description }}</p>

                    <h4
                        class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">
                        Bootsdetails</h4>

                        




                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
                        @foreach([
                                'Marke' => $boat->brand->name ?? 'N/A',
                                'Modell' => $boat->carModel->name ?? 'N/A',
                                'Baujahr' => $boat->year_of_construction ?? 'N/A',
                                'Zustand' => $boat->condition ?? 'N/A',
                                'Boots-Typ' => $boat->boat_type ?? 'N/A',
                                'Material' => $boat->material ?? 'N/A',
                                'Gesamtlänge' => ($boat->total_length ? $boat->total_length . ' m' : 'N/A'),
                                'Gesamtbreite' => ($boat->total_width ? $boat->total_width . ' m' : 'N/A'),
                                'Kojen' => $boat->berths ?? 'N/A',
                                'Motortyp' => $boat->engine_type ?? 'N/A',
                                'Motorleistung' => ($boat->engine_power ? $boat->engine_power . ' PS' : 'N/A'),
                                'Betriebsstunden' => ($boat->operating_hours ? $boat->operating_hours . ' Std.' : 'N/A'),
                                'Letzter Service' => ($boat->last_service ? \Carbon\Carbon::parse($boat->last_service)->format('d.m.Y') : 'N/A'),
                            ] as $label => $value)
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
                                <span class="font-semibold text-gray-500 dark:text-gray-600">{{ $label }}:</span>
                                    <span class="text-gray-700 dark:text-gray-800">{{ $value }}</span>
                                </div>
                        @endforeach
                    </div>


                    <h4 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2 border-gray-200 dark:border-gray-300">Verkäuferdetails</h4>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 mb-6 text-sm">
    @foreach([
        'Name' => $boat->seller_name ?? 'N/A',
        'Telefon' => $boat->seller_phone ?? 'N/A',
        'E-Mail' => $boat->seller_email ?? 'N/A',
        'Land' => $boat->country ?? 'N/A',
        'PLZ' => $boat->zip_code ?? 'N/A',
        'Stadt' => $boat->city ?? 'N/A',
        'Straße' => $boat->street ?? 'N/A',
    ] as $label => $value)
        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-100 p-3 rounded-md">
            <span class="font-semibold text-gray-500 dark:text-gray-600">{{ $label }}:</span>
            <span class="text-gray-700 dark:text-gray-800">{{ $value }}</span>
        </div>
    @endforeach
</div>

                           
                    @if (isset($boat->images) && $boat->images->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-xl font-semibold text-gray-600 dark:text-gray-700 mb-3 border-b pb-2 border-gray-200 dark:border-gray-300">Bilder</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($boat->images as $image)
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Bootsbild" class="w-full h-48 object-cover rounded-lg shadow-sm">
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