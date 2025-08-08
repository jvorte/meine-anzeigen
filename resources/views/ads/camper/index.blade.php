<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 py-2">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Όλοι οι Campers
                </h1>
                <p class="mt-1 text-gray-600 max-w-xl">
                    Περιηγηθείτε σε όλες τις διαθέσιμες αγγελίες campers.
                </p>
            </div>

            <div class="px-4 py-1 md:py-1 flex justify-end items-center">
                <a href="{{ route('ads.camper.create') }}" class="c-button">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumbs --}}
        <x-breadcrumbs :items="[
            ['label' => 'Όλες οι Αγγελίες', 'url' => route('ads.index')],
            ['label' => 'Campers', 'url' => route('ads.camper.index')],
        ]" class="mb-8" />
        
        {{-- Filters Section --}}
        <form action="{{ route('ads.camper.index') }}" method="GET" x-data="{
            camperBrands: {{ json_encode($camperBrands) }},
            camperModels: {{ json_encode($camperModels) }},
            selectedBrand: '{{ request('brand') }}',
            selectedModel: '{{ request('model') }}',
            filteredModels: [],
            filterModels() {
                this.filteredModels = this.camperModels.filter(model => model.camper_brand_id == this.selectedBrand);
                if (!this.filteredModels.some(model => model.id == this.selectedModel)) {
                    this.selectedModel = '';
                }
            },
            init() {
                this.filterModels();
            }
        }">
            <div class="flex flex-wrap gap-2 mb-8 p-4 rounded-lg bg-gray-50 border border-gray-200">
                
                {{-- Dropdown Filter for 'Μάρκα' --}}
                <div class="relative flex-shrink-0">
                    <select name="brand" x-model="selectedBrand" @change="filterModels" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μάρκα</option>
                        <template x-for="brand in camperBrands" :key="brand.id">
                            <option :value="brand.id" x-text="brand.name"></option>
                        </template>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Μοντέλο' --}}
                <div class="relative flex-shrink-0">
                    <select name="model" x-model="selectedModel" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Μοντέλο</option>
                        <template x-for="model in filteredModels" :key="model.id">
                            <option :value="model.id" x-text="model.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Τιμή' --}}
                <div class="relative flex-shrink-0">
                    <select name="price" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τιμή</option>
                        <option value="0-30000" {{ request('price') == '0-30000' ? 'selected' : '' }}>€0 - €30.000</option>
                        <option value="30001-60000" {{ request('price') == '30001-60000' ? 'selected' : '' }}>€30.001 - €60.000</option>
                        <option value="60001-999999" {{ request('price') == '60001-999999' ? 'selected' : '' }}>€60.001+</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Έτος Κυκλοφορίας' --}}
                <div class="relative flex-shrink-0">
                    <select name="first_registration" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Έτος</option>
                        <option value="2020-2024" {{ request('first_registration') == '2020-2024' ? 'selected' : '' }}>2020 - 2024</option>
                        <option value="2010-2019" {{ request('first_registration') == '2010-2019' ? 'selected' : '' }}>2010 - 2019</option>
                        <option value="0-2009" {{ request('first_registration') == '0-2009' ? 'selected' : '' }}>Πριν από το 2010</option>
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Τύπος Camper' --}}
                <div class="relative flex-shrink-0">
                    <select name="camper_type" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Τύπος Camper</option>
                        @foreach(['van' => 'Van', 'alcove' => 'Alcove', 'integrated' => 'Integrated', 'semi_integrated' => 'Semi-integrated'] as $value => $label)
                            <option value="{{ $value }}" {{ request('camper_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Dropdown Filter for 'Αριθμός Κλινών' --}}
                <div class="relative flex-shrink-0">
                    <select name="berths" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κλίνες</option>
                        <option value="1-2" {{ request('berths') == '1-2' ? 'selected' : '' }}>1-2</option>
                        <option value="3-4" {{ request('berths') == '3-4' ? 'selected' : '' }}>3-4</option>
                        <option value="5-9" {{ request('berths') == '5-9' ? 'selected' : '' }}>5+</option>
                    </select>
                </div>

                {{-- Dropdown Filter for 'Κατάσταση' --}}
                <div class="relative flex-shrink-0">
                    <select name="condition" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <option value="">Κατάσταση</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Καινούργιο</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Μεταχειρισμένο</option>
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
                <a href="{{ route('ads.camper.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Καθαρισμός Φίλτρων
                </a>
            </div>
        </form>

        @if ($campers->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 my-5 gap-6">
                @foreach ($campers as $camper)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
                        <a href="{{ route('ads.camper.show', $camper->id) }}">
                            <div class="aspect-w-4 aspect-h-3 bg-gray-100">
                                @if ($camper->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $camper->images->first()->image_path) }}" alt="{{ $camper->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $camper->title }}
                                </h3>
                                <p class="text-sm text-gray-600 truncate">
                                    {{ $camper->camperBrand->name ?? '' }} {{ $camper->camperModel->name ?? '' }}
                                </p>
                                <div class="mt-2 text-blue-600 font-bold">
                                    € {{ number_format($camper->price, 2) }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $campers->links() }}
            </div>
        @else
            <div class="text-gray-600 text-center py-20">
                Δεν βρέθηκαν campers με τα συγκεκριμένα κριτήρια.
            </div>
        @endif
    </div>
</x-app-layout>
