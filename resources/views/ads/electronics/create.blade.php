{{-- resources/views/ads/electronics/create.blade.php --}}
<x-app-layout>


         {{-- -----------------------------------breadcrumbs ---------------------------------------------- --}}
   <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
           Neue Elektronik Anzeige erstellen
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>

    </x-slot>

    <div class="py-1">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-1">
            {{-- Breadcrumbs component --}}
            <x-breadcrumbs :items="[
        ['label' => 'Anzeige erstellen', 'url' => route('ads.create')],
        ['label' =>'Neue Elektronik Anzeige', 'url' => route('ads.create')],
    ]" />

        </div>
    </div>
{{-- --------------------------------------------------------------------------------- --}}

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl mt-6">

        <form method="POST" action="{{ route('ads.electronics.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Hidden inputs for Alpine.js values --}}
            <input type="hidden" name="brand_id" x-bind:value="selectedBrandId" />
            <input type="hidden" name="electronic_model_id" x-bind:value="selectedElectronicModelId" />

            {{-- Electronic Details Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Elektronik-Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                     x-data="{
                        selectedBrandId: @json(old('brand_id')),
                        selectedElectronicModelId: @json(old('electronic_model_id')),
                        electronicModels: @json($initialElectronicModels), // Initial models for old value
                        async fetchElectronicModels() {
                            if (this.selectedBrandId) {
                                const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                                this.electronicModels = await response.json();
                                // Reset selected model if it's not in the new list
                                if (!Object.keys(this.electronicModels).includes(String(this.selectedElectronicModelId))) {
                                    this.selectedElectronicModelId = '';
                                }
                            } else {
                                this.electronicModels = {};
                                this.selectedElectronicModelId = '';
                            }
                        }
                     }"
                     x-init="fetchElectronicModels(); $watch('selectedBrandId', fetchElectronicModels)">

                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
                        <select name="category" id="category"
                                class="form-select w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Brand (Dynamic with Alpine.js) --}}
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Marke</label>
                        <select name="brand_id" id="brand_id" x-model="selectedBrandId"
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Electronic Model (Dynamic with Alpine.js) --}}
                    <div x-show="Object.keys(electronicModels).length > 0" x-transition>
                        <label for="electronic_model_id" class="block text-sm font-medium text-gray-700 mb-2">Modell</label>
                        <select name="electronic_model_id" id="electronic_model_id" x-model="selectedElectronicModelId"
                                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            <template x-for="(name, id) in electronicModels" :key="id">
                                <option :value="id" x-text="name"></option>
                            </template>
                        </select>
                        @error('electronic_model_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preis (in €)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="z.B. 750"
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
                            <option value="">Bitte wählen</option>
                            <option value="neu" {{ old('condition') == 'neu' ? 'selected' : '' }}>Neu</option>
                            <option value="gebraucht" {{ old('condition') == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                            <option value="defekt" {{ old('condition') == 'defekt' ? 'selected' : '' }}>Defekt (als Ersatzteilspender)</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Year of Purchase --}}
                    <div>
                        <label for="year_of_purchase" class="block text-sm font-medium text-gray-700 mb-2">Kaufjahr (optional)</label>
                        <input type="number" name="year_of_purchase" id="year_of_purchase" value="{{ old('year_of_purchase') }}" placeholder="z.B. 2023" min="1950" max="{{ date('Y') }}"
                               class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('year_of_purchase')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Warranty Status --}}
                    <div>
                        <label for="warranty_status" class="block text-sm font-medium text-gray-700 mb-2">Garantie-Status</label>
                        <select name="warranty_status" id="warranty_status"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Bitte wählen</option>
                            @foreach($warrantyStatuses as $status)
                                <option value="{{ $status }}" {{ old('warranty_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('warranty_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Accessories --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="accessories" class="block text-sm font-medium text-gray-700 mb-2">Zubehör (optional, z.B. Ladekabel, Fernbedienung)</label>
                        <textarea name="accessories" id="accessories" rows="3" placeholder="Liste hier enthaltenes Zubehör auf."
                                  class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('accessories') }}</textarea>
                        @error('accessories')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Title & Description Section --}}
            <section class="bg-white p-6 rounded-lg shadow">
                {{-- Titel --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-800 mb-2">Anzeigentitel</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           placeholder="Aussagekräftiger Titel für deine Anzeige (z.B. iPhone 15 Pro Max 256GB)"
                           class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beschreibung --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Beschreibung</label>
                    <textarea name="description" id="description" rows="7"
                              placeholder="Gib hier alle wichtigen Details zu deinem Elektronikartikel ein. Zustand, Funktionen, Mängel."
                              class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Photo Upload Section --}}
            <section class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="text-xl font-semibold text-gray-700 mb-6">Fotos hinzufügen</h4>
                <div>
                    <label for="images" class="sr-only">Bilder hochladen</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                           class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                    Anzeige erstellen
                </button>
            </div>

        </form>
    </div>

    {{-- Alpine.js for dynamic models --}}
    @push('scripts')
        <script>
            // Ensure Alpine.js is loaded before this script runs
            document.addEventListener('alpine:init', () => {
                Alpine.data('electronicForm', () => ({
                    selectedBrandId: @json(old('brand_id')),
                    selectedElectronicModelId: @json(old('electronic_model_id')),
                    electronicModels: @json($initialElectronicModels),

                    async fetchElectronicModels() {
                        if (this.selectedBrandId) {
                            try {
                                const response = await fetch(`/electronic-models/${this.selectedBrandId}`);
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                this.electronicModels = await response.json();
                                // Reset selected model if it's not in the new list
                                if (!Object.keys(this.electronicModels).includes(String(this.selectedElectronicModelId))) {
                                    this.selectedElectronicModelId = '';
                                }
                            } catch (error) {
                                console.error('Error fetching electronic models:', error);
                                this.electronicModels = {}; // Clear models on error
                                this.selectedElectronicModelId = '';
                            }
                        } else {
                            this.electronicModels = {};
                            this.selectedElectronicModelId = '';
                        }
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
