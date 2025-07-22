{{-- resources/views/ads/services/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Neue Anzeige: Dienstleistung erstellen
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.services.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Hidden field for category_slug --}}
            <input type="hidden" name="category_slug" value="dienstleistungen">

            {{-- Dienstleistungsdetails Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Dienstleistungsdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Dienstleistung Kategorie --}}
                    <div>
                        <label for="dienstleistung_kategorie" class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
                        <select name="dienstleistung_kategorie" id="dienstleistung_kategorie"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'] as $category)
                                <option value="{{ $category }}" {{ old('dienstleistung_kategorie') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                        @error('dienstleistung_kategorie')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Titel der Dienstleistung --}}
                    <div class="md:col-span-2">
                        <label for="titel" class="block text-sm font-medium text-gray-700 mb-2">Titel der Dienstleistung</label>
                        <input type="text" name="titel" id="titel" value="{{ old('titel') }}" placeholder="z.B. Professionelle Fensterreinigung"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('titel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Region / Ort --}}
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 mb-2">Region / Ort</label>
                        <input type="text" name="region" id="region" value="{{ old('region') }}" placeholder="z.B. Wien, Niederösterreich"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('region')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preis (optional) --}}
                    <div>
                        <label for="preis" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €/Stunde/Pauschale, optional)</label>
                        <input type="number" step="0.01" name="preis" id="preis" value="{{ old('preis') }}" placeholder="z.B. 50.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('preis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="verfugbarkeit" class="block text-sm font-medium text-gray-700 mb-2">Verfügbarkeit (optional)</label>
                        <select name="verfugbarkeit" id="verfugbarkeit"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'] as $avail)
                                <option value="{{ $avail }}" {{ old('verfugbarkeit') == $avail ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $avail)) }}</option>
                            @endforeach
                        </select>
                        @error('verfugbarkeit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Beschreibung --}}
                <div class="mt-6">
                    <label for="beschreibung" class="block text-sm font-medium text-gray-700 mb-2">Beschreibung der Dienstleistung</label>
                    <textarea name="beschreibung" id="beschreibung" rows="7"
                              placeholder="Beschreibe hier deine Dienstleistung detailliert. Was bietest du an? Welche Erfahrungen hast du?"
                              class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('beschreibung') }}</textarea>
                    @error('beschreibung')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Fotos hinzufügen Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen (optional)</h4>
                <div>
                    <label for="bilder" class="sr-only">Bilder hochladen</label>
                    <input type="file" name="bilder[]" id="bilder" multiple accept="image/*"
                           class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                    @error('bilder')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Kontaktinformationen Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Kontaktinformationen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Kontakt Name --}}
                    <div>
                        <label for="kontakt_name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" name="kontakt_name" id="kontakt_name" value="{{ old('kontakt_name') }}" placeholder="Ihr Name"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('kontakt_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kontakt Telefon --}}
                    <div>
                        <label for="kontakt_tel" class="block text-sm font-medium text-gray-700 mb-2">Telefon (optional)</label>
                        <input type="tel" name="kontakt_tel" id="kontakt_tel" value="{{ old('kontakt_tel') }}" placeholder="+43 664 1234567"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('kontakt_tel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kontakt E-Mail --}}
                    <div>
                        <label for="kontakt_email" class="block text-sm font-medium text-gray-700 mb-2">E-Mail</label>
                        <input type="email" name="kontakt_email" id="kontakt_email" value="{{ old('kontakt_email') }}" placeholder="ihre.email@example.com"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('kontakt_email')
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
