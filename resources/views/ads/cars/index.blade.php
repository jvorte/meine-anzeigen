<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">Alle Autos</h2>
        <p class="text-md text-gray-700 dark:text-gray-500">Filtern Sie nach Marke, Baujahr und mehr.</p>
    </x-slot>

    <div class="py-5 bg-gray-50 dark:bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                
                <form action="{{ route('categories.cars.index') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="make" class="block text-sm font-medium text-gray-700">Marke</label>
                            <input type="text" name="make" id="make" value="{{ request('make') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Baujahr</label>
                            <input type="number" name="year" id="year" value="{{ request('year') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Filter anwenden
                            </button>
                        </div>
                    </div>
                </form>

                @if ($ads->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center text-lg py-10">Es sind noch keine Anzeigen in dieser Kategorie verfügbar.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
                        @foreach ($ads as $ad)
                            {{-- Your ad card HTML goes here, it will be simpler now --}}
                        @endforeach
                    </div>
                    <div class="mt-8">
                        {{ $ads->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>