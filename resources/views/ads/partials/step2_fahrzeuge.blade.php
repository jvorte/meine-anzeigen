<div>
    <label for="vehicle_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fahrzeugtyp wählen</label>
    <select id="vehicle_type" name="vehicle_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        <option value="">-- Bitte wählen --</option>
        <option value="gebrauchtwagen">Gebrauchtwagen</option>
        <option value="motorrad">Motorrad & Quad</option>
        <option value="nutzfahrzeug">Nutzfahrzeug & Pickup</option>
        <option value="wohnwagen">Wohnwagen & Wohnmobil</option>
        <option value="ersatzteile">Ersatzteile & Zubehör</option>
    </select>

    <button
        x-on:click="$dispatch('proceed-step', { type: document.getElementById('vehicle_type').value })"
        class="mt-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none"
        :disabled="!document.getElementById('vehicle_type') || !document.getElementById('vehicle_type').value"
    >
        Weiter
    </button>
</div>
