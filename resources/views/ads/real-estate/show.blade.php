<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2">
            Listing: {{ $realEstate->title }}
        </h2>
        <p class="text-md text-gray-700 dark:text-gray-500">
            Detailed view of your real estate listing.
        </p>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Real Estate Listings', 'url' => route('categories.show', 'real-estate')],
                ['label' => $realEstate->title, 'url' => null],
            ]" />
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="max-w-6xl mx-auto my-5 flex justify-between items-center">
        <!-- Left button -->
        <div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 ml-0 bg-slate-600 border border-slate-300 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Dashboard
            </a>
        </div>

        <!-- Right buttons -->
        <div class="flex space-x-4">
            <a href="{{ route('ads.real-estate.edit', $realEstate) }}"
                class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Contact
            </a>

            <a href="{{ route('ads.real-estate.edit', $realEstate) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Edit Listing
            </a>

            <form action="{{ route('ads.real-estate.destroy', $realEstate) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this listing? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Delete Listing
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-xl my-6">

        {{-- Main Title --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $realEstate->title }}</h1>

        {{-- Basic Data Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Basic Data</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Property Type:</p>
                    <p class="text-gray-700">{{ $realEstate->property_type }}</p>
                </div>
                @if($realEstate->object_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Object Type:</p>
                    <p class="text-gray-700">{{ $realEstate->object_type }}</p>
                </div>
                @endif
                @if($realEstate->condition)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Condition:</p>
                    <p class="text-gray-700">{{ $realEstate->condition }}</p>
                </div>
                @endif
                @if($realEstate->room_count)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Number of Rooms:</p>
                    <p class="text-gray-700">{{ $realEstate->room_count }}</p>
                </div>
                @endif
                @if($realEstate->building_type)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Building Type:</p>
                    <p class="text-gray-700">{{ $realEstate->building_type }}</p>
                </div>
                @endif
                @if($realEstate->availability)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Availability:</p>
                    <p class="text-gray-700">{{ $realEstate->availability }}</p>
                </div>
                @endif
                @if($realEstate->fixed_term)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Fixed Term:</p>
                    <p class="text-gray-700">{{ $realEstate->fixed_term }}</p>
                </div>
                @endif
                @if($realEstate->fixed_term_end)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Fixed Term End:</p>
                    <p class="text-gray-700">{{ \Carbon\Carbon::parse($realEstate->fixed_term_end)->format('d.m.Y') }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Description Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Description</h4>
            <div class="space-y-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Main Description:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->description }}</p>
                </div>
                @if($realEstate->property_description)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Property Description:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->property_description }}</p>
                </div>
                @endif
                @if($realEstate->location)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Location Description:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->location }}</p>
                </div>
                @endif
                @if($realEstate->other)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Other:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->other }}</p>
                </div>
                @endif
                @if($realEstate->additional_information)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Additional Information:</p>
                    <p class="text-gray-700 leading-relaxed">{{ $realEstate->additional_information }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Location Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Location</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Country:</p>
                    <p class="text-gray-700">{{ $realEstate->country }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Postal Code:</p>
                    <p class="text-gray-700">{{ $realEstate->postal_code }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">City:</p>
                    <p class="text-gray-700">{{ $realEstate->city }}</p>
                </div>
                @if($realEstate->street)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Street:</p>
                    <p class="text-gray-700">{{ $realEstate->street }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Prices & Areas Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Prices & Areas</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($realEstate->total_rent)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Total Rent:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->total_rent, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->living_area)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Living Area:</p>
                    <p class="text-gray-700">{{ number_format($realEstate->living_area, 2, ',', '.') }} m&sup2;</p>
                </div>
                @endif
                @if($realEstate->plot_area)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Plot Area:</p>
                    <p class="text-gray-700">{{ number_format($realEstate->plot_area, 2, ',', '.') }} m&sup2;</p>
                </div>
                @endif
                @if($realEstate->deposit)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Deposit:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->deposit, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->broker_fee)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Broker Fee:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->broker_fee, 2, ',', '.') }}</p>
                </div>
                @endif
                @if($realEstate->buyout_price)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Buyout Price:</p>
                    <p class="text-gray-700">&euro;{{ number_format($realEstate->buyout_price, 2, ',', '.') }}</p>
                </div>
                @endif
            </div>
        </section>

        {{-- Equipment & Heating Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Equipment & Heating</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($realEstate->heating)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Heating:</p>
                    <p class="text-gray-700">{{ $realEstate->heating }}</p>
                </div>
                @endif

                @if($realEstate->equipment && count($realEstate->equipment) > 0)
                <div class="md:col-span-2 lg:col-span-3">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Equipment:</p>
                    <ul class="list-disc list-inside text-gray-700 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1">
                        @foreach($realEstate->equipment as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </section>

        {{-- Photos & Documents Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Photos & Documents</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($realEstate->images->count() > 0)
                <div class="md:col-span-2">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Images:</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($realEstate->images as $image)
                            <a href="{{ Storage::url($image->path) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($image->path) }}" alt="Real Estate Image" class="w-full h-32 object-cover rounded-md shadow-sm">
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($realEstate->floor_plan_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Floor Plan:</p>
                    <a href="{{ Storage::url($realEstate->floor_plan_path) }}" target="_blank" class="text-blue-600 hover:underline">View (PDF/Image)</a>
                </div>
                @endif

                @if($realEstate->energy_certificate_path)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Energy Certificate:</p>
                    <a href="{{ Storage::url($realEstate->energy_certificate_path) }}" target="_blank" class="text-blue-600 hover:underline">View (PDF/Image)</a>
                </div>
                @endif

                @if($realEstate->virtual_tour_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">360° Virtual Tour Link:</p>
                    <a href="{{ $realEstate->virtual_tour_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->virtual_tour_link }}</a>
                </div>
                @endif

                @if($realEstate->property_info_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Property Information Link:</p>
                    <a href="{{ $realEstate->property_info_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->property_info_link }}</a>
                </div>
                @endif

                @if($realEstate->condition_report_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Condition Report Link:</p>
                    <a href="{{ $realEstate->condition_report_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->condition_report_link }}</a>
                </div>
                @endif

                @if($realEstate->sales_report_link)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Sales Report Link:</p>
                    <a href="{{ $realEstate->sales_report_link }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->sales_report_link }}</a>
                </div>
                @endif
            </div>
        </section>

        {{-- Contact Section --}}
        <section class="bg-gray-50 p-6 rounded-lg shadow-inner mb-8">
            <h4 class="text-xl font-semibold text-gray-700 mb-6">Contact Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Contact Name:</p>
                    <p class="text-gray-700">{{ $realEstate->contact_name }}</p>
                </div>
                @if($realEstate->homepage)
                <div>
                    <p class="text-sm font-semibold text-gray-800">Homepage:</p>
                    <a href="{{ $realEstate->homepage }}" target="_blank" class="text-blue-600 hover:underline">{{ $realEstate->homepage }}</a>
                </div>
                @endif
            </div>
        </section>

    </div>
</x-app-layout>
