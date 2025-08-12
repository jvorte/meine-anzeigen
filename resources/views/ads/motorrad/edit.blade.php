{{-- resources/views/ads/motorrad/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            motorcycles
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Motorrad Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'motorcycles Anzeigen', 'url' => route('categories.motorcycles.index')],
                ['label' => $motorradAd->title, 'url' => route('ads.motorcycles.index', $motorradAd)],
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

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.motorrad.update', $motorradAd) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Marke --}}
                    <div>
                        <label for="motorcycle_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <select name="motorcycle_brand_id" id="motorcycle_brand_id" onchange="loadModels(this.value)"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($brands as $id => $name)
                            <option value="{{ $id }}" {{ (old('motorcycle_brand_id', $motorradAd->motorcycle_brand_id) == $id) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                        @error('motorcycle_brand_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modell --}}
                    <div>
                        <label for="motorcycle_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="motorcycle_model_id" id="motorcycle_model_id"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($initialModels as $id => $name)
                            <option value="{{ $id }}" {{ (old('motorcycle_model_id', $motorradAd->motorcycle_model_id) == $id) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                        @error('motorcycle_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            <script>
                async function loadModels(brandId, selectedModelId = null) {
                    const modelSelect = document.getElementById('motorcycle_model_id');
                    modelSelect.innerHTML = '<option value="">Bitte wählen</option>'; // Clear

                    if (!brandId) return;

                    try {
                        const response = await fetch(`/api/motorcycle-brands/${brandId}/models`);
                        if (!response.ok) throw new Error('Network response was not ok');
                        const models = await response.json();

                        models.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);
                        });

                        if (selectedModelId) {
                            modelSelect.value = selectedModelId;
                        }
                    } catch (error) {
                        console.error('Error loading models:', error);
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const brandId = '{{ old('
                    motorcycle_brand_id ', $motorradAd->motorcycle_brand_id ?? '
                    ') }}';
                    const modelId = '{{ old('
                    motorcycle_model_id ', $motorradAd->motorcycle_model_id ?? '
                    ') }}';

                    if (brandId) {
                        loadModels(brandId, modelId);
                    }
                });
            </script>

            {{-- Basic Data Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (€)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $motorradAd->price ?? '') }}"
                            placeholder="z.B. 7.500"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            min="0" step="0.01">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung</label>
                        <input type="number" name="first_registration" id="first_registration"
                            min="1900" max="{{ date('Y') }}"
                            value="{{ old('first_registration', $motorradAd->first_registration) }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('first_registration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">Kilometerstand (in km)</label>
                        <input type="number" name="mileage" id="mileage"
                            value="{{ old('mileage', $motorradAd->mileage) }}" placeholder="z.B. 50.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power', $motorradAd->power) }}"
                            placeholder="z.B. 150"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            {{-- Type & Condition Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Typ & Zustand</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe</label>
                        <select name="color" id="color"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        
                            @foreach($colors as $color)
                            <option value="{{ $color }}" {{ old('color', $motorradAd->color) == $color ? 'selected' : '' }}>
                                {{ $color }}
                            </option>
                            @endforeach
                        </select>
                        @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($conditions as $condition)
                            <option value="{{ $condition }}" {{ old('condition', $motorradAd->condition) == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $motorradAd->title) }}"
                        placeholder="Aussagekräftiger Titel für deine Anzeige"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Gib hier alle wichtigen Details zu deinem Motorrad ein. Je mehr Informationen, desto besser!"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $motorradAd->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                            {{ old('show_phone', $motorradAd->show_phone) ? 'checked' : '' }}>
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
                            {{ old('show_mobile_phone', $motorradAd->show_mobile_phone) ? 'checked' : '' }}>
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
                            {{ old('show_email', $motorradAd->show_email) ? 'checked' : '' }}>
                        <span class="ml-2">Email</span>
                    </label>
                </div>
            </section>


            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos verwalten und hinzufügen</h4>

                {{-- Unified Alpine.js component for both existing and new images --}}
                <div x-data="multiImageUploader(
                    {{ json_encode($motorradAd->images->map(fn($image) => [
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
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige aktualisieren
                </button>
            </div>

        </form>
    </div>

</x-app-layout>