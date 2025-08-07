<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-200 ">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white">
                    <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('imageUploader', () => ({
            previews: [],
            files: [], // To store the actual File objects

            handleFiles(event) {
                this.previews = []; // Clear existing previews
                this.files = []; // Clear existing files

                Array.from(event.target.files).forEach(file => {
                    this.files.push(file); // Store the actual file
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            },

            remove(index) {
                this.previews.splice(index, 1); // Remove preview
                this.files.splice(index, 1);    // Remove actual file

           
            }
        }));
    });
</script>
           @include('layouts.footer') {{-- Include the footer here --}}
    </body>
</html>
