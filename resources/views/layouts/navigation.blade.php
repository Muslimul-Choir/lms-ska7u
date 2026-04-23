<!-- Sidebar Navigation -->
<nav x-data="{ sidebarOpen: true }" class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white z-50 transition-transform duration-300 ease-in-out"
     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-8 w-auto fill-current text-white" />
        </a>
        <!-- Close Button (Mobile) -->
        <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-6">
        <div class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4m0-11l-4-2m4 2l4-2"></path>
                </svg>
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('bagian.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('bagian.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                {{ __('Bagian') }}
            </a>

            <a href="{{ route('mapel.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('mapel.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                {{ __('Mapel') }}
            </a>

            <a href="{{ route('jambelajar.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jambelajar.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Jam Belajar') }}
            </a>

            <a href="{{ route('jurusan.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('jurusan.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                {{ __('Jurusan') }}
            </a>

            <a href="{{ route('semester.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('semester.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ __('Semester') }}
            </a>

            <a href="{{ route('tahunajaran.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tahunajaran.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Tahun Ajaran') }}
            </a>

            <a href="{{ route('tingkatan.index') }}" class="block px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('tingkatan.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <svg class="inline-block w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                {{ __('Tingkatan') }}
            </a>
        </div>
    </div>

    <!-- User Profile Section -->
    <div class="border-t border-gray-800 px-4 py-4">
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <div class="text-left">
                    <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu (Opens Upward) -->
            <div x-show="dropdownOpen" 
                 @click.outside="dropdownOpen = false"
                 x-transition
                 class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg py-2 text-gray-800 z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 transition-colors">
                    {{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 transition-colors">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Toggle Button -->
<button x-data="{ sidebarOpen: true }" @click="sidebarOpen = !sidebarOpen" class="md:hidden fixed bottom-8 right-8 z-40 bg-gray-900 text-white p-3 rounded-full shadow-lg hover:bg-gray-800 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>