<nav x-data="{ open: false }" class="bg-white dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-32 h-auto fill-current" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-gray-500">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        {{ __('Home') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-pen-icon lucide-user-round-pen"><path d="M2 21a8 8 0 0 1 10.821-7.487"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="8" r="5"/></svg>
                            {{ __('My Profile') }}
                        </x-nav-link>

                        <x-nav-link :href="route('my-ads.index')" :active="request()->routeIs('my-ads.index')" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet-icon lucide-file-spreadsheet"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 13h2"/><path d="M14 13h2"/><path d="M8 17h2"/><path d="M14 17h2"/></svg> {{ __('My Ads') }}
                        </x-nav-link>

                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')" class="relative flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                <path d="M13 8H7"/>
                                <path d="M17 12H7"/>
                            </svg>
                            <span>{{ __('Nachrichten') }}</span>
                            @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    {{ $unreadMessagesCount }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M3 9h8m-9 4h16m-7 4h8m-10 4h2" />
                            </svg>
                            <span class="ms-2 uppercase">{{ app()->getLocale() }}</span>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ url('lang/en') }}">English</x-dropdown-link>
                        <x-dropdown-link href="{{ url('lang/de') }}">Deutsch</x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo" class="w-8 h-8 mr-2 rounded-full object-cover">
                                <div>Willkommen, {{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4 mt-2">
                        <a href="{{ route('login') }}" class="flex items-center text-sm text-gray-600 hover:text-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 12H5a2 2 0 0 0-2 2v5"/>
                                <circle cx="13" cy="19" r="2"/>
                                <circle cx="5" cy="19" r="2"/>
                                <path d="M8 19h3m5-17v17h6M6 12V7c0-1.1.9-2 2-2h3l5 5"/>
                            </svg>
                            Login
                        </a>

                        <a href="{{ route('register') }}" class="flex items-center text-sm text-gray-600 hover:text-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M2 21a8 8 0 0 1 10.821-7.487"/>
                                <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
                                <circle cx="10" cy="8" r="5"/>
                            </svg>
                            Registrieren
                        </a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('My Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('my-ads.index')" :active="request()->routeIs('my-ads.index')">
                    {{ __('My Ads') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')" class="flex items-center">
                    {{ __('Nachrichten') }}
                    @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                        <span class="ms-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-center px-4">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo" class="w-10 h-10 mr-3 rounded-full object-cover">
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4 space-y-1">
                <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">{{ __('Registrieren') }}</x-responsive-nav-link>
            </div>
        @endauth
        
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4 space-y-1">
            <h3 class="text-gray-500 font-medium">{{ __('Sprache') }}</h3>
            <div class="flex space-x-2">
                <a href="{{ url('lang/en') }}" class="text-sm text-gray-700 hover:text-blue-600">English</a>
                <a href="{{ url('lang/de') }}" class="text-sm text-gray-700 hover:text-blue-600">Deutsch</a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
        {{-- Updated Header Section with Gradient and Prominent CTA --}}
        <div class="relative flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 p-6 bg-cover bg-center shadow-lg rounded-lg"
            style="background-image: url('/storage/images/real-estate.jpg');"> {{-- Replaced with a stable placeholder image --}}
            {{-- Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black opacity-20 rounded-lg"></div> {{-- Adjust opacity (e.g., 10 to 40) --}}

            {{-- Main Heading and Description (ensure z-index to be above overlay) --}}
            <div class="relative z-10 text-center md:text-left flex-grow">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight mb-2">
                    Finde deine nächste Anzeige
                </h2>
                <p class="text-md text-gray-600 dark:text-gray-100">
                    Durchsuche Tausende von Anzeigen oder erstelle deine eigene.
                </p>
            </div>

            {{-- Prominent Search Bar (ensure z-index to be above overlay) --}}
            <div class="relative z-10 w-full md:w-1/2 lg:w-2/5">
                <form action="{{ route('ads.search') }}" method="GET">

                    <input type="text" name="query" placeholder="Was suchst du? z.B. iPhone, Wohnung, Fahrrad..."
                        class="w-full p-3 pl-10 border border-gray-300 rounded-full shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-black dark:bg-gray-100 dark:text-gray-900 dark:border-gray-600"
                        aria-label="Search ads">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </div>

        {{-- Category Navigation Links --}}
        <nav
            class="p-4 mt-4 pb-2 border-b border-gray-200 dark:border-gray-700
                grid grid-cols-2 gap-x-4 gap-y-3 justify-center md:flex md:flex-wrap md:justify-start">
            @foreach ($categories as $cat)
                {{-- Check if it's the "Fahrzeuge" category --}}
                @if ($cat->slug == 'cars')
                    {{-- Alpine.js for modal --}}
                    <div x-data="{ open: false }" class="relative">
                        <a @click.prevent="open = true" {{-- Prevent default link behavior --}}
                            href="#" {{-- No direct href, managed by modal --}}
                            class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-car-icon lucide-car">
                                <path
                                    d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                <circle cx="7" cy="17" r="2" />
                                <path d="M9 17h6" />
                                <circle cx="17" cy="17" r="2" />
                            </svg>
                            <span>Vehicles</span>
                        </a>

                        {{-- The Modal --}}
                        <div x-show="open"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4"
                                @click.away="open = false" {{-- Close when clicking outside --}}
                                x-cloak> {{-- Hides until Alpine processes it --}}
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative" @click.stop> {{-- Prevent closing when clicking inside modal --}}
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Fahrzeugkategorien</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Link to generic Fahrzeuge page, if you still want one for "all vehicles" --}}
                                    <a href="{{ route('categories.cars.index') }}"
                                        class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-parking mb-2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 17V7H7.8C7.1 7 6.5 7.5 6.5 8.2V10c0 .7.6 1.2 1.3 1.2H10V17"/><path d="M13 17V7h4"/></svg>
                                        <span>Autos</span>
                                    </a>
                                    {{-- Sub-category links for Fahrzeuge. Only include the actual sub-categories for vehicles. --}}
                                    {{-- Make sure your $categories collection passed from the controller includes these slugs --}}
                                    @foreach ($categories->whereIn('slug', ['motorcycles', 'commercial-vehicles', 'campers']) as $subCat)
                                        <a href="{{ route('categories.' . $subCat->slug . '.index') }}"
                                            class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-200">
                                            @if ($subCat->slug == 'motorcycles')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-motorbike mb-2"><path d="M5 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M17 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M7.5 14h9l4 -2l-1.5 -4.5h-11.5l-4 2z"/><path d="M18 5l-1.5 4.5"/><path d="M9 6l-2 4"/><path d="M12 7v4"/></svg>
                                            @elseif ($subCat->slug == 'commercial-vehicles')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucude-truck mb-2"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M10 18H7"/><path d="M18 18h-1"/><path d="M19 12h2v3"/><path d="M18 11V6a2 2 0 0 0-2-2h-3"/><path d="M14 18h6a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2h-3"/><path d="M7 18v.001"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                                            @elseif ($subCat->slug == 'campers')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-caravan mb-2"><path d="M6 10c-1.1 0-2 .9-2 2v6h3"/><path d="M15 10h5a2 2 0 0 1 2 2v6h-3"/><path d="M11 10V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4h8Z"/><path d="M15 18H9a2 2 0 0 1-2-2v-4h10v4a2 2 0 0 1-2 2Z"/><path d="M18 20v2"/><path d="M14 14h.01"/><path d="M12 10h.01"/><path d="M20 20v2"/></svg>
                                            @endif
                                            <span>{{ $subCat->name }}</span>
                                        </a>
                                    @endforeach

                                </div>

                                {{-- Close button --}}
                                <button @click="open = false"
                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif (!in_array($cat->slug, ['motorcycles', 'commercial-vehicles', 'campers']))
                    {{-- All other categories (excluding vehicle sub-categories that are now in the modal) remain as direct links --}}
                    <a href="{{ route('categories.' . $cat->slug . '.index') }}"
                        class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-1 rounded-full dark:hover:bg-gray-400 dark:text-gray-700 dark:hover:text-white">
                        {{-- Original SVG Icon Logic here for other categories --}}
                        @if ($cat->slug == 'vehicles-parts')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wrench-icon lucide-wrench"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"/></svg>
                        @elseif ($cat->slug == 'boats')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sailboat-icon lucide-sailboat"><path d="M10 2v15"/><path d="M7 22a4 4 0 0 1-4-4 1 1 0 0 1 1-1h16a1 1 0 0 1 1 1 4 4 0 0 1-4 4z"/><path d="M9.159 2.46a1 1 0 0 1 1.521-.193l9.977 8.98A1 1 0 0 1 20 13H4a1 1 0 0 1-.824-1.567z"/></svg>
                        @elseif ($cat->slug == 'electronics')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cable-icon lucide-cable"><path d="M17 19a1 1 0 0 1-1-1v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a1 1 0 0 1-1 1z"/><path d="M17 21v-2"/><path d="M19 14V6.5a1 1 0 0 0-7 0v11a1 1 0 0 1-7 0V10"/><path d="M21 21v-2"/><path d="M3 5V3"/><path d="M4 10a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2z"/><path d="M7 5V3"/></svg>
                        @elseif ($cat->slug == 'household')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-couch"><path d="M21 9V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3"/><path d="M2 11v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v1.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5V11a2 2 0 0 0-4 0z"/><path d="M4 18v2"/><path d="M20 18v2"/><path d="M12 4v9"/></svg>
                        @elseif ($cat->slug == 'real-estate')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        @elseif ($cat->slug == 'services')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-platter"><path d="M12 3V2"/><path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5"/><path d="M2 14h12a2 2 0 0 1 0 4h-2"/><path d="M4 10h16"/><path d="M5 10a7 7 0 0 1 14 0"/><path d="M5 14v6a1 1 0 0 1-1 1H2"/></svg>
                        @elseif ($cat->slug == 'others')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-open-icon lucide-package-open"><path d="M12 22v-9"/><path d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"/><path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"/><path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"/></svg>
                        @else
                            {{-- Default icon if no match --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414L19 21l3.5-7.5L12.586 2.586z"/><circle cx="7" cy="7" r="1"/></svg>
                        @endif
                        <span>{{ $cat->name }}</span>
                    </a>
                @endif
            @endforeach
        </nav>
    </div>
</nav>