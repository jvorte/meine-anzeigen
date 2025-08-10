{{-- resources/views/ads/services/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-3">
            Dienstleistung Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 max-w-3xl">
            Passe die Details deiner Dienstleistung Anzeige an oder lösche sie. Nutze das folgende Formular, um alle
            Angaben übersichtlich und einfach zu bearbeiten.
        </p>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
   <x-breadcrumbs :items="[
    ['label' => 'Alle Anzeigen', 'url' => route('ads.index')],
    ['label' => 'Dienstleistungen', 'url' => route('categories.services.index')],
    ['label' => $service->title, 'url' => null],
]" class="mb-8" />
</div>

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-3xl shadow-xl my-6">
        <form method="POST" action="{{ route('ads.services.update', $service->id) }}" enctype="multipart/form-data"
            class="space-y-10">
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
                        <label for="service_type"
                            class="block text-sm font-semibold text-gray-700 mb-3">Kategorie</label>
                        <select name="service_type" id="service_type"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        
                          @foreach($serviceCategoryOptions as $serviceCategoryOption)
                                <option value="{{ $serviceCategoryOption }}" {{ old('service_type') == $serviceCategoryOption ? 'selected' : '' }}>
                                    {{ ucfirst($serviceCategoryOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Titel der Dienstleistung --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">Titel der
                            Dienstleistung</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}"
                            placeholder="z.B. Professionelle Fensterreinigung"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('title')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Region / Ort --}}
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-3">Region /
                            Ort</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $service->location) }}"
                            placeholder="z.B. Wien, Niederösterreich"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('location')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Preis (optional) --}}
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">Preis (in
                            €/Stunde/Pauschale, optional)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $service->price) }}"
                            placeholder="z.B. 50.00"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                        @error('price')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="availability" class="block text-sm font-semibold text-gray-700 mb-3">Verfügbarkeit
                            (optional)</label>
                        <select name="availability" id="availability"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">
                       
                                  @foreach($availabilityOptions as $availabilityOption)
                                <option value="{{ $availabilityOption }}" {{ old('condition') == $availabilityOption ? 'selected' : '' }}>
                                    {{ ucfirst($availabilityOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('availability')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Beschreibung --}}
                <div class="mt-8">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Beschreibung der
                        Dienstleistung</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Beschreibe hier deine Dienstleistung detailliert. Was bietest du an? Welche Erfahrungen hast du?"
                        class="w-full p-4 border border-gray-300 rounded-lg shadow-sm resize-none focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-200">{{ old('description', $service->description) }}</textarea>
                    @error('description')<p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </section>

            {{-- Fotoverwaltung --}}
                    <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos verwalten und hinzufügen</h4>

                {{-- Unified Alpine.js component for both existing and new images --}}
                <div x-data="multiImageUploader(
                    {{ json_encode($service->images->map(fn($image) => [
                        'id' => $image->id,
                        'url' => asset('storage/' . $image->image_path),
                        'is_thumbnail' => $image->is_thumbnail ?? false, // Ensure this maps correctly if you use it
                    ])) }}
                )" class="space-y-4">

                    {{-- Input for new files --}}
                    <input type="file" name="images[]" multiple @change="addNewFiles($event)"
                        class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Loop through EXISTING images, now managed by Alpine --}}
                        <template x-for="(image, index) in existingImages" :key="'existing-' + image.id">
                            <div class="relative group">
                                <img :src="image.url" class="w-full h-32 object-cover rounded shadow">
                                {{-- THIS IS THE HIDDEN INPUT FOR EXISTING IMAGES TO KEEP --}}
                                <input type="hidden" :name="'existing_images[]'" :value="image.id">

                                {{-- Button to remove existing image (which removes its hidden input) --}}
                                <button type="button" @click="removeExisting(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>

                        {{-- Loop through NEW previews (from uploaded files) --}}
                        <template x-for="(preview, index) in newFilePreviews" :key="'new-' + index">
                            <div class="relative group">
                                <img :src="preview" class="w-full h-32 object-cover rounded shadow">
                                {{-- Button to remove new image --}}
                                <button type="button" @click="removeNewFile(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews and Main Form Logic --}}
                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            existingImages: initialImages, // Images already saved in DB
                            newFiles: [], // Newly selected File objects
                            newFilePreviews: [], // URLs for new file previews

                            // `init` is not strictly necessary if `initialImages` is directly assigned
                            // but good practice if you had complex setup on mount.
                            // init() {
                            //    console.log('Alpine component initialized with existing images:', this.existingImages);
                            // },

                            addNewFiles(event) {
                                const files = Array.from(event.target.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newFilePreviews.push(URL.createObjectURL(file));
                                });
                                this.updateFileInput(); // Update the native file input so it sends the files
                            },

                            removeExisting(index) {
                                // Important: This removes the image from the `existingImages` array.
                                // Because the `<template x-for>` is reactive, this also removes the
                                // hidden input for that image, effectively telling the backend to delete it.
                                URL.revokeObjectURL(this.existingImages[index].url); // Clean up blob URL
                                this.existingImages.splice(index, 1);
                            },

                            removeNewFile(index) {
                                // Remove from newFiles and newFilePreviews
                                URL.revokeObjectURL(this.newFilePreviews[index]); // Clean up blob URL
                                this.newFiles.splice(index, 1);
                                this.newFilePreviews.splice(index, 1);
                                this.updateFileInput(); // Update the native file input
                            },

                            updateFileInput() {
                                // This is crucial: it reconstructs the FileList for the original
                                // input[type="file"] element, ensuring only the currently selected
                                // new files are actually sent.
                                const dataTransfer = new DataTransfer();
                                this.newFiles.forEach(file => dataTransfer.items.add(file));
                                const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                if (fileInput) {
                                    fileInput.files = dataTransfer.files;
                                }
                            }
                        };
                    }
                </script>
            </section>


            {{-- Submit Button --}}
            <div class="pt-8 border-t border-gray-300 flex justify-end">
                <button type="submit"
                    class="bg-gray-700 text-white px-12 py-4 rounded-full font-semibold text-lg shadow-lg hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75 transition transform hover:scale-105">
                    Anzeige aktualisieren
                </button>
            </div>
        </form>
    </div>
</x-app-layout>