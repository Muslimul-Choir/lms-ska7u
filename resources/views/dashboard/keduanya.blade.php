<div class="space-y-5" x-data="{ peranAktif: 'walikelas' }">

    {{-- ── Unified Greeting Panel (Premium UI) ── --}}
    <div class="bg-gradient-to-r from-[#5c1020] to-[#7a1a2e] rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0 ring-4 ring-[#5c1020]/30">
                <span class="text-lg font-bold text-white font-heading">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
            <div>
                <p class="text-white font-semibold text-sm font-heading">Selamat datang kembali, {{ auth()->user()->name }}</p>
                <p class="text-[#fde68a] text-xs mt-0.5">Anda memiliki akses untuk menjadi Walikelas & Pengajar. Silakan pilih mode dashboard di bawah.</p>
            </div>
        </div>
        
        {{-- Badge Status Kelas (Jika ada data wali kelas) --}}
        @if(isset($waliKelasData['kelas']))
            <div class="bg-black/20 border border-white/10 rounded-lg px-3 py-1.5 self-start sm:self-auto text-left sm:text-right">
                <p class="text-[#fde68a] text-[9px] uppercase tracking-widest font-semibold">Wali Kelas Aktif</p>
                <p class="text-white font-bold text-xs font-heading">{{ $waliKelasData['kelas']->nama_kelas }}</p>
            </div>
        @endif
    </div>

    {{-- ── Switcher Peran / Segmented Control (UI/UX Professional) ── --}}
    <div class="bg-slate-100 p-1 rounded-xl grid grid-cols-2 max-w-md mx-auto border border-slate-200/60 shadow-inner">
        {{-- Tombol Wali Kelas --}}
        <button 
            @click="peranAktif = 'walikelas'"
            :class="peranAktif === 'walikelas' 
                ? 'bg-white text-[#1B3A6B] shadow-md font-bold' 
                : 'text-slate-500 hover:text-slate-800 font-medium'"
            class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-xs transition-all duration-200 ease-out font-heading">
            <svg class="w-4 h-4" :class="peranAktif === 'walikelas' ? 'text-amber-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /> 
            </svg>
            <span>Wali Kelas</span>
        </button>

        {{-- Tombol Pengajar --}}
        <button 
            @click="peranAktif = 'pengajar'"
            :class="peranAktif === 'pengajar' 
                ? 'bg-white text-[#5c1020] shadow-md font-bold' 
                : 'text-slate-500 hover:text-slate-800 font-medium'"
            class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-xs transition-all duration-200 ease-out font-heading">
            <svg class="w-4 h-4" :class="peranAktif === 'pengajar' ? 'text-amber-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span>Pengajar</span>
        </button>
    </div>

    {{-- ── Divider Line Efek Kreatif ── --}}
    <div class="relative py-2">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-slate-50 px-3 text-[10px] uppercase font-bold tracking-widest text-slate-400">
                Dashboard <span x-text="peranAktif === 'walikelas' ? 'Wali Kelas' : 'Pengajar'"></span>
            </span>
        </div>
    </div>

    {{-- ── Container View Dashboard ── --}}
    <div class="transition-all duration-300">
        {{-- Section Wali Kelas --}}
        <div x-show="peranAktif === 'walikelas'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-cloak>
            @include('dashboard.walikelas')
        </div>

        {{-- Section Pengajar --}}
        <div x-show="peranAktif === 'pengajar'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-cloak>
            @include('dashboard.guru')
        </div>
    </div>

</div>