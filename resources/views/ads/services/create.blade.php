{{-- resources/views/ads/services/create.blade.php --}}
<x-app-layout>
    {{-- -----------------------------------Header & Breadcrumbs ---------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-1">
            New Servise
        </h2>
        <p class="text-md text-gray-700 max-w-3xl">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                ['label' => 'Anzeige erstellen', 'url' => route('ads.create')],
                ['label' => 'Neue Dienstleistung Anzeige', 'url' => route('ads.create')],
            ]" class="mb-8" />
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

 

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-3xl shadow-xl mt-6">
        <form method="POST" action="{{ route('ads.services.store') }}" enctype="multipart/form-data" class="space-y-10">
            @csrf

            {{-- Hidden field for category_slug --}}
            <input type="hidden" name="category_slug" value="dienstleistungen">

            {{-- Dienstleistungsdetails Section --}}
            <section class="bg-gray-50 p-8 rounded-xl shadow-inner border border-gray-300">
                <h4 class="text-2xl font-semibold text-gray-800 mb-8 tracking-wide border-b border-gray-300 pb-2">
                    Dienstleistungsdetails
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Dienstleistung Kategorie --}}
                    <div>
                        <label for="service_type" class="block text-sm font-semibold text-gray-700 mb-3">Kategorie</label>
                        <select name="service_type" id="service_type"
                            class="form-select w-full p-3 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                            <option value="">select</option>
                            @foreach($serviceCategoryOptions as $serviceCategoryOption)
                                <option value="{{ $serviceCategoryOption }}" {{ old('condition') == $serviceCategoryOption ? 'selected' : '' }}>
                                    {{ ucfirst($serviceCategoryOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')
                            <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Titel der Dienstleistung --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">
                            Titel der Dienstleistung
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="z.B. Professionelle Fensterreinigung"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                        @error('title')
                            <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Region / Ort --}}
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-3">Region / Ort</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="z.B. Wien, Niederösterreich"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                        @error('location')
                            <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preis (optional) --}}
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">
                            Preis (in €/Stunde/Pauschale, optional)
                        </label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 50.00"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                        @error('price')
                            <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Verfügbarkeit --}}
                    <div>
                        <label for="availability" class="block text-sm font-semibold text-gray-700 mb-3">
                            Verfügbarkeit (optional)
                        </label>
                        <select name="availability" id="availability"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
                        >
                            <option value="" disabled {{ old('availability') ? '' : 'selected' }}>Bitte wählen</option>
                         @foreach($availabilityOptions as $availabilityOption)
                                <option value="{{ $availabilityOption }}" {{ old('condition') == $availabilityOption ? 'selected' : '' }}>
                                    {{ ucfirst($availabilityOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('availability')
                            <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Beschreibung --}}
                <div class="mt-8">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Beschreibung der Dienstleistung</label>
                    <textarea name="description" id="description" rows="7" placeholder="Beschreibe hier deine Dienstleistung detailliert. Was bietest du an? Welche Erfahrungen hast du?"
                        class="w-full p-4 border border-gray-300 rounded-lg shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 resize-none"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
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

    

            {{-- Photo Upload Section with Alpine.js for previews --}}
            <section class="bg-gray-50 p-8 rounded-xl shadow-inner border border-gray-300">
                <h4 class="text-2xl font-semibold text-gray-800 mb-8 tracking-wide">{{ __('section_photos') }}</h4>

                <div x-data="multiImageUploader()" class="space-y-6">
                    <input type="file" name="images[]" multiple @change="addFiles($event)"
                        class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 cursor-pointer"/>

                    @error('images')
                        <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <template x-for="(image, index) in previews" :key="index">
                            <div class="relative group rounded-lg overflow-hidden shadow-lg border border-gray-200 hover:shadow-xl transition">
                                <img :src="image" class="w-full h-32 object-cover rounded-lg" alt="Preview Image" />
                                <button type="button" @click="remove(index)"
                                    class="absolute top-2 right-2 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                    tabindex="0" aria-label="Foto entfernen"
                                >✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews --}}
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
            <div class="pt-8 border-t border-gray-300 flex justify-end">
                <button type="submit"
                    class="bg-gray-700 text-white px-10 py-4 rounded-full font-semibold text-lg hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75 shadow-lg transition transform hover:scale-105"
                >
                  {{ __('create_ad') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>