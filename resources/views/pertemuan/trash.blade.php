<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-500 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Arsip Pertemuan</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Terhapus Sementara</p>
                </div>
            </div>

            {{-- Tombol bulk action — tampil jika ada data --}}
            @php
                $hasData = $isGuru
                    ? ($pertemuans instanceof \Illuminate\Pagination\LengthAwarePaginator && $pertemuans->total() > 0)
                    : ($trashByGuru instanceof \Illuminate\Support\Collection && $trashByGuru->count() > 0);
            @endphp

            @if($hasData)
                <div class="flex gap-2 flex-shrink-0">
                    <form action="{{ route('pertemuan.restoreAll') }}" method="POST" id="restoreAllForm">
                        @csrf @method('PATCH')
                        <button type="button" onclick="confirmRestoreAll(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Pulihkan Semua
                        </button>
                    </form>
                    <form action="{{ route('pertemuan.forceDeleteAll') }}" method="POST" id="forceDeleteAllForm">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmForceDeleteAll(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Master Data</span>
                <span class="text-gray-300">/</span>
                <a href="{{ route('pertemuan.index') }}" class="hover:text-amber-600 transition">Pertemuan</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Arsip</span>
            </nav>

            {{-- Warning Banner --}}
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"/>
                </svg>
                <p class="text-xs tracking-widest font-medium leading-relaxed text-red-700">
                    Data dalam arsip telah dihapus sementara. Gunakan tombol aksi untuk memulihkan atau menghapus data secara permanen.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Data Pertemuan Terhapus</h3>
                        <p class="text-gray-400 text-xs mt-0.5">
                            @if($isGuru)
                                Arsip pertemuan milik Anda
                            @else
                                Arsip pertemuan semua guru
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('pertemuan.index') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Data Utama
                    </a>
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
                            <input type="text" id="trashSearchInput" value="{{ $search ?? '' }}"
                                placeholder="Cari nomor / tanggal..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400/30 focus:border-red-400 transition">
                        </div>

                        {{-- Filter Guru — hanya untuk admin & super_admin --}}
                        @if(!$isGuru)
                            <select id="trashGuruSelect"
                                class="rounded-xl border min-w-[160px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-red-400 focus:ring-2 focus:ring-red-100 outline-none cursor-pointer transition">
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
                        <select id="trashStatusSelect"
                            class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-red-400 focus:ring-2 focus:ring-red-100 outline-none cursor-pointer transition">
                            <option value="">Semua Status</option>
                            <option value="dijadwalkan" {{ ($statusFilter ?? '') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                            <option value="berlangsung" {{ ($statusFilter ?? '') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="selesai"     {{ ($statusFilter ?? '') == 'selesai'     ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan"  {{ ($statusFilter ?? '') == 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        <button type="button" id="trashBtnSearch"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if($search || ($statusFilter ?? null) || (isset($idGuruFilter) && $idGuruFilter))
                            <a href="{{ route('pertemuan.trash') }}"
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
                     TAMPILAN ACCORDION — Admin & Super Admin
                     Dikelompokkan per guru, load-more 5 per batch
                ============================================================ --}}
                @if(!$isGuru)
                    <div class="divide-y divide-gray-100" x-data>

                        @forelse($trashByGuru as $guruId => $group)
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
                                    'bg-red-100 text-red-600',
                                    'bg-orange-100 text-orange-600',
                                    'bg-pink-100 text-pink-600',
                                    'bg-rose-100 text-rose-600',
                                    'bg-fuchsia-100 text-fuchsia-600',
                                ];
                                $avatarClass = $avatarClasses[$loop->index % count($avatarClasses)];

                                $mapelNama = $guruModel?->guruMapel?->first()?->mapel?->nama_mapel ?? null;
                            @endphp

                            <div x-data="{ open: false }"
                                class="trash-accordion-guru-item"
                                data-guru-index="{{ $loop->index }}">

                                {{-- Accordion Header --}}
                                <div @click="open = !open"
                                    :class="open ? 'bg-red-50/40' : ''"
                                    class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-red-50/40 transition select-none group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $avatarClass }} flex items-center justify-center font-bold text-sm flex-shrink-0 border border-white shadow-sm">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700 group-hover:text-red-600 transition leading-none">
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
                                                {{ $items->count() }} data terhapus
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-400 border border-red-100">
                                            {{ $items->count() }} Item
                                        </span>
                                        <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 group-hover:bg-red-100 group-hover:text-red-500 transition">
                                            <svg class="w-4 h-4 transition-transform duration-300"
                                                :class="{ 'rotate-180': open }"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Accordion Body --}}
                                <div x-show="open" x-transition.opacity
                                    class="border-t border-gray-100 bg-white">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm">
                                            <thead>
                                                <tr class="bg-red-50/40 border-b border-red-100/60">
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest w-12">#</th>
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jadwal Belajar</th>
                                                    <th class="px-6 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-28">No. Pertemuan</th>
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                                                    <th class="px-6 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-28">Status</th>
                                                    <th class="px-6 py-2.5 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dihapus Pada</th>
                                                    <th class="px-6 py-2.5 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-28">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @forelse($items as $i => $pertemuan)
                                                    <tr class="hover:bg-red-50/20 transition opacity-80">
                                                        <td class="px-6 py-3 text-gray-400 text-xs font-mono">
                                                            {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                                                    <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <div class="font-semibold text-gray-500 text-sm line-through decoration-red-300">
                                                                        {{ $pertemuan->jadwalBelajar->Mapel->nama_mapel ?? '-' }}
                                                                    </div>
                                                                    <div class="text-xs text-gray-400 mt-1">
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
                                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-100 text-red-400 text-xs font-bold">
                                                                {{ $pertemuan->nomor_pertemuan }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-3 text-gray-400 text-xs">
                                                            @if($pertemuan->tanggal)
                                                                <span class="line-through decoration-red-300">
                                                                    {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                                                </span>
                                                            @else
                                                                <span class="text-gray-300 italic">Belum ditentukan</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-3 text-center">
                                                            @php
                                                                $statusMap = [
                                                                    'dijadwalkan' => 'bg-blue-50 text-blue-400 border-blue-100',
                                                                    'berlangsung' => 'bg-amber-50 text-amber-400 border-amber-100',
                                                                    'selesai'     => 'bg-emerald-50 text-emerald-400 border-emerald-100',
                                                                    'dibatalkan'  => 'bg-red-50 text-red-400 border-red-100',
                                                                ];
                                                            @endphp
                                                            <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold opacity-70 {{ $statusMap[$pertemuan->status] ?? 'bg-gray-100 text-gray-400 border-gray-100' }}">
                                                                {{ ucfirst($pertemuan->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-3">
                                                            <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-red-50 border border-red-100 rounded-lg">
                                                                <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                                    {{ $pertemuan->deleted_at?->format('d M Y, H:i') ?? '-' }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-3">
                                                            <div class="flex items-center justify-center gap-1.5">
                                                                {{-- Restore --}}
                                                                <form action="{{ route('pertemuan.restore', $pertemuan->id) }}" method="POST"
                                                                    onsubmit="confirmRestore(event)">
                                                                    @csrf @method('PATCH')
                                                                    <button type="submit" title="Pulihkan"
                                                                        class="w-7 h-7 flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 rounded-lg transition">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                                {{-- Force Delete --}}
                                                                <form action="{{ route('pertemuan.force-delete', $pertemuan->id) }}" method="POST"
                                                                    onsubmit="confirmForceDelete(event)">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" title="Hapus Permanen"
                                                                        class="w-7 h-7 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="px-6 py-6 text-center text-xs text-gray-400 italic">
                                                            Belum ada data terhapus dari guru ini.
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm font-semibold">Tempat sampah kosong</p>
                                    <p class="text-gray-300 text-xs">Tidak ada data pertemuan yang dihapus sementara.</p>
                                </div>
                            </div>
                        @endforelse

                        {{-- Load More Guru Trash --}}
                        @if($trashByGuru->count() > 5)
                            <div id="trashLoadMoreContainer"
                                class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p id="trashLoadMoreInfo" class="text-xs text-gray-400 order-2 sm:order-1"></p>
                                <button type="button" id="trashBtnLoadMore"
                                    class="order-1 sm:order-2 inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-red-50 text-red-500 text-xs font-semibold rounded-xl border border-red-200 hover:border-red-400 transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                    Muat 5 Guru Berikutnya
                                </button>
                            </div>
                        @endif

                    </div>

                {{-- ============================================================
                     TAMPILAN TABEL — Guru (hanya data miliknya, 5 per halaman)
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
                                    <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Dihapus Pada</th>
                                    <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">

                                @forelse($pertemuans as $pertemuan)
                                    <tr class="hover:bg-red-50/30 transition opacity-80">
                                        <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                            {{ str_pad($loop->iteration + ($pertemuans->currentPage() - 1) * $pertemuans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-500 text-sm line-through decoration-red-300">
                                                        {{ $pertemuan->jadwalBelajar->Mapel->nama_mapel ?? '-' }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 mt-1">
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
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-400 text-xs font-bold">
                                                {{ $pertemuan->nomor_pertemuan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-sm">
                                            @if($pertemuan->tanggal)
                                                <span class="line-through decoration-red-300">
                                                    {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 italic text-xs">Belum ditentukan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $statusMap = [
                                                    'dijadwalkan' => 'bg-blue-50 text-blue-400 border-blue-100',
                                                    'berlangsung' => 'bg-amber-50 text-amber-400 border-amber-100',
                                                    'selesai'     => 'bg-emerald-50 text-emerald-400 border-emerald-100',
                                                    'dibatalkan'  => 'bg-red-50 text-red-400 border-red-100',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold opacity-75 {{ $statusMap[$pertemuan->status] ?? 'bg-gray-100 text-gray-400 border-gray-100' }}">
                                                {{ ucfirst($pertemuan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                                <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                    {{ $pertemuan->deleted_at?->format('d M Y, H:i') ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-1.5">
                                                {{-- Restore --}}
                                                <form action="{{ route('pertemuan.restore', $pertemuan->id) }}" method="POST"
                                                    onsubmit="confirmRestore(event)">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" title="Pulihkan"
                                                        class="w-8 h-8 flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                {{-- Force Delete --}}
                                                <form action="{{ route('pertemuan.force-delete', $pertemuan->id) }}" method="POST"
                                                    onsubmit="confirmForceDelete(event)">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" title="Hapus Permanen"
                                                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-400 text-sm font-semibold">Tempat sampah kosong</p>
                                                <p class="text-gray-300 text-xs">Tidak ada data pertemuan yang dihapus sementara.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination 5 per halaman untuk guru --}}
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

    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-restore')
    @include('components.alerts.confirm-restore-all')
    @include('components.alerts.confirm-force-delete-all')

    @push('scripts')
    <script>
        // ── Filter & Search ──────────────────────────────────────────────
        const trashSearchInput  = document.getElementById('trashSearchInput');
        const trashGuruSelect   = document.getElementById('trashGuruSelect');
        const trashStatusSelect = document.getElementById('trashStatusSelect');
        const trashBtnSearch    = document.getElementById('trashBtnSearch');

        function getTrashSearchUrl() {
            const params = new URLSearchParams();
            if (trashSearchInput  && trashSearchInput.value.trim())  params.append('search',   trashSearchInput.value.trim());
            if (trashGuruSelect   && trashGuruSelect.value)           params.append('id_guru',  trashGuruSelect.value);
            if (trashStatusSelect && trashStatusSelect.value)         params.append('status',   trashStatusSelect.value);
            return `{{ route('pertemuan.trash') }}?${params.toString()}`;
        }

        if (trashBtnSearch)    trashBtnSearch.addEventListener('click',    () => window.location.href = getTrashSearchUrl());
        if (trashSearchInput)  trashSearchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') window.location.href = getTrashSearchUrl(); });
        if (trashGuruSelect)   trashGuruSelect.addEventListener('change',   () => window.location.href = getTrashSearchUrl());
        if (trashStatusSelect) trashStatusSelect.addEventListener('change', () => window.location.href = getTrashSearchUrl());

        // ── Confirm Actions ──────────────────────────────────────────────
        function confirmForceDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            showConfirmDelete(false).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        function confirmRestore(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            showConfirmRestore('pertemuan').then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        function confirmRestoreAll(event) {
            event.preventDefault();
            showConfirmRestoreAll('Pertemuan').then((result) => {
                if (result.isConfirmed) document.getElementById('restoreAllForm').submit();
            });
        }

        function confirmForceDeleteAll(event) {
            event.preventDefault();
            showConfirmForceDeleteAll('Pertemuan').then((result) => {
                if (result.isConfirmed) document.getElementById('forceDeleteAllForm').submit();
            });
        }

        // ── Accordion Load More Trash (Admin / Super Admin) ──────────────
        (function () {
            const BATCH = 5;
            const items = document.querySelectorAll('.trash-accordion-guru-item');
            if (!items.length) return;

            let shown = BATCH;

            function refresh() {
                items.forEach((el) => {
                    const idx = parseInt(el.getAttribute('data-guru-index'), 10);
                    el.style.display = idx < shown ? '' : 'none';
                });

                const container = document.getElementById('trashLoadMoreContainer');
                const btn       = document.getElementById('trashBtnLoadMore');
                const info      = document.getElementById('trashLoadMoreInfo');

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

            const btn = document.getElementById('trashBtnLoadMore');
            if (btn) {
                btn.addEventListener('click', () => {
                    shown = Math.min(shown + BATCH, items.length);
                    refresh();
                    const lastVisible = document.querySelector(`.trash-accordion-guru-item[data-guru-index="${shown - 1}"]`);
                    if (lastVisible) {
                        lastVisible.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });
            }
        })();
    </script>
    @endpush
</x-app-layout>