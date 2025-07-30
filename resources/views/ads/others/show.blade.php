{{-- resources/views/ads/others/show.blade.php --}}

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
            Sonstige Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer sonstigen Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
                ['label' => 'Sonstige Anzeigen', 'url' => route('categories.show', 'sonstiges')], {{-- Assuming 'sonstiges' is the slug for others --}}
                ['label' => $other->title, 'url' => null],
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button --}}
        @if ($other->user) {{-- Only show the button if a user exists for the 'other' item --}}
            <a href="{{ route('messages.create', $other->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
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
            @if (auth()->id() === $other->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.others.edit', $other->id) }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                          hover:bg-blue-50 hover:text-blue-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                          transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.others.destroy', $other->id) }}" method="POST"
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
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $other->title }}</h1>

    

        {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($other->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

        

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $other->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section>

    

        {{-- Product Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Produktdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($other->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $other->condition }}</p>
                </div>
                @endif
                {{-- Add other specific fields for your 'Other' model here. Examples: --}}
                @if($other->type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Typ:</p>
                    <p class="text-gray-700">{{ $other->type }}</p>
                </div>
                @endif
                @if($other->manufacturer)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Hersteller:</p>
                    <p class="text-gray-700">{{ $other->manufacturer }}</p>
                </div>
                @endif
                @if($other->model_name)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modell:</p>
                    <p class="text-gray-700">{{ $other->model_name }}</p>
                </div>
                @endif
                @if($other->color)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Farbe:</p>
                    <p class="text-gray-700">{{ $other->color }}</p>
                </div>
                @endif
                @if($other->dimensions)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Abmessungen:</p>
                    <p class="text-gray-700">{{ $other->dimensions }}</p>
                </div>
                @endif
                @if($other->weight)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Gewicht:</p>
                    <p class="text-gray-700">{{ $other->weight }}</p>
                </div>
                @endif
                {{-- Add any other relevant 'other' item specific fields here --}}
            </div>
        </section>

 

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (isset($other->images) && $other->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($other->images as $image)
                                <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->path) }}" alt="Anderes Artikelbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic">Es sind keine Bilder für diesen Artikel verfügbar.</p>
                @endif
                {{-- Add any other document links here if they exist on the $other model --}}
            </div>
        </section>


        {{-- Contact Information Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($other->user)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Name des Ansprechpartners:</p>
                    <p class="text-gray-700">{{ $other->user->name }}</p>
                </div>
                {{-- Assuming user or other has a contact number or email --}}
                {{-- @if($other->user->phone)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Telefon:</p>
                    <p class="text-gray-700">{{ $other->user->phone }}</p>
                </div>
                @endif --}}
                @else
                    <p class="text-gray-600 italic md:col-span-3">Kontaktdaten des Verkäufers sind nicht verfügbar.</p>
                @endif
                <div>
                    <p class="text-sm font-semibold text-gray-800">Anzeigedatum:</p>
                    <p class="text-gray-700">{{ $other->created_at->format('d.m.Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>