{{-- resources/views/ads/services/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Dienstleistung Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Passe die Details deiner Dienstleistung Anzeige an oder lösche sie.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Meine Anzeigen', 'url' => route('dashboard')], {{-- Assuming a dashboard or list of user ads --}}
                ['label' => $ad->title, 'url' => route('ads.services.show', $ad)], {{-- Link to the ad's show page --}}
                ['label' => 'Bearbeiten', 'url' => route('ads.services.edit', $ad)],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.services.update', $ad->id) }}" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT') {{-- Essential for updating resources --}}

            {{-- Hidden field for category_slug (can be kept or removed if not editable) --}}
            <input type="hidden" name="category_slug" value="dienstleistungen">

            {{-- Dienstleistungsdetails Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Dienstleistungsdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Dienstleistung Kategorie --}}
                    <div>
                        <label for="service_type"
                            class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
                        <select name="service_type" id="service_type"
                            class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['reinigung', 'handwerk', 'it', 'beratung', 'transport', 'sonstiges'] as $category)
                                <option value="{{ $category }}" {{ old('service_type', $ad->service_type) == $category ? 'selected' : '' }}>{{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Titel der Dienstleistung --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titel der
                            Dienstleistung</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $ad->title) }}"
                            placeholder="z.B. Professionelle Fensterreinigung"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Region / Ort --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Region / Ort</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $ad->location) }}"
                            placeholder="z.B. Wien, Niederösterreich"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preis (optional) --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in
                            €/Stunde/Pauschale, optional)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $ad->price) }}"
                            placeholder="z.B. 50.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="availability" class="block text-sm font-medium text-gray-700 mb-2">Verfügbarkeit
                            (optional)</label>
                        <select name="availability" id="availability"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach(['sofort', 'nach_vereinbarung', 'während_wochentagen', 'wochenende'] as $avail)
                                <option value="{{ $avail }}" {{ old('availability', $ad->availability) == $avail ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $avail)) }}</option>
                            @endforeach
                        </select>
                        @error('availability')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Beschreibung --}}
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Beschreibung der
                        Dienstleistung</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Beschreibe hier deine Dienstleistung detailliert. Was bietest du an? Welche Erfahrungen hast du?"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $ad->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Photo Upload Section (with Alpine.js for previews and existing photos) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos verwalten</h4>

                <div x-data="multiImageUploader(
                    {{ json_encode($ad->images->map(fn($image) => ['id' => $image->id, 'url' => asset('storage/' . $image->path)])) }}
                )" class="space-y-4">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Neue Fotos
                        hinzufügen</label>
                    <input type="file" name="images[]" id="images" multiple @change="addNewFiles($event)"
                        class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Existing Images --}}
                        <template x-for="(image, index) in existingImages" :key="'existing-' + image.id">
                            <div class="relative group">
                                <img :src="image.url" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="removeExistingImage(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                        {{-- Newly Uploaded Images --}}
                        <template x-for="(image, index) in newImagePreviews" :key="'new-' + index">
                            <div class="relative group">
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="removeNewImage(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>

                    {{-- Hidden input to send IDs of images to be deleted --}}
                    <template x-for="id in imagesToDelete" :key="'delete-' + id">
                        <input type="hidden" :name="'images_to_delete[]'" :value="id">
                    </template>
                </div>

                {{-- Alpine.js Script for Image Previews and Main Form Logic --}}
                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            existingImages: initialImages, // [{ id: ..., url: ... }]
                            newFiles: [], // File objects for new uploads
                            newImagePreviews: [], // URLs for new uploads
                            imagesToDelete: [], // IDs of existing images to delete

                            addNewFiles(event) {
                                const files = Array.from(event.target.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newImagePreviews.push(URL.createObjectURL(file));
                                });
                                // Clear the file input to allow selecting the same files again if needed
                              
                            },

                            removeExistingImage(index) {
                                const imageId = this.existingImages[index].id;
                                this.imagesToDelete.push(imageId);
                                this.existingImages.splice(index, 1);
                            },

                            removeNewImage(index) {
                                URL.revokeObjectURL(this.newImagePreviews[index]); // Free up memory
                                this.newFiles.splice(index, 1);
                                this.newImagePreviews.splice(index, 1);
                            },
                        };
                    }
                </script>
            </section>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige aktualisieren
                </button>
            </div>
        </form>



    </div>
</x-app-layout>