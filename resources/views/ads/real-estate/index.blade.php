{{-- resources/views/ads/real-estate/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Ακίνητα
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες ακινήτων.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.real-estate.create') }}" class="c-button">
                    <span class="c-main">
                        <span class="c-ico">
                            <span class="c-blur"></span>
                            <span class="ico-text">+</span>
                        </span>
                        Νέα Αγγελία
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-breadcrumbs :items="[
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            ['label' => 'Ακίνητα', 'url' => route('ads.real-estate.index')],
        ]" class="mb-6" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.real-estate.index') }}" method="GET">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Τύπος Ακινήτου' --}}
                <div class="relative flex-shrink-0">
                    <select name="title" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τύπος Ακινήτου</option>
                        @foreach($immobilientyps as $immobilientyp)
                            <option value="{{ $immobilientyp }}" {{ request('immobilientyp') == $immobilientyp ? 'selected' : '' }}>{{ $immobilientyp }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Αριθμός Δωματίων' --}}
                <div class="relative flex-shrink-0">
                    <select name="anzahl_zimmer" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Αριθμός Δωματίων</option>
                        <option value="1" {{ request('anzahl_zimmer') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('anzahl_zimmer') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ request('anzahl_zimmer') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ request('anzahl_zimmer') == '4' ? 'selected' : '' }}>4+</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τιμή' --}}
                <div class="relative flex-shrink-0">
                    <select name="price" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τιμή</option>
                        <option value="0-100000" {{ request('price') == '0-100000' ? 'selected' : '' }}>€0 - €100.000</option>
                        <option value="100001-300000" {{ request('price') == '100001-300000' ? 'selected' : '' }}>€100.001 - €300.000</option>
                        <option value="300001-999999999" {{ request('price') == '300001-999999999' ? 'selected' : '' }}>€300.001+</option>
                    </select>
                </div>
                
                {{-- Dropdown for 'Ταξινόμηση' --}}
                <div class="relative flex-shrink-0">
                    <select name="sort_by" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Ταξινόμηση</option>
                        <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Τελευταία</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Τιμή: Φθηνότερο πρώτα</option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Τιμή: Ακριβότερο πρώτα</option>
                    </select>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Αναζήτηση
                </button>
                
                {{-- Reset Button --}}
                <a href="{{ route('ads.real-estate.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        {{-- Real Estate Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            @forelse($realEstateAds as $realEstate)
                <a href="{{ route('ads.real-estate.show', $realEstate->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    @if($realEstate->images->count())
                        <img src="{{ asset('storage/' . $realEstate->images->first()->image_path) }}" alt="{{ $realEstate->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Δεν υπάρχει εικόνα
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $realEstate->title }}</h2>
                        <p class="text-gray-500 mt-1"> {{ $realEstate->bautyp ?? 'Δ/Α' }}</p>
                        <p class="text-gray-600 mt-1">{{ $realEstate->ort ?? 'Δ/Α' }}</p>
                        <p class="text-gray-500 mt-1">{{ $realEstate->anzahl_zimmer }} Δωμάτια</p>
                        
                        @if($realEstate->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($realEstate->price, 2) }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">Τιμή κατόπιν συνεννόησης</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-600 col-span-full">Δεν βρέθηκαν αγγελίες ακινήτων.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $realEstateAds->links() }}
        </div>
    </div>
</x-app-layout>
