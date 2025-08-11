{{-- resources/views/commercial_vehicles/edit.blade.php --}}

<x-app-layout>

    {{-- ----------------------------------breadcrumbs --------------------------------------------------- --}}
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Auto Anzeige bearbeiten
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Bearbeite die Details deiner Anzeige oder füge neue Fotos hinzu.
        </p>
    </x-slot>

 

    <div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Breadcrumbs component --}}
        <x-breadcrumbs :items="[
            {{-- Link to the general campers category page --}}
            ['label' => 'commercial-vehicles Anzeigen', 'url' => route('categories.commercial-vehicles.index')],

            {{-- Link to the specific camper's show page --}}
            ['label' => 'commercial-vehicle Anzeige', 'url' => route('categories.commercial-vehicles.show', $commercialVehicle->id)],

            {{-- The current page (Camper Edit) - set URL to null as it's the current page --}}
            ['label' => 'commercial-vehicle bearbeiten', 'url' => null],
        ]" />
    </div>
</div>
    {{-- ------------------------------------------------------------------------------------- --}}

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


 

    <div class="py-6">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-white  rounded-md my-3 py-4">
                  
       <form method="POST" action="{{ route('ads.commercial-vehicles.update', ['commercial_vehicle' => $commercialVehicle->id]) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $commercialVehicle->title) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Preis (€)</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $commercialVehicle->price) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="commercial_brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marke</label>
                        <select name="commercial_brand_id" id="commercial_brand_id" {{-- Changed name and id --}}
                                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Bitte wählen --</option>
                            @foreach($commercialBrands as $brand) {{-- Iterating over $commercialBrands --}}
                                <option value="{{ $brand->id }}" {{ old('commercial_brand_id', $commercialVehicle->commercial_brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

               <div>
                        <label for="commercial_model_id" class="block text-sm font-medium text-gray-700 mb-1">Modell</label>
                        <select name="commercial_model_id" id="commercial_model_id"
                                class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Bitte wählen --</option>
                            {{-- CHANGE THIS LINE: from $commercialModels to $initialCommercialModels --}}
                            @foreach($initialCommercialModels as $model)
                                <option value="{{ $model->id }}" {{ old('commercial_model_id', $commercialVehicle->commercial_model_id) == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>

                {{-- Erstzulassung --}}

<div>
    <label for="first_registration" class="block text-sm font-medium text-gray-700 mb-2">Erstzulassung (Year)</label>
    <select name="first_registration" id="first_registration"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Bitte wählen</option>
        @php
            $currentYear = date('Y');
            $startYear = 1990;
        @endphp
        @for ($year = $currentYear; $year >= $startYear; $year--)
            <option value="{{ $year }}" {{ old('first_registration', $commercialVehicle->first_registration) == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>
    @error('first_registration')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>




      {{-- Commercial Vehicle Type --}}
                    <div>
                        <label for="commercial_vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Fahrzeugtyp</label>
                        <select name="commercial_vehicle_type" id="commercial_vehicle_type"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($commercialVehicleTypes as $type)
                                <option value="{{ $type }}" {{ old('commercial_vehicle_type', $commercialVehicle->commercial_vehicle_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('commercial_vehicle_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Kilometerstand (km)</label>
                        <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $commercialVehicle->mileage) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Leistung (PS)</label>
                        <input type="number" name="power" id="power" value="{{ old('power', $commercialVehicle->power) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

           <div>
    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Farbe</label>
    <select name="color" id="color" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Bitte wählen</option>
        @foreach($colors as $color)
            <option value="{{ $color }}" {{ old('color', $commercialVehicle->color) == $color ? 'selected' : '' }}>{{ $color }}</option>
        @endforeach
    </select>
    @error('color')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


    

<div>
    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
    <select name="condition" id="condition"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Please select</option>
         @foreach($conditions as $key => $label)
                <option value="{{ $key }}" {{ old('condition', $commercialVehicle->condition) == $key ? 'selected' : '' }}>
                 {{ $label }}
            </option>

        @endforeach
    </select>
    @error('condition')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


                    
                        {{-- Fuel Type --}}
                    <div>
                        <label for="fuel_type"
                            class="block text-sm font-medium text-gray-700 mb-2">Kraftstoffart</label>
                        <select name="fuel_type" id="fuel_type"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="Petrol" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                            <option value="Diesel" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Electric" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'Electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="lpg" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'lpg' ? 'selected' : '' }}>LPG</option>
                            <option value="cng" {{ old('fuel_type', $commercialVehicle->fuel_type) == 'cng' ? 'selected' : '' }}>CNG</option>
                        </select>
                        @error('fuel_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
<div>
    <label for="transmission" class="block text-sm font-medium text-gray-700 mb-2">Transmission</label>
    <select name="transmission" id="transmission"
        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        <option value="">Bitte wählen</option>
        @foreach(['manual' => 'Manual', 'automatic' => 'Automatic'] as $value => $label)
            <option value="{{ $value }}" {{ strtolower(old('transmission', $commercialVehicle->transmission)) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('transmission')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


                    
                    <div>
                        <label for="payload_capacity" class="block text-sm font-medium text-gray-700 mb-1">Nutzlast (kg)</label>
                        <input type="number" name="payload_capacity" id="payload_capacity" value="{{ old('payload_capacity', $commercialVehicle->payload_capacity) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="gross_vehicle_weight" class="block text-sm font-medium text-gray-700 mb-1">Zulässiges Gesamtgewicht (kg)</label>
                        <input type="number" name="gross_vehicle_weight" id="gross_vehicle_weight" value="{{ old('gross_vehicle_weight', $commercialVehicle->gross_vehicle_weight) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label for="number_of_axles" class="block text-sm font-medium text-gray-700 mb-1">Anzahl der Achsen</label>
                        <input type="number" name="number_of_axles" id="number_of_axles" value="{{ old('number_of_axles', $commercialVehicle->number_of_axles) }}"
                               class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

               

                        {{-- Emission Class --}}
                    <div>
                        <label for="emission_class" class="block text-sm font-medium text-gray-700 mb-2">Emissionsklasse</label>
                        <select name="emission_class" id="emission_class"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($emissionClasses as $class)
                            <option value="{{ $class }}" {{ old('emission_class', $commercialVehicle->emission_class) == $class ? 'selected' : '' }}>{{ $class }}</option>

                            @endforeach
                        </select>
                        @error('emission_class')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                       {{-- Seats --}}
                    <div>
                        <label for="seats_from" class="block text-sm font-medium text-gray-700 mb-2">Anzahl
                            Sitze</label>
                        <select name="seats_from" id="seats_from"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <option value="2" {{ old('seats_from', $commercialVehicle->seats) == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('seats_from', $commercialVehicle->seats) == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('seats_from', $commercialVehicle->seats) == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('seats_from', $commercialVehicle->seats) == '5' ? 'selected' : '' }}>5</option>
                            <option value="7" {{ old('seats_from', $commercialVehicle->seats) == '7' ? 'selected' : '' }}>7</option>
                            <option value="9" {{ old('seats_from', $commercialVehicle->seats) == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('seats_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

             <div class="my-6">
    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Beschreibung</label>
    <textarea name="description" id="description" rows="6" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $commercialVehicle->description) }}</textarea>
  </div>


                
            {{-- Existing Photos Section --}}
            @if ($commercialVehicle->images->count() > 0)
                <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6">Vorhandene Fotos</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($commercialVehicle->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Car Image" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                <label class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="mr-1"> Löschen
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-600 mt-4">Wähle Fotos zum Löschen aus.</p>
                </section>
            @endif




                  {{-- Photo Upload Section --}}
            {{-- The x-data="multiImageUploader()" is placed on a div wrapping the input and previews --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>

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

                {{-- Alpine.js Script for Image Previews --}}
                <script>
                    function multiImageUploader() {
                        return {
                            files: [], // Stores the actual File objects
                            previews: [], // Stores URLs for image previews

                            addFiles(event) {
                                const newFiles = Array.from(event.target.files);

                                newFiles.forEach(file => {
                                    this.files.push(file);
                                    this.previews.push(URL.createObjectURL(file));
                                });

                                // Important: Assign the collected files back to the input's files property
                                // This ensures the native form submission sends the correct set of files
                                const dataTransfer = new DataTransfer();
                                this.files.forEach(file => dataTransfer.items.add(file));
                                event.target.files = dataTransfer.files;

                                // No need to clear event.target.value = '' if you're managing `event.target.files` directly.
                                // It can sometimes interfere with re-selecting the *same* file if you clear it.
                                // If you want to allow selecting the same file multiple times, you might need
                                // to rethink the preview logic or clear it but rely on the `files` array.
                            },

                            remove(index) {
                                // Remove from internal arrays
                                this.files.splice(index, 1);
                                this.previews.splice(index, 1);

                                // Update the actual file input's files property
                                // Find the file input within the current component's scope
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

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



                <div class="flex justify-between items-center pt-6 border-t">
              

                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 shadow transition">
                        Aktualisieren
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
