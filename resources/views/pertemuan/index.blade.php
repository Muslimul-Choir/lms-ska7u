<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Master Pertemuan</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Pertemuan</h3>
                        <p class="text-gray-400 text-xs mt-0.5">
                            @if($isGuru)
                                Pertemuan yang Anda buat
                            @else
                                {{-- Badge read-only untuk admin & super_admin --}}
                                <span class="inline-flex items-center gap-1 text-gray-500">
                                    {{-- <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg> --}}
                                    Mode Lihat Saja — kelola data pertemuan semua guru
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-2">

                        {{-- Tombol Arsip — guru: selalu tampil (kecuali walikelas), admin/super_admin: selalu tampil --}}
                        @if($isGuru && !$isWaliKelasOnly)
                            <a href="{{ route('pertemuan.trash') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Arsip
                                @if(isset($trashCount) && $trashCount > 0)
                                    <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                                @endif
                            </a>
                        @elseif(!$isGuru)
                            {{-- admin & super_admin: tombol arsip ada tapi read-only (hanya lihat) --}}
                            {{-- <a href="{{ route('pertemuan.trash') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Arsip
                                @if(isset($trashCount) && $trashCount > 0)
                                    <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                                @endif
                            </a> --}}
                        @endif

                        {{-- Tombol Tambah: HANYA guru pengajar (bukan walikelas) --}}
                        @if($isGuru && !$isWaliKelasOnly)
                            <button type="button" onclick="openCreateModal()"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Pertemuan
                            </button>
                        @endif

                        {{-- Badge read-only untuk admin & super_admin --}}
                        @if(!$isGuru)
                            <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-50 text-blue-600 text-xs font-semibold rounded-xl border border-blue-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Read Only
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Search --}}
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ $search ?? '' }}"
                                placeholder="Cari nomor / tanggal..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Filter Guru — hanya untuk admin & super_admin --}}
                        @if(!$isGuru)
                            <select id="guruSelect"
                                class="rounded-xl border min-w-[160px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                                <option value="">Semua Guru</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ (isset($idGuruFilter) && $idGuruFilter == $guru->id) ? 'selected' : '' }}>
                                        {{ $guru->user->name ?? ('Guru #' . $guru->id) }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        {{-- Filter Status --}}
                        <select id="statusSelect"
                            class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="">Semua Status</option>
                            <option value="dijadwalkan" {{ ($statusFilter ?? '') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                            <option value="berlangsung" {{ ($statusFilter ?? '') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="selesai"     {{ ($statusFilter ?? '') == 'selesai'     ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan"  {{ ($statusFilter ?? '') == 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if($search || ($statusFilter ?? null) || (isset($idGuruFilter) && $idGuruFilter))
                            <a href="{{ route('pertemuan.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                {{-- ============================================================
                     TAMPILAN ACCORDION — Admin & Super Admin (READ ONLY)
                     Tidak ada tombol Edit & Hapus
                ============================================================ --}}
                @if(!$isGuru)
                    <div class="divide-y divide-gray-100" x-data>

                        {{-- Banner read-only --}}
                        <div class="px-6 py-3 bg-blue-50 border-b border-blue-100 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-blue-600">
                                Anda memiliki akses <strong>lihat saja</strong>. Pengelolaan data pertemuan hanya dapat dilakukan oleh masing-masing guru.
                            </p>
                        </div>

                        @forelse($pertemuanByGuru as $guruId => $group)
                            @php
                                $guruModel  = $group['guru'];
                                $guruUser   = $group['guruUser'] ?? $guruModel?->user;
                                $namaGuru   = $guruUser?->name ?? ('Guru #' . $guruId);
                                $items      = $group['pertemuans'];

                                $words    = explode(' ', trim($namaGuru));
                                $initials = '';
                                foreach (array_slice($words, 0, 2) as $w) {
                                    $initials .= strtoupper($w[0] ?? '');
                                }

                                $avatarClasses = [
                                    'bg-amber-100 text-amber-700',
                                    'bg-blue-100 text-blue-700',
                                    'bg-emerald-100 text-emerald-700',
                                    'bg-pink-100 text-pink-700',
                                    'bg-purple-100 text-purple-700',
                                ];
                                $avatarClass = $avatarClasses[$loop->index % count($avatarClasses)];

                                $mapelNama = $guruModel?->guruMapel?->first()?->mapel?->nama_mapel ?? null;
                            @endphp

                            <div x-data="{ open: false }"
                                class="accordion-guru-item"
                                data-guru-index="{{ $loop->index }}">

                                {{-- Accordion Header --}}
                                <div @click="open = !open"
                                    :class="open ? 'bg-amber-50/40' : ''"
                                    class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-amber-50/40 transition select-none group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $avatarClass }} flex items-center justify-center font-bold text-sm flex-shrink-0 border border-white shadow-sm">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 group-hover:text-amber-700 transition leading-none">
                                                {{ $namaGuru }}
                                            </p>
                                            <p class="text-[11px] text-gray-400 mt-1">
                                                @if($mapelNama)
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                        {{ $mapelNama }} ·
                                                    </span>
                                                @endif
                                                {{ $items->count() }} pertemuan
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500">
                                            {{ $items->count() }} Item
                                        </span>
                                        <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 group-hover:bg-amber-100 group-hover:text-amber-600 transition">
                                            <svg class="w-4 h-4 transition-transform duration-300"
                                                :class="{ 'rotate-180': open }"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Accordion Body (read-only: kolom Aksi dihilangkan) --}}
                                <div x-show="open" x-transition.opacity
                                    class="border-t border-gray-100 bg-white">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm">
                                            <thead>
                                                <tr class="bg-gray-50/70 border-b border-gray-100">
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest w-12">#</th>
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jadwal Belajar</th>
                                                    <th class="px-6 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-28">No. Pertemuan</th>
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                                                    <th class="px-6 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-28">Status</th>
                                                    {{-- Tidak ada kolom Aksi untuk admin/super_admin --}}
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @forelse($items as $i => $pertemuan)
                                                    <tr class="hover:bg-blue-50/20 transition">
                                                        <td class="px-6 py-3 text-gray-400 text-xs font-mono">
                                                            {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <div class="font-semibold text-gray-800 text-sm">
                                                                        {{ $pertemuan->jadwalBelajar->Mapel->nama_mapel ?? '-' }}
                                                                    </div>
                                                                    <div class="text-xs text-gray-500 mt-1">
                                                                        {{ $pertemuan->jadwalBelajar->Kelas->Tingkatan->nama_tingkatan ?? '' }}
                                                                        {{ $pertemuan->jadwalBelajar->Kelas->Jurusan->nama_jurusan ?? '' }}
                                                                        {{ $pertemuan->jadwalBelajar->Kelas->Bagian->nama_bagian ?? '' }}
                                                                        • {{ $pertemuan->jadwalBelajar->hari ?? '-' }}
                                                                        • {{ \Carbon\Carbon::parse($pertemuan->jadwalBelajar->JamBelajar->jam_mulai ?? '00:00')->format('H:i') }}
                                                                        - {{ \Carbon\Carbon::parse($pertemuan->jadwalBelajar->JamBelajar->jam_selesai ?? '00:00')->format('H:i') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-3 text-center">
                                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                                                {{ $pertemuan->nomor_pertemuan }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-3 text-gray-600 text-xs">
                                                            @if($pertemuan->tanggal)
                                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                                            @else
                                                                <span class="text-gray-300 italic">Belum ditentukan</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-3 text-center">
                                                            @include('pertemuan._status-badge', ['status' => $pertemuan->status])
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="px-6 py-6 text-center text-xs text-gray-400 italic">
                                                            Belum ada pertemuan dari guru ini.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm font-semibold">Belum ada data pertemuan</p>
                                    <p class="text-gray-300 text-xs">Belum ada guru yang membuat pertemuan.</p>
                                </div>
                            </div>
                        @endforelse

                        {{-- Load More Guru --}}
                        @if($pertemuanByGuru->count() > 5)
                            <div id="loadMoreContainer"
                                class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p id="loadMoreInfo" class="text-xs text-gray-400 order-2 sm:order-1"></p>
                                <button type="button" id="btnLoadMore"
                                    class="order-1 sm:order-2 inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-amber-50 text-amber-600 text-xs font-semibold rounded-xl border border-amber-200 hover:border-amber-400 transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                    Muat 5 Guru Berikutnya
                                </button>
                            </div>
                        @endif

                    </div>

                {{-- ============================================================
                     TAMPILAN TABEL — Guru (CRUD penuh, 5 per halaman)
                ============================================================ --}}
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Jadwal Belajar</th>
                                    <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">No. Pertemuan</th>
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">Status</th>
                                    @unless($isWaliKelasOnly)
                                      <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                                    @endunless
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">

                                @if($jadwalBelajars->isEmpty())
                                    <tr>
                                        <td colspan="6" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <p class="text-blue-600 text-sm font-semibold">Belum Ada Jadwal yang Ditugaskan</p>
                                                <p class="text-blue-400 text-xs max-w-xs">Anda belum diassign ke mapel apapun. Hubungi administrator untuk diassign mengajar di kelas-kelas tertentu.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @forelse($pertemuans as $pertemuan)
                                        <tr class="hover:bg-amber-50/40 transition">
                                            <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                                {{ str_pad($loop->iteration + ($pertemuans->currentPage() - 1) * $pertemuans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-800 text-sm">
                                                            {{ $pertemuan->jadwalBelajar->Mapel->nama_mapel ?? '-' }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            {{ $pertemuan->jadwalBelajar->Kelas->Tingkatan->nama_tingkatan ?? '' }}
                                                            {{ $pertemuan->jadwalBelajar->Kelas->Jurusan->nama_jurusan ?? '' }}
                                                            {{ $pertemuan->jadwalBelajar->Kelas->Bagian->nama_bagian ?? '' }}
                                                            • {{ $pertemuan->jadwalBelajar->hari ?? '-' }}
                                                            • {{ \Carbon\Carbon::parse($pertemuan->jadwalBelajar->JamBelajar->jam_mulai ?? '00:00')->format('H:i') }}
                                                            - {{ \Carbon\Carbon::parse($pertemuan->jadwalBelajar->JamBelajar->jam_selesai ?? '00:00')->format('H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                                    {{ $pertemuan->nomor_pertemuan }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 text-sm">
                                                @if($pertemuan->tanggal)
                                                    {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                                @else
                                                    <span class="text-gray-300 italic text-xs">Belum ditentukan</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @include('pertemuan._status-badge', ['status' => $pertemuan->status])
                                            </td>
                                            @unless($isWaliKelasOnly)
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <button type="button"
                                                        onclick="openEditModal(this)"
                                                        data-id="{{ $pertemuan->id }}"
                                                        data-route="{{ route('pertemuan.update', $pertemuan->id) }}"
                                                        data-id-jadwal="{{ $pertemuan->id_jadwal }}"
                                                        data-nomor-pertemuan="{{ $pertemuan->nomor_pertemuan }}"
                                                        data-tanggal="{{ $pertemuan->tanggal ?? '' }}"
                                                        data-status="{{ $pertemuan->status }}"
                                                        title="Edit"
                                                        class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('pertemuan.destroy', $pertemuan->id) }}" method="POST"
                                                        onsubmit="return confirmDelete(event)">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" title="Hapus"
                                                            class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            @endunless
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $isWaliKelasOnly ? 5 : 6 }}" class="px-6 py-20 text-center">
                                                <div class="flex flex-col items-center gap-3">
                                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                        </svg>
                                                    </div>
                                                    <p class="text-gray-400 text-sm font-semibold">Belum ada data pertemuan</p>
                                                    @unless($isWaliKelasOnly)
                                                    <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Pertemuan</span> untuk mulai menambahkan</p>
                                                    <button type="button" onclick="openCreateModal()"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                        Tambah Pertemuan
                                                    </button>
                                                    @endunless
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif

                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination untuk guru --}}
                    @if($pertemuans->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-gray-500">
                                Menampilkan
                                <span class="font-semibold text-gray-700">{{ $pertemuans->firstItem() }}–{{ $pertemuans->lastItem() }}</span>
                                dari
                                <span class="font-semibold text-gray-700">{{ $pertemuans->total() }}</span>
                                entri
                                <span class="text-gray-400">(5 per halaman)</span>
                            </p>
                            {{ $pertemuans->links() }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')

    {{-- Modal hanya di-include jika user adalah guru (bukan walikelas) --}}
    @if($isGuru && !$isWaliKelasOnly)
        @include('pertemuan.modal-create')
        @include('pertemuan.modal-edit')
    @endif

    @push('scripts')
    <script>
        // ── Filter & Search ──────────────────────────────────────────────
        const searchInput  = document.getElementById('searchInput');
        const guruSelect   = document.getElementById('guruSelect');
        const statusSelect = document.getElementById('statusSelect');
        const btnSearch    = document.getElementById('btnSearch');

        function getSearchUrl() {
            const params = new URLSearchParams();
            if (searchInput  && searchInput.value.trim())  params.append('search',   searchInput.value.trim());
            if (guruSelect   && guruSelect.value)           params.append('id_guru',  guruSelect.value);
            if (statusSelect && statusSelect.value)         params.append('status',   statusSelect.value);
            return `{{ route('pertemuan.index') }}?${params.toString()}`;
        }

        if (btnSearch)    btnSearch.addEventListener('click',    () => window.location.href = getSearchUrl());
        if (searchInput)  searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') window.location.href = getSearchUrl(); });
        if (guruSelect)   guruSelect.addEventListener('change',   () => window.location.href = getSearchUrl());
        if (statusSelect) statusSelect.addEventListener('change', () => window.location.href = getSearchUrl());

        @if($isGuru && !$isWaliKelasOnly)
        // ── Modal Create (hanya guru pengajar) ───────────────────────────
        function openCreateModal() {
            document.getElementById('modalCreate').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        function closeCreateModal() {
            document.getElementById('modalCreate').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ── Modal Edit (hanya guru pengajar) ─────────────────────────────
        function openEditModal(button) {
            const d    = button.dataset;
            const form = document.getElementById('editFormAction');
            const btn  = document.getElementById('editSubmitBtn');

            form.action = d.route;
            document.getElementById('edit_route').value           = d.route;
            document.getElementById('edit_id_jadwal').value       = d.idJadwal;
            document.getElementById('edit_nomor_pertemuan').value = d.nomorPertemuan;
            document.getElementById('edit_tanggal').value         = d.tanggal;
            document.getElementById('edit_status').value          = d.status;

            btn.disabled = false;
            btn.innerHTML = `
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Update
            `;

            document.getElementById('modalEdit').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        function closeEditModal() {
            document.getElementById('modalEdit').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ── Confirm Delete ───────────────────────────────────────────────
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            showConfirmDelete(true).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
        @endif

        // ── Accordion Load More (Admin / Super Admin) ────────────────────
        (function () {
            const BATCH = 5;
            const items = document.querySelectorAll('.accordion-guru-item');
            if (!items.length) return;

            let shown = BATCH;

            function refresh() {
                items.forEach((el) => {
                    const idx = parseInt(el.getAttribute('data-guru-index'), 10);
                    el.style.display = idx < shown ? '' : 'none';
                });

                const container = document.getElementById('loadMoreContainer');
                const btn       = document.getElementById('btnLoadMore');
                const info      = document.getElementById('loadMoreInfo');

                if (!container) return;

                if (shown >= items.length) {
                    container.style.display = 'none';
                } else {
                    container.style.display = '';
                    const remaining = items.length - shown;
                    const nextBatch = Math.min(BATCH, remaining);
                    if (info) {
                        info.textContent = `Menampilkan ${shown} dari ${items.length} guru`;
                    }
                    if (btn) {
                        btn.innerHTML = `
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                            Muat ${nextBatch} Guru Berikutnya
                        `;
                    }
                }
            }

            refresh();

            const btn = document.getElementById('btnLoadMore');
            if (btn) {
                btn.addEventListener('click', () => {
                    shown = Math.min(shown + BATCH, items.length);
                    refresh();
                    const lastVisible = document.querySelector(`.accordion-guru-item[data-guru-index="${shown - 1}"]`);
                    if (lastVisible) {
                        lastVisible.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });
            }
        })();

        // ── DOMContentLoaded ─────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            @if($isGuru && !$isWaliKelasOnly)
            const createForm = document.getElementById('createFormAction');
            const createBtn  = document.getElementById('createSubmitBtn');
            const editForm   = document.getElementById('editFormAction');
            const editBtn    = document.getElementById('editSubmitBtn');

            if (createForm && createBtn) {
                createForm.addEventListener('submit', () => {
                    createBtn.disabled = true;
                    createBtn.innerHTML = `
                        <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Menyimpan...
                    `;
                });
            }

            if (editForm && editBtn) {
                editForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    showConfirmUpdate().then((result) => {
                        if (result.isConfirmed) {
                            editBtn.disabled = true;
                            editBtn.innerHTML = `
                                <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                Menyimpan...
                            `;
                            editForm.submit();
                        }
                    });
                });
            }

            @if($errors->any())
                @if(old('_modal') === 'create')
                    openCreateModal();
                @elseif(old('_modal') === 'edit')
                    const savedRoute = document.getElementById('edit_route').value;
                    if (savedRoute) document.getElementById('editFormAction').action = savedRoute;
                    document.getElementById('modalEdit').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                @endif
            @endif

            ['modalCreate', 'modalEdit'].forEach(id => {
                const modal = document.getElementById(id);
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            this.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }
                    });
                }
            });
            @endif
        });
    </script>
    @endpush
</x-app-layout>