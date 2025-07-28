{{-- resources/views/ads/boats/edit.blade.php --}}
<x-app-layout>
    {{-- -----------------------------------breadcrumbs ---------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Bootsanzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Passe die Informationen für deine Bootsanzeige an.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Bootsanzeigen', 'url' => route('ads.index')], {{-- Assuming an index route for all ads --}}
                ['label' => 'Bootsanzeige bearbeiten', 'url' => route('ads.boats.edit', $boat->id)],
            ]" />
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.boats.update', $boat->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Hidden field for category_slug (assuming it remains 'boats') --}}
            <input type="hidden" name="category_slug" value="boats">

            {{-- Basisdaten Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Basisdaten</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Titel --}}
                    <div class="lg:col-span-3">
                        <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $boat->title) }}"
                               placeholder="Aussagekräftiger Titel für deine Anzeige"
                               class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Marke (Brand) - Now a simple text input --}}
                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <input type="text" name="brand_name" id="brand_name" value="{{ old('brand', $boat->brand_name) }}" {{-- Ensure $boat->brand_name is directly used --}}
                               placeholder="z.B. Bavaria, Jeanneau"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('brand_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modell (Model) - Now a simple text input --}}
                    <div>
                        <label for="model_name" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <input type="text" name="model_name" id="model_name" value="{{ old('model', $boat->model_name) }}" {{-- Ensure $boat->model_name is directly used --}}
                               placeholder="z.B. Cruiser 34, Sun Odyssey 409"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('model_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Baujahr --}}
                    <div>
                        <label for="year_of_construction" class="block text-sm font-medium text-gray-700 mb-2">Baujahr</label>
                        <input type="number" name="year_of_construction" id="year_of_construction" value="{{ old('year_of_construction', $boat->year_of_construction) }}" placeholder="z.B. 2010" min="1900" max="{{ date('Y') + 1 }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('year_of_construction')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Zustand --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($conditions as $cond)
                                <option value="{{ $cond }}" {{ old('condition', $boat->condition) == $cond ? 'selected' : '' }}>{{ ucfirst($cond) }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bootstyp --}}
                    <div>
                        <label for="boat_type" class="block text-sm font-medium text-gray-700 mb-2">Bootstyp</label>
                        <select name="boat_type" id="boat_type"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($boatTypes as $type)
                                <option value="{{ $type }}" {{ old('boat_type', $boat->boat_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('boat_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Material --}}
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <select name="material" id="material"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($materials as $mat)
                                <option value="{{ $mat }}" {{ old('material', $boat->material) == $mat ? 'selected' : '' }}>{{ $mat }}</option>
                            @endforeach
                        </select>
                        @error('material')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gesamtlänge --}}
                    <div>
                        <label for="total_length" class="block text-sm font-medium text-gray-700 mb-2">Gesamtlänge (in m, optional)</label>
                        <input type="number" step="0.01" name="total_length" id="total_length" value="{{ old('total_length', $boat->total_length) }}" placeholder="z.B. 9.50" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_length')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gesamtbreite --}}
                    <div>
                        <label for="total_width" class="block text-sm font-medium text-gray-700 mb-2">Gesamtbreite (in m, optional)</label>
                        <input type="number" step="0.01" name="total_width" id="total_width" value="{{ old('total_width', $boat->total_width) }}" placeholder="z.B. 3.00" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_width')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kojen --}}
                    <div>
                        <label for="berths" class="block text-sm font-medium text-gray-700 mb-2">Kojen (optional)</label>
                        <input type="number" name="berths" id="berths" value="{{ old('berths', $boat->berths) }}" placeholder="z.B. 4" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('berths')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Motortyp --}}
                    <div>
                        <label for="engine_type" class="block text-sm font-medium text-gray-700 mb-2">Motortyp (optional)</label>
                        <select name="engine_type" id="engine_type"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($engineTypes as $engine)
                                <option value="{{ $engine }}" {{ old('engine_type', $boat->engine_type) == $engine ? 'selected' : '' }}>{{ $engine }}</option>
                            @endforeach
                        </select>
                        @error('engine_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Motorleistung --}}
                    <div>
                        <label for="engine_power" class="block text-sm font-medium text-gray-700 mb-2">Motorleistung (in PS, optional)</label>
                        <input type="number" name="engine_power" id="engine_power" value="{{ old('engine_power', $boat->engine_power) }}" placeholder="z.B. 150" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('engine_power')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Betriebsstunden --}}
                    <div>
                        <label for="operating_hours" class="block text-sm font-medium text-gray-700 mb-2">Betriebsstunden (optional)</label>
                        <input type="number" name="operating_hours" id="operating_hours" value="{{ old('operating_hours', $boat->operating_hours) }}" placeholder="z.B. 500" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('operating_hours')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Letzter Service --}}
                    <div>
                        <label for="last_service" class="block text-sm font-medium text-gray-700 mb-2">Letzter Service (optional)</label>
                        <input type="date" name="last_service" id="last_service" value="{{ old('last_service', $boat->last_service ? \Carbon\Carbon::parse($boat->last_service)->format('Y-m-d') : '') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('last_service')
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
                                  placeholder="Gib hier die Hauptbeschreibung deines Boots ein."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $boat->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Preise Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Preise</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Preis --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $boat->price) }}" placeholder="z.B. 15000.00"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Standort Section --}}
            {{-- <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Standort</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Land</label>
                        <input type="text" name="country" id="country" value="{{ old('country', $boat->country ?? 'Österreich') }}" placeholder="z.B. Österreich"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">Postleitzahl</label>
                        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $boat->zip_code) }}" placeholder="z.B. 1010"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('zip_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Ort</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $boat->city) }}" placeholder="z.B. Wien"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

        
                    <div>
                        <label for="street" class="block text-sm font-medium text-gray-700 mb-2">Straße (optional)</label>
                        <input type="text" name="street" id="street" value="{{ old('street', $boat->street) }}" placeholder="z.B. Musterstraße 123"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('street')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section> --}}

            {{-- Fotos & Dokumente Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

                {{-- Updated initialImages to use `image_path` --}}
                <div x-data="multiImageUploader({{ json_encode($boat->images->map(fn($image) => ['id' => $image->id, 'path' => asset('storage/' . $image->image_path)])) }})" class="space-y-4">
                    {{-- The file input field. Laravel will pick up files from here. --}}
                    <input type="file" name="images[]" multiple @change="addFiles($event)" class="block w-full border p-2 rounded" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*') {{-- For individual image validation errors --}}
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="(image, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="image.path" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="remove(index, image.id)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>

                    {{-- Hidden input to store IDs of images to be deleted --}}
                    <input type="hidden" name="deleted_images" :value="deletedImageIds.join(',')">
                </div>

                {{-- Alpine.js Script for Image Previews (stays the same, but commenting for clarity) --}}
                <script>
                    function multiImageUploader(initialImages = []) {
                        return {
                            files: [], // Stores new File objects to be uploaded
                            previews: initialImages, // Stores {id, path} for existing, and {path} for new files for previews
                            deletedImageIds: [], // Stores IDs of images to be deleted

                            addFiles(event) {
                                const newFiles = Array.from(event.target.files);

                                newFiles.forEach(file => {
                                    this.files.push(file);
                                    this.previews.push({ path: URL.createObjectURL(file), fileObject: file }); // Store fileObject for removal
                                });

                                // Update the actual file input's files property for submission
                                const dataTransfer = new DataTransfer();
                                this.files.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;
                            },

                            remove(index, imageId = null) {
                                // If imageId exists, it's an existing image to be marked for deletion
                                if (imageId) {
                                    this.deletedImageIds.push(imageId);
                                } else {
                                    // It's a newly added file not yet uploaded
                                    URL.revokeObjectURL(this.previews[index].path); // Revoke URL for memory cleanup
                                    const fileToRemove = this.previews[index].fileObject;
                                    this.files = this.files.filter(f => f !== fileToRemove); // Remove from internal files array

                                    // Update the actual file input's files property for submission
                                    const dataTransfer = new DataTransfer();
                                    this.files.forEach(file => dataTransfer.items.add(file));
                                    const fileInput = this.$el.querySelector('input[type="file"][name="images[]"]');
                                    if (fileInput) {
                                        fileInput.files = dataTransfer.files;
                                    }
                                }
                                this.previews.splice(index, 1);
                            }
                        };
                    }
                </script>
            </section>

            <div class="flex justify-end mt-8">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                    Anzeige aktualisieren
                </button>
            </div>
        </form>
    </div>
</x-app-layout>