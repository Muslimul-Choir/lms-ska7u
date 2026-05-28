<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-slate-950/60 backdrop-blur-sm lg:hidden" style="display:none"></div>

{{-- ══════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════ --}}
<aside :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-[#5c1020] dark:bg-[#4a0e1f]
           flex flex-col border-r border-[#c9982a]
           transition-transform duration-300 ease-in-out
           lg:translate-x-0 lg:shadow-none"
    @keydown.escape.window="sidebarOpen = false">

    {{-- ── BRAND ── --}}
    <div class="px-4">
        <div class="flex-shrink-0 flex items-center justify-between px-2 h-16 rounded-lg border-b-2 border-[#c9982a]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                @if(Auth::user() && Auth::user()->role === 'siswa')
                    <x-student-logo class="w-9 h-9 flex-shrink-0" />
                @else
                    <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-orange-100" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" />
                        </svg>
                    </span>
                @endif
                <div>
                    <p class="font-heading font-bold text-white text-sm leading-tight">
                        {{ config('app.name', 'LMS SKA7U') }}</p>
                    <p class="text-[10px] text-[#c9982a] uppercase tracking-widest">Learning System</p>
                </div>
            </a>
            {{-- Tombol tutup (mobile) --}}
            <button @click="sidebarOpen = false"
                class="lg:hidden p-1.5 rounded-md text-[#c9982a] hover:text-white hover:bg-yellow-500 hover:bg-opacity-10 transition-colors"
                aria-label="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>


    {{-- ── NAVIGATION (scrollable) ── --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5 scrollbar-thin"
         x-data="{ scrollPos: 0 }"
         x-init="
            $nextTick(() => {
                const saved = sessionStorage.getItem('lms_sidebar_scroll');
                if (saved) {
                    $el.scrollTop = parseInt(saved);
                }
            });
         "
         @scroll.passive="sessionStorage.setItem('lms_sidebar_scroll', $el.scrollTop)">

        @php
            function navActive(string $pattern): string
            {
                return request()->routeIs($pattern)
                    ? 'border-l-4 border-[#f59e0b] bg-yellow-500 bg-opacity-30 text-[#fde68a] font-bold'
                    : 'text-[rgba(255,235,200,0.55)] hover:bg-yellow-500 hover:bg-opacity-10 hover:text-[#fde68a]';
            }

            function iconActive(string $pattern): string
            {
                return request()->routeIs($pattern) ? 'text-[#f59e0b] font-bold' : '';
            }

            function textActive(string $pattern): string
            {
                return request()->routeIs($pattern) ? 'font-semibold' : '';
            }

            function navIndicator(string $pattern): bool
            {
                return request()->routeIs($pattern);
            }
        @endphp

        {{-- ─────────────────────────────
             UMUM
        ───────────────────────────── --}}
        @auth
        @unless(Auth::user()->role === 'siswa')
        <p class="px-3 pt-1 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Umum</p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('dashboard') }}">
            <svg class="{{ iconActive('dashboard') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="3" width="7" height="7" rx="1" />
                <rect x="3" y="14" width="7" height="7" rx="1" />
                <rect x="14" y="14" width="7" height="7" rx="1" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('dashboard') }}">Dashboard</span>
            @if (navIndicator('dashboard'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
        {{-- Admin Management --}}
        <a href="{{ route('users.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('users.*') }}">
            <svg class="{{ iconActive('users.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('users.*') }}">Admin Management</span>
            @if (navIndicator('users.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- ─────────────────────────────
             DATA MASTER
        ───────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Data Master</p>

        {{-- Bagian --}}
        <a href="{{ route('bagian.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('bagian.*') }}">
            <svg class="{{ iconActive('bagian.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16M3 21h18M9 9h1M9 13h1M14 9h1M14 13h1M9 17h6v4H9z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('bagian.*') }}">Bagian</span>
            @if (navIndicator('bagian.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Jurusan --}}
        <a href="{{ route('jurusan.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('jurusan.*') }}">
            <svg class="{{ iconActive('jurusan.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M22 10v6M2 10l10-5 10 5-10 5zM6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('jurusan.*') }}">Jurusan</span>
            @if (navIndicator('jurusan.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Tingkatan --}}
        <a href="{{ route('tingkatan.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('tingkatan.*') }}">
            <svg class="{{ iconActive('tingkatan.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18" />
                <rect x="4" y="13" width="4" height="8" rx="0.5" />
                <rect x="10" y="9" width="4" height="12" rx="0.5" />
                <rect x="16" y="5" width="4" height="16" rx="0.5" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('tingkatan.*') }}">Tingkatan</span>
            @if (navIndicator('tingkatan.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Kelas --}}
        <a href="{{ route('kelas.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('kelas.*') }}">
            <svg class="{{ iconActive('kelas.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                <circle cx="12" cy="11" r="1" fill="currentColor" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('kelas.*') }}">Kelas</span>
            @if (navIndicator('kelas.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Tahun Ajaran --}}
        <a href="{{ route('tahunajaran.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('tahunajaran.*') }}">
            <svg class="{{ iconActive('tahunajaran.*') }} w-4 h-4 flex-shrink-0" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('tahunajaran.*') }}">Tahun Ajaran</span>
            @if (navIndicator('tahunajaran.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Semester --}}
        <a href="{{ route('semester.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('semester.*') }}">
            <svg class="{{ iconActive('semester.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('semester.*') }}">Semester</span>
            @if (navIndicator('semester.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- ─────────────────────────────
             SDM
        ───────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">SDM</p>

        {{-- Guru --}}
        <a href="{{ route('guru.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('guru.*') }}">
            <svg class="{{ iconActive('guru.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="7" r="3" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a6 6 0 016-6h2M16 11h6M19 8v6" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('guru.*') }}">Guru</span>
            @if (navIndicator('guru.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Siswa --}}
        <a href="{{ route('siswa.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.*') }}">
            <svg class="{{ iconActive('siswa.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.*') }}">Siswa</span>
            @if (navIndicator('siswa.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>
        @endif

        {{-- ─────────────────────────────
             PEMBELAJARAN
        ───────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Pembelajaran</p>

        @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
        {{-- Mapel --}}
        <a href="{{ route('mapel.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('mapel.*') }}">
            <svg class="{{ iconActive('mapel.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('mapel.*') }}">Mapel</span>
            @if (navIndicator('mapel.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Guru Mapel --}}
        <a href="{{ route('guru_mapel.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('guru_mapel.*') }}">
            <svg class="{{ iconActive('guru_mapel.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <circle cx="9" cy="7" r="3" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a4 4 0 014-4h4M16 11l2 2 4-4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('guru_mapel.*') }}">Guru Mapel</span>
            @if (navIndicator('guru_mapel.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Jam Belajar --}}
        <a href="{{ route('jambelajar.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('jambelajar.*') }}">
            <svg class="{{ iconActive('jambelajar.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3.5 3.5" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('jambelajar.*') }}">Jam Belajar</span>
            @if (navIndicator('jambelajar.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>
        @endif

        {{-- Jadwal Belajar --}}
        <a href="{{ route('jadwalbelajar.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('jadwalbelajar.*') }}">
            <svg class="{{ iconActive('jadwalbelajar.*') }} w-4 h-4 flex-shrink-0" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path stroke-linecap="round" d="M3 9h18M3 15h18M9 3v18M15 3v18" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('jadwalbelajar.*') }}">Jadwal Belajar</span>
            @if (navIndicator('jadwalbelajar.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Pertemuan --}}
        <a href="{{ route('pertemuan.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('pertemuan.*') }}">
            <svg class="{{ iconActive('pertemuan.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                <rect x="9" y="3" width="6" height="4" rx="1" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('pertemuan.*') }}">Pertemuan</span>
            @if (navIndicator('pertemuan.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Absensi --}}
        <a href="{{ route('absensi.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('absensi.*') }}">
            <svg class="{{ iconActive('absensi.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('absensi.*') }}">Absensi</span>
            @if (navIndicator('absensi.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- ─────────────────────────────
             KONTEN & EVALUASI
        ───────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Konten & Evaluasi</p>

        {{-- Materi --}}
        <a href="{{ route('materi.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('materi.*') }}">
            <svg class="{{ iconActive('materi.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('materi.*') }}">Materi</span>
            @if (navIndicator('materi.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Tugas --}}
        <a href="{{ route('tugas.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('tugas.*') }}">
            <svg class="{{ iconActive('tugas.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('tugas.*') }}">Tugas</span>
            @if (navIndicator('tugas.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Pengumpulan Tugas --}}
        <a href="{{ route('pengumpulan-tugas.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('pengumpulan-tugas.*') }}">
            <svg class="{{ iconActive('pengumpulan-tugas.*') }} w-4 h-4 flex-shrink-0" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('pengumpulan-tugas.*') }}">Pengumpulan
                Tugas</span>
            @if (navIndicator('pengumpulan-tugas.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Penilaian --}}
        <a href="{{ route('penilaian.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('penilaian.*') }}">
            <svg class="{{ iconActive('penilaian.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('penilaian.*') }}">Penilaian</span>
            @if (navIndicator('penilaian.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Kuis --}}
        <a href="{{ route('kuis.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('kuis.*') }} {{ navActive('soal_kuis.*') }} {{ navActive('hasil_kuis.*') }}">
            <svg class="{{ iconActive('kuis.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('kuis.*') }}">Kuis</span>
            @if (navIndicator('kuis.*') || navIndicator('soal_kuis.*') || navIndicator('hasil_kuis.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
        {{-- ─────────────────────────────
             SISTEM
        ───────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Sistem</p>

        {{-- Activity Log --}}
        <a href="{{ route('activity-log.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('activity-log.*') }}">
            <svg class="{{ iconActive('activity-log.*') }} w-4 h-4 flex-shrink-0" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('activity-log.*') }}">Activity Log</span>
            @if (navIndicator('activity-log.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>
        @endif
        @endunless

        {{-- ── SISWA MENU ── --}}
        @if(Auth::user()->role === 'siswa')
        <p class="px-3 pt-1 pb-2 text-[10px] font-bold uppercase tracking-widest text-[#c9982a]">Pembelajaran</p>

        {{-- Dashboard Siswa --}}
        <a href="{{ route('siswa.dashboard') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.dashboard') }}">
            <svg class="{{ iconActive('siswa.dashboard') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="3" width="7" height="7" rx="1" />
                <rect x="3" y="14" width="7" height="7" rx="1" />
                <rect x="14" y="14" width="7" height="7" rx="1" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.dashboard') }}">Dashboard</span>
            @if (navIndicator('siswa.dashboard'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Materi --}}
        <a href="{{ route('siswa.materi.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.materi.*') }}">
            <svg class="{{ iconActive('siswa.materi.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.materi.*') }}">Materi</span>
            @if (navIndicator('siswa.materi.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Tugas --}}
        <a href="{{ route('siswa.tugas.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.tugas.*') }}">
            <svg class="{{ iconActive('siswa.tugas.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.tugas.*') }}">Tugas</span>
            @if (navIndicator('siswa.tugas.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Kuis --}}
        <a href="{{ route('siswa.kuis.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.kuis.*') }}">
            <svg class="{{ iconActive('siswa.kuis.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.kuis.*') }}">Kuis</span>
            @if (navIndicator('siswa.kuis.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Jadwal --}}
        <a href="{{ route('siswa.jadwal.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.jadwal.*') }}">
            <svg class="{{ iconActive('siswa.jadwal.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path stroke-linecap="round" d="M3 9h18M3 15h18M9 3v18M15 3v18" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.jadwal.*') }}">Jadwal</span>
            @if (navIndicator('siswa.jadwal.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Absensi --}}
        <a href="{{ route('siswa.absensi.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.absensi.*') }}">
            <svg class="{{ iconActive('siswa.absensi.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.absensi.*') }}">Absensi</span>
            @if (navIndicator('siswa.absensi.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>

        {{-- Pertemuan --}}
        <a href="{{ route('siswa.pertemuan.index') }}"
            class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ navActive('siswa.pertemuan.*') }}">
            <svg class="{{ iconActive('siswa.pertemuan.*') }} w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                <rect x="9" y="3" width="6" height="4" rx="1" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4" />
            </svg>
            <span class="flex-1 truncate tracking-wide {{ textActive('siswa.pertemuan.*') }}">Pertemuan</span>
            @if (navIndicator('siswa.pertemuan.*'))
                <span class="flex-shrink-0 w-1 h-4 rounded-full bg-yellow-400"></span>
            @endif
        </a>
        @endif
        @endauth

    </nav>

    {{-- ── PROFILE FOOTER ── --}}
    @auth
        <div class="flex-shrink-0 border-t border-[rgba(201,152,42,0.25)] px-3 py-3 relative" x-data="{ profileOpen: false }">

            <button @click="profileOpen = !profileOpen"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg
                    hover:bg-[rgba(201,152,42,0.2)]
                   transition-all duration-150">
                <div
                    class="w-8 h-8 rounded-full bg-amber-500 border border-amber-700 flex items-center justify-center flex-shrink-0">
                    <span
                        class="text-[12px] font-bold text-orange-100 font-heading">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 text-left min-w-0">
                    <p class="text-sm font-semibold text-slate-200 truncate max-w-36 leading-tight font-heading">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-slate-400 truncate max-w-36 tracking-wide">
                        {{ Auth::user()->email }}
                    </p>
                </div>
                <svg class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-yellow-300"
                    :class="profileOpen ? '-rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            {{-- Dropdown membuka ke atas --}}
            <div x-show="profileOpen" @click.outside="profileOpen = false"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute bottom-[4.5rem] left-3 right-3 bg-[#3a0c15]
                rounded-xl border border-[#c9982a]
                overflow-hidden z-50
                shadow-[0_-4px_16px_rgba(0,0,0,0.4)]"
                style="display:none">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2.5 px-4 py-3 text-sm
               text-[#fde68a] hover:bg-[rgba(201,152,42,0.18)]
               transition-colors">
                    <svg class="w-4 h-4 text-[#c9982a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Edit Profil
                </a>

                <div class="border-t border-[rgba(201,152,42,0.25)]"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-left
                   text-rose-400 hover:bg-[rgba(239,68,68,0.12)]
                   transition-colors">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

        </div>
    @endauth

</aside>
