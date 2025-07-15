<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow rounded-xl">
        <h1 class="text-2xl font-bold mb-4">{{ $ad->title }}</h1>

        <div class="mb-6">
            <h2 class="font-semibold text-gray-700 mb-2">🇩🇪 Beschreibung (DE):</h2>
            <p>{{ $ad->description_de }}</p>
        </div>

        <div>
            <h2 class="font-semibold text-gray-700 mb-2">🇬🇧 Description (EN):</h2>
            <p>{{ $ad->description_en }}</p>
        </div>
    </div>
</x-app-layout>
