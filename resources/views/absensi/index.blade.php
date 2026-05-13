{{-- resources/views/absensi/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">Master Absensi</h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Absensi</p>
            </div>
        </div>
    </x-slot>

    @php
        $statusMap = [
            'hadir' => ['bg-green-50', 'text-green-700', 'border-green-200', 'Hadir'],
            'izin'  => ['bg-blue-50',  'text-blue-700',  'border-blue-200',  'Izin'],
            'sakit' => ['bg-amber-50', 'text-amber-700', 'border-amber-200', 'Sakit'],
            'alpha' => ['bg-red-50',   'text-red-600',   'border-red-200',   'Alpha'],
        ];
        $offset = ($absensis->currentPage() - 1) * $absensis->perPage();
    @endphp

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide" aria-label="Breadcrumb">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span>Master Data</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-600 font-semibold">Absensi</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div role="alert"
                     class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                            aria-label="Tutup notifikasi"
                            class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Absensi</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data kehadiran siswa per pertemuan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('absensi.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" id="btnTambahAbsensi"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Absensi
                        </button>
                    </div>
                </div>

                {{-- Search & Filter --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex flex-wrap items-center gap-2 max-w-4xl">
                        <div class="relative flex-1 min-w-[160px]">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none" aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="searchInput" value="{{ request('search') }}"
                                   placeholder="Cari nama siswa..."
                                   autocomplete="off"
                                   class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                        </div>

                        <div class="relative">
                            <select id="pertemuanSelect"
                                    class="pl-3 pr-8 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition appearance-none">
                                <option value="">Semua Pertemuan</option>
                                @foreach($pertemuans as $pertemuan)
                                    <option value="{{ $pertemuan->id }}"
                                            {{ request('id_pertemuan') == $pertemuan->id ? 'selected' : '' }}>
                                        Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none" aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <div class="relative">
                            <select id="statusSelect"
                                    class="pl-3 pr-8 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition appearance-none">
                                <option value="">Semua Status</option>
                                @foreach(['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'] as $val => $label)
                                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none" aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if(request()->hasAny(['search', 'id_pertemuan', 'status']))
                            <button type="button" id="btnReset"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" aria-label="Daftar Absensi">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Siswa</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Pertemuan</th>
                                <th scope="col" class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-28">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keterangan</th>
                                <th scope="col" class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody" class="divide-y divide-slate-100">
                            @forelse ($absensis as $absensi)
                                @php
                                    [$bg, $text, $border, $label] = $statusMap[$absensi->status]
                                        ?? ['bg-slate-50', 'text-slate-500', 'border-slate-200', $absensi->status];
                                    $namaLengkap = $absensi->siswa?->nama_lengkap ?? 'N/A';
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + $offset, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                                    {{ Str::upper(Str::substr($namaLengkap, 0, 2)) }}
                                                </span>
                                            </div>
                                            <p class="font-semibold text-[#0F2145] text-sm leading-tight">{{ $namaLengkap }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-slate-600 text-sm">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold" aria-hidden="true">
                                                {{ $absensi->pertemuan?->nomor_pertemuan ?? '-' }}
                                            </span>
                                            Pertemuan ke-{{ $absensi->pertemuan?->nomor_pertemuan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 {{ $bg }} {{ $text }} border {{ $border }} text-[10px] font-bold rounded-full uppercase tracking-wide">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-sm">
                                        {{ $absensi->keterangan ? Str::limit($absensi->keterangan, 40) : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                    data-id="{{ $absensi->id }}"
                                                    data-id_pertemuan="{{ $absensi->id_pertemuan }}"
                                                    data-id_siswa="{{ $absensi->id_siswa }}"
                                                    data-status="{{ $absensi->status }}"
                                                    data-keterangan="{{ $absensi->keterangan }}"
                                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                                  data-confirm="Yakin ingin menghapus absensi ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Belum ada data absensi</p>
                                            <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Absensi</span> untuk mulai menambahkan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($absensis->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $absensis->firstItem() }}–{{ $absensis->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $absensis->total() }}</span>
                            entri
                        </p>
                        {{ $absensis->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('absensi.modal-create')
    @include('absensi.modal-edit')

    <script>
    (() => {
        'use strict';

        // ─── DOM refs ───────────────────────────────────────────────────────
        const modalCreate     = document.getElementById('modalCreate');
        const modalEdit       = document.getElementById('modalEdit');
        const searchInput     = document.getElementById('searchInput');
        const pertemuanSelect = document.getElementById('pertemuanSelect');
        const statusSelect    = document.getElementById('statusSelect');
        const btnSearch       = document.getElementById('btnSearch');
        const btnReset        = document.getElementById('btnReset');
        const tableBody       = document.getElementById('absensiTableBody');

        // ─── State ──────────────────────────────────────────────────────────
        // Single source of truth — read from current URL so refreshes are consistent
        const state = {
            search    : '{{ request("search") }}',
            pertemuan : '{{ request("id_pertemuan") }}',
            status    : '{{ request("status") }}',
            page      : 1,
        };

        // ─── Status map (single definition — not duplicated) ────────────────
        const STATUS_MAP = {
            hadir : ['bg-green-50', 'text-green-700', 'border-green-200', 'Hadir'],
            izin  : ['bg-blue-50',  'text-blue-700',  'border-blue-200',  'Izin'],
            sakit : ['bg-amber-50', 'text-amber-700', 'border-amber-200', 'Sakit'],
            alpha : ['bg-red-50',   'text-red-600',   'border-red-200',   'Alpha'],
        };

        // ─── Helpers ────────────────────────────────────────────────────────

        /** Safely escape text before injecting into innerHTML */
        function esc(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function truncate(str, len = 40) {
            return str && str.length > len ? str.substring(0, len) + '...' : (str || '-');
        }

        /** Debounce — prevents hammering the server on each keystroke */
        function debounce(fn, delay = 300) {
            let timer;
            return (...args) => { clearTimeout(timer); timer = setTimeout(() => fn(...args), delay); };
        }

        function closeModal(modal) { modal.style.display = 'none'; }
        function openModal(modal)  { modal.style.display = 'block'; }

        // ─── Row builder ────────────────────────────────────────────────────
        function buildRow(a, index, page) {
            const no   = String((page - 1) * 5 + index + 1).padStart(3, '0');
            const [bg, textCls, border, label] = STATUS_MAP[a.status] ?? ['bg-slate-50','text-slate-500','border-slate-200', a.status];
            const nama  = esc(a.siswa?.nama_lengkap ?? 'N/A');
            const inits = nama.substring(0, 2).toUpperCase();
            const ket   = esc(truncate(a.keterangan));
            const nomor = esc(a.pertemuan?.nomor_pertemuan ?? '-');

            return `
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                            <span class="text-[#1B3A6B] text-[10px] font-bold">${inits}</span>
                        </div>
                        <p class="font-semibold text-[#0F2145] text-sm leading-tight">${nama}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 text-slate-600 text-sm">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold" aria-hidden="true">${nomor}</span>
                        Pertemuan ke-${nomor}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 ${bg} ${textCls} border ${border} text-[10px] font-bold rounded-full uppercase tracking-wide">
                        ${label}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-500 text-sm">${ket}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <button type="button"
                            data-id="${a.id}"
                            data-id_pertemuan="${a.id_pertemuan}"
                            data-id_siswa="${a.id_siswa}"
                            data-status="${esc(a.status)}"
                            data-keterangan="${esc(a.keterangan ?? '')}"
                            class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <form action="/absensi/${a.id}" method="POST" data-confirm="Yakin ingin menghapus absensi ini?">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>`;
        }

        // ─── Render ─────────────────────────────────────────────────────────
        function renderTable(rows, page) {
            tableBody.innerHTML = rows.length
                ? rows.map((a, i) => buildRow(a, i, page)).join('')
                : `<tr><td colspan="6" class="px-6 py-16 text-center">
                       <div class="flex flex-col items-center gap-3">
                           <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                               <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                               </svg>
                           </div>
                           <p class="text-slate-400 text-sm font-medium">Belum ada data absensi</p>
                       </div>
                   </td></tr>`;

            bindEditButtons();
        }

        // ─── Fetch ──────────────────────────────────────────────────────────
        async function loadData() {
            const params = new URLSearchParams({
                search       : state.search,
                id_pertemuan : state.pertemuan,
                status       : state.status,
                page         : state.page,
            });
            try {
                const res  = await fetch(`{{ route('absensi.index') }}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const { absensis } = await res.json();
                renderTable(absensis, state.page);
            } catch (err) {
                console.error('Gagal memuat data absensi:', err);
            }
        }

        // ─── Edit modal binding ──────────────────────────────────────────────
        function bindEditButtons() {
            tableBody.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editIdPertemuan').value = this.dataset.id_pertemuan;
                    document.getElementById('editIdSiswa').value     = this.dataset.id_siswa;
                    document.getElementById('editKeterangan').value  = this.dataset.keterangan ?? '';
                    document.getElementById('formEdit').action       = `/absensi/${this.dataset.id}`;

                    document.querySelectorAll('.edit-status-radio').forEach(radio => {
                        radio.checked = radio.value === this.dataset.status;
                    });

                    openModal(modalEdit);
                });
            });
        }

        // ─── Delete confirmation (delegated — no inline onsubmit) ───────────
        document.addEventListener('submit', function (e) {
            const form = e.target.closest('form[data-confirm]');
            if (!form) return;
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });

        // ─── Filter events ──────────────────────────────────────────────────
        const debouncedLoad = debounce(() => { state.page = 1; loadData(); });

        searchInput.addEventListener('input', function () {
            state.search = this.value;
            debouncedLoad();
        });
        pertemuanSelect.addEventListener('change', function () {
            state.pertemuan = this.value;
            state.page = 1;
            loadData();
        });
        statusSelect.addEventListener('change', function () {
            state.status = this.value;
            state.page = 1;
            loadData();
        });
        btnSearch.addEventListener('click', () => {
            state.search    = searchInput.value;
            state.pertemuan = pertemuanSelect.value;
            state.status    = statusSelect.value;
            state.page      = 1;
            loadData();
        });
        if (btnReset) {
            btnReset.addEventListener('click', () => {
                searchInput.value = pertemuanSelect.value = statusSelect.value = '';
                Object.assign(state, { search: '', pertemuan: '', status: '', page: 1 });
                loadData();
            });
        }

        // ─── Modal open/close ───────────────────────────────────────────────
        document.getElementById('btnTambahAbsensi').addEventListener('click', () => openModal(modalCreate));

        [
            ['closeCreate',  modalCreate],
            ['cancelCreate', modalCreate],
            ['overlayCreate',modalCreate],
            ['closeEdit',    modalEdit],
            ['cancelEdit',   modalEdit],
            ['overlayEdit',  modalEdit],
        ].forEach(([id, modal]) => {
            document.getElementById(id)?.addEventListener('click', () => closeModal(modal));
        });

        // ─── Init ────────────────────────────────────────────────────────────
        bindEditButtons();

        @if ($errors->any())
            openModal(modalCreate);
        @endif
    })();
    </script>

</x-app-layout>