<form method="POST" action="{{ route('ads.store') }}" class="space-y-4">
    @csrf

    <input type="hidden" name="category" value="fahrzeuge">
    <input type="hidden" name="vehicle_type" value="gebrauchtwagen">

    {{-- Titel --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titel der Anzeige</label>
        <input type="text" name="title" id="title" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
    </div>

    {{-- Marke --}}
    <div>
        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marke</label>
        <select name="attributes[brand]" id="brand" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">-- Bitte wählen --</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Modell --}}
    <div>
        <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modell</label>
        <select name="attributes[model]" id="model" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">-- Bitte wählen --</option>
            {{-- Τα μοντέλα θα φορτωθούν με AJAX βάσει μάρκας --}}
        </select>
    </div>

    {{-- Baujahr --}}
    <div>
        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Erstzulassung</label>
        <input type="number" name="attributes[year]" id="year" min="1900" max="{{ date('Y') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
    </div>

    {{-- Kraftstoff --}}
    <div>
        <label for="fuel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kraftstoffart</label>
        <select name="attributes[fuel]" id="fuel"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">-- Bitte wählen --</option>
            @foreach (config('car_filters.fuel_types') as $fuel)
                <option value="{{ $fuel }}">{{ $fuel }}</option>
            @endforeach
        </select>
    </div>

    {{-- Getriebe --}}
    <div>
        <label for="transmission" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Getriebe</label>
        <select name="attributes[transmission]" id="transmission"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">-- Bitte wählen --</option>
            @foreach (config('car_filters.transmissions') as $transmission)
                <option value="{{ $transmission }}">{{ $transmission }}</option>
            @endforeach
        </select>
    </div>

    {{-- Kilometerstand --}}
    <div>
        <label for="km" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kilometerstand</label>
        <input type="number" name="attributes[km]" id="km" min="0"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
    </div>

    {{-- Preis --}}
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preis (€)</label>
        <input type="number" name="attributes[price]" id="price" min="0" step="100"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
    </div>

    {{-- Submit --}}
    <div>
        <button type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
            Anzeige erstellen
        </button>
    </div>
</form>

{{-- Script για AJAX φόρτωση μοντέλων με βάση τη μάρκα --}}
<script>
    document.getElementById('brand').addEventListener('change', function () {
        const brandId = this.value;
        const modelSelect = document.getElementById('model');
        modelSelect.innerHTML = '<option value="">Lade Modelle...</option>';

        if (brandId) {
            fetch(`/api/car-models-by-name/${encodeURIComponent(brandId)}`)
                .then(response => response.json())
                .then(models => {
                    modelSelect.innerHTML = '<option value="">-- Bitte wählen --</option>';
                    models.forEach(model => {
                        modelSelect.innerHTML += `<option value="${model.name}">${model.name}</option>`;
                    });
                });
        } else {
            modelSelect.innerHTML = '<option value="">-- Bitte wählen --</option>';
        }
    });
</script>
