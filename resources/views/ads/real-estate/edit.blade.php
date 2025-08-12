{{-- resources/views/ads/real-estate/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Anzeige Immobilie bearbeiten: {{ $realEstate->title }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Passe die Details deiner Immobilienanzeige an und speichere die Änderungen.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Immobilien Anzeigen', 'url' => route('categories.real-estate.index')],
                ['label' => $realEstate->title, 'url' => route('ads.real-estate.show', $realEstate->id)],
                ['label' => 'Bearbeiten', 'url' => null],
            ]" />
        </div>
    </div>

    <!-- check form fields -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        <form method="POST" action="{{ route('ads.real-estate.update', $realEstate->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Hidden field for category_slug (assuming it's not editable) --}}
            <input type="hidden" name="category_slug" value="{{ old('category_slug', $realEstate->category_slug) }}">

            {{-- Basisdaten Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Titel --}}
                    <div class="lg:col-span-3">
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $realEstate->title) }}"
                            placeholder="Aussagekräftiger Titel für deine Anzeige"
                            class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Immobilientyp --}}
                    <div>
                        <label for="propertyTypeOptions" class="block text-sm font-medium text-gray-700 mb-2">Immobilientyp</label>
                        <select name="propertyTypeOptions" id="immobilientyp"
                            class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($propertyTypeOptions as $propertyTypeOption)
                            <option value="{{ $propertyTypeOption }}" {{ old('condition') == $propertyTypeOption ? 'selected' : '' }}>
                                {{ ucfirst($propertyTypeOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('propertyTypeOptions')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Objekttyp --}}
                    <div>
                        <label for="objekttyp" class="block text-sm font-medium text-gray-700 mb-2">Objekttyp (optional)</label>
                        <select name="objekttyp" id="objekttyp"
                            class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($objectTypeOptions as $objectTypeOption )
                            <option value="{{ $objectTypeOption }}" {{ old('condition') == $objectTypeOption ? 'selected' : '' }}>
                                {{ ucfirst($objectTypeOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('objekttyp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand (optional)</label>
                        <select name="condition" id="condition"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">

                            @foreach($stateOptions as $stateOption )
                            <option value="{{ $stateOption }}" {{ old('condition') == $stateOption ? 'selected' : '' }}>
                                {{ ucfirst($stateOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Anzahl Zimmer --}}
                    <div>
                        <label for="anzahl_zimmer" class="block text-sm font-medium text-gray-700 mb-2">Anzahl Zimmer (optional)</label>
                        <input type="number" step="0.5" name="anzahl_zimmer" id="anzahl_zimmer" value="{{ old('anzahl_zimmer', $realEstate->anzahl_zimmer) }}" placeholder="z.B. 3.5" min="0.5"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('anzahl_zimmer')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bautyp --}}
                    <div>
                        <label for="bautyp" class="block text-sm font-medium text-gray-700 mb-2">Bautyp (optional)</label>
                        <select name="bautyp" id="bautyp"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($constructionTypeOptions as $constructionTypeOption )
                            <option value="{{ $constructionTypeOption }}" {{ old('condition') == $constructionTypeOption ? 'selected' : '' }}>
                                {{ ucfirst($constructionTypeOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('bautyp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="verfugbarkeit" class="block text-sm font-medium text-gray-700 mb-2">AvailabilityOptions (optional)</label>
                        <select name="verfugbarkeit" id="verfugbarkeit"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($availabilityOptions as $availabilityOption )
                            <option value="{{ $availabilityOption }}" {{ old('condition') == $availabilityOption ? 'selected' : '' }}>
                                {{ ucfirst($availabilityOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('verfugbarkeit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Befristung --}}
                    <div>
                        <label for="befristung" class="block text-sm font-medium text-gray-700 mb-2">Befristung (optional)</label>
                        <select name="befristung" id="befristung"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($fixedTermContractOptions as $fixedTermContractOption )
                            <option value="{{ $fixedTermContractOption }}" {{ old('condition') == $fixedTermContractOption ? 'selected' : '' }}>
                                {{ ucfirst($fixedTermContractOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('befristung')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Year of Construction --}}
                    <div>
                        <label for="year_of_construction" class="block text-sm font-medium text-gray-700 mb-2">Year of Construction (optional)</label>
                        <input
                            type="number"
                            name="year_of_construction"
                            id="year_of_construction"
                            min="1800"
                            max="{{ date('Y') }}"
                            value="{{ old('year_of_construction', $realEstate->year_of_construction ?? '') }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            placeholder="e.g. 1995">
                        @error('year_of_construction')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pet Friendly --}}
                    <div class="mt-4">
                        <label for="pet_friendly" class="block text-sm font-medium text-gray-700 mb-2">Pet Friendly</label>
                        <select
                            name="pet_friendly"
                            id="pet_friendly"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Please select</option>
                            <option value="Yes" {{ old('pet_friendly', $realEstate->pet_friendly) === 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('pet_friendly', $realEstate->pet_friendly) === 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('pet_friendly')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Befristung Ende --}}
                    <div>
                        <label for="befristung_ende" class="block text-sm font-medium text-gray-700 mb-2">
                            Befristung Ende (optional)
                        </label>
                        @if($realEstate->befristung_ende)
                        <p class="text-sm text-gray-500 mb-1">
                            Aktuelles gespeichertes Datum:
                            <span class="font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($realEstate->befristung_ende)->format('d.m.Y') }}
                            </span>
                        </p>
                        @endif
                        <input
                            type="date"
                            name="befristung_ende"
                            id="befristung_ende"
                            value="{{ old('befristung_ende', $realEstate->befristung_ende ? \Carbon\Carbon::parse($realEstate->befristung_ende)->format('Y-m-d') : '') }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('befristung_ende')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                </div>
            </section>

            {{-- Beschreibung Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Beschreibung</h4>
                <div class="space-y-6">
                    {{-- Hauptbeschreibung --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Hauptbeschreibung</label>
                        <textarea name="description" id="description" rows="5"
                            placeholder="Gib hier die Hauptbeschreibung deiner Immobilie ein."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $realEstate->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Objektbeschreibung --}}
                    <div>
                        <label for="objektbeschreibung" class="block text-sm font-medium text-gray-700 mb-2">Objektbeschreibung (optional)</label>
                        <textarea name="objektbeschreibung" id="objektbeschreibung" rows="3"
                            placeholder="Detaillierte Beschreibung des Objekts."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('objektbeschreibung', $realEstate->objektbeschreibung) }}</textarea>
                        @error('objektbeschreibung')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lage --}}
                    <div>
                        <label for="lage" class="block text-sm font-medium text-gray-700 mb-2">Lage (optional)</label>
                        <textarea name="lage" id="lage" rows="3"
                            placeholder="Beschreibung der Lage und Umgebung."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('lage', $realEstate->lage) }}</textarea>
                        @error('lage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sonstiges --}}
                    <div>
                        <label for="sonstiges" class="block text-sm font-medium text-gray-700 mb-2">Sonstiges (optional)</label>
                        <textarea name="sonstiges" id="sonstiges" rows="3"
                            placeholder="Weitere allgemeine Informationen."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('sonstiges', $realEstate->sonstiges) }}</textarea>
                        @error('sonstiges')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zusatzinformation --}}
                    <div>
                        <label for="zusatzinformation" class="block text-sm font-medium text-gray-700 mb-2">Zusatzinformation (optional)</label>
                        <textarea name="zusatzinformation" id="zusatzinformation" rows="3"
                            placeholder="Zusätzliche Informationen, die für den Käufer/Mieter relevant sein könnten."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('zusatzinformation', $realEstate->zusatzinformation) }}</textarea>
                        @error('zusatzinformation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Standort Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Standort</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Land --}}
                    <div>
                        <label for="land" class="block text-sm font-medium text-gray-700 mb-2">Land</label>
                        <input type="text" name="land" id="land" value="{{ old('land', $realEstate->land) ?? 'Österreich' }}" placeholder="z.B. Österreich"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('land')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PLZ --}}
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">Postleitzahl</label>
                        <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $realEstate->postcode) }}" placeholder="z.B. 1010"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('postcode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ort --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Ort</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $realEstate->location) }}" placeholder="z.B. Wien"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Straße --}}
                    <div>
                        <label for="strasse" class="block text-sm font-medium text-gray-700 mb-2">Straße (optional)</label>
                        <input type="text" name="strasse" id="strasse" value="{{ old('strasse', $realEstate->strasse) }}" placeholder="z.B. Musterstraße 123"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('strasse')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Preise & Flächen Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise & Flächen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Gesamtmiete --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (in €)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $realEstate->price) }}" placeholder="z.B. 1200.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Wohnfläche --}}
                    <div>
                        <label for="livingSpace" class="block text-sm font-medium text-gray-700 mb-2">Wohnfläche (in m²)</label>
                        <input type="number" step="0.01" name="livingSpace" id="livingSpace" value="{{ old('livingSpace', $realEstate->livingSpace) }}" placeholder="z.B. 90.50"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('livingSpace')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grundfläche --}}
                    <div>
                        <label for="grundflaeche" class="block text-sm font-medium text-gray-700 mb-2">Grundfläche (in m²)</label>
                        <input type="number" step="0.01" name="grundflaeche" id="grundflaeche" value="{{ old('grundflaeche', $realEstate->grundflaeche) }}" placeholder="z.B. 500.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('grundflaeche')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kaution --}}
                    <div>
                        <label for="kaution" class="block text-sm font-medium text-gray-700 mb-2">Kaution (in €)</label>
                        <input type="number" step="0.01" name="kaution" id="kaution" value="{{ old('kaution', $realEstate->kaution) }}" placeholder="z.B. 3600.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('kaution')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Maklerprovision --}}
                    <div>
                        <label for="maklerprovision" class="block text-sm font-medium text-gray-700 mb-2">Maklerprovision (in €)</label>
                        <input type="number" step="0.01" name="maklerprovision" id="maklerprovision" value="{{ old('maklerprovision', $realEstate->maklerprovision) }}" placeholder="z.B. 2400.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('maklerprovision')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ablöse --}}
                    <div>
                        <label for="abloese" class="block text-sm font-medium text-gray-700 mb-2">Ablöse (in €)</label>
                        <input type="number" step="0.01" name="abloese" id="abloese" value="{{ old('abloese', $realEstate->abloese) }}" placeholder="z.B. 5000.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('abloese')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Ausstattung & Heizung Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Ausstattung & Heizung</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Heizung --}}
                    <div>
                        <label for="heating" class="block text-sm font-medium text-gray-700 mb-2">Heizung (optional)</label>
                        <select name="heating" id="heating"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @foreach($heatingOptions as $heatingOption )
                            <option value="{{ $heatingOption }}" {{ old('condition') == $heatingOption ? 'selected' : '' }}>
                                {{ ucfirst($heatingOption) }}
                            </option>
                            @endforeach
                        </select>
                        @error('heating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ausstattung (Checkboxes) --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ausstattung (optional)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @php
                            $equipmentOptions = [
                            'Balcony',
                            'Terrace',
                            'Garden',
                            'Basement',
                            'Attic',
                            'Garage',
                            'Parking space',
                            'Fitted kitchen',
                            'Furnished',
                            'Accessible',
                            'Elevator',
                            'Air conditioning',
                            'Swimming pool',
                            'Sauna',
                            'Alarm system',
                            'Wheelchair accessible',
                            'Cable/satellite TV',
                            'Internet connection',
                            'Laundry room',
                            'Storage room',
                            'Guest toilet',
                            'Bathtub',
                            'Shower',
                            'Separate toilet'
                            ];
                            @endphp
                            @foreach($equipmentOptions as $option)
                            <div class="flex items-center">
                                <input type="checkbox" name="ausstattung[]" id="ausstattung_{{ Str::slug($option) }}" value="{{ $option }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    {{ in_array($option, old('ausstattung', $realEstate->ausstattung ?? [])) ? 'checked' : '' }}>
                                <label for="ausstattung_{{ Str::slug($option) }}" class="ml-2 text-sm text-gray-700">{{ $option }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('ausstattung')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Grundriss --}}
                <div>
                    <label for="grundriss_path" class="block text-sm font-medium text-gray-700 mb-2">Grundriss (PDF/Bild, optional)</label>
                    @if ($realEstate->grundriss_path)
                    <p class="mb-2 text-sm text-gray-600">Aktuelle Datei:
                        <a href="{{ Storage::url($realEstate->grundriss_path) }}" target="_blank" class="text-blue-600 hover:underline">Anzeigen</a>
                        <input type="checkbox" name="delete_grundriss" value="1" class="ml-2 rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500"> <span class="text-sm text-gray-600">Löschen</span>
                    </p>
                    @endif
                    <input type="file" name="grundriss_path" id="grundriss_path" accept=".pdf,image/*"
                        class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                    @error('grundriss_path')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Energieausweis --}}
                <div>
                    <label for="energieausweis_path" class="block text-sm font-medium text-gray-700 mb-2">Energieausweis (PDF/Bild, optional)</label>
                    @if ($realEstate->energieausweis_path)
                    <p class="mb-2 text-sm text-gray-600">Aktuelle Datei:
                        <a href="{{ Storage::url($realEstate->energieausweis_path) }}" target="_blank" class="text-blue-600 hover:underline">Anzeigen</a>
                        <input type="checkbox" name="delete_energieausweis" value="1" class="ml-2 rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500"> <span class="text-sm text-gray-600">Löschen</span>
                    </p>
                    @endif
                    <input type="file" name="energieausweis_path" id="energieausweis_path" accept=".pdf,image/*"
                        class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                    @error('energieausweis_path')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rundgang Link --}}
                <div>
                    <label for="rundgang_link" class="block text-sm font-medium text-gray-700 mb-2">360° Rundgang Link (optional)</label>
                    <input type="url" name="rundgang_link" id="rundgang_link" value="{{ old('rundgang_link', $realEstate->rundgang_link) }}" placeholder="https://..."
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('rundgang_link')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Objektinformationen Link --}}
                <div>
                    <label for="objektinformationen_link" class="block text-sm font-medium text-gray-700 mb-2">Objektinformationen Link (optional)</label>
                    <input type="url" name="objektinformationen_link" id="objektinformationen_link" value="{{ old('objektinformationen_link', $realEstate->objektinformationen_link) }}" placeholder="https://..."
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('objektinformationen_link')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Zustandsbericht Link --}}
                <div>
                    <label for="zustandsbericht_link" class="block text-sm font-medium text-gray-700 mb-2">Zustandsbericht Link (optional)</label>
                    <input type="url" name="zustandsbericht_link" id="zustandsbericht_link" value="{{ old('zustandsbericht_link', $realEstate->zustandsbericht_link) }}" placeholder="https://..."
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('zustandsbericht_link')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Verkaufsbericht Link --}}
                <div>
                    <label for="verkaufsbericht_link" class="block text-sm font-medium text-gray-700 mb-2">Verkaufsbericht Link (optional)</label>
                    <input type="url" name="verkaufsbericht_link" id="verkaufsbericht_link" value="{{ old('verkaufsbericht_link', $realEstate->verkaufsbericht_link) }}" placeholder="https://..."
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('verkaufsbericht_link')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            </section>

            {{-- Kontakt Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Contact Name --}}
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">Name des Ansprechpartners</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $realEstate->contact_name) }}" placeholder="Max Mustermann"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('contact_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Homepage --}}
                    <div>
                        <label for="homepage" class="block text-sm font-medium text-gray-700 mb-2">Homepage (optional)</label>
                        <input type="url" name="homepage" id="homepage" value="{{ old('homepage', $realEstate->homepage) }}" placeholder="https://www.example.com"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('homepage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

{{-- Contact Section --}}
<section class="bg-gray-50 p-6 rounded-lg shadow-inner">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">
        Select if you want to publish your Mobile phone or email
    </h4>

    {{-- Phone --}}
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_phone" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_phone', $realEstate->show_phone) ? 'checked' : '' }}
            >
            <span class="ml-2">Phone</span>
        </label>
    </div>

    {{-- Mobile --}}
    <div class="mt-2">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_mobile_phone" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_mobile_phone', $realEstate->show_mobile_phone) ? 'checked' : '' }}
            >
            <span class="ml-2">Mobile</span>
        </label>
    </div>

    {{-- Email --}}
    <div class="mt-2">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_email" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_email', $realEstate->show_email) ? 'checked' : '' }}
            >
            <span class="ml-2">Email</span>
        </label>
    </div>
</section>

            


            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                {{-- Initial Alpine.js data with existing images --}}
                <div x-data="multiImageUploader( {{ json_encode($realEstate->images->map(fn($image) => ['id' => $image->id, 'url' => Storage::url($image->image_path)])) }} )" class="space-y-4">
                    {{-- The file input field for NEW uploads --}}
                    <input type="file" name="images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Hidden input to store IDs of images to be deleted --}}
                    <input type="hidden" name="existing_images_to_delete" :value="imagesToDelete.join(',')">

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Loop for EXISTING Images --}}
                        <template x-for="(image, index) in existingImages" :key="`existing-${image.id}`">
                            <div x-show="!imagesToDelete.includes(image.id)" class="relative group">
                                <img :src="image.url" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="markForDeletion(image.id)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>

                        {{-- Loop for NEWLY Added Images (your original logic) --}}
                        <template x-for="(image, index) in newPreviews" :key="`new-${index}`">
                            <div class="relative group">
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="removeNewFile(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews and Deletion --}}
                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            // For new files being uploaded in this submission
                            newFiles: [],
                            newPreviews: [],

                            // For existing images loaded from the database
                            existingImages: initialImages, // This will hold objects like {id: 1, url: '...'}
                            imagesToDelete: [], // Stores IDs of existing images marked for deletion

                            init() {
                                // This runs when the component initializes
                                console.log('Initial images:', this.existingImages);
                            },

                            addFiles(event) {
                                const filesToAdd = Array.from(event.target.files);

                                filesToAdd.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newPreviews.push(URL.createObjectURL(file));
                                });

                                // Update the actual file input's files property for Laravel to pick up
                                this.updateFileInput(event.target);
                            },

                            removeNewFile(index) {
                                URL.revokeObjectURL(this.newPreviews[index]); // Free up memory
                                this.newFiles.splice(index, 1);
                                this.newPreviews.splice(index, 1);

                                // Re-update the file input to reflect removed new files
                                const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                if (fileInput) {
                                    this.updateFileInput(fileInput);
                                }
                            },

                            markForDeletion(imageId) {
                                // Add the image ID to the list of images to delete
                                this.imagesToDelete.push(imageId);
                                // You might also want to visually hide it immediately
                                // The x-show="!imagesToDelete.includes(image.id)" on the template handles this
                            },

                            updateFileInput(fileInput) {
                                const dataTransfer = new DataTransfer();
                                this.newFiles.forEach(file => dataTransfer.items.add(file));
                                fileInput.files = dataTransfer.files;
                            }
                        };
                    }
                </script>
            </section>


            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Änderungen speichern
                </button>
            </div>
        </form>
    </div>
</x-app-layout>