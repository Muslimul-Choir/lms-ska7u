<!-- Sidebar Navigation Wrapper -->
<div x-data="{ sidebarOpen: true }">
    <!-- Sidebar Navigation -->
    <nav class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white z-50 transition-transform duration-300 ease-in-out flex flex-col"
         :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <!-- Sidebar Header -->
        <div class="flex-shrink-0 flex items-center justify-between h-16 px-4 border-b border-gray-800">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-logo class="block h-8 w-auto fill-current text-white" />
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Links (Scrollable) -->
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1 scrollbar-thin scrollbar-thumb-gray-700">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/>
                </svg>
                {{ __('Dashboard') }}
            </a>

            {{-- Admin Management — shield icon --}}
            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                {{ __('Admin Management') }}
            </a>

            {{-- Absensi — check circle --}}
            <a href="{{ route('absensi.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('absensi.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                </svg>
                {{ __('Absensi') }}
            </a>

            {{-- Bagian — office/building --}}
            <a href="{{ route('bagian.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('bagian.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1M9 13h1M14 9h1M14 13h1"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6v4H9z"/>
                </svg>
                {{ __('Bagian') }}
            </a>

            {{-- Mapel — open book --}}
            <a href="{{ route('mapel.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('mapel.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                {{ __('Mapel') }}
            </a>

            {{-- Jam Belajar — clock --}}
            <a href="{{ route('jambelajar.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jambelajar.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3.5 3.5"/>
                </svg>
                {{ __('Jam Belajar') }}
            </a>

            {{-- Jurusan — graduation cap --}}
            <a href="{{ route('jurusan.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jurusan.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/>
                </svg>
                {{ __('Jurusan') }}
            </a>

            {{-- Semester — layers/stack --}}
            <a href="{{ route('semester.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('semester.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17l10 5 10-5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12l10 5 10-5"/>
                </svg>
                {{ __('Semester') }}
            </a>

            {{-- Tahun Ajaran — calendar with star --}}
            <a href="{{ route('tahunajaran.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tahunajaran.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l.5 1.5H14l-1.2.9.5 1.6-1.3-1-1.3 1 .5-1.6L10 13.5h1.5z"/>
                </svg>
                {{ __('Tahun Ajaran') }}
            </a>

            {{-- Tingkatan — bar chart ascending --}}
            <a href="{{ route('tingkatan.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tingkatan.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18"/>
                    <rect x="4" y="13" width="4" height="8" rx="0.5" stroke-width="2"/>
                    <rect x="10" y="9" width="4" height="12" rx="0.5" stroke-width="2"/>
                    <rect x="16" y="5" width="4" height="16" rx="0.5" stroke-width="2"/>
                </svg>
                {{ __('Tingkatan') }}
            </a>

            {{-- Kelas — classroom door --}}
            <a href="{{ route('kelas.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('kelas.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21v-6h6v6"/>
                    <circle cx="12" cy="11" r="1" fill="currentColor"/>
                </svg>
                {{ __('Kelas') }}
            </a>

            {{-- Guru — person with plus (tambah/kelola) --}}
            <a href="{{ route('guru.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('guru.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="3" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a6 6 0 016-6h2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11h6M19 8v6"/>
                </svg>
                {{ __('Guru') }}
            </a>

            {{-- Siswa — group of people --}}
            <a href="{{ route('siswa.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Siswa') }}
            </a>

            {{-- Guru Mapel — person with checkmark --}}
            <a href="{{ route('guru_mapel.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('guru_mapel.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="3" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11l2 2 4-4"/>
                </svg>
                {{ __('Guru Mapel') }}
            </a>

            {{-- Jadwal Belajar — table/grid schedule --}}
            <a href="{{ route('jadwalbelajar.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jadwalbelajar.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-width="2" d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                </svg>
                {{ __('Jadwal Belajar') }}
            </a>

            {{-- Pertemuan — clipboard with list --}}
            <a href="{{ route('pertemuan.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('pertemuan.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 16h4"/>
                </svg>
                {{ __('Pertemuan') }}
            </a>

            {{-- Materi & Tugas --}}
            <a href="{{ route('materi.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('materi.*') || request()->routeIs('tugas.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                {{ __('Materi & Tugas') }}
            </a>

            {{-- Pengumpulan Tugas --}}
            <a href="{{ route('pengumpulan-tugas.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('pengumpulan-tugas.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                {{ __('Pengumpulan Tugas') }}
            </a>

            {{-- Penilaian --}}
            <a href="{{ route('penilaian.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('penilaian.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                {{ __('Penilaian') }}
            </a>

            {{-- Activity Log --}}
            <a href="{{ route('activity-log.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('activity-log.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('Activity Log') }}
            </a>

        </div>

        <!-- User Profile Section -->
        <div class="flex-shrink-0 border-t border-gray-800 px-4 py-4">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 text-left min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <svg class="w-4 h-4 flex-shrink-0 transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <!-- Dropdown Menu (Opens Upward) -->
                <div x-show="dropdownOpen"
                     @click.outside="dropdownOpen = false"
                     x-transition
                     class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg py-2 text-gray-800 z-50">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('Profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition-colors text-sm text-left text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </nav>

    <!-- Mobile Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden fixed bottom-8 right-8 z-40 bg-gray-900 text-white p-3 rounded-full shadow-lg hover:bg-gray-800 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>