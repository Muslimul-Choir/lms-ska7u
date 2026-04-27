<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Manajemen Kelas
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Kelola Data Kelas & Rombongan Belajar</p>
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
                <span class="text-slate-600 font-semibold">Kelas</span>
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

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Kelas</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data kelas dan rombongan belajar</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('kelas.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" onclick="openCreateModal()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kelas
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex flex-wrap items-end gap-2">

                        {{-- Search --}}
                        <div class="flex-1 min-w-[180px] max-w-xs">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" id="searchInput" value="{{ request('search') }}"
                                    placeholder="Cari kelas..."
                                    class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                            </div>
                        </div>

                        {{-- Filter Tahun Ajaran --}}
                        <div class="min-w-[150px]">
                            <select id="tahunAjaranSelect"
                                class="w-full py-2 px-3 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                                <option value="">Semua Tahun</option>
                                @foreach ($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}" {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama_tahun }}{{ $ta->is_aktif ? ' (Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Tingkatan --}}
                        <div class="min-w-[130px]">
                            <select id="tingkatanSelect"
                                class="w-full py-2 px-3 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                                <option value="">Semua Tingkat</option>
                                @foreach ($tingkatanList as $t)
                                    <option value="{{ $t->id }}" {{ request('id_tingkatan') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nama_tingkatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Jurusan --}}
                        <div class="min-w-[150px]">
                            <select id="jurusanSelect"
                                class="w-full py-2 px-3 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                                <option value="">Semua Jurusan</option>
                                @foreach ($jurusanList as $j)
                                    <option value="{{ $j->id }}" {{ request('id_jurusan') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Submit Search --}}
                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>

                        {{-- Reset --}}
                        @if (request()->hasAny(['search', 'id_tahun_ajaran', 'id_tingkatan', 'id_jurusan']))
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
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kelas</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Tahun Ajaran</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Tingkatan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Wali Kelas</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kelasTableBody" class="divide-y divide-slate-100">
                            @forelse ($kelasList as $index => $kelas)
                                <tr class="hover:bg-slate-50/70 transition group">
                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($kelasList->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    {{-- Kelas --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                                    {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">
                                                {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                                {{ $kelas->Bagian?->nama_bagian ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Tahun Ajaran --}}
                                    <td class="px-6 py-4">
                                        @if ($kelas->TahunAjaran)
                                            <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                                {{ $kelas->TahunAjaran->nama_tahun }}
                                                @if ($kelas->TahunAjaran->is_aktif)
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-sm">—</span>
                                        @endif
                                    </td>
                                    {{-- Jurusan --}}
                                    <td class="px-6 py-4">
                                        @if ($kelas->Jurusan)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-blue-50 text-[#1B3A6B] border border-blue-100">
                                                {{ $kelas->Jurusan->nama_jurusan }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-sm">—</span>
                                        @endif
                                    </td>
                                    {{-- Wali Kelas --}}
                                    <td class="px-6 py-4 text-slate-600 text-sm">
                                        {{ $kelas->WaliKelas?->nama_lengkap ?? '—' }}
                                    </td>
                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                onclick="openEditModal(this)"
                                                data-id="{{ $kelas->id }}"
                                                data-tingkatan="{{ $kelas->id_tingkatan }}"
                                                data-jurusan="{{ $kelas->id_jurusan }}"
                                                data-bagian="{{ $kelas->id_bagian }}"
                                                data-tahun="{{ $kelas->id_tahun_ajaran }}"
                                                data-wali="{{ $kelas->id_wali_kelas }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                  onsubmit="return confirmDelete(event, '{{ $kelas->Tingkatan?->nama_tingkatan }} {{ $kelas->Bagian?->nama_bagian }}')">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Belum ada data kelas</p>
                                            <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Kelas</span> untuk mulai menambahkan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kelasList->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $kelasList->firstItem() }}–{{ $kelasList->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $kelasList->total() }}</span>
                            entri
                        </p>
                        {{ $kelasList->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Include Modal Partials --}}
    @include('kelas.modal-create', [
        'tingkatanList' => $tingkatanList,
        'jurusanList'   => $jurusanList,
        'bagianList'    => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList'      => $guruList,
    ])
    @include('kelas.modal-edit', [
        'tingkatanList' => $tingkatanList,
        'jurusanList'   => $jurusanList,
        'bagianList'    => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList'      => $guruList,
    ])

    @push('scripts')
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');
        const searchInput = document.getElementById('searchInput');
        const tahunAjaranSelect = document.getElementById('tahunAjaranSelect');
        const tingkatanSelect = document.getElementById('tingkatanSelect');
        const jurusanSelect = document.getElementById('jurusanSelect');
        const btnSearch = document.getElementById('btnSearch');
        const btnReset = document.getElementById('btnReset');
        const tableBody = document.getElementById('kelasTableBody');

        let currentPage = 1;
        let currentSearch = '{{ request("search") }}';
        let currentTahunAjaran = '{{ request("id_tahun_ajaran") }}';
        let currentTingkatan = '{{ request("id_tingkatan") }}';
        let currentJurusan = '{{ request("id_jurusan") }}';

        // Function to load data
        function loadData(search = '', tahunAjaran = '', tingkatan = '', jurusan = '', page = 1) {
            const params = new URLSearchParams({
                search: search,
                id_tahun_ajaran: tahunAjaran,
                id_tingkatan: tingkatan,
                id_jurusan: jurusan,
                page: page
            });

            fetch(`{{ route('kelas.index') }}?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderTable(data.kelasList, page);
            })
            .catch(error => console.error('Error:', error));
        }

        // Function to render table
        function renderTable(kelasList, currentPage) {
            if (kelasList.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Belum ada data kelas</p>
                                <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Kelas</span> untuk mulai menambahkan data</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = kelasList.map((kelas, index) => {
                const no = String((currentPage - 1) * 10 + index + 1).padStart(3, '0');
                const waliKelas = kelas.wali_kelas ? kelas.wali_kelas.nama_lengkap : '-';
                return `
                    <tr class="hover:bg-slate-50/70 transition group">
                        <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                        ${kelas.nama_kelas.substring(0, 2)}
                                    </span>
                                </div>
                                <span class="font-semibold text-[#0F2145] text-sm">${kelas.nama_kelas}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">
                            ${kelas.tahun_ajaran.nama_tahun}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">
                            ${kelas.tingkatan.nama_tingkatan}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">
                            ${waliKelas}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    data-id="${kelas.id}"
                                    data-tingkatan="${kelas.id_tingkatan}"
                                    data-jurusan="${kelas.id_jurusan}"
                                    data-bagian="${kelas.id_bagian}"
                                    data-tahun="${kelas.id_tahun_ajaran}"
                                    data-wali="${kelas.id_wali_kelas || ''}"
                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <form action="/kelas/${kelas.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
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
                    </tr>
                `;
            }).join('');
            bindEditButtons();
        }

        // Function to bind edit buttons
        function bindEditButtons() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    openEditModal(this);
                });
            });
        }

        // Event listeners
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            currentPage = 1;
            loadData(currentSearch, currentTahunAjaran, currentTingkatan, currentJurusan, currentPage);
        });

        tahunAjaranSelect.addEventListener('change', function() {
            currentTahunAjaran = this.value;
            currentPage = 1;
            loadData(currentSearch, currentTahunAjaran, currentTingkatan, currentJurusan, currentPage);
        });

        tingkatanSelect.addEventListener('change', function() {
            currentTingkatan = this.value;
            currentPage = 1;
            loadData(currentSearch, currentTahunAjaran, currentTingkatan, currentJurusan, currentPage);
        });

        jurusanSelect.addEventListener('change', function() {
            currentJurusan = this.value;
            currentPage = 1;
            loadData(currentSearch, currentTahunAjaran, currentTingkatan, currentJurusan, currentPage);
        });

        btnSearch.addEventListener('click', function() {
            currentSearch = searchInput.value;
            currentTahunAjaran = tahunAjaranSelect.value;
            currentTingkatan = tingkatanSelect.value;
            currentJurusan = jurusanSelect.value;
            currentPage = 1;
            loadData(currentSearch, currentTahunAjaran, currentTingkatan, currentJurusan, currentPage);
        });

        if (btnReset) {
            btnReset.addEventListener('click', function() {
                searchInput.value = '';
                tahunAjaranSelect.value = '';
                tingkatanSelect.value = '';
                jurusanSelect.value = '';
                currentSearch = '';
                currentTahunAjaran = '';
                currentTingkatan = '';
                currentJurusan = '';
                currentPage = 1;
                loadData('', '', '', '', 1);
            });
        }

        // Initial load if no filters
        if (!currentSearch && !currentTahunAjaran && !currentTingkatan && !currentJurusan) {
            loadData('', '', '', '', 1);
        }

        // ---- Modal Create ----
        function openCreateModal() {
            modalCreate.style.display = 'block';
            document.body.classList.add('overflow-hidden');
        }
        function closeCreateModal() {
            modalCreate.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }

        // ---- Modal Edit ----
        function openEditModal(btn) {
            try {
                const d = btn.dataset;
                document.getElementById('editFormAction').action       = `/kelas/${d.id}`;
                document.getElementById('edit_id').value               = d.id;
                document.getElementById('edit_id_tingkatan').value     = d.tingkatan;
                document.getElementById('edit_id_jurusan').value       = d.jurusan;
                document.getElementById('edit_id_bagian').value        = d.bagian;
                document.getElementById('edit_id_tahun_ajaran').value  = d.tahun;
                document.getElementById('edit_id_wali_kelas').value    = d.wali;
                modalEdit.style.display = 'block';
                document.body.classList.add('overflow-hidden');
            } catch (err) {
                alert('Gagal memuat data. Silakan coba lagi.');
                console.error(err);
            }
        }
        function closeEditModal() {
            modalEdit.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }

        // ---- Buka modal jika ada error validasi ----
        @if ($errors->any())
            @if (old('_modal') === 'create')
                document.addEventListener('DOMContentLoaded', () => openCreateModal());
            @elseif (old('_modal') === 'edit')
                document.addEventListener('DOMContentLoaded', () => {
                    document.getElementById('modalEdit').style.display = 'block';
                    document.body.classList.add('overflow-hidden');
                });
            @endif
        @endif
    </script>
    @endpush

</x-app-layout>