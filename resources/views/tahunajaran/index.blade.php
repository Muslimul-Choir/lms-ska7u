<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Icon --}}
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Master Tahun Ajaran
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Tahun Akademik</p>
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
                <span class="text-slate-600 font-semibold">Tahun Ajaran</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">✕</button>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Tahun Ajaran</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data tahun akademik</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('tahunajaran.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                            🗑 Trash
                        </a>
                        <button type="button" id="btnTambahTahun"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md">
                            + Tambah Tahun
                        </button>
                    </div>
                </div>

                {{-- Search --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex items-center gap-2 max-w-md">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="searchInput"
                                value="{{ request('search') }}"
                                placeholder="Cari tahun ajaran..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition"
                            >
                        </div>
                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if(request('search'))
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
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase w-12">#</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Nama Tahun</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase w-24">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tahunAjaranTableBody" class="divide-y divide-slate-100">
                            @forelse ($tahunAjarans as $tahun)
                                <tr class="hover:bg-slate-50/70 transition">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($tahunAjarans->currentPage() - 1) * $tahunAjarans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold">
                                                    {{ substr($tahun->nama_tahun, 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">
                                                {{ $tahun->nama_tahun }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($tahun->is_aktif)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 border border-green-200 text-[10px] font-semibold rounded-full">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-50 text-slate-500 border border-slate-200 text-[10px] font-semibold rounded-full">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $tahun->id }}"
                                                data-nama="{{ $tahun->nama_tahun }}"
                                                data-is_aktif="{{ $tahun->is_aktif }}"
                                                class="btn-edit px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg">
                                                Edit
                                            </button>

                                            <form action="{{ route('tahunajaran.destroy', $tahun) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                        Belum ada data tahun ajaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($tahunAjarans->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-between">
                        <span class="text-xs text-slate-500">
                            {{ $tahunAjarans->firstItem() }} - {{ $tahunAjarans->lastItem() }} dari {{ $tahunAjarans->total() }}
                        </span>
                        {{ $tahunAjarans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('tahunajaran.modal-create')
    @include('tahunajaran.modal-edit')

    {{-- Script --}}
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit   = document.getElementById('modalEdit');
        const searchInput = document.getElementById('searchInput');
        const btnSearch   = document.getElementById('btnSearch');
        const btnReset    = document.getElementById('btnReset');
        const tableBody   = document.getElementById('tahunAjaranTableBody');

        let currentPage = 1;
        let currentSearch = '{{ $search }}';

        // Function to load data
        function loadData(search = '', page = 1) {
            fetch(`{{ route('tahunajaran.index') }}?search=${encodeURIComponent(search)}&page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderTable(data.tahunAjarans, page);
            })
            .catch(error => console.error('Error:', error));
        }

        // Function to render table
        function renderTable(tahunAjarans, currentPage) {
            if (tahunAjarans.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Belum ada data tahun ajaran</p>
                                <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Tahun Ajaran</span> untuk mulai menambahkan data</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = tahunAjarans.map((tahun, index) => {
                const no = String((currentPage - 1) * 5 + index + 1).padStart(3, '0');
                const statusHtml = tahun.is_aktif ?
                    `<span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 border border-green-200 text-[10px] font-semibold rounded-full">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Aktif
                    </span>` :
                    `<span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 text-red-700 border border-red-200 text-[10px] font-semibold rounded-full">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Tidak Aktif
                    </span>`;
                return `
                    <tr class="hover:bg-slate-50/70 transition group">
                        <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                        ${tahun.nama_tahun.substring(0, 2)}
                                    </span>
                                </div>
                                <span class="font-semibold text-[#0F2145] text-sm">${tahun.nama_tahun}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            ${statusHtml}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    data-id="${tahun.id}"
                                    data-nama="${tahun.nama_tahun}"
                                    data-is_aktif="${tahun.is_aktif}"
                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <form action="/tahunajaran/${tahun.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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
                    document.getElementById('editNamaTahun').value = this.dataset.nama;
                    document.getElementById('editIsAktif').checked = this.dataset.is_aktif == '1';
                    document.getElementById('formEdit').action = `/tahunajaran/${this.dataset.id}`;
                    modalEdit.style.display = 'block';
                });
            });
        }

        // Event listeners
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            currentPage = 1;
            loadData(currentSearch, currentPage);
        });

        btnSearch.addEventListener('click', function() {
            currentSearch = searchInput.value;
            currentPage = 1;
            loadData(currentSearch, currentPage);
        });

        if (btnReset) {
            btnReset.addEventListener('click', function() {
                searchInput.value = '';
                currentSearch = '';
                currentPage = 1;
                loadData('', 1);
            });
        }

        // Initial load if no search
        if (!currentSearch) {
            loadData('', 1);
        }

        // Modal events
        document.getElementById('btnTambahTahun').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('closeCreate').addEventListener('click',     () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate').addEventListener('click',    () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click',   () => modalCreate.style.display = 'none');

        document.getElementById('closeEdit').addEventListener('click',       () => modalEdit.style.display = 'none');
        document.getElementById('cancelEdit').addEventListener('click',      () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit').addEventListener('click',     () => modalEdit.style.display = 'none');

        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>