{{-- resources/views/electronics/show.blade.php --}}

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
            Elektronik Anzeige
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Elektronik-Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Elektronik Anzeigen', 'url' => route('categories.show', 'elektronik')],
                ['label' => $electronic->title, 'url' => null],
            ]" />
        </div>
    </div>

    {{-- Action Buttons (Consistent placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button --}}
        @if ($electronic->user) {{-- Only show the button if a user exists for the electronic item --}}
            <a href="{{ route('messages.create', $electronic->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
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
            @if (auth()->id() === $electronic->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.electronics.edit', $electronic->id) }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-transparent
                          hover:bg-blue-50 hover:text-blue-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                          transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                <form action="{{ route('ads.electronics.destroy', $electronic->id) }}" method="POST"
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
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $electronic->title }}</h1>

    

        {{-- Prices Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($electronic->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

   

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $electronic->description ?? 'Keine Beschreibung verfügbar.' }}</p>
            </div>
        </section>

  

        {{-- Electronic Details Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Elektronikdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($electronic->electronicBrand)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Marke:</p>
                    <p class="text-gray-700">{{ $electronic->electronicBrand->name }}</p>
                </div>
                @endif
                @if($electronic->electronicModel)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modell:</p>
                    <p class="text-gray-700">{{ $electronic->electronicModel->name }}</p>
                </div>
                @endif
                @if($electronic->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $electronic->condition }}</p>
                </div>
                @endif
                @if($electronic->year_of_purchase)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kaufjahr:</p>
                    <p class="text-gray-700">{{ $electronic->year_of_purchase }}</p>
                </div>
                @endif
                @if($electronic->warranty_status)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Garantie-Status:</p>
                    <p class="text-gray-700">{{ $electronic->warranty_status }}</p>
                </div>
                @endif
                @if($electronic->color)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Farbe:</p>
                    <p class="text-gray-700">{{ $electronic->color }}</p>
                </div>
                @endif
                @if($electronic->usage_time)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Nutzungsdauer:</p>
                    <p class="text-gray-700">{{ $electronic->usage_time }}</p>
                </div>
                @endif
                @if($electronic->power)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Leistung:</p>
                    <p class="text-gray-700">{{ $electronic->power }}</p>
                </div>
                @endif
                @if($electronic->operating_system)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Betriebssystem:</p>
                    <p class="text-gray-700">{{ $electronic->operating_system }}</p>
                </div>
                @endif
                @if($electronic->storage_capacity)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Speicherkapazität:</p>
                    <p class="text-gray-700">{{ $electronic->storage_capacity }}</p>
                </div>
                @endif
                @if($electronic->screen_size)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Bildschirmgröße:</p>
                    <p class="text-gray-700">{{ $electronic->screen_size }}</p>
                </div>
                @endif
                @if($electronic->processor)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Prozessor:</p>
                    <p class="text-gray-700">{{ $electronic->processor }}</p>
                </div>
                @endif
                @if($electronic->ram)
                <div>
                    <p class="text-sm font-semibold text-gray-800">RAM:</p>
                    <p class="text-gray-700">{{ $electronic->ram }}</p>
                </div>
                @endif
                @if($electronic->accessories)
                <div class="lg:col-span-3"> {{-- Span full width for accessories as it's a longer text field --}}
                    <p class="text-sm font-semibold text-gray-800">Zubehör:</p>
                    <p class="text-gray-700">{{ $electronic->accessories }}</p>
                </div>
                @endif
            </div>
        </section>

     

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($electronic->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($electronic->images as $image)
                                <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Elektronikbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 italic">Es sind keine Bilder für dieses Gerät verfügbar.</p>
                @endif
                {{-- Add any other document links here if they exist on the $electronic model --}}
                {{-- Example: --}}
                {{-- @if($electronic->invoice_document_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Rechnung:</p>
                    <a href="{{ Storage::url($electronic->invoice_document_path) }}" target="_blank" class="text-blue-600 hover:underline">Ansehen</a>
                </div>
                @endif --}}
            </div>
        </section>

   
        {{-- Contact Information Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($electronic->user)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Name des Ansprechpartners:</p>
                    <p class="text-gray-700">{{ $electronic->user->name }}</p>
                </div>
                {{-- Assuming user or electronic has a contact number or email --}}
                {{-- @if($electronic->user->phone)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Telefon:</p>
                    <p class="text-gray-700">{{ $electronic->user->phone }}</p>
                </div>
                @endif --}}
                @else
                    <p class="text-gray-600 italic md:col-span-3">Kontaktdaten des Verkäufers sind nicht verfügbar.</p>
                @endif
                <div>
                    <p class="text-sm font-semibold text-gray-800">Anzeigedatum:</p>
                    <p class="text-gray-700">{{ $electronic->created_at->format('d.m.Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>