{{-- resources/views/ads/motorrad/create.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            {{ __('Create new motorcycle ad') }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            {{ __('Select a suitable category and fill in the required fields to create your ad') }}
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
        ['label' => 'motorcycles ads', 'url' => route('categories.motorcycles.index')],
        ['label' => 'New motorcycles ads', 'url' => null],
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


    {{-- Main container for the form --}}
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.motorcycles.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Vehicle Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('Vehicle details') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Marke --}}
                    <div>
                        <label for="motorcycle_brand_id"
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('brand') }}</label>
                        <select name="motorcycle_brand_id" id="motorcycle_brand_id" onchange="loadModels(this.value)"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @foreach($brands as $id => $name)
                            <option value="{{ $id }}" {{ old('motorcycle_brand_id') == $id ? 'selected' : '' }}>
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
                        <label for="motorcycle_model_id"
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('model') }}</label>
                        <select name="motorcycle_model_id" id="motorcycle_model_id"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            {{-- Δεν φορτώνουμε μοντέλα server side στο create --}}
                        </select>
                        @error('motorcycle_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            <script>
                function loadModels(brandId) {
                    const modelSelect = document.getElementById('motorcycle_model_id');
                    modelSelect.innerHTML = '<option>Loading...</option>';

                    if (!brandId) {
                        modelSelect.innerHTML = '<option value="">Bitte zuerst eine Marke wählen</option>';
                        return;
                    }

                    fetch(`/api/motorcycle-brands/${brandId}/models`)

                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(models => {
                            modelSelect.innerHTML = '<option value="">Bitte wählen</option>';
                            models.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.id;
                                option.textContent = model.name;

                                // Επιλογή αν υπάρχει old('motorcycle_model_id') (πχ μετά από validation error)
                                const oldModelId = "{{ old('motorcycle_model_id') }}";
                                if (model.id == oldModelId) {
                                    option.selected = true;
                                }

                                modelSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading car models:', error);
                            modelSelect.innerHTML = '<option value="">Fehler beim Laden</option>';
                        });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const selectedBrandId = document.getElementById('motorcycle_brand_id').value;
                    if (selectedBrandId) {
                        loadModels(selectedBrandId);
                    }
                });
            </script>

            {{-- Basic Data Section (Erstzulassung, Kilometerstand, Leistung) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_basic_data') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">{{ __('price') }}</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                            placeholder="z.B. 5000.00"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Erstzulassung --}}
                    <div>
                        <label for="first_registration"
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('year_of_construction') }}</label>
                        <select name="first_registration" id="first_registration"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @php
                            $currentYear = date('Y');
                            $startYear = $currentYear - 100; // 50 years back
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}" {{ old('first_registration') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endfor
                        </select>
                        @error('first_registration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Kilometerstand --}}
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Mileage') }} (in
                            km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}"
                            placeholder="z.B. 50.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Leistung (PS) --}}
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Power') }} (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power') }}" placeholder="z.B. 150"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Type & Condition Section (Farbe & Zustand) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('condition_label') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Farbe --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Color') }}</label>
                        <select name="color" id="color"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @foreach($colors as $color)
                            <option value="{{ $color }}" {{ old('color') == $color ? 'selected' : '' }}>{{ __($color) }}
                            </option>
                            @endforeach
                        </select>
                        @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">{{ __('condition') }}</label>
                        <select name="condition" id="condition"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @foreach($conditions as $condition)
                            <option value="{{ $condition }}" {{ old('condition') == $condition ? 'selected' : '' }}>
                                {{ __($condition) }}
                            </option>
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
                {{-- Titel --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Titel</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="Aussagekräftiger Titel für deine Anzeige"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Description</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="Gib hier alle wichtigen Details zu deinem Motorrad ein. Je mehr Informationen, desto besser!"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- conatct Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('publish_contact_select') }}</h4>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_phone" value="1" class="rounded border-gray-300">
                        <span class="ml-2">Phone</span>
                    </label>
                </div>

                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_mobile_phone" value="1" class="rounded border-gray-300">
                        <span class="ml-2">Mobile</span>
                    </label>
                </div>


                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_email" value="1" class="rounded border-gray-300">
                        <span class="ml-2">email</span>
                    </label>
                </div>


            </section>

            {{-- Photo Upload Section (with Alpine.js for previews) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_photos') }}</h4>

                {{-- Pass an empty array for initial images in create form --}}
                <div x-data="multiImageUploader([])" class="space-y-4">
                    <input type="file" name="images[]" multiple @change="addNewFiles($event)"
                        class="block w-full border p-2 rounded" />
                    @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Loop through existing images (will be empty in create form) --}}
                        <template x-for="(image, index) in existingImages" :key="'existing-' + index">
                            {{-- ... (existing image display logic - won't be shown in create) ... --}}
                        </template>

                        {{-- Loop through new previews (from uploaded files) --}}
                        <template x-for="(preview, index) in newFilePreviews" :key="'new-' + index">
                            <div class="relative group">
                                <img :src="preview" class="w-full h-32 object-cover rounded shadow">
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

                            // Initialize with existing images and add their previews
                            init() {
                                // This data is already in initialImages.url
                            },

                            addNewFiles(event) {
                                const files = Array.from(event.target.files);
                                files.forEach(file => {
                                    this.newFiles.push(file);
                                    this.newFilePreviews.push(URL.createObjectURL(file));
                                });
                                this.updateFileInput();
                            },

                            removeExisting(index) {
                                // Remove from existingImages array, which will also remove the hidden input
                                URL.revokeObjectURL(this.existingImages[index].url); // Clean up blob URL if applicable
                                this.existingImages.splice(index, 1);
                            },

                            removeNewFile(index) {
                                // Remove from newFiles and newFilePreviews
                                URL.revokeObjectURL(this.newFilePreviews[index]);
                                this.newFiles.splice(index, 1);
                                this.newFilePreviews.splice(index, 1);
                                this.updateFileInput();
                            },

                            updateFileInput() {
                                // Update the actual file input element with current newFiles
                                const dataTransfer = new DataTransfer();
                                this.newFiles.forEach(file => dataTransfer.items.add(file));
                                this.$el.querySelector('input[type="file"][name="images[]"]').files = dataTransfer.files;
                            }
                        };
                    }
                </script>



                {{-- Submit Button --}}
                <div class="pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                        {{ __('create_ad') }}
                    </button>
                </div>

        </form>
    </div>
</x-app-layout>