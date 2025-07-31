{{-- resources/views/ads/motorrad/edit.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Motorrad Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Motorrad Anzeige.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Motorrad Anzeigen', 'url' => route('categories.show', 'motorrad')],
                ['label' => $motorradAd->title, 'url' => route('ads.motorrad.show', $motorradAd)],
                ['label' => 'Bearbeiten', 'url' => null],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.motorrad.update', $motorradAd) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fahrzeugdetails</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Marke --}}
                    <div>
                        <label for="motorcycle_brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
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
                    const brandId = '{{ old('motorcycle_brand_id', $motorradAd->motorcycle_brand_id ?? '') }}';
                    const modelId = '{{ old('motorcycle_model_id', $motorradAd->motorcycle_model_id ?? '') }}';

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
                        <input type="date" name="first_registration" id="first_registration"
                            value="{{ old('first_registration', $motorradAd->first_registration ? \Carbon\Carbon::parse($motorradAd->first_registration)->format('Y-m-d') : '') }}"
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
                            <option value="">Bitte wählen</option>
                            @foreach($colors as $color)
                                <option value="{{ $color }}" {{ old('color', $motorradAd->color) == $color ? 'selected' : '' }}>{{ $color }}</option>
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

            {{-- Photo Upload Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">

   {{-- Existing Photos Section --}}
@if ($motorradAd->images->count() > 0)
    <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-6">
        <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($motorradAd->images as $image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Motorrad Foto" class="w-full h-48 object-cover rounded-lg shadow-sm">
                    <label class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="mr-1"> Löschen
                    </label>
                </div>
            @endforeach
        </div>
        <p class="text-sm text-gray-600 mt-4">Wähle Fotos zum Löschen aus.</p>
    </section>
@endif

                
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                <div x-data="multiImageUploader()" class="space-y-4">
                    <input type="file" name="images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="(image, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                <script>
                    function multiImageUploader() {
                        return {
                            files: [],
                            previews: [],

                            addFiles(event) {
                                const newFiles = Array.from(event.target.files);

                                newFiles.forEach(file => {
                                    this.files.push(file);
                                    this.previews.push(URL.createObjectURL(file));
                                });

                                const dataTransfer = new DataTransfer();
                                this.files.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;
                            },

                            remove(index) {
                                URL.revokeObjectURL(this.previews[index]);

                                this.files.splice(index, 1);
                                this.previews.splice(index, 1);

                                const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                if (fileInput) {
                                    const dataTransfer = new DataTransfer();
                                    this.files.forEach(file => dataTransfer.items.add(file));
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
