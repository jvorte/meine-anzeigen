{{-- resources/views/ads/real-estate/create.blade.php --}}
<x-app-layout>
  

    
           {{-- -----------------------------------breadcrumbs ---------------------------------------------- --}}
   <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
           Neue  Anzeige Immobilie erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

   <div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Breadcrumbs component --}}
        <x-breadcrumbs :items="[
            {{-- Link to the general Cars category listing --}}
            ['label' => 'Cars Anzeigen', 'url' => route('categories.show', 'cars')],

            {{-- The current page (New Car Ad creation) - set URL to null --}}
            ['label' => 'Neue Auto Anzeige', 'url' => null],
        ]" />
    </div>
</div>
{{-- --------------------------------------------------------------------------------- --}}
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.realestate.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Hidden field for category_slug --}}
            <input type="hidden" name="category_slug" value="immobilien">

            {{-- Basisdaten Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Titel --}}
                    <div class="lg:col-span-3">
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                               placeholder="Aussagekräftiger Titel für deine Anzeige"
                               class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Immobilientyp --}}
                    <div>
                        <label for="immobilientyp" class="block text-sm font-medium text-gray-700 mb-2">Immobilientyp</label>
                        <select name="immobilientyp" id="immobilientyp"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['Wohnung', 'Haus', 'Grundstück', 'Gewerbeobjekt', 'Garage/Stellplatz', 'Andere'] as $type)
                                <option value="{{ $type }}" {{ old('immobilientyp') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('immobilientyp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Objekttyp --}}
                    <div>
                        <label for="objekttyp" class="block text-sm font-medium text-gray-700 mb-2">Objekttyp (optional)</label>
                        <select name="objekttyp" id="objekttyp"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['Kauf', 'Miete'] as $type)
                                <option value="{{ $type }}" {{ old('objekttyp') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('objekttyp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
                    <div>
                        <label for="zustand" class="block text-sm font-medium text-gray-700 mb-2">Zustand (optional)</label>
                        <select name="zustand" id="zustand"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['Neubau / Erstbezug', 'Saniert', 'Renovierungsbedürftig', 'Altbau', 'Rohbau'] as $cond)
                                <option value="{{ $cond }}" {{ old('zustand') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                            @endforeach
                        </select>
                        @error('zustand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Anzahl Zimmer --}}
                    <div>
                        <label for="anzahl_zimmer" class="block text-sm font-medium text-gray-700 mb-2">Anzahl Zimmer (optional)</label>
                        <input type="number" step="0.5" name="anzahl_zimmer" id="anzahl_zimmer" value="{{ old('anzahl_zimmer') }}" placeholder="z.B. 3.5" min="0.5"
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
                            <option value="">Bitte wählen</option>
                            @foreach(['Massivbau', 'Fertigteilhaus', 'Holzbau', 'Ziegelbau', 'Stahlbeton'] as $type)
                                <option value="{{ $type }}" {{ old('bautyp') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('bautyp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="verfugbarkeit" class="block text-sm font-medium text-gray-700 mb-2">Verfügbarkeit (optional)</label>
                        <select name="verfugbarkeit" id="verfugbarkeit"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['Sofort', 'Nach Vereinbarung', 'Ab [Datum]'] as $avail)
                                <option value="{{ $avail }}" {{ old('verfugbarkeit') == $avail ? 'selected' : '' }}>{{ $avail }}</option>
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
                            <option value="">Bitte wählen</option>
                            @foreach(['Unbefristet', 'Befristet'] as $term)
                                <option value="{{ $term }}" {{ old('befristung') == $term ? 'selected' : '' }}>{{ $term }}</option>
                            @endforeach
                        </select>
                        @error('befristung')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Befristung Ende --}}
                    <div>
                        <label for="befristung_ende" class="block text-sm font-medium text-gray-700 mb-2">Befristung Ende (optional)</label>
                        <input type="date" name="befristung_ende" id="befristung_ende" value="{{ old('befristung_ende') }}"
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
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Objektbeschreibung --}}
                    <div>
                        <label for="objektbeschreibung" class="block text-sm font-medium text-gray-700 mb-2">Objektbeschreibung (optional)</label>
                        <textarea name="objektbeschreibung" id="objektbeschreibung" rows="3"
                                  placeholder="Detaillierte Beschreibung des Objekts."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('objektbeschreibung') }}</textarea>
                        @error('objektbeschreibung')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lage --}}
                    <div>
                        <label for="lage" class="block text-sm font-medium text-gray-700 mb-2">Lage (optional)</label>
                        <textarea name="lage" id="lage" rows="3"
                                  placeholder="Beschreibung der Lage und Umgebung."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('lage') }}</textarea>
                        @error('lage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sonstiges --}}
                    <div>
                        <label for="sonstiges" class="block text-sm font-medium text-gray-700 mb-2">Sonstiges (optional)</label>
                        <textarea name="sonstiges" id="sonstiges" rows="3"
                                  placeholder="Weitere allgemeine Informationen."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('sonstiges') }}</textarea>
                        @error('sonstiges')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zusatzinformation --}}
                    <div>
                        <label for="zusatzinformation" class="block text-sm font-medium text-gray-700 mb-2">Zusatzinformation (optional)</label>
                        <textarea name="zusatzinformation" id="zusatzinformation" rows="3"
                                  placeholder="Zusätzliche Informationen, die für den Käufer/Mieter relevant sein könnten."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('zusatzinformation') }}</textarea>
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
                        <input type="text" name="land" id="land" value="{{ old('land') ?? 'Österreich' }}" placeholder="z.B. Österreich"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('land')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PLZ --}}
                    <div>
                        <label for="plz" class="block text-sm font-medium text-gray-700 mb-2">Postleitzahl</label>
                        <input type="text" name="plz" id="plz" value="{{ old('plz') }}" placeholder="z.B. 1010"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('plz')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ort --}}
                    <div>
                        <label for="ort" class="block text-sm font-medium text-gray-700 mb-2">Ort</label>
                        <input type="text" name="ort" id="ort" value="{{ old('ort') }}" placeholder="z.B. Wien"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('ort')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Straße --}}
                    <div>
                        <label for="strasse" class="block text-sm font-medium text-gray-700 mb-2">Straße (optional)</label>
                        <input type="text" name="strasse" id="strasse" value="{{ old('strasse') }}" placeholder="z.B. Musterstraße 123"
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
                        <label for="gesamtmiete" class="block text-sm font-medium text-gray-700 mb-2">Gesamtmiete (in €)</label>
                        <input type="number" step="0.01" name="gesamtmiete" id="gesamtmiete" value="{{ old('gesamtmiete') }}" placeholder="z.B. 1200.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('gesamtmiete')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Wohnfläche --}}
                    <div>
                        <label for="wohnflaeche" class="block text-sm font-medium text-gray-700 mb-2">Wohnfläche (in m²)</label>
                        <input type="number" step="0.01" name="wohnflaeche" id="wohnflaeche" value="{{ old('wohnflaeche') }}" placeholder="z.B. 90.50"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('wohnflaeche')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grundfläche --}}
                    <div>
                        <label for="grundflaeche" class="block text-sm font-medium text-gray-700 mb-2">Grundfläche (in m²)</label>
                        <input type="number" step="0.01" name="grundflaeche" id="grundflaeche" value="{{ old('grundflaeche') }}" placeholder="z.B. 500.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('grundflaeche')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kaution --}}
                    <div>
                        <label for="kaution" class="block text-sm font-medium text-gray-700 mb-2">Kaution (in €)</label>
                        <input type="number" step="0.01" name="kaution" id="kaution" value="{{ old('kaution') }}" placeholder="z.B. 3600.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('kaution')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Maklerprovision --}}
                    <div>
                        <label for="maklerprovision" class="block text-sm font-medium text-gray-700 mb-2">Maklerprovision (in €)</label>
                        <input type="number" step="0.01" name="maklerprovision" id="maklerprovision" value="{{ old('maklerprovision') }}" placeholder="z.B. 2400.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('maklerprovision')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ablöse --}}
                    <div>
                        <label for="abloese" class="block text-sm font-medium text-gray-700 mb-2">Ablöse (in €)</label>
                        <input type="number" step="0.01" name="abloese" id="abloese" value="{{ old('abloese') }}" placeholder="z.B. 5000.00"
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
                        <label for="heizung" class="block text-sm font-medium text-gray-700 mb-2">Heizung (optional)</label>
                        <select name="heizung" id="heizung"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['Zentralheizung', 'Etagenheizung', 'Fußbodenheizung', 'Fernwärme', 'Gasheizung', 'Ölheizung', 'Elektroheizung', 'Kamin/Ofen'] as $heat)
                                <option value="{{ $heat }}" {{ old('heizung') == $heat ? 'selected' : '' }}>{{ $heat }}</option>
                            @endforeach
                        </select>
                        @error('heizung')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ausstattung (Checkboxes) --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ausstattung (optional)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @php
                                $ausstattungOptions = [
                                    'Balkon', 'Terrasse', 'Garten', 'Keller', 'Dachboden', 'Garage', 'Stellplatz',
                                    'Einbauküche', 'Möbliert', 'Barrierefrei', 'Aufzug', 'Klimaanlage', 'Swimmingpool',
                                    'Sauna', 'Alarmanlage', 'Rollstuhlgeeignet', 'Kabel/Sat-TV', 'Internetanschluss',
                                    'Waschküche', 'Abstellraum', 'Gäste-WC', 'Badewanne', 'Dusche', 'Separate Toilette'
                                ];
                            @endphp
                            @foreach($ausstattungOptions as $option)
                                <div class="flex items-center">
                                    <input type="checkbox" name="ausstattung[]" id="ausstattung_{{ Str::slug($option) }}" value="{{ $option }}"
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                           {{ in_array($option, old('ausstattung', [])) ? 'checked' : '' }}>
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

            {{-- Fotos & Dokumente Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos & Dokumente</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Multiple Images --}}
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Fotos hinzufügen</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                               class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                        @error('images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grundriss --}}
                    <div>
                        <label for="grundriss_path" class="block text-sm font-medium text-gray-700 mb-2">Grundriss (PDF/Bild, optional)</label>
                        <input type="file" name="grundriss_path" id="grundriss_path" accept=".pdf,image/*"
                               class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                        @error('grundriss_path')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Energieausweis --}}
                    <div>
                        <label for="energieausweis_path" class="block text-sm font-medium text-gray-700 mb-2">Energieausweis (PDF/Bild, optional)</label>
                        <input type="file" name="energieausweis_path" id="energieausweis_path" accept=".pdf,image/*"
                               class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                        @error('energieausweis_path')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rundgang Link --}}
                    <div>
                        <label for="rundgang_link" class="block text-sm font-medium text-gray-700 mb-2">360° Rundgang Link (optional)</label>
                        <input type="url" name="rundgang_link" id="rundgang_link" value="{{ old('rundgang_link') }}" placeholder="https://..."
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('rundgang_link')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Objektinformationen Link --}}
                    <div>
                        <label for="objektinformationen_link" class="block text-sm font-medium text-gray-700 mb-2">Objektinformationen Link (optional)</label>
                        <input type="url" name="objektinformationen_link" id="objektinformationen_link" value="{{ old('objektinformationen_link') }}" placeholder="https://..."
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('objektinformationen_link')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustandsbericht Link --}}
                    <div>
                        <label for="zustandsbericht_link" class="block text-sm font-medium text-gray-700 mb-2">Zustandsbericht Link (optional)</label>
                        <input type="url" name="zustandsbericht_link" id="zustandsbericht_link" value="{{ old('zustandsbericht_link') }}" placeholder="https://..."
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('zustandsbericht_link')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verkaufsbericht Link --}}
                    <div>
                        <label for="verkaufsbericht_link" class="block text-sm font-medium text-gray-700 mb-2">Verkaufsbericht Link (optional)</label>
                        <input type="url" name="verkaufsbericht_link" id="verkaufsbericht_link" value="{{ old('verkaufsbericht_link') }}" placeholder="https://..."
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
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" placeholder="Max Mustermann"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('contact_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Tel --}}
                    <div>
                        <label for="contact_tel" class="block text-sm font-medium text-gray-700 mb-2">Telefon (optional)</label>
                        <input type="tel" name="contact_tel" id="contact_tel" value="{{ old('contact_tel') }}" placeholder="+43 664 1234567"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('contact_tel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Email --}}
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">E-Mail</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" placeholder="max.mustermann@example.com"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('contact_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Firmenname --}}
                    <div>
                        <label for="firmenname" class="block text-sm font-medium text-gray-700 mb-2">Firmenname (optional)</label>
                        <input type="text" name="firmenname" id="firmenname" value="{{ old('firmenname') }}" placeholder="Muster Immobilien GmbH"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('firmenname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Homepage --}}
                    <div>
                        <label for="homepage" class="block text-sm font-medium text-gray-700 mb-2">Homepage (optional)</label>
                        <input type="url" name="homepage" id="homepage" value="{{ old('homepage') }}" placeholder="https://www.example.com"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('homepage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telefon 2 --}}
                    <div>
                        <label for="telefon2" class="block text-sm font-medium text-gray-700 mb-2">Telefon 2 (optional)</label>
                        <input type="tel" name="telefon2" id="telefon2" value="{{ old('telefon2') }}" placeholder="+43 1 2345678"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('telefon2')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fax --}}
                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 mb-2">Fax (optional)</label>
                        <input type="tel" name="fax" id="fax" value="{{ old('fax') }}" placeholder="+43 1 9876543"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('fax')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Immocard ID --}}
                    <div>
                        <label for="immocard_id" class="block text-sm font-medium text-gray-700 mb-2">Immocard ID (optional)</label>
                        <input type="text" name="immocard_id" id="immocard_id" value="{{ old('immocard_id') }}" placeholder="ID des Objekts"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('immocard_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Immocard Firma ID --}}
                    <div>
                        <label for="immocard_firma_id" class="block text-sm font-medium text-gray-700 mb-2">Immocard Firma ID (optional)</label>
                        <input type="text" name="immocard_firma_id" id="immocard_firma_id" value="{{ old('immocard_firma_id') }}" placeholder="ID der Firma"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('immocard_firma_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zusatzkontakt --}}
                    <div class="md:col-span-full">
                        <div class="flex items-center">
                            <input type="checkbox" name="zusatzkontakt" id="zusatzkontakt" value="1"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   {{ old('zusatzkontakt') ? 'checked' : '' }}>
                            <label for="zusatzkontakt" class="ml-2 text-sm font-medium text-gray-700">Zusätzlicher Kontakt gewünscht</label>
                        </div>
                        @error('zusatzkontakt')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige erstellen
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
