{{-- resources/views/ads/others/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
         {{ __('Edit Ad') }}: {{ $other->title }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
           {{ __('Edit the details of your ad or add new photos') }}
        </p>

    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'Sonstiges Anzeigen', 'url' => route('categories.others.index')],
        ['label' => $other->title, 'url' => route('ads.others.show', $other->id)],
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

 
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        <form method="POST" action="{{ route('ads.others.update', $other->id) }}" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Hidden field for category_slug (assuming it's not editable) --}}
            <input type="hidden" name="category_slug" value="{{ old('category_slug', $other->category_slug) }}">

            {{-- General Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Artikel-Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">{{ __('title') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $other->title) }}"
                            placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. Alte Schallplatten Sammlung)"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" step="0.01" name="price" id="price"
                            value="{{ old('price', $other->price) }}" placeholder="z.B. 75.00"
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
                            @foreach($conditionOptions as $conditionOption)
                                <option value="{{ $conditionOption }}" {{ old('condition') == $conditionOption ? 'selected' : '' }}>
                                    {{ ucfirst($conditionOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2 mt-6">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('description') }}</label>
                        <textarea name="description" id="description" rows="7"
                            placeholder="Gib hier alle wichtigen Details zu deinem Artikel ein, der nicht in andere Kategorien passt."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $other->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>


            {{-- Contact Section --}}
<section class="bg-gray-50 p-6 rounded-lg shadow-inner">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">
         {{ __('publish_contact_select') }}
    </h4>

    {{-- Phone --}}
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input 
                type="checkbox" 
                name="show_phone" 
                value="1" 
                class="rounded border-gray-300"
                {{ old('show_phone', $other->show_phone) ? 'checked' : '' }}
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
                {{ old('show_mobile_phone', $other->show_mobile_phone) ? 'checked' : '' }}
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
                {{ old('show_email', $other->show_email) ? 'checked' : '' }}
            >
            <span class="ml-2">Email</span>
        </label>
    </div>
</section>





            {{-- Photo Upload Section (with Alpine.js for previews) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <div x-data="multiImageUploader(
                            {{ json_encode(
    $other->images->map(fn($image) => [
        'id' => $image->id,
        'url' => asset('storage/' . $image->image_path),
        'is_thumbnail' => $image->is_thumbnail ?? false,
    ])
) }}
                        )" class="space-y-4">

                    <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_photos') }}</h4>

                    <input type="file" name="images[]" multiple @change="addFiles($event)"
                        class="block w-full border p-2 rounded" />

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="(image, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="typeof image === 'string' ? image : image.url"
                                    class="w-full h-32 object-cover rounded shadow">

                                <!-- Αν είναι παλιά εικόνα, στείλε το ID της στο request -->
                                <template x-if="image.id">
                                    <input type="hidden" name="existing_image_ids[]" :value="image.id">
                                </template>

                                <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>



                    {{-- Alpine.js Script for Image Previews and Main Form Logic --}}
                    <script>
                        function multiImageUploader(existingImages = []) {
                            return {
                                files: [],
                                previews: existingImages.length ? existingImages : [],


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


                        // Define the Alpine.js component for the motorcycle form
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('motorcycleAdForm', (initialBrandId, initialModelId, initialModels) => ({
                                selectedMotorcycleBrandId: initialBrandId || '',
                                selectedMotorcycleModelId: initialModelId || '',
                                motorcycleModels: initialModels || {}, // Ensure it's an object, not null

                                // Define the async function first, so it's available when init() calls it
                                async fetchMotorcycleModels() {
                                    console.log('fetchMotorcycleModels triggered. Current selectedBrandId (before fetch):', this.selectedMotorcycleBrandId);

                                    // The fix for the AJAX URL should be `/api/motorcycle-models/...`
                                    // Double-check your routes/api.php and the previous conversation for the correct URL prefix.
                                    // If you moved it to web.php and removed the /api prefix, then it should match that.
                                    // For consistency, it's generally better to use /api for such endpoints.
                                    const fetchUrl = `/api/motorcycle-models/${this.selectedMotorcycleBrandId}`; // Assuming API route is /api/motorcycle-models
                                    console.log('Attempting to fetch models from URL:', fetchUrl);
                                    try {
                                        const response = await fetch(fetchUrl);
                                        if (!response.ok) {
                                            console.error('HTTP error! Status:', response.status, 'Response text:', await response.text());
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        const data = await response.json();
                                        console.log('Models fetched successfully:', data);
                                        this.motorcycleModels = data;

                                        // If the previously selected model is not in the new list, clear it
                                        if (this.selectedMotorcycleModelId && !Object.keys(this.motorcycleModels).includes(String(this.selectedMotorcycleModelId))) {
                                            this.selectedMotorcycleModelId = '';
                                            console.log('Cleared selectedMotorcycleModelId as it was not in the new list.');
                                        }
                                    } catch (error) {
                                        console.error('Error fetching motorcycle models:', error);
                                        this.motorcycleModels = {}; // Clear models on error
                                        this.selectedMotorcycleModelId = ''; // Clear selected model on error
                                    }
                                },

                                // The init method for the component
                                init() {
                                    // Call fetch on init to handle cases where old('brand_id') exists on page load
                                    // Use $nextTick to ensure all component properties are fully initialized
                                    this.$nextTick(() => {
                                        this.fetchMotorcycleModels();
                                    });

                                    // Watch for changes on the brand select element's x-model bound variable
                                    this.$watch('selectedMotorcycleBrandId', (value) => {
                                        console.log('selectedMotorcycleBrandId changed to (via $watch):', value);
                                        this.fetchMotorcycleModels();
                                    });
                                },
                            }));
                        });
                    </script>
            </section>


            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                   {{ __('update_listing') }}
                </button>
            </div>

        </form>
    </div>
</x-app-layout>