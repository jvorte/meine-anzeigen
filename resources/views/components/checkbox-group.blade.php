@props(['name', 'label', 'options' => [], 'values' => []])

<div class="mb-4">
    <span class="block text-sm font-semibold text-gray-800 mb-1">
        {{ $label }}
    </span>
    <div class="grid grid-cols-2 gap-3">
        @foreach($options as $key => $text)
            <label class="inline-flex items-center cursor-pointer">
                <input 
                    type="checkbox" 
                    name="{{ $name }}[]" 
                    value="{{ $key }}"
                    {{ in_array($key, old($name, $values ?? [])) ? 'checked' : '' }}
                    class="rounded border-gray-600 text-indigo-600 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
                />
                <span class="ml-2 text-sm text-gray-900 select-none">{{ $text }}</span>
            </label>
        @endforeach
    </div>
</div>
