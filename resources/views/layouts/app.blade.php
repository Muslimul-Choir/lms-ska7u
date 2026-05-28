{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

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
            <a href="@auth{{ Auth::user()->role === 'siswa' ? route('siswa.dashboard') : route('dashboard') }}@else{{ route('dashboard') }}@endauth" class="flex items-center gap-2.5">
                @if(Auth::user() && Auth::user()->role === 'siswa')
                    <x-student-logo class="w-8 h-8 flex-shrink-0" />
                @else
                    <span class="flex-shrink-0 w-7 h-7 rounded-md bg-amber-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-orange-100" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" />
                        </svg>
                    </span>
                @endif
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
        @hasSection('header')
            <div class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
                <div class="max-w-screen-2xl mx-auto px-6 lg:px-8 py-5">
                    {{-- Breadcrumb --}}
                    @hasSection('breadcrumb')
                        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
                            @yield('breadcrumb')
                        </nav>
                    @endif
                    
                    @yield('header')
                </div>
            </div>
        @endif

        {{-- Content --}}
        <main
            class="flex-1 w-full max-w-screen-2xl mx-auto
                         px-4 pt-4 pb-8 @auth @if(Auth::user()->role === 'siswa') pb-24 lg:pb-8 @endif @endauth
                         sm:px-6 sm:pt-6
                         lg:px-8 lg:py-8">
            @yield('content')
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

    <x-alerts.success />
    <x-alerts.error />

    @auth
        @if(Auth::user()->role === 'siswa')
            {{-- Modern Mobile Bottom Nav --}}
            <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] pb-safe">
                <div class="flex justify-around items-center h-16 max-w-md mx-auto px-2">
                    {{-- Home / Dashboard --}}
                    <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.dashboard') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        <span>Home</span>
                    </a>
                    
                    {{-- Materi --}}
                    <a href="{{ route('siswa.materi.index') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.materi.*') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Materi</span>
                    </a>
                    
                    {{-- Absensi --}}
                    <a href="{{ route('siswa.absensi.index') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.absensi.*') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>
                        <span>Absensi</span>
                    </a>
                    
                    {{-- Jadwal --}}
                    <a href="{{ route('siswa.jadwal.index') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.jadwal.*') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        <span>Jadwal</span>
                    </a>

                    {{-- Pertemuan --}}
                    <a href="{{ route('siswa.pertemuan.index') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.pertemuan.*') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span>Pertemuan</span>
                    </a>

                    {{-- Tugas --}}
                    <a href="{{ route('siswa.tugas.index') }}" class="flex flex-col items-center justify-center flex-1 text-[10px] gap-1 transition-colors {{ request()->routeIs('siswa.tugas.*') ? 'text-amber-500 font-semibold' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Tugas</span>
                    </a>
                </div>
            </div>
        @endif
    @endauth

    @stack('scripts')
    
    {{-- Preserve sidebar scroll position --}}
    <script>
        (function() {
            'use strict';
            
            const SCROLL_KEY = 'lms_sidebar_scroll';
            let sidebar = null;
            let restoreAttempts = 0;
            const MAX_ATTEMPTS = 10;
            
            // Function to get sidebar element
            function getSidebar() {
                if (!sidebar) {
                    sidebar = document.querySelector('aside nav.overflow-y-auto');
                }
                return sidebar;
            }
            
            // Restore scroll position
            function restoreScroll() {
                const nav = getSidebar();
                if (!nav) {
                    // Retry if sidebar not found yet
                    if (restoreAttempts < MAX_ATTEMPTS) {
                        restoreAttempts++;
                        setTimeout(restoreScroll, 50);
                    }
                    return;
                }
                
                const savedScroll = sessionStorage.getItem(SCROLL_KEY);
                if (savedScroll !== null) {
                    const scrollValue = parseInt(savedScroll, 10);
                    nav.scrollTop = scrollValue;
                    console.log('Restored scroll to:', scrollValue);
                }
            }
            
            // Save scroll position
            function saveScroll() {
                const nav = getSidebar();
                if (nav && nav.scrollTop !== undefined) {
                    sessionStorage.setItem(SCROLL_KEY, nav.scrollTop.toString());
                    console.log('Saved scroll:', nav.scrollTop);
                }
            }
            
            // Initialize
            function init() {
                // Restore scroll position
                restoreScroll();
                
                const nav = getSidebar();
                if (!nav) return;
                
                // Save on scroll
                nav.addEventListener('scroll', saveScroll, { passive: true });
                
                // Save on any link click in sidebar
                nav.addEventListener('click', function(e) {
                    if (e.target.closest('a')) {
                        saveScroll();
                    }
                }, true);
            }
            
            // Run on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
            
            // Save before page unload
            window.addEventListener('beforeunload', saveScroll);
            
            // Also save on visibility change (when switching tabs)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    saveScroll();
                }
            });
        })();
    </script>
</body>

</html>