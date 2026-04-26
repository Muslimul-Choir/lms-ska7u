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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="9 22 9 12 15 12 15 22"/>
                </svg>
                {{ __('Dashboard') }}
            </a>

            {{-- Bagian --}}
            <a href="{{ route('bagian.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('bagian.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                {{ __('Bagian') }}
            </a>

            {{-- Mapel --}}
            <a href="{{ route('mapel.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('mapel.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.833 5.083 8.5 4.5 6 5v13c2.5-.5 4.833.083 6 1.253m0-13C13.167 5.083 15.5 4.5 18 5v13c-2.5-.5-4.833.083-6 1.253"/>
                </svg>
                {{ __('Mapel') }}
            </a>

            {{-- Jam Belajar --}}
            <a href="{{ route('jambelajar.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jambelajar.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/>
                </svg>
                {{ __('Jam Belajar') }}
            </a>

            {{-- Jurusan --}}
            <a href="{{ route('jurusan.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jurusan.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-4-2c0 1.1 1.8 2 4 2s4-.9 4-2"/>
                </svg>
                {{ __('Jurusan') }}
            </a>

            {{-- Semester --}}
            <a href="{{ route('semester.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('semester.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round" stroke-width="2"/>
                    <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round" stroke-width="2"/>
                    <line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round" stroke-width="2"/>
                </svg>
                {{ __('Semester') }}
            </a>

            {{-- Tahun Ajaran --}}
            <a href="{{ route('tahunajaran.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tahunajaran.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                {{ __('Tahun Ajaran') }}
            </a>

            {{-- Tingkatan --}}
            <a href="{{ route('tingkatan.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tingkatan.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18h2v-6H3v6zm4 0h2V6H7v12zm4 0h2v-4h-2v4zm4 0h2V9h-2v9zm4 0h2V3h-2v15z"/>
                </svg>
                {{ __('Tingkatan') }}
            </a>

            {{-- Kelas --}}
            <a href="{{ route('kelas.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('kelas.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Kelas') }}
            </a>

            {{-- Guru --}}
            <a href="{{ route('guru.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('guru.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Guru') }}
            </a>
            {{-- siswa --}}
            <a href="{{ route('siswa.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Siswa') }}
            </a>

            {{-- Guru Mapel --}}
            <a href="{{ route('guru_mapel.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('guru_mapel.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.833 5.083 8.5 4.5 6 5v13c2.5-.5 4.833.083 6 1.253m0-13C13.167 5.083 15.5 4.5 18 5v13c-2.5-.5-4.833.083-6 1.253"/>
                </svg>
                {{ __('Guru Mapel') }}
            </a>

             {{-- Jadwal Belajar --}}
            <a href="{{ route('jadwalbelajar.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jadwalbelajar.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.833 5.083 8.5 4.5 6 5v13c2.5-.5 4.833.083 6 1.253m0-13C13.167 5.083 15.5 4.5 18 5v13c-2.5-.5-4.833.083-6 1.253"/>
                </svg>
                {{ __('Jadwal Belajar') }}
            </a>

        </div>

        <!-- User Profile Section (Fixed / tidak scroll) -->
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