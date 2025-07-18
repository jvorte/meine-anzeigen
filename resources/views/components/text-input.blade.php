@props(['name', 'label' => null, 'value' => null])
@if($label)
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-1">
        {{ $label }}
    </label>
@endif


<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-1">
        {{ $label }}
    </label>
    <input 
        type="text" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        class="w-full p-3 border border-gray-600 rounded-lg bg-white text-gray-900 placeholder-gray-400 shadow-sm 
               focus:border-indigo-600 focus:ring focus:ring-indigo-300 focus:ring-opacity-50 transition duration-150 ease-in-out"
    />
</div>
