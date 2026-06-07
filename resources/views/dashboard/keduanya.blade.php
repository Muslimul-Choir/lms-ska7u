<div class="space-y-5">

    {{-- ══════════════════════════════════════
         SECTION WALI KELAS
    ══════════════════════════════════════ --}}
    <div class="flex items-center gap-3 pt-2">
        <div class="flex-1 h-px bg-slate-200"></div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-[#1B3A6B] rounded-full">
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-[11px] font-bold uppercase tracking-widest text-amber-400">Sebagai Wali Kelas</span>
        </div>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    {{-- Render section walikelas --}}
    @include('dashboard.walikelas')

      {{-- ══════════════════════════════════════
         SECTION PENGAJAR
    ══════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-slate-200"></div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-[#5c1020] rounded-full">
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="7" r="3"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a6 6 0 016-6h2M16 11h6M19 8v6"/>
            </svg>
            <span class="text-[11px] font-bold uppercase tracking-widest text-amber-400">Sebagai Pengajar</span>
        </div>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    {{-- Render section pengajar --}}
    @include('dashboard.guru')

</div>