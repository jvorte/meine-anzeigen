<x-app-layout>
<x-slot name="header">
    <nav class="flex space-x-4 overflow-x-auto">
        @foreach ($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 whitespace-nowrap">
                {{ $category->name }}
            </a>
        @endforeach
    </nav>
</x-slot>

{{-- στο κεντρο της σελίδας θα εχει ολες τις κατηγοριες για να επιλεξει ο χρηστης
και να παει στο επομενο βημα της δημιουργιας αγγελιας  --}}

</x-app-layout>