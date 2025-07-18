@props(['name', 'label', 'options' => [], 'value' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-1">
        {{ $label }}
    </label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}"
        class="mt-1 block w-full p-3 border border-gray-600 rounded-lg shadow-sm bg-white text-gray-900
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600 sm:text-sm
               transition duration-150 ease-in-out"
    >
        <option value="">Bitte auswählen</option>
        @foreach($options as $key => $text)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
