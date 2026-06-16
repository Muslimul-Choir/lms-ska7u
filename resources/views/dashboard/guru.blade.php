@php
    $summary = $pengajarData['summary'];
    $jadwal = $pengajarData['jadwal_per_hari'];
    $hariIni = $pengajarData['hari_ini'];
    $tugasDl = $pengajarData['tugas_deadline'];
    $kuisDl = $pengajarData['kuis_deadline'];
    $pending = $pengajarData['pengumpulan_belum_dinilai'];
    $siswaPerKelas = $pengajarData['siswa_per_kelas'];
@endphp

<div class="space-y-5" x-data="{ hariAktif: '{{ $hariIni ?: 'Senin' }}', kelasAktif: null }">

    {{-- ── Greeting ── --}}
    {{-- <div class="bg-gradient-to-r from-[#5c1020] to-[#7a1a2e] rounded-xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
            <span
                class="text-lg font-bold text-white font-heading">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div>
            <p class="text-white font-semibold text-sm font-heading">Selamat datang, {{ auth()->user()->name }}</p>
            <p class="text-[#fde68a] text-xs mt-0.5">Berikut ringkasan aktivitas mengajar Anda hari ini</p>
        </div>
    </div> --}}

    {{-- ══════════════════════════════════════
         BAGIAN ATAS - Summary Cards
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Kelas Diampu</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['total_kelas'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Siswa</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['total_siswa'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Tugas Aktif</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['tugas_aktif'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Belum Dinilai</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $summary['belum_dinilai'] }}</p>
                @if ($summary['belum_dinilai'] > 0)
                    <p class="text-[10px] text-rose-500 font-medium mt-0.5">Perlu perhatian</p>
                @endif
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         BAGIAN TENGAH - Perlu Perhatian
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
                <span
                    class="text-[10px] font-bold px-2 py-1 bg-amber-50 text-amber-600 rounded-full border border-amber-200">
                    {{ $tugasDl->count() + $kuisDl->count() }} item
                </span>
            </div>

            <div class="divide-y divide-slate-50 max-h-72 overflow-y-auto">
                @forelse($tugasDl as $tugas)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">{{ $tugas->judul }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $tugas->Mapel?->nama_mapel ?? 'Mapel tidak ditemukan' }} ·
                                {{ $tugas->Pertemuan->JadwalBelajar->Kelas->nama_kelas ?? 'Kelas tidak ditemukan' }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span
                                class="text-[10px] font-bold px-2 py-1 rounded-full
                                {{ $tugas->sisa_hari <= 1 ? 'bg-rose-50 text-rose-600 border border-rose-200' : ($tugas->sisa_hari <= 3 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                {{ $tugas->sisa_hari === 0 ? 'Hari ini' : $tugas->sisa_hari . ' hari' }}
                            </span>
                        </div>
                    </div>
                @empty
                @endforelse

                @forelse($kuisDl as $kuis)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">{{ $kuis->judul }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? 'Mapel tidak ditemukan' }} ·
                                {{ $kuis->Pertemuan->JadwalBelajar->Kelas->nama_kelas ?? 'Kelas tidak ditemukan' }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span
                                class="text-[10px] font-bold px-2 py-1 rounded-full
                                {{ $kuis->sisa_hari <= 1 ? 'bg-rose-50 text-rose-600 border border-rose-200' : ($kuis->sisa_hari <= 3 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                {{ $kuis->sisa_hari === 0 ? 'Hari ini' : $kuis->sisa_hari . ' hari' }}
                            </span>
                        </div>
                    </div>
                @empty
                @endforelse

                @if ($tugasDl->isEmpty() && $kuisDl->isEmpty())
                    <div class="px-5 py-10 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                @if ($pending->count() > 0)
                    <span
                        class="text-[10px] font-bold px-2 py-1 bg-rose-50 text-rose-600 rounded-full border border-rose-200">
                        {{ $summary['belum_dinilai'] }} total
                    </span>
                @endif
            </div>

            <div class="divide-y divide-slate-50 max-h-72 overflow-y-auto">
                @forelse($pending as $p)
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <span
                                class="text-[10px] font-bold text-slate-500">{{ strtoupper(substr($p->Siswa?->nama_lengkap ?? '?', 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-[#0F2145] truncate">
                                {{ $p->Siswa?->nama_lengkap ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5 truncate">{{ $p->Tugas?->judul ?? '-' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-[10px] text-slate-400">{{ $p->created_at->diffForHumans() }}</p>
                            <a href="{{ route('tugas.rekap', $p->Tugas) }}"
                                class="text-[10px] font-semibold text-amber-600 hover:text-amber-700 mt-0.5 block">
                                Rekap →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs text-slate-400">Semua pengumpulan sudah dinilai</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         BAGIAN BAWAH - Jadwal Minggu Ini
    ══════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Jadwal Mengajar Minggu Ini</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ now()->startOfWeek()->format('d M') }} –
                    {{ now()->endOfWeek()->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Tab Hari --}}
        <div class="flex gap-1.5 p-4 border-b border-slate-100 overflow-x-auto">
            @foreach ($jadwal as $hari => $data)
                <button @click="hariAktif = '{{ $hari }}'"
                    :class="hariAktif === '{{ $hari }}'
                        ?
                        '{{ $data['aktif'] ? 'bg-[#5c1020]' : 'bg-[#1B3A6B]' }} text-white border-transparent' :
                        '{{ $data['aktif'] ? 'border-amber-400 text-amber-600 bg-amber-50' : 'border-slate-200 text-slate-500 bg-white hover:border-slate-300' }}'"
                    class="flex-shrink-0 px-3 py-2 rounded-lg text-xs font-semibold border transition-all duration-150 flex items-center gap-1.5">
                    {{ $hari }}
                    @if ($data['aktif'])
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                    @endif
                    <span class="text-[10px] opacity-70">({{ $data['jadwal']->count() }})</span>
                </button>
            @endforeach
        </div>

        {{-- Isi Jadwal per Hari --}}
        @foreach ($jadwal as $hari => $data)
            <div x-show="hariAktif === '{{ $hari }}'" x-cloak class="p-5">
                @if ($data['jadwal']->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($data['jadwal'] as $j)
                            <div
                                class="flex items-center gap-4 p-3.5 rounded-lg border {{ $data['aktif'] ? 'border-amber-200 bg-amber-50' : 'border-slate-100 bg-slate-50' }} transition-colors">
                                {{-- Jam --}}
                                <div class="text-center flex-shrink-0 w-16">
                                    <p class="text-xs font-bold text-[#0F2145]">
                                        {{ $j->JamBelajar ? \Carbon\Carbon::parse($j->JamBelajar->jam_mulai)->format('H:i') : '-' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400">
                                        {{ $j->JamBelajar ? \Carbon\Carbon::parse($j->JamBelajar->jam_selesai)->format('H:i') : '' }}
                                    </p>
                                </div>
                                {{-- Divider --}}
                                <div class="w-px h-8 bg-slate-200 flex-shrink-0"></div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-[#0F2145] truncate">
                                        {{ $j->nama_kegiatan ?? ($j->Mapel?->nama_mapel ?? '-') }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->Kelas?->nama_kelas ?? '-' }}
                                    </p>
                                </div>
                                @if ($data['aktif'])
                                    <span
                                        class="flex-shrink-0 text-[10px] font-bold px-2 py-1 bg-amber-500 text-white rounded-full">Hari
                                        ini</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center">
                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <p class="text-xs text-slate-400">Tidak ada jadwal hari {{ $hari }}</p>
                    </div>
                @endif
            </div>
        @endforeach

    </div>

    {{-- ══════════════════════════════════════
         DAFTAR SISWA PER KELAS
    ══════════════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Daftar Siswa yang Diajar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Statistik siswa per kelas</p>
            </div>
        </div>

        @if(count($siswaPerKelas) > 0)
            <div class="divide-y divide-slate-100">
                @foreach($siswaPerKelas as $index => $data)
                    <div class="border-b border-slate-100 last:border-b-0">
                        {{-- Header Kelas (Clickable) --}}
                        <button 
                            @click="kelasAktif = kelasAktif === {{ $index }} ? null : {{ $index }}"
                            class="w-full px-5 py-4 flex items-center gap-3 hover:bg-slate-50 transition-colors text-left"
                        >
                            {{-- Icon Kelas --}}
                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>

                            {{-- Info Kelas --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[#0F2145]">{{ $data['kelas']->nama_kelas }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $data['kelas']->Tingkatan->nama_tingkatan ?? '' }} 
                                    {{ $data['kelas']->Jurusan->nama_jurusan ?? '' }} 
                                    {{ $data['kelas']->Bagian->nama_bagian ?? '' }}
                                    · {{ $data['total_siswa'] }} siswa
                                </p>
                            </div>

                            {{-- Icon Expand/Collapse --}}
                            <div class="flex-shrink-0 transition-transform" :class="kelasAktif === {{ $index }} ? 'rotate-180' : ''">
                                <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        {{-- Content Siswa (Collapsible) --}}
                        <div x-show="kelasAktif === {{ $index }}" x-collapse x-cloak>
                            <div class="px-5 pb-4">
                                @if(count($data['siswa_stats']) > 0)
                                    <div class="space-y-2">
                                        @foreach($data['siswa_stats'] as $stat)
                                            <div class="p-3 rounded-lg border border-slate-100 bg-slate-50">
                                                {{-- Nama Siswa --}}
                                                <div class="flex items-center gap-2 mb-2">
                                                    <div class="w-7 h-7 rounded-full bg-[#5c1020] flex items-center justify-center flex-shrink-0">
                                                        <span class="text-[10px] font-bold text-white">
                                                            {{ strtoupper(substr($stat['siswa']->nama_lengkap, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <p class="text-xs font-semibold text-[#0F2145]">{{ $stat['siswa']->nama_lengkap }}</p>
                                                </div>

                                                {{-- Statistik Grid --}}
                                                <div class="grid grid-cols-2 lg:grid-cols-6 gap-2">
                                                    {{-- Total Tugas --}}
                                                    <div class="bg-white rounded-lg px-2 py-1.5 border border-slate-200">
                                                        <p class="text-[9px] text-slate-400 uppercase tracking-wide mb-0.5">Total Tugas</p>
                                                        <p class="text-sm font-bold text-[#0F2145]">{{ $stat['total_tugas'] }}</p>
                                                    </div>

                                                    {{-- Sudah Kumpul --}}
                                                    <div class="bg-emerald-50 rounded-lg px-2 py-1.5 border border-emerald-200">
                                                        <p class="text-[9px] text-emerald-600 uppercase tracking-wide mb-0.5 flex items-center gap-1">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Kumpul
                                                        </p>
                                                        <p class="text-sm font-bold text-emerald-600">{{ $stat['sudah_kumpul'] }}</p>
                                                    </div>

                                                    {{-- Belum Kumpul --}}
                                                    <div class="bg-rose-50 rounded-lg px-2 py-1.5 border border-rose-200">
                                                        <p class="text-[9px] text-rose-600 uppercase tracking-wide mb-0.5 flex items-center gap-1">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Belum
                                                        </p>
                                                        <p class="text-sm font-bold text-rose-600">{{ $stat['belum_kumpul'] }}</p>
                                                    </div>

                                                    {{-- Terlambat --}}
                                                    <div class="bg-amber-50 rounded-lg px-2 py-1.5 border border-amber-200">
                                                        <p class="text-[9px] text-amber-600 uppercase tracking-wide mb-0.5 flex items-center gap-1">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Telat
                                                        </p>
                                                        <p class="text-sm font-bold text-amber-600">{{ $stat['terlambat'] }}</p>
                                                    </div>

                                                    {{-- Sudah Dinilai --}}
                                                    <div class="bg-violet-50 rounded-lg px-2 py-1.5 border border-violet-200">
                                                        <p class="text-[9px] text-violet-600 uppercase tracking-wide mb-0.5 flex items-center gap-1">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                            Dinilai
                                                        </p>
                                                        <p class="text-sm font-bold text-violet-600">{{ $stat['sudah_dinilai'] }}</p>
                                                    </div>

                                                    {{-- Rata-rata Nilai --}}
                                                    <div class="bg-blue-50 rounded-lg px-2 py-1.5 border border-blue-200">
                                                        <p class="text-[9px] text-blue-600 uppercase tracking-wide mb-0.5 flex items-center gap-1">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Rata²
                                                        </p>
                                                        <p class="text-sm font-bold text-blue-600">
                                                            @if($stat['rata_rata'] > 0)
                                                                {{ $stat['rata_rata'] }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-6 text-center">
                                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        <p class="text-xs text-slate-400">Tidak ada siswa di kelas ini</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-5 py-10 text-center">
                <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-sm text-slate-400 font-medium">Tidak ada siswa yang diajar</p>
                <p class="text-xs text-slate-400 mt-1">Siswa akan muncul setelah ada kelas yang diajar</p>
            </div>
        @endif
    </div>

</div>
