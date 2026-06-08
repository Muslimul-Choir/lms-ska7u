@php
    $summary  = $pengajarData['summary'];
    $jadwal   = $pengajarData['jadwal_per_hari'];
    $hariIni  = $pengajarData['hari_ini'];
    $tugasDl  = $pengajarData['tugas_deadline'];
    $kuisDl   = $pengajarData['kuis_deadline'];
    $pending  = $pengajarData['pengumpulan_belum_dinilai'];
@endphp

<div class="space-y-5" x-data="{ hariAktif: '{{ $hariIni ?: 'Senin' }}' }">

    {{-- ── Greeting ── --}}
    <div class="bg-gradient-to-r from-[#5c1020] to-[#7a1a2e] rounded-xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
            <span class="text-lg font-bold text-white font-heading">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div>
            <p class="text-white font-semibold text-sm font-heading">Selamat datang, {{ auth()->user()->name }}</p>
            <p class="text-[#fde68a] text-xs mt-0.5">Berikut ringkasan aktivitas mengajar Anda hari ini</p>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BAGIAN ATAS — Summary Cards
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Kelas Diampu</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['total_kelas'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Siswa</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['total_siswa'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Tugas Aktif</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['tugas_aktif'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Belum Dinilai</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['belum_dinilai'] }}</p>
                @if($summary['belum_dinilai'] > 0)
                    <p class="text-[10px] text-rose-500 font-medium mt-0.5">Perlu perhatian</p>
                @endif
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         BAGIAN TENGAH — Perlu Perhatian
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Kiri: Tugas & Kuis Mendekati Deadline --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div class="flex-1">
                    <h3 class="font-semibold text-sm text-[#0F2145]">Mendekati Deadline</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tugas & kuis dalam 7 hari ke depan</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-1 bg-amber-50 text-amber-600 rounded-full border border-amber-200">
                    {{ $tugasDl->count() + $kuisDl->count() }} item
                </span>
            </div>

            <div class="divide-y divide-slate-50 max-h-72 overflow-y-auto">
                @forelse($tugasDl as $tugas)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">{{ $tugas->judul }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $tugas->Mapel?->nama_mapel ?? '-' }} · {{ $tugas->GuruMapel?->Kelas?->nama_kelas ?? '-' }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-[10px] font-bold px-2 py-1 rounded-full
                                {{ $tugas->sisa_hari <= 1 ? 'bg-rose-50 text-rose-600 border border-rose-200' : ($tugas->sisa_hari <= 3 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                {{ $tugas->sisa_hari === 0 ? 'Hari ini' : $tugas->sisa_hari . ' hari' }}
                            </span>
                        </div>
                    </div>
                @empty @endforelse

                @forelse($kuisDl as $kuis)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">{{ $kuis->judul }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }} · {{ $kuis->GuruMapel?->Kelas?->nama_kelas ?? '-' }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-[10px] font-bold px-2 py-1 rounded-full
                                {{ $kuis->sisa_hari <= 1 ? 'bg-rose-50 text-rose-600 border border-rose-200' : ($kuis->sisa_hari <= 3 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                {{ $kuis->sisa_hari === 0 ? 'Hari ini' : $kuis->sisa_hari . ' hari' }}
                            </span>
                        </div>
                    </div>
                @empty @endforelse

                @if($tugasDl->isEmpty() && $kuisDl->isEmpty())
                    <div class="px-5 py-10 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-slate-400">Tidak ada deadline dalam 7 hari ke depan</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kanan: Pengumpulan Belum Dinilai --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-rose-500 flex-shrink-0"></span>
                <div class="flex-1">
                    <h3 class="font-semibold text-sm text-[#0F2145]">Belum Dinilai</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pengumpulan tugas menunggu penilaian</p>
                </div>
                @if($pending->count() > 0)
                    <span class="text-[10px] font-bold px-2 py-1 bg-rose-50 text-rose-600 rounded-full border border-rose-200">
                        {{ $summary['belum_dinilai'] }} total
                    </span>
                @endif
            </div>

            <div class="divide-y divide-slate-50 max-h-72 overflow-y-auto">
                @forelse($pending as $p)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-[10px] font-bold text-slate-500">{{ strtoupper(substr($p->Siswa?->nama_lengkap ?? '?', 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">{{ $p->Siswa?->nama_lengkap ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5 truncate">{{ $p->Tugas?->judul ?? '-' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-[10px] text-slate-400">{{ $p->created_at->diffForHumans() }}</p>
                            <a href="{{ route('penilaian.index') }}"
                               class="text-[10px] font-semibold text-amber-600 hover:text-amber-700 mt-0.5 block">
                                Nilai →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-slate-400">Semua pengumpulan sudah dinilai</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         BAGIAN BAWAH — Jadwal Minggu Ini
    ══════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Jadwal Mengajar Minggu Ini</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ now()->startOfWeek()->format('d M') }} – {{ now()->endOfWeek()->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Tab Hari --}}
        <div class="flex gap-1.5 p-4 border-b border-slate-100 overflow-x-auto">
            @foreach($jadwal as $hari => $data)
                <button
                    @click="hariAktif = '{{ $hari }}'"
                    :class="hariAktif === '{{ $hari }}'
                        ? '{{ $data['aktif'] ? 'bg-[#5c1020]' : 'bg-[#1B3A6B]' }} text-white border-transparent'
                        : '{{ $data['aktif'] ? 'border-amber-400 text-amber-600 bg-amber-50' : 'border-slate-200 text-slate-500 bg-white hover:border-slate-300' }}'"
                    class="flex-shrink-0 px-3 py-2 rounded-lg text-xs font-semibold border transition-all duration-150 flex items-center gap-1.5">
                    {{ $hari }}
                    @if($data['aktif'])
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                    @endif
                    <span class="text-[10px] opacity-70">({{ $data['jadwal']->count() }})</span>
                </button>
            @endforeach
        </div>

        {{-- Isi Jadwal per Hari --}}
        @foreach($jadwal as $hari => $data)
            <div x-show="hariAktif === '{{ $hari }}'" x-cloak class="p-5">
                @if($data['jadwal']->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($data['jadwal'] as $j)
                            <div class="flex items-center gap-4 p-3.5 rounded-lg border {{ $data['aktif'] ? 'border-amber-200 bg-amber-50' : 'border-slate-100 bg-slate-50' }} transition-colors">
                                {{-- Jam --}}
                                <div class="text-center flex-shrink-0 w-16">
                                    <p class="text-xs font-bold text-[#0F2145]">{{ $j->JamBelajar ? \Carbon\Carbon::parse($j->JamBelajar->jam_mulai)->format('H:i') : '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $j->JamBelajar ? \Carbon\Carbon::parse($j->JamBelajar->jam_selesai)->format('H:i') : '' }}</p>
                                </div>
                                {{-- Divider --}}
                                <div class="w-px h-8 bg-slate-200 flex-shrink-0"></div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-[#0F2145] truncate">
                                        {{ $j->nama_kegiatan ?? $j->Mapel?->nama_mapel ?? '-' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->Kelas?->nama_kelas ?? '-' }}</p>
                                </div>
                                @if($data['aktif'])
                                    <span class="flex-shrink-0 text-[10px] font-bold px-2 py-1 bg-amber-500 text-white rounded-full">Hari ini</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        <p class="text-xs text-slate-400">Tidak ada jadwal hari {{ $hari }}</p>
                    </div>
                @endif
            </div>
        @endforeach

    </div>

</div>