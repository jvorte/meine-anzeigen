{{-- resources/views/ads/boats/create.blade.php --}}
<x-app-layout>

    {{-- -----------------------------------breadcrumbs ---------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2 mx-2">
            {{ __('new_boats_ads') }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500 mx-2">
            {{ __('sub_new_boats_ads') }}
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => __('breadcrumb_all_ads'), 'url' => route('categories.boats.index')],
                ['label' => __('breadcrumb_new_ad'), 'url' => null],
            ]" />
        </div>
    </div>
    {{-- --------------------------------------------------------------------------------- --}}
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
        <form method="POST" action="{{ route('ads.boats.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                {{-- Titel --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('title_label') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           placeholder="{{ __('title_placeholder') }}"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('description_label') }}</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="{{ __('description_placeholder') }}"
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Boat Details Section (Marke & Modell) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_boat_details') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Marke --}}
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">{{ __('brand_label') }}</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                               placeholder="{{ __('brand_placeholder') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('brand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Modell --}}
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-2">{{ __('model_label') }}</label>
                        <input type="text" name="model" id="model" value="{{ old('model') }}"
                               placeholder="{{ __('model_placeholder') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('model')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Basic Data Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_basic_data') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">{{ __('price_label') }}</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                               placeholder="{{ __('price_placeholder') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Baujahr --}}
                    <div>
                        <label for="year_of_construction" class="block text-sm font-medium text-gray-700 mb-2">{{ __('year_label') }}</label>
                        <input type="number" name="year_of_construction" id="year_of_construction"
                               value="{{ old('year_of_construction') }}" placeholder="{{ __('year_placeholder') }}" min="1900"
                               max="{{ date('Y') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('year_of_construction')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Zustand --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">{{ __('condition_label') }}</label>
                        <select name="condition" id="condition"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select_placeholder') }}</option>
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>{{ __('condition_new') }}</option>
                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>{{ __('condition_used') }}</option>
                            <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>{{ __('condition_refurbished') }}</option>
                            <option value="broken" {{ old('condition') == 'broken' ? 'selected' : '' }}>{{ __('condition_broken') }}</option>
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Boat Specific Data --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_specifications') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Boat Type --}}
                    <div>
                        <label for="boat_type" class="block text-sm font-medium text-gray-700 mb-2">{{ __('boat_type_label') }}</label>
                        <select name="boat_type" id="boat_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select_placeholder') }}</option>
                            @foreach($boatTypes as $type)
                            <option value="{{ $type }}" {{ old('boat_type') == $type ? 'selected' : '' }}>{{ __($type) }}</option>
                            @endforeach
                        </select>
                        @error('boat_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Material --}}
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-2">{{ __('material_label') }}</label>
                        <select name="material" id="material" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select_placeholder') }}</option>
                            @foreach($materials as $material)
                            <option value="{{ $material }}" {{ old('material') == $material ? 'selected' : '' }}>{{ __($material) }}</option>
                            @endforeach
                        </select>
                        @error('material')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Total Length --}}
                    <div>
                        <label for="total_length" class="block text-sm font-medium text-gray-700 mb-2">{{ __('length_label') }}</label>
                        <input type="number" step="0.1" name="total_length" id="total_length" value="{{ old('total_length') }}" placeholder="{{ __('length_placeholder') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_length')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Total Width --}}
                    <div>
                        <label for="total_width" class="block text-sm font-medium text-gray-700 mb-2">{{ __('width_label') }}</label>
                        <input type="number" step="0.1" name="total_width" id="total_width" value="{{ old('total_width') }}" placeholder="{{ __('width_placeholder') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('total_width')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Berths --}}
                    <div>
                        <label for="berths" class="block text-sm font-medium text-gray-700 mb-2">{{ __('berths_label') }}</label>
                        <input type="number" name="berths" id="berths" value="{{ old('berths') }}" placeholder="{{ __('berths_placeholder') }}" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('berths')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Engine Type --}}
                    <div>
                        <label for="engine_type" class="block text-sm font-medium text-gray-700 mb-2">{{ __('engine_type_label') }}</label>
                        <select name="engine_type" id="engine_type" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select_placeholder') }}</option>
                            @foreach($engineTypes as $type)
                            <option value="{{ $type }}" {{ old('engine_type') == $type ? 'selected' : '' }}>{{ __($type) }}</option>
                            @endforeach
                        </select>
                        @error('engine_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Engine Power (PS) --}}
                    <div>
                        <label for="engine_power" class="block text-sm font-medium text-gray-700 mb-2">{{ __('engine_power_label') }}</label>
                        <input type="number" name="engine_power" id="engine_power" value="{{ old('engine_power') }}" placeholder="{{ __('engine_power_placeholder') }}" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('engine_power')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Operating Hours --}}
                    <div>
                        <label for="operating_hours" class="block text-sm font-medium text-gray-700 mb-2">{{ __('operating_hours_label') }}</label>
                        <input type="number" name="operating_hours" id="operating_hours" value="{{ old('operating_hours') }}" placeholder="{{ __('form_boats_create.operating_hours_placeholder') }}" min="0"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('operating_hours')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Last Service --}}
                    <div>
                        <label for="last_service" class="block text-sm font-medium text-gray-700 mb-2">{{ __('last_service_label') }}</label>
                        <input type="date" name="last_service" id="last_service" value="{{ old('last_service') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('last_service')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Contact Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_contact_info') }}</h4>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_phone" value="1" class="rounded border-gray-300">
                        <span class="ml-2">{{ __('contact_phone') }}</span>
                    </label>
                </div>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_mobile_phone" value="1" class="rounded border-gray-300">
                        <span class="ml-2">{{ __('contact_mobile') }}</span>
                    </label>
                </div>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_email" value="1" class="rounded border-gray-300">
                        <span class="ml-2">{{ __('contact_email') }}</span>
                    </label>
                </div>
            </section>

            {{-- Photo Upload Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_photos') }}</h4>
                <div x-data="multiImageUploader()" class="space-y-4">
                    <input type="file" name="images[]" multiple @change="addFiles($event)"
                           class="block w-full border p-2 rounded" />
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
                {{-- Alpine.js Script for Image Previews --}}
                <script>
                    function multiImageUploader() { /* ... το script σου παραμένει ίδιο ... */ }
                </script>
            </section>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    {{ __('submit_button') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>