{{-- resources/views/ads/auto/create.blade.php --}}
<x-app-layout>

    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            {{ __('New Car ad') }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            {{ __('Select a suitable category and fill in the required fields to create your ad.') }}
        </p>

    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
                {{-- Link to the general Cars category listing --}}
                ['label' => __('Cars Ads'), 'url' => route('categories.cars.index')],

                {{-- The current page (New Car Ad creation) - set URL to null --}}
                ['label' => __('New car ad'), 'url' => null],
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

        <form method="POST" action="{{ route('ads.cars.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('Vehicle details') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Marke --}}
                    <div>
                        <label for="car_brand_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('brand') }}</label>
                        <select name="car_brand_id" id="car_brand_id" onchange="loadModels(this.value)"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @foreach($brands as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('car_brand_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                        @error('car_brand_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modell --}}
                    <div>
                        <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('model') }}</label>
                        <select name="car_model_id" id="car_model_id"
                            class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            {{-- Δεν φορτώνουμε μοντέλα server side στο create --}}
                        </select>
                        @error('car_model_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </section>

            <script>
                function loadModels(brandId) {
                    const modelSelect = document.getElementById('car_model_id');
                    modelSelect.innerHTML = '<option>Loading...</option>';

                    if (!brandId) {
                        modelSelect.innerHTML = '<option value="">Bitte zuerst eine Marke wählen</option>';
                        return;
                    }

                    fetch(`/api/car-brands/${brandId}/models`)
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

                                // Επιλογή αν υπάρχει old('car_model_id') (πχ μετά από validation error)
                                const oldModelId = "{{ old('car_model_id') }}";
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
                    const selectedBrandId = document.getElementById('car_brand_id').value;
                    if (selectedBrandId) {
                        loadModels(selectedBrandId);
                    }
                });
            </script>


            {{-- Basic Data Section (Erstzulassung, Kilometerstand, Leistung) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('section_basic_data') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">



                    {{-- Erstzulassung --}}
                    <div>
                        <label for="registration_to" class="block text-sm font-medium text-gray-700 mb-2">{{ __('year') }}</label>
                        <select name="registration_to" id="registration_to" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('select') }}</option>
                            @php
                            $currentYear = date('Y');
                            $startYear = 1990;
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}" {{ old('registration_to') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('registration_to')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Kilometers--}}
                    <div>
                        <label for="mileage_from" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Mileage') }}
                            (in km)</label>
                        <input type="number" name="mileage_from" id="mileage_from" value="{{ old('mileage_from') }}"
                            placeholder="z.B. 50.000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('mileage_from')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- power (PS) --}}
                    <div>
                        <label for="power_from" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Power') }}
                            (PS)</label>
                        <input type="number" name="power_from" id="power_from" value="{{ old('power_from') }}"
                            placeholder="z.B. 150"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('power_from')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Type & Condition Section (Farbe & Zustand) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('description') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- color --}}
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Color') }}</label>
                        <select name="color" id="color" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Color') }}</option>
                            <option value="black" {{ old('color',  request('color'))  == 'black'  ? 'selected' : '' }}>{{ __('Black') }}</option>
                            <option value="white" {{ old('color',  request('color'))  == 'white'  ? 'selected' : '' }}>{{ __('White') }}</option>
                            <option value="red" {{ old('color',  request('color'))  == 'red'    ? 'selected' : '' }}>{{ __('Red') }}</option>
                            <option value="blue" {{ old('color',  request('color'))  == 'blue'   ? 'selected' : '' }}>{{ __('Blue') }}</option>
                            <option value="green" {{ old('color',  request('color'))  == 'green'  ? 'selected' : '' }}>{{ __('Green') }}</option>
                            <option value="yellow" {{ old('color',  request('color'))  == 'yellow' ? 'selected' : '' }}>{{ __('Yellow') }}</option>
                            <option value="orange" {{ old('color',  request('color'))  == 'orange' ? 'selected' : '' }}>{{ __('Orange') }}</option>
                            <option value="silver" {{ old('color',  request('color'))  == 'silver' ? 'selected' : '' }}>{{ __('Silver') }}</option>
                            <option value="grey" {{ old('color',  request('color'))  == 'grey'   ? 'selected' : '' }}>{{ __('Grey') }}</option>
                            <option value="brown" {{ old('color',  request('color'))  == 'brown'  ? 'selected' : '' }}>{{ __('Brown') }}</option>
                            <option value="other" {{ old('color',  request('color'))  == 'other'  ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                        @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Condition --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">{{ __('condition') }}</label>
                        <select name="condition" id="condition" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Condition') }}</option>
                            <option value="new" {{ old('condition',     request('condition'))     == 'new'      ? 'selected' : '' }}>{{ __('New') }}</option>
                            <option value="used" {{ old('condition',     request('condition'))     == 'used'     ? 'selected' : '' }}>{{ __('Used') }}</option>
                            <option value="accident" {{ old('condition',     request('condition'))     == 'accident' ? 'selected' : '' }}>{{ __('Accident vehicle') }}</option>
                            <option value="damaged" {{ old('condition',     request('condition'))     == 'damaged'  ? 'selected' : '' }}>{{ __('Damaged vehicle') }}</option>
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- New Fields for Autos (Fuel Type, Transmission, Drive, Doors, Seats, Seller Type, Price, Vehicle Type, Warranty) --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('Additional vehicle features') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Fuel Type --}}
                    <div>
                        <label for="fuel_type"
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('fuel_type') }}</label>
                        <select name="fuel_type" id="fuel_type" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Fuel') }}</option>
                            <option value="Petrol" {{ old('fuel_type', request('fuel_type')) == 'Petrol'   ? 'selected' : '' }}>{{ __('Petrol') }}</option>
                            <option value="Diesel" {{ old('fuel_type', request('fuel_type')) == 'Diesel'   ? 'selected' : '' }}>{{ __('Diesel') }}</option>
                            <option value="Electric" {{ old('fuel_type', request('fuel_type')) == 'Electric' ? 'selected' : '' }}>{{ __('Electric') }}</option>
                            <option value="Hybrid" {{ old('fuel_type', request('fuel_type')) == 'Hybrid'   ? 'selected' : '' }}>{{ __('Hybrid') }}</option>
                            <option value="LPG" {{ old('fuel_type', request('fuel_type')) == 'LPG'      ? 'selected' : '' }}>{{ __('LPG') }}</option>
                            <option value="CNG" {{ old('fuel_type', request('fuel_type')) == 'CNG'      ? 'selected' : '' }}>{{ __('CNG') }}</option>
                        </select>
                        @error('fuel_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Transmission --}}
                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-700 mb-2">{{ __('gearbox') }}</label>
                        <select name="transmission" id="transmission" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Transmission') }}</option>
                            <option value="manual" {{ old('transmission', request('transmission')) == 'manual'    ? 'selected' : '' }}>{{ __('Manual') }}</option>
                            <option value="automatic" {{ old('transmission', request('transmission')) == 'automatic' ? 'selected' : '' }}>{{ __('Automatic') }}</option>
                        </select>
                        @error('transmission')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Drive --}}
                    <div>
                        <label for="drive" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Wheel drive') }}</label>
                        <select name="drive" id="drive" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Drive') }}</option>
                            <option value="front" {{ old('drive', request('drive')) == 'front' ? 'selected' : '' }}>{{ __('Front-wheel drive') }}</option>
                            <option value="rear" {{ old('drive', request('drive'))  == 'rear'  ? 'selected' : '' }}>{{ __('Rear-wheel drive') }}</option>
                            <option value="all" {{ old('drive', request('drive'))   == 'all'   ? 'selected' : '' }}>{{ __('All-wheel drive') }}</option>
                        </select>
                        @error('drive')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Doors --}}
                    <div>
                        <label for="doors_from" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Doors') }}
                        </label>
                        <select name="doors_from" id="doors_from"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('Select Doors') }}</option>
                            <option value="2" {{ old('doors_from', request('doors_from')) == '2' ? 'selected' : '' }}>{{ __('2/3') }}</option>
                            <option value="4" {{ old('doors_from', request('doors_from')) == '4' ? 'selected' : '' }}>{{ __('4/5') }}</option>
                            <option value="6" {{ old('doors_from', request('doors_from')) == '6' ? 'selected' : '' }}>{{ __('6/7') }}</option>
                        </select>
                    </div>

                    {{-- Seats --}}
                    <div>
                        <label for="seats_from" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Seats') }}</label>
                        <select name="seats_from" id="seats_from"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('Select Seats') }}</option>
                            <option value="2" {{ old('seats_from', request('seats_from')) == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('seats_from', request('seats_from')) == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('seats_from', request('seats_from')) == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('seats_from', request('seats_from')) == '5' ? 'selected' : '' }}>5</option>
                            <option value="7" {{ old('seats_from', request('seats_from')) == '7' ? 'selected' : '' }}>7</option>
                            <option value="9" {{ old('seats_from', request('seats_from')) == '9' ? 'selected' : '' }}>9</option>
                        </select>
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price_from" class="block text-sm font-medium text-gray-700 mb-2">{{ __('price') }}</label>
                        <input type="number" name="price_from" id="price_from" value="{{ old('price_from') }}"
                            placeholder="z.B. 15000"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('price_from')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Vehicle Type --}}
                    <div>
                        <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Vehicle Type') }}
                        </label>
                        <select name="vehicle_type" id="vehicle_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('Select Vehicle Type') }}</option>
                            <option value="sedan" {{ old('vehicle_type', request('vehicle_type')) == 'sedan' ? 'selected' : '' }}>
                                {{ __('Sedan') }}
                            </option>
                            <option value="station" {{ old('vehicle_type', request('vehicle_type')) == 'station' ? 'selected' : '' }}>
                                {{ __('Station Wagon') }}
                            </option>
                            <option value="SUV/Off-road" {{ old('vehicle_type', request('vehicle_type')) == 'SUV/Off-road' ? 'selected' : '' }}>
                                {{ __('SUV/Off-road Vehicle') }}
                            </option>
                            <option value="coupe" {{ old('vehicle_type', request('vehicle_type')) == 'coupe' ? 'selected' : '' }}>
                                {{ __('Coupe') }}
                            </option>
                            <option value="convertible" {{ old('vehicle_type', request('vehicle_type')) == 'convertible' ? 'selected' : '' }}>
                                {{ __('Convertible') }}
                            </option>
                            <option value="minivan" {{ old('vehicle_type', request('vehicle_type')) == 'minivan' ? 'selected' : '' }}>
                                {{ __('Minivan') }}
                            </option>
                            <option value="pickup" {{ old('vehicle_type', request('vehicle_type')) == 'pickup' ? 'selected' : '' }}>
                                {{ __('Pickup') }}
                            </option>
                        </select>
                        @error('vehicle_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Warranty --}}
                    <div>
                        <label for="warranty" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Warranty') }}</label>
                        <select name="warranty" id="warranty"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">{{ __('Select Warranty') }}</option>
                            <option value="yes" {{ old('warranty', request('warranty')) == 'yes' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                            <option value="no" {{ old('warranty', request('warranty')) == 'no' ? 'selected' : '' }}>{{ __('No') }}</option>
                        </select>
                    </div>

                    {{-- Seller Type --}}
                    <div>
                        <label for="seller_type" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Provider') }}</label>
                        <select name="seller_type" id="seller_type" class="w-full border rounded p-2">
                            <option value="">{{ __('Select Seller Type') }}</option>
                            <option value="Private" {{ old('seller_type', request('seller_type')) == 'Private' ? 'selected' : '' }}>{{ __('Private') }}</option>
                            <option value="Handler" {{ old('seller_type', request('seller_type')) == 'Handler' ? 'selected' : '' }}>{{ __('Handler') }}</option>
                        </select>
                        @error('seller_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                {{-- Titel --}}
                <div class="mb-6">
                    <label for="title" class="block text-md  text-gray-800 mb-2">{{ __('title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="{{ __('Meaningful title for your ad') }}"
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-md font-medium text-gray-800 mb-2">{{ __('description') }}</label>
                    <textarea name="description" id="description" rows="7"
                        placeholder="{{ __('Enter all the important details about your car here. The more information, the better!') }}"
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



            {{-- Photo Upload Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">{{ __('photos') }}</h4>

                <div x-data="multiImageUploader()" class="space-y-4">
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
                                <img :src="image" class="w-full h-32 object-cover rounded shadow">
                                <button type="button" @click="remove(index)"
                                    class="absolute top-1 right-1 bg-red-700 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hidden group-hover:flex">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Alpine.js Script for Image Previews and Main Form Logic --}}
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


            {{-- Add category_slug hidden input --}}
            <input type="hidden" name="category_slug" value="auto">

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