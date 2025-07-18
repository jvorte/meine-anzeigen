@props(['name', 'label', 'value' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-1">
        {{ $label }}
    </label>
    <input 
        type="month" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        class="mt-1 block w-full p-3 border border-gray-600 rounded-lg shadow-sm bg-white text-gray-900
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-600 sm:text-sm
               transition duration-150 ease-in-out"
    />
</div>
