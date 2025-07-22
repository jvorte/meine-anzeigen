<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Neue Anzeige erstellen
        </h2>
        <p class="text-md text-gray-600 dark:text-gray-400">
            Wähle eine passende Kategorie und fülle die erforderlichen Felder aus, um deine Anzeige zu erstellen.
        </p>
    </x-slot>

    <div class="py-8 lg:py-12" x-data="{
        selectedCategory: null,
        showModal: false,
        categories: {{ $categories->toJson() }},
        selectedBrandId: '',
        models: [],
        selectedModelId: '',
        get selectedCategoryName() {
            const cat = this.categories.find(c => c.slug === this.selectedCategory);
            return cat ? cat.name : '';
        },
        async fetchModels() {
            if (!this.selectedBrandId) {
                this.models = [];
                this.selectedModelId = '';
                return;
            }
            try {
                const response = await fetch(`/models/${this.selectedBrandId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                this.models = Object.entries(data).map(([id, name]) => ({ id, name }));
                this.selectedModelId = ''; // Reset model when brand changes
            } catch (error) {
                console.error('Error fetching models:', error);
                this.models = [];
                this.selectedModelId = '';
            }
        },
        getFormAction() {
            switch (this.selectedCategory) {
                case 'fahrzeuge': return '{{ route('vehicles.store') }}';
                case 'fahrzeugeteile': return '{{ route('parts.store') }}';
                case 'elektronik': return '{{ route('electronics.store') }}';
                case 'haushalt': return '{{ route('household.store') }}';
                case 'immobilien': return '{{ route('realestate.store') }}';
                case 'dienstleistungen': return '{{ route('services.store') }}';
                default: return '#';
            }
        },
        openCategory(slug) {
            this.selectedCategory = slug;
            this.showModal = true;
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        },
        closeModal() {
            this.showModal = false;
            this.selectedCategory = null;
            this.selectedBrandId = '';
            this.models = [];
            this.selectedModelId = '';
            document.body.style.overflow = ''; // Re-enable scrolling
        }
    }" x-init="$watch('selectedBrandId', () => fetchModels())">

        <div
            class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 bg-white p-6 sm:p-8 rounded-xl shadow-2xl ring-1 ring-gray-100 dark:ring-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <button
                        class="flex flex-col items-center justify-center p-6 bg-blue-50 hover:bg-blue-100 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 group"
                        @click="openCategory('{{ $category->slug }}')">
                        <img src="{{ asset('storage/icons/categories/' . $category->slug . '.png') }}"
                            alt="{{ $category->name }} Icon"
                            class="w-16 h-16 object-contain mb-3 group-hover:animate-bounce" />
                        <span class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">
                            {{ $category->name }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div x-show="showModal"
                class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50 overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div class="bg-white rounded-xl w-full max-w-4xl lg:max-w-5xl max-h-[95vh] overflow-y-auto p-8 relative shadow-2xl transform transition-all duration-300"
                    @click.away="closeModal()" x-trap.noscroll="showModal"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                    <button @click="closeModal()"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-3xl font-bold p-1 rounded-full hover:bg-gray-100 transition-colors"
                        aria-label="Modal schließen">
                        &times;
                    </button>

                    <form method="POST" :action="getFormAction()" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <input type="hidden" name="category_slug" x-model="selectedCategory">
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg shadow-sm">
                                <h3 class="font-bold mb-2">Fehler beim Erstellen der Anzeige:</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex items-center pb-4 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Kategorie: <span x-text="selectedCategoryName" class="text-blue-600"></span>
                            </h2>
                        </div>



                        <template x-if="selectedCategory === 'fahrzeuge'">
                            <div class="bg-white rounded-lg p-6 max-w-md w-full space-y-4">

                                <h2 class="text-xl font-semibold mb-4">Unterkategorie wählen</h2>

                                <div class="grid grid-cols-2 gap-4">
                                    <a href="{{ route('ads.autos.create') }}" class="btn btn-outline">Autos</a>
                                    <a href="{{ route('ads.motorrad.create') }}" class="btn btn-outline">Motorräder</a>
                                    <a href="{{ route('ads.nutzfahrzeug.create') }}"
                                        class="btn btn-outline">Nutzfahrzeuge</a>
                                    <a href="{{ route('ads.wohnmobile.create') }}" class="btn btn-outline">Wohnwagen & Wohnmobile</a>
                                </div>

                                <button @click="openModal = false"
                                    class="mt-6 btn btn-secondary w-full">Schließen</button>
                            </div>
                      
                       </template>





                {{-- für fahrzeugeteile --}}
                <template x-if="selectedCategory === 'fahrzeugeteile'">
              
                </template>



                {{-- für elektronik --}}
                <template x-if="selectedCategory === 'elektronik'">
               
                </template>




                {{-- für haushalt --}}
                <template x-if="selectedCategory === 'haushalt'">
                
                </template>



                {{-- Nur Beispiel für immobilien (υπάρχουν και οι άλλες κατηγορίες σε παρόμοια μορφή) --}}
                <template x-if="selectedCategory === 'immobilien'">
               
                </template>



                {{-- Nur Beispiel für dienstleistungen (υπάρχουν και οι άλλες κατηγορίες σε παρόμοια μορφή) --}}
                <template x-if="selectedCategory === 'dienstleistungen'">
                
                </template>

                <template x-if="selectedCategory === 'boote'">
                 
                </template>

                <template x-if="selectedCategory === 'sonstiges'">
                    <div class="space-y-8">
                        <input type="hidden" name="category_slug" value="sonstiges">

                        <section class="bg-gray-50 dark:bg-gray-100 p-6 rounded-lg shadow-inner">
                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-800 mb-6">Sonstiges
                                Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="condition"
                                        class="block text-sm font-semibold text-gray-800 dark:text-gray-800 mb-2">Zustand</label>
                                    <select name="condition" id="condition"
                                        class="form-select w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-100 dark:border-gray-500 dark:text-gray-100"
                                        value="{{ old('condition') }}">
                                        <option value="">Bitte wählen</option>
                                        <option value="neu">Neu</option>
                                        <option value="neuwertig">Neuwertig</option>
                                        <option value="gebraucht">Gebraucht</option>
                                        <option value="defekt">Defekt</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="location"
                                        class="block text-sm font-semibold text-gray-800 dark:text-gray-800 mb-2">Standort</label>
                                    <input type="text" name="location" id="location" placeholder="z.B. Wien"
                                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-100 dark:border-gray-500 dark:text-gray-100"
                                        value="{{ old('location') }}" />
                                </div>
                            </div>
                        </section>

                        <section class="bg-white dark:bg-gray-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-800 mb-6">Preis</h4>
                            <div>
                                <label for="price"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-800 mb-2">Preis
                                    (€) (optional)</label>
                                <input type="number" name="price" id="price" step="0.01" placeholder="z. B. 20.00"
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-100 dark:border-gray-500 dark:text-gray-100"
                                    value="{{ old('price') }}" />
                            </div>
                        </section>

                        <section class="bg-white dark:bg-gray-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-800 mb-6">
                                Anzeigentitel</h4>
                            <div>
                                <label for="title"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-800 mb-2">Titel</label>
                                <input type="text" name="title" id="title" required
                                    placeholder="Aussagekräftiger Titel für Ihre Anzeige"
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-100 dark:border-gray-500 dark:text-gray-100"
                                    value="{{ old('title') }}" />
                            </div>
                        </section>

                        <section class="bg-white dark:bg-gray-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-800 mb-6">Beschreibung
                            </h4>
                            <div>
                                <label for="description"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-800 mb-2">Zusätzliche
                                    Informationen</label>
                                <textarea name="description" id="description" rows="7"
                                    placeholder="Geben Sie hier alle wichtigen Details zu Ihrer Anzeige ein."
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm bg-white text-gray-900
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600
                          transition duration-150 ease-in-out dark:bg-gray-100 dark:border-gray-500 dark:text-gray-800">{{ old('description') }}</textarea>
                            </div>
                        </section>

                        <section class="bg-gray-50 dark:bg-gray-100 p-6 rounded-lg shadow-inner">
                            <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-800 mb-6">Fotos
                                hinzufügen</h4>
                            <div x-data="imageUploader()" class="space-y-4">
                                <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles"
                                    class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer dark:text-gray-300 dark:file:bg-blue-800 dark:file:text-blue-100 dark:hover:file:bg-blue-700" />
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4"
                                    x-show="previews.length" x-transition>
                                    <template x-for="(src, index) in previews" :key="index">
                                        <div class="relative group">
                                            <img :src="src"
                                                class="w-full h-32 object-cover rounded-lg shadow-md border border-gray-200 dark:border-gray-600" />
                                            <button type="button" @click="remove(index)"
                                                class="absolute top-1 right-1 bg-white text-red-600 text-xs rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 dark:bg-gray-900 dark:text-red-400"
                                                aria-label="Bild entfernen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </section>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 shadow-lg">
                                Anzeige erstellen
                            </button>
                        </div>
                    </div>
                </template>


                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        function imageUploader() {
            return {
                previews: [],
                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    this.previews = []; // Clear existing previews

                    files.forEach(file => {
                        if (file.type.startsWith('image/')) { // Ensure it's an image
                            const reader = new FileReader();
                            reader.onload = e => this.previews.push(e.target.result);
                            reader.readAsDataURL(file);
                        }
                    });
                },
                remove(index) {
                    this.previews.splice(index, 1);
                    // You might also want to clear the file input's files if needed,
                    // but for a simple preview removal, this is sufficient.
                }
            };
        }
    </script>
</x-app-layout>