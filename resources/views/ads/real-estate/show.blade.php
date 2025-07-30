<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Anzeige: {{ $realEstate->title }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Immobilienanzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Immobilien Anzeigen', 'url' => route('categories.show', 'immobilien')],
                ['label' => $realEstate->title, 'url' => null],
            ]" />
        </div>
    </div>
            {{-- Action Buttons --}}
        <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Zurück zum Dashboard
            </a>
                  <a href="{{ route('ads.real-estate.edit', $realEstate) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
               Contact
            </a>
            <a href="{{ route('ads.real-estate.edit', $realEstate) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Anzeige bearbeiten
            </a>
            <form action="{{ route('ads.real-estate.destroy', $realEstate) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Anzeige löschen
                </button>
            </form>
        
        </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        {{-- Main Title --}}

        
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $realEstate->title }}</h1>

        


        {{-- Basic Data Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Immobilientyp:</p>
                    <p class="text-gray-700">{{ $realEstate->immobilientyp }}</p>
                </div>
                @if($realEstate->objekttyp)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Objekttyp:</p>
                    <p class="text-gray-700">{{ $realEstate->objekttyp }}</p>
                </div>
                @endif
                @if($realEstate->zustand)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $realEstate->zustand }}</p>
                </div>
                @endif
                @if($realEstate->anzahl_zimmer)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Anzahl Zimmer:</p>
                    <p class="text-gray-700">{{ $realEstate->anzahl_zimmer }}</p>
                </div>
                @endif
                @if($realEstate->bautyp)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Bautyp:</p>
                    <p class="text-gray-700">{{ $realEstate->bautyp }}</p>
                </div>
                @endif
                @if($realEstate->verfugbarkeit)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Verfügbarkeit:</p>
                    <p class="text-gray-700">{{ $realEstate->verfugbarkeit }}</p>
                </div>
                @endif
                @if($realEstate->befristung)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Befristung:</p>
                    <p class="text-gray-700">{{ $realEstate->befristung }}</p>
                </div>
                @endif
                @if($realEstate->befristung_ende)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Befristung Ende:</p>
                    <p class="text-gray-700">{{ \Carbon\Carbon::parse($realEstate->befristung_ende)->format('d.m.Y') }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div class="space-y-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->description }}</p>
                </div>
                @if($realEstate->objektbeschreibung)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Objektbeschreibung:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->objektbeschreibung }}</p>
                </div>
                @endif
                @if($realEstate->lage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Lagebeschreibung:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->lage }}</p>
                </div>
                @endif
                @if($realEstate->sonstiges)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Sonstiges:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->sonstiges }}</p>
                </div>
                @endif
                @if($realEstate->zusatzinformation)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zusatzinformation:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->zusatzinformation }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Location Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Standort</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Land:</p>
                    <p class="text-gray-700">{{ $realEstate->land }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Postleitzahl:</p>
                    <p class="text-gray-700">{{ $realEstate->plz }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Ort:</p>
                    <p class="text-gray-700">{{ $realEstate->ort }}</p>
                </div>
                @if($realEstate->strasse)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Straße:</p>
                    <p class="text-gray-700">{{ $realEstate->strasse }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Prices & Areas Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise & Flächen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($realEstate->gesamtmiete)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Gesamtmiete:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->gesamtmiete, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->wohnflaeche)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Wohnfläche:</p>
                    <p class="text-gray-700">{{ number_format($realEstate->wohnflaeche, 2, ',', '.') }} m&sup2;</p>
                </div>
                @endif
                @if($realEstate->grundflaeche)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Grundfläche:</p>
                    <p class="text-gray-700">{{ number_format($realEstate->grundflaeche, 2, ',', '.') }} m&sup2;</p>
                </div>
                @endif
                @if($realEstate->kaution)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kaution:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->kaution, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->maklerprovision)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Maklerprovision:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->maklerprovision, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->abloese)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Ablöse:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->abloese, 2, ',', '.') }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Ausstattung & Heating Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung & Heizung</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($realEstate->heizung)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Heizung:</p>
                    <p class="text-gray-700">{{ $realEstate->heizung }}</p>
                </div>
                @endif

                @if($realEstate->ausstattung && count($realEstate->ausstattung) > 0)
                <div class="md:col-span-2 lg:col-span-3">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Ausstattung:</p>
                    <ul class="list-disc list-inside text-gray-700 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1">
                        @foreach($realEstate->ausstattung as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </section>

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($realEstate->images->count() > 0)
                <div class="md:col-span-2">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($realEstate->images as $image)
                            <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($image->path) }}" alt="Immobilienbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($realEstate->grundriss_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Grundriss:</p>
                    <a href="{{ Storage::url($realEstate->grundriss_path) }}" target="_blank" class="text-blue-600 hover:underline">Ansehen (PDF/Bild)</a>
                </div>
                @endif

                @if($realEstate->energieausweis_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Energieausweis:</p>
                    <a href="{{ Storage::url($realEstate->energieausweis_path) }}" target="_blank" class="text-blue-600 hover:underline">Ansehen (PDF/Bild)</a>
                </div>
                @endif

                @if($realEstate->rundgang_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">360° Rundgang Link:</p>
                    <a href="{{ $realEstate->rundgang_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->rundgang_link }}</a>
                </div>
                @endif

                @if($realEstate->objektinformationen_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Objektinformationen Link:</p>
                    <a href="{{ $realEstate->objektinformationen_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->objektinformationen_link }}</a>
                </div>
                @endif

                @if($realEstate->zustandsbericht_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustandsbericht Link:</p>
                    <a href="{{ $realEstate->zustandsbericht_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->zustandsbericht_link }}</a>
                </div>
                @endif

                @if($realEstate->verkaufsbericht_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Verkaufsbericht Link:</p>
                    <a href="{{ $realEstate->verkaufsbericht_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->verkaufsbericht_link }}</a>
                </div>
                @endif
            </div>
        </section>

        {{-- Contact Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Name des Ansprechpartners:</p>
                    <p class="text-gray-700">{{ $realEstate->contact_name }}</p>
                </div>
                @if($realEstate->homepage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Homepage:</p>
                    <a href="{{ $realEstate->homepage }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->homepage }}</a>
                </div>
                @endif
            </div>
        </section>


    </div>
</x-app-layout>