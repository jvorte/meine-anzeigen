{{-- resources/views/ads/motorrad/create.blade.php --}}
<x-app-layout>

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Neue Anzeige: Motorrad</h2>

        <form method="POST" action="{{ route('ads.motorrad.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Bilder hochladen --}}
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700">Bilder</label>
                <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Titel --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titel</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Beschreibung --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Beschreibung</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Marke --}}
            <div>
                <label for="brand_id" class="block text-sm font-medium text-gray-700">Marke</label>
                <select name="brand_id" id="brand_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Bitte wählen</option>
                    @foreach($brands as $id => $name)
                        <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Modell --}}
            <div>
                <label for="car_model_id" class="block text-sm font-medium text-gray-700">Modell</label>
                <select name="car_model_id" id="car_model_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Bitte wählen</option>
                    @foreach($models as $id => $name)
                        <option value="{{ $id }}" {{ old('car_model_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('car_model_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Erstzulassung --}}
            <div>
                <label for="first_registration" class="block text-sm font-medium text-gray-700">Erstzulassung</label>
                <input type="date" name="first_registration" id="first_registration" value="{{ old('first_registration') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                @error('first_registration')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kilometerstand --}}
            <div>
                <label for="mileage" class="block text-sm font-medium text-gray-700">Kilometerstand</label>
                <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                @error('mileage')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Leistung (PS) --}}
            <div>
                <label for="power" class="block text-sm font-medium text-gray-700">Leistung (PS)</label>
                <input type="number" name="power" id="power" value="{{ old('power') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                @error('power')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Farbe --}}
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700">Farbe</label>
                <select name="color" id="color" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Bitte wählen</option>
                    @foreach($colors as $color)
                        <option value="{{ $color }}" {{ old('color') == $color ? 'selected' : '' }}>{{ $color }}</option>
                    @endforeach
                </select>
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Zustand --}}
            <div>
                <label for="condition" class="block text-sm font-medium text-gray-700">Zustand</label>
                <select name="condition" id="condition" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Bitte wählen</option>
                    <option value="neu" {{ old('condition') == 'neu' ? 'selected' : '' }}>Neu</option>
                    <option value="gebraucht" {{ old('condition') == 'gebraucht' ? 'selected' : '' }}>Gebraucht</option>
                </select>
                @error('condition')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Button --}}
            <div class="pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">Anzeige erstellen</button>
            </div>

        </form>
    </div>
@endsection

</x-app-layout>
