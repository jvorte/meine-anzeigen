<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-8">Kategorien & Anzeigen</h1>

        @foreach($categories as $category)
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $category->name }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($category->ads as $ad)
                        <div class="bg-white border rounded-lg p-4 shadow hover:shadow-md transition">
                            <h3 class="text-lg font-bold mb-2">{{ $ad->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $ad->description_de }}</p>
                            <a href="{{ route('ads.show', $ad) }}" class="text-blue-600 text-sm mt-2 inline-block">Anzeigen</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Keine Anzeigen in dieser Kategorie.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
