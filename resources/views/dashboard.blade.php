<x-app-layout>
    <x-slot name="header">
        @php
            $role   = auth()->user()->role;
            $status = auth()->user()->guru?->status_pengajar ?? null;
        @endphp

        @if(in_array($role, ['admin', 'super_admin']))
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[16px] text-[#0F2145] leading-none">Dashboard Admin</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5 uppercase tracking-widest">Ringkasan Data Sistem</p>
                </div>
            </div>

        @elseif($status === 'keduanya')
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[16px] text-[#0F2145] leading-none">Dashboard</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5 uppercase tracking-widest">Pengajar & Wali Kelas</p>
                </div>
            </div>

        @elseif($status === 'walikelas')
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[16px] text-[#0F2145] leading-none">Dashboard</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5 uppercase tracking-widest">Wali Kelas</p>
                </div>
            </div>

        @else
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[16px] text-[#0F2145] leading-none">Dashboard</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5 uppercase tracking-widest">Ringkasan Aktivitas Mengajar</p>
                </div>
            </div>
        @endif
    </x-slot>

    @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
        @include('dashboard.admin')

    @elseif(isset($isKeduanya) && $isKeduanya)
        @include('dashboard.keduanya')

    @elseif(isset($isWaliKelas) && $isWaliKelas)
        @include('dashboard.walikelas')

    @else
        @include('dashboard.guru')
    @endif

</x-app-layout>