{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LMS SKA7U') }}</title>

    {{-- ── FONTS ── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    {{-- ── VITE ── --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ── Chart.js ── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Lato', sans-serif;
        }

        body {
            font-family: var(--font-body);
            font-size: 15px;
            line-height: 1.65;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading {
            font-family: var(--font-heading);
            letter-spacing: -0.01em;
        }

        /* Thin scrollbar for sidebar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 9999px;
        }

        /* Focus ring */
        *:focus-visible {
            outline: 2px solid #f59e0b;
            outline-offset: 2px;
        }

        /* Page-load fade */
        main {
            animation: pageIn 0.50s ease;
        }

        @keyframes pageIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-cloak class="h-full bg-slate-50 scrollbar-thin text-slate-700 dark:bg-slate-950 dark:text-slate-200 antialiased"
    x-data="{ sidebarOpen: false }" :class="sidebarOpen ? 'overflow-hidden' : 'overflow-auto lg:overflow-auto'">

    {{-- ── NAVIGATION (sidebar + overlay) ── --}}
    @include('layouts.navigation')

    {{-- ══════════════════════════════════════
             MAIN WRAPPER
        ══════════════════════════════════════ --}}
    <div class="lg:pl-64 flex flex-col min-h-screen">

        {{-- Mobile top bar --}}
        <header
            class="lg:hidden sticky top-0 z-20 h-14 bg-[#5c1020] dark:bg-[#4a0e1f] flex items-center gap-3 px-4 flex-shrink-0">
            <button @click="sidebarOpen = true"
                class="p-1.5 rounded-md text-[#c9982a] hover:text-white hover:bg-yellow-500 hover:bg-opacity-10 transition-colors"
                aria-label="Buka menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <span class="flex-shrink-0 w-7 h-7 rounded-md bg-amber-500 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-orange-100" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" />
                    </svg>
                </span>
                <span class="font-heading font-semibold text-white text-sm">{{ config('app.name', 'LMS SKA7U') }}</span>
            </a>
            @auth
                <div
                    class="ml-auto w-fit h-6 px-3 rounded-full bg-amber-500 border border-slate-700 flex items-center justify-center">
                    <span
                        class="text-[10px] font-bold text-white font-heading">{{ Auth::user()->name }}</span>
                </div>
            @endauth
        </header>

        {{-- Desktop page header --}}
        @isset($header)
            <div class=" bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
                <div class="max-w-screen-2xl mx-auto px-6 lg:px-8 py-5">
                    {{ $header }}
                </div>
            </div>
        @endisset

        {{-- Content --}}
        <main
            class="flex-1 w-full max-w-screen-2xl mx-auto
                         px-4 pt-4 pb-8
                         sm:px-6 sm:pt-6
                         lg:px-8 lg:py-8">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="hidden lg:block border-t border-slate-200 dark:border-slate-800 px-8 py-4">
            <p class="text-xs text-slate-400 text-center">
                &copy; {{ date('Y') }} <span
                    class="font-medium text-slate-500">{{ config('app.name', 'LMS SKA7U') }}</span>
                &mdash; Academic Learning Management System
            </p>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>