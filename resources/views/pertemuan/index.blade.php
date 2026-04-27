<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Master Pertemuan
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Pertemuan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Pertemuan</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Pertemuan</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data pertemuan tiap jadwal belajar</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pertemuan.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" id="btnTambahPertemuan"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Pertemuan
                        </button>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex flex-wrap items-center gap-2 max-w-3xl">
                        <div class="relative flex-1 min-w-[160px]">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nomor / tanggal..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                        </div>

                        {{-- Filter Jadwal --}}
                        <div class="relative">
                            <select id="jadwalSelect" class="pl-3 pr-8 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition appearance-none">
                                <option value="">Semua Jadwal</option>
                                @foreach($jadwalBelajars as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ request('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->nama_jadwal ?? 'Jadwal #' . $jadwal->id }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Filter Status --}}
                        <div class="relative">
                            <select id="statusSelect" class="pl-3 pr-8 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition appearance-none">
                                <option value="">Semua Status</option>
                                <option value="dijadwalkan"  {{ request('status') == 'dijadwalkan'  ? 'selected' : '' }}>Dijadwalkan</option>
                                <option value="berlangsung" {{ request('status') == 'berlangsung'  ? 'selected' : '' }}>Berlangsung</option>
                                <option value="selesai"     {{ request('status') == 'selesai'      ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan"  {{ request('status') == 'dibatalkan'   ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if(request('search') || request('id_jadwal') || request('status'))
                            <button type="button" id="btnReset"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Jadwal Belajar</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-28">No. Pertemuan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-36">Tanggal</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-32">Status</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pertemuanTableBody" class="divide-y divide-slate-100">
                            @forelse ($pertemuans as $pertemuan)
                                <tr class="hover:bg-slate-50/70 transition group">
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($pertemuans->currentPage() - 1) * $pertemuans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">
                                                {{ $pertemuan->jadwalBelajar->nama_jadwal ?? 'Jadwal #' . $pertemuan->id_jadwal }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#1B3A6B]/10 text-[#1B3A6B] text-xs font-bold">
                                            {{ $pertemuan->nomor_pertemuan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($pertemuan->tanggal)
                                            <span class="text-slate-700 text-sm">
                                                {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs italic">Belum ditentukan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusMap = [
                                                'dijadwalkan'  => ['bg-blue-50',   'text-blue-700',   'border-blue-200',   'Dijadwalkan'],
                                                'berlangsung'  => ['bg-amber-50',  'text-amber-700',  'border-amber-200',  'Berlangsung'],
                                                'selesai'      => ['bg-green-50',  'text-green-700',  'border-green-200',  'Selesai'],
                                                'dibatalkan'   => ['bg-red-50',    'text-red-600',    'border-red-200',    'Dibatalkan'],
                                            ];
                                            [$bg, $text, $border, $label] = $statusMap[$pertemuan->status] ?? ['bg-slate-50', 'text-slate-500', 'border-slate-200', $pertemuan->status];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 {{ $bg }} {{ $text }} border {{ $border }} text-[10px] font-semibold rounded-full">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $pertemuan->id }}"
                                                data-id_jadwal="{{ $pertemuan->id_jadwal }}"
                                                data-nomor_pertemuan="{{ $pertemuan->nomor_pertemuan }}"
                                                data-tanggal="{{ $pertemuan->tanggal }}"
                                                data-status="{{ $pertemuan->status }}"
                                                class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('pertemuan.destroy', $pertemuan) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus pertemuan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Belum ada data pertemuan</p>
                                            <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Pertemuan</span> untuk mulai menambahkan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($pertemuans->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $pertemuans->firstItem() }}–{{ $pertemuans->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $pertemuans->total() }}</span>
                            entri
                        </p>
                        {{ $pertemuans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('pertemuan.modal-create')
    @include('pertemuan.modal-edit')

    <script>
        const modalCreate       = document.getElementById('modalCreate');
        const modalEdit         = document.getElementById('modalEdit');
        const searchInput       = document.getElementById('searchInput');
        const jadwalSelect      = document.getElementById('jadwalSelect');
        const statusSelect      = document.getElementById('statusSelect');
        const btnSearch         = document.getElementById('btnSearch');
        const btnReset          = document.getElementById('btnReset');
        const tableBody         = document.getElementById('pertemuanTableBody');

        let currentSearch       = '{{ request("search") }}';
        let currentJadwal       = '{{ request("id_jadwal") }}';
        let currentStatus       = '{{ request("status") }}';
        let currentPage         = 1;

        const statusMap = {
            dijadwalkan : ['bg-blue-50',  'text-blue-700',  'border-blue-200',  'Dijadwalkan'],
            berlangsung : ['bg-amber-50', 'text-amber-700', 'border-amber-200', 'Berlangsung'],
            selesai     : ['bg-green-50', 'text-green-700', 'border-green-200', 'Selesai'],
            dibatalkan  : ['bg-red-50',   'text-red-600',   'border-red-200',   'Dibatalkan'],
        };

        function loadData(search = '', jadwal = '', status = '', page = 1) {
            const params = new URLSearchParams({ search, id_jadwal: jadwal, status, page });
            fetch(`{{ route('pertemuan.index') }}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => renderTable(data.pertemuans, page))
            .catch(err => console.error('Error:', err));
        }

        function renderTable(pertemuans, page) {
            if (!pertemuans.length) {
                tableBody.innerHTML = `
                    <tr><td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 text-sm font-medium">Belum ada data pertemuan</p>
                        </div>
                    </td></tr>`;
                return;
            }

            tableBody.innerHTML = pertemuans.map((p, i) => {
                const no      = String((page - 1) * 5 + i + 1).padStart(3, '0');
                const [bg, text, border, label] = statusMap[p.status] ?? ['bg-slate-50','text-slate-500','border-slate-200', p.status];
                const tanggal = p.tanggal
                    ? new Date(p.tanggal).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' })
                    : '<span class="text-slate-300 text-xs italic">Belum ditentukan</span>';

                return `
                <tr class="hover:bg-slate-50/70 transition group">
                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-[#0F2145] text-sm">
                                ${p.jadwal_belajar?.nama_jadwal ?? 'Jadwal #' + p.id_jadwal}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#1B3A6B]/10 text-[#1B3A6B] text-xs font-bold">
                            ${p.nomor_pertemuan}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">${tanggal}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2 py-1 ${bg} ${text} border ${border} text-[10px] font-semibold rounded-full">
                            ${label}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                data-id="${p.id}"
                                data-id_jadwal="${p.id_jadwal}"
                                data-nomor_pertemuan="${p.nomor_pertemuan}"
                                data-tanggal="${p.tanggal ?? ''}"
                                data-status="${p.status}"
                                class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>
                            <form action="/pertemuan/${p.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pertemuan ini?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>`;
            }).join('');

            bindEditButtons();
        }

        function bindEditButtons() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editIdJadwal').value          = this.dataset.id_jadwal;
                    document.getElementById('editNomorPertemuan').value    = this.dataset.nomor_pertemuan;
                    document.getElementById('editTanggal').value           = this.dataset.tanggal;
                    document.getElementById('editStatus').value            = this.dataset.status;
                    document.getElementById('formEdit').action             = `/pertemuan/${this.dataset.id}`;
                    modalEdit.style.display = 'block';
                });
            });
        }

        // Event listeners
        searchInput.addEventListener('input',  function () { currentSearch = this.value; currentPage = 1; loadData(currentSearch, currentJadwal, currentStatus, 1); });
        jadwalSelect.addEventListener('change', function () { currentJadwal = this.value; currentPage = 1; loadData(currentSearch, currentJadwal, currentStatus, 1); });
        statusSelect.addEventListener('change', function () { currentStatus = this.value; currentPage = 1; loadData(currentSearch, currentJadwal, currentStatus, 1); });
        btnSearch.addEventListener('click', function () {
            currentSearch = searchInput.value;
            currentJadwal = jadwalSelect.value;
            currentStatus = statusSelect.value;
            currentPage   = 1;
            loadData(currentSearch, currentJadwal, currentStatus, 1);
        });
        if (btnReset) {
            btnReset.addEventListener('click', function () {
                searchInput.value  = '';
                jadwalSelect.value = '';
                statusSelect.value = '';
                currentSearch = currentJadwal = currentStatus = '';
                currentPage   = 1;
                loadData('', '', '', 1);
            });
        }

        if (!currentSearch && !currentJadwal && !currentStatus) loadData('', '', '', 1);

        // Modal events
        document.getElementById('btnTambahPertemuan').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('closeCreate').addEventListener('click',        () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate').addEventListener('click',       () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click',      () => modalCreate.style.display = 'none');
        document.getElementById('closeEdit').addEventListener('click',          () => modalEdit.style.display   = 'none');
        document.getElementById('cancelEdit').addEventListener('click',         () => modalEdit.style.display   = 'none');
        document.getElementById('overlayEdit').addEventListener('click',        () => modalEdit.style.display   = 'none');

        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>