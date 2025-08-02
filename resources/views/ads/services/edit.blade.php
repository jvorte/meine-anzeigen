{{-- resources/views/ads/services/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-3">
            Dienstleistung Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 max-w-3xl">
            Passe die Details deiner Dienstleistung Anzeige an oder lösche sie. Nutze das folgende Formular, um alle Angaben übersichtlich und einfach zu bearbeiten.
        </p>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Meine Anzeigen', 'url' => route('dashboard')],
                ['label' => $ad->title, 'url' => route('ads.services.show', $ad)],
                ['label' => 'Bearbeiten', 'url' => route('ads.services.edit', $ad)],
            ]" class="mb-10" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-3xl shadow-xl mt-6">
        <form method="POST" action="{{ route('ads.services.update', $ad->id) }}" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')

            {{-- Hidden field for category_slug --}}
            <input type="hidden" name="category_slug" value="dienstleistungen">

            {{-- Dienstleistungsdetails --}}
            <section class="bg-gray-50 p-8 rounded-xl shadow-inner border border-gray-300">
                <h4 class="text-2xl font-semibold text-gray-800 mb-8 tracking-wide border-b border-gray-300 pb-2">
                    Dienstleistungsdetails
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    {{-- Dienstleistung Kategorie --}}
                    <div>
                        <label for="service_type" class="block text-sm font-semibold text-gray-700 mb-3">Kategorie</label>
                        <select name="service_type" id="service_type"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                            <option value="">Bitte wählen</option>
                            @foreach(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'] as $category)
                                <option value="{{ $category }}" {{ old('service_type', $ad->service_type) == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Titel der Dienstleistung --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">Titel der Dienstleistung</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $ad->title) }}" placeholder="z.B. Professionelle Fensterreinigung"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('title')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Region / Ort --}}
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-3">Region / Ort</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $ad->location) }}" placeholder="z.B. Wien, Niederösterreich"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('location')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Preis (optional) --}}
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">Preis (in €/Stunde/Pauschale, optional)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $ad->price) }}" placeholder="z.B. 50.00"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('price')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="availability" class="block text-sm font-semibold text-gray-700 mb-3">Verfügbarkeit (optional)</label>
                        <select name="availability" id="availability"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                            <option value="">Bitte wählen</option>
                            @foreach(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'] as $avail)
                                <option value="{{ $avail }}" {{ old('availability', $ad->availability) == $avail ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $avail)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('availability')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Beschreibung --}}
                <div class="mt-8">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Beschreibung der Dienstleistung</label>
                    <textarea name="description" id="description" rows="7" placeholder="Beschreibe hier deine Dienstleistung detailliert. Was bietest du an? Welche Erfahrungen hast du?"
                        class="w-full p-4 border border-gray-300 rounded-lg shadow-sm resize-none focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">{{ old('description', $ad->description) }}</textarea>
                    @error('description')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </section>

            {{-- Fotoverwaltung --}}
            <section class="bg-gray-50 p-8 rounded-xl shadow-inner border border-gray-300">
                <h4 class="text-2xl font-semibold text-gray-800 mb-8 tracking-wide border-b border-gray-300 pb-2">
                    Fotos verwalten
                </h4>
                <div x-data="multiImageUploader(
                    {{ $ad->images->map(fn($image) => ['id' => $image->id, 'url' => asset('storage/' . $image->path)])->toJson() }}
                )" class="space-y-6">

                    <label for="images" class="block text-sm font-semibold text-gray-700 mb-4">
                        Neue Fotos hinzufügen
                    </label>
                    <input type="file" name="images[]" id="images" multiple @change="addNewFiles($event)"
                        class="block w-full rounded-lg border border-gray-300 p-3 shadow-sm cursor-pointer transition focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50" />

                    @error('images')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        {{-- Bestehende Bilder --}}
                        <template x-for="(image, index) in existingImages" :key="'existing-' + image.id">
                            <div class="relative group rounded-xl overflow-hidden shadow-lg">
                                <img :src="image.url" alt="Vorhandenes Bild" class="w-full h-32 object-cover rounded-lg cursor-pointer" />
                                <button type="button" @click="removeExistingImage(index)" aria-label="Foto entfernen"
                                    class="absolute top-2 right-2 bg-red-600 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    &times;
                                </button>
                            </div>
                        </template>

                        {{-- Neue Upload Bildvorschau --}}
                        <template x-for="(image, index) in newImagePreviews" :key="'new-' + index">
                            <div class="relative group rounded-xl overflow-hidden shadow-lg">
                                <img :src="image" alt="Neue Bildvorschau" class="w-full h-32 object-cover rounded-lg cursor-pointer" />
                                <button type="button" @click="removeNewImage(index)" aria-label="Foto entfernen"
                                    class="absolute top-2 right-2 bg-red-600 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Hidden Inputs für zu löschende Bilder --}}
                    <template x-for="id in imagesToDelete" :key="'delete-' + id">
                        <input type="hidden" :name="'images_to_delete[]'" :value="id" />
                    </template>
                </div>

                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            existingImages: initialImages,
                            newFiles: [],
                            newImagePreviews: [],
                            imagesToDelete: [],

                            addNewFiles(event) {
                                const input = event.target;
                                if (!input.files.length) return;
                                const files = Array.from(input.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newImagePreviews.push(URL.createObjectURL(file));
                                });
                                // Input zurücksetzen, damit gleiche Dateien erneut selektiert werden können
                                input.value = '';
                            },

                            removeExistingImage(index) {
                                this.imagesToDelete.push(this.existingImages[index].id);
                                this.existingImages.splice(index, 1);
                            },

                            removeNewImage(index) {
                                URL.revokeObjectURL(this.newImagePreviews[index]);
                                this.newFiles.splice(index, 1);
                                this.newImagePreviews.splice(index, 1);
                            },
                        }
                    }
                </script>
            </section>

            {{-- Submit Button --}}
            <div class="pt-8 border-t border-gray-300 flex justify-end">
                <button type="submit"
                    class="bg-gray-700 text-white px-12 py-4 rounded-full font-semibold text-lg shadow-lg hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75 transition transform hover:scale-105"
                >
                    Anzeige aktualisieren
                </button>
            </div>
        </form>
    </div>
</x-app-layout>