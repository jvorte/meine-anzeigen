{{-- resources/views/ads/household/edit.blade.php --}}
<x-app-layout>
  
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
           Anzeige Haushaltsartikel bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite deine Anzeige und passe die Informationen an.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component (προαιρετικό, αν έχεις) --}}
            <x-breadcrumbs :items="[
                ['label' => 'household Anzeigen', 'url' => route('categories.household.index')],
                ['label' => 'Anzeige bearbeiten', 'url' => null],
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

        <form method="POST" action="{{ route('ads.household-items.update', $householdItem) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Item Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Artikel-Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
                        <select name="category" id="category"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $householdItem->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Brand --}}
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Marke (optional)</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $householdItem->brand) }}" placeholder="z.B. Ektorp Sofa, Serie 7 Stuhl"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('brand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Model Name --}}
                    <div>
                        <label for="model_name" class="block text-sm font-medium text-gray-700 mb-2">Modellbezeichnung (optional)</label>
                        <input type="text" name="model_name" id="model_name" value="{{ old('model_name', $householdItem->model_name) }}" placeholder="z.B. Ektorp Sofa, Serie 7 Stuhl"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('model_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $householdItem->price) }}" placeholder="z.B. 250"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Condition --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Zustand</label>
                        <select name="condition" id="condition"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                         @foreach ($conditions as $condition) 
                         
                                <option value="{{ $condition }}" {{ old('category', $householdItem->condition) == $cat ? 'selected' : '' }}>{{ $condition }}</option>
                            @endforeach
                            </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Material --}}
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Material (optional)</label>
                        <input type="text" name="material" id="material" value="{{ old('material', $householdItem->material) }}" placeholder="z.B. Holz, Stoff, Metall"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('material')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Color --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe (optional)</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $householdItem->color) }}" placeholder="z.B. Grau, Weiß, Braun"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dimensions --}}
                    <div class="md:col-span-2">
                        <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Maße (L x B x H, optional)</label>
                        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $householdItem->dimensions) }}" placeholder="z.B. 200x90x75 cm"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('dimensions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                {{-- Title --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $householdItem->title) }}"
                           placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. Modernes 3-Sitzer Sofa)"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="Gib hier alle wichtigen Details zu deinem Haushaltsartikel ein. Zustand, Alter, Besonderheiten, Abholbedingungen."
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description', $householdItem->description) }}</textarea>
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
                {{ old('show_phone', $householdItem->show_phone) ? 'checked' : '' }}
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
                {{ old('show_mobile_phone', $householdItem->show_mobile_phone) ? 'checked' : '' }}
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
                {{ old('show_email', $householdItem->show_email) ? 'checked' : '' }}
            >
            <span class="ml-2">Email</span>
        </label>
    </div>
</section>




    <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

    {{-- Initial Alpine.js data with existing images --}}
    <div x-data="multiImageUploader( {{ json_encode($householdItem->images->map(fn($image) => ['id' => $image->id, 'url' => Storage::url($image->image_path)])) }} )" class="space-y-4">
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
                    Anzeige aktualisieren
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
