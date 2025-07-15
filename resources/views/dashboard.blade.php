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


    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Willkommen bei Meine Anzeigen!</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Hier findest du eine Übersicht deiner Kategorien und Anzeigen.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
