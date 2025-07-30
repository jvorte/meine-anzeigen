<x-app-layout>
    <x-slot name="header">
        {{-- "Neu Anzeige" button as per your original boats blade header --}}
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
        {{-- The main page title, not the ad title --}}
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Boats Anzeigen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detaillierte Ansicht Ihrer Bootsanzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Boats Anzeigen', 'url' => route('categories.show', 'boats')],
                ['label' => $boat->title, 'url' => null], {{-- Updated to use $boat->title for consistency --}}
            ]" />
        </div>
    </div>

    {{-- Action Buttons (consistent with realEstate blade placement and styling) --}}
    <div class="max-w-6xl mx-auto my-5 flex space-x-4 justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Zurück zum Dashboard
        </a>
        {{-- Contact Seller Button (Styled like the other action buttons) --}}
        @if ($boat->user)
            <a href="{{ route('messages.create', $boat->user->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Contact
            </a>
        @endif
        {{-- Edit Button (Visible to owner or admin, consistent styling) --}}
        @auth
            @if (auth()->id() === $boat->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <a href="{{ route('ads.boats.edit', $boat->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Anzeige bearbeiten
                </a>
                {{-- Delete Form/Button (consistent styling) --}}
                <form action="{{ route('ads.boats.destroy', $boat->id) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Anzeige löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.');">
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
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $boat->title }}</h1>

    

        {{-- Basic Data Section (consistent with realEstate) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Bootsdetails</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Iterate through basic details, ensuring consistency in display and conditional rendering --}}
                <div>
                    <p class="text-sm font-semibold text-gray-800">Marke:</p>
                    <p class="text-gray-700">{{ $boat->brand ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Modell:</p>
                    <p class="text-gray-700">{{ $boat->model ?? 'N/A' }}</p>
                </div>
                @if($boat->year_of_construction)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Baujahr:</p>
                    <p class="text-gray-700">{{ $boat->year_of_construction }}</p>
                </div>
                @endif
                @if($boat->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Zustand:</p>
                    <p class="text-gray-700">{{ $boat->condition }}</p>
                </div>
                @endif
                @if($boat->boat_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Boots-Typ:</p>
                    <p class="text-gray-700">{{ $boat->boat_type }}</p>
                </div>
                @endif
                @if($boat->material)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Material:</p>
                    <p class="text-gray-700">{{ $boat->material }}</p>
                </div>
                @endif
                @if($boat->total_length)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Gesamtlänge:</p>
                    <p class="text-gray-700">{{ $boat->total_length }} m</p>
                </div>
                @endif
                @if($boat->total_width)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Gesamtbreite:</p>
                    <p class="text-gray-700">{{ $boat->total_width }} m</p>
                </div>
                @endif
                @if($boat->berths)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kojen:</p>
                    <p class="text-gray-700">{{ $boat->berths }}</p>
                </div>
                @endif
                @if($boat->engine_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Motortyp:</p>
                    <p class="text-gray-700">{{ $boat->engine_type }}</p>
                </div>
                @endif
                @if($boat->engine_power)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Motorleistung:</p>
                    <p class="text-gray-700">{{ $boat->engine_power }} PS</p>
                </div>
                @endif
                @if($boat->operating_hours)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Betriebsstunden:</p>
                    <p class="text-gray-700">{{ number_format($boat->operating_hours, 0, ',', '.') }} Std.</p>
                </div>
                @endif
                @if($boat->last_service)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Letzter Service:</p>
                    <p class="text-gray-700">{{ \Carbon\Carbon::parse($boat->last_service)->format('d.m.Y') }}</p>
                </div>
                @endif
            </div>
        </section>

    
        {{-- Description Section (consistent with realEstate) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Hauptbeschreibung:</p>
                <p class="text-gray-700 leading-relaxed">{{ $boat->description }}</p>
            </div>
        </section>

    

        {{-- Prices Section (consistent with realEstate) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
            <div>
                <p class="text-sm font-semibold text-gray-800">Preis:</p>
                <p class="text-gray-700">&euro;{{ number_format($boat->price ?? 0, 2, ',', '.') }}</p>
            </div>
        </section>

    

        {{-- Photos & Documents Section (consistent with realEstate) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (isset($boat->images) && $boat->images->count() > 0)
                    <div class="md:col-span-2">
                        <p class="text-sm font-semibold text-gray-800 mb-2">Bilder:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($boat->images as $image)
                                <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($image->path) }}" alt="Bootsbild" class="w-full h-32 object-cover rounded-md shadow-sm">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Example for other potential boat documents --}}
                @if($boat->service_history_document_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Serviceheft:</p>
                    <a href="{{ Storage::url($boat->service_history_document_path) }}" target="_blank" class="text-blue-600 hover:underline">Ansehen (PDF/Bild)</a>
                </div>
                @endif
                @if($boat->inspection_report_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Inspektionsbericht Link:</p>
                    <a href="{{ $boat->inspection_report_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $boat->inspection_report_link }}</a>
                </div>
                @endif
            </div>
        </section>

        

        {{-- Contact Section (consistent with realEstate) --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($boat->user) {{-- Assuming contact_name is linked to the user model --}}
                <div>
                    <p class="text-sm font-semibold text-gray-800">Name des Ansprechpartners:</p>
                    <p class="text-gray-700">{{ $boat->user->name }}</p>
                </div>
                @endif
                @if($boat->homepage) {{-- Assuming a homepage field exists on the boat model or related contact --}}
                <div>
                    <p class="text-sm font-semibold text-gray-800">Homepage:</p>
                    <a href="{{ $boat->homepage }}" target="_blank" class="text-blue-600 hover:underline">{{ $boat->homepage }}</a>
                </div>
                @endif
            </div>
        </section>

    </div>
</x-app-layout>