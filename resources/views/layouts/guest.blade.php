<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FIGO HOLIDAYS') }} - Admin Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

        @php 
            $siteSettings = \App\Models\GeneralSetting::first();
            $primaryColor = $siteSettings->primary_color ?? '#0F4A3B';
        @endphp
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                green: '{{ $primaryColor }}',
                                greenLight: '{{ $primaryColor }}CC',
                            }
                        }
                    }
                }
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: {{ $primaryColor }};
            }
            [x-cloak] { display: none !important; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-\[\#0F4A3B\] { background-color: var(--primary-color) !important; }
            .text-\[\#0F4A3B\] { color: var(--primary-color) !important; }
            .shadow-\[\#0F4A3B\/20\] { --tw-shadow-color: {{ $primaryColor }}33; }
            .focus\:border-\[\#0F4A3B\/20\]:focus { border-color: {{ $primaryColor }}33 !important; }
            .hover\:text-\[\#0F4A3B\]:hover { color: var(--primary-color) !important; }
        </style>
    </head>
    <body class="h-full antialiased bg-[#F8F9FA]">
        {{ $slot }}
    </body>
</html>
