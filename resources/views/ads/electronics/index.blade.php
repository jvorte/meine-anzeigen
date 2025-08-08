{{-- resources/views/ads/electronics/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Όλα τα Ηλεκτρονικά
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες για ηλεκτρονικές συσκευές.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.electronics.create') }}" class="c-button">
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
            ['label' => 'Ηλεκτρονικά', 'url' => route('ads.electronics.index')],
        ]" class="mb-6" />

        {{-- Filters Section --}}
        <form action="{{ route('ads.electronics.index') }}" method="GET">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Κατηγορία' --}}
                <div class="relative flex-shrink-0">
                    <select name="category" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατηγορία</option>
                        @foreach(['phones' => 'Κινητά', 'laptops' => 'Laptops', 'tablets' => 'Tablets', 'consoles' => 'Κονσόλες', 'tvs' => 'Τηλεοράσεις'] as $value => $label)
                            <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="brand" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Κατάσταση' --}}
                <div class="relative flex-shrink-0">
                    <select name="condition" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατάσταση</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Καινούργιο</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Μεταχειρισμένο</option>
                        <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Σαν καινούργιο</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τιμή' --}}
                <div class="relative flex-shrink-0">
                    <select name="price" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τιμή</option>
                        <option value="0-100" {{ request('price') == '0-100' ? 'selected' : '' }}>€0 - €100</option>
                        <option value="101-500" {{ request('price') == '101-500' ? 'selected' : '' }}>€101 - €500</option>
                        <option value="501-999999" {{ request('price') == '501-999999' ? 'selected' : '' }}>€501+</option>
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
                <a href="{{ route('ads.electronics.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        {{-- Electronics Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 my-5">
            @forelse($ads as $electronic)
                <a href="{{ route('ads.electronics.show', $electronic->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    @if($electronic->images->count())
                        <img src="{{ asset('storage/' . $electronic->images->first()->image_path) }}" alt="{{ $electronic->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Δεν υπάρχει εικόνα
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $electronic->title }}</h2>
                        <p class="text-gray-600 mt-1">
                            Μάρκα: {{ $electronic->brand ?? 'Άγνωστη' }}
                        </p>
                        <p class="text-gray-500 mt-1">
                            Μοντέλο: {{ $electronic->electronic_model ?? 'Δ/Α' }} | Κατηγορία: {{ $electronic->category }}
                        </p>
                        @if($electronic->price)
                            <p class="text-blue-600 font-semibold mt-2">€ {{ number_format($electronic->price, 2) }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">Τιμή κατόπιν συνεννόησης</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-600 col-span-full">Δεν βρέθηκαν ηλεκτρονικές συσκευές.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $ads->links() }}
        </div>
    </div>
</x-app-layout>
