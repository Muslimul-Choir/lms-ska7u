<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Master Semester</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Master Data</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Semester</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Daftar Semester
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Kelola data periode semester akademik</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('semester.trash') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Tempat Sampah
                        </a>
                        <button type="button" id="btnTambahSemester"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                             Tambah Semester
                        </button>
                    </div>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- Search Input --}}
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama semester..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Tahun Ajaran Filter --}}
                        <div class="relative">
                            <select id="tahunAjaranSelect"
                                    class="pl-3 pr-8 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition appearance-none">
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach($tahunAjarans as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->id }}" {{ request('tahun_ajaran') == $tahunAjaran->id ? 'selected' : '' }}>
                                        {{ $tahunAjaran->nama_tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if(request('search') || request('tahun_ajaran'))
                            <button type="button" id="btnReset"
                               class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-xl transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Nama Semester</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tahun Ajaran</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">Status</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="semesterTableBody" class="divide-y divide-gray-100">
                            @forelse ($semesters as $semester)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($semesters->currentPage() - 1) * $semesters->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($semester->nama_semester, 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">{{ $semester->nama_semester }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">
                                            {{ $semester->tahunAjaran->nama_tahun ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($semester->is_aktif)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-bold rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $semester->id }}"
                                                data-nama="{{ $semester->nama_semester }}"
                                                data-id_tahun_ajaran="{{ $semester->id_tahun_ajaran }}"
                                                data-is_aktif="{{ $semester->is_aktif }}"
                                                class="btn-edit w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('semester.destroy', $semester) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus semester ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                        title="Hapus">
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
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data semester</p>
                                            <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Semester</span> untuk mulai menambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($semesters->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $semesters->firstItem() }}–{{ $semesters->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $semesters->total() }}</span>
                            entri
                        </p>
                        {{ $semesters->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    @include('semester.modal-create')
    @include('semester.modal-edit')

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // =========================
        // ELEMENT
        // =========================
        const modalCreate       = document.getElementById('modalCreate');
        const modalEdit         = document.getElementById('modalEdit');

        const searchInput       = document.getElementById('searchInput');
        const tahunAjaranSelect = document.getElementById('tahunAjaranSelect');

        const btnSearch         = document.getElementById('btnSearch');
        const btnReset          = document.getElementById('btnReset');

        const btnTambahSemester = document.getElementById('btnTambahSemester');

        // =========================
        // SEARCH
        // =========================
        function doSearch() {
            const params = new URLSearchParams();

            if (searchInput.value.trim() !== '') {
                params.append('search', searchInput.value.trim());
            }

            if (tahunAjaranSelect.value !== '') {
                params.append('tahun_ajaran', tahunAjaranSelect.value);
            }

            window.location.href =
                `{{ route('semester.index') }}?${params.toString()}`;
        }

        if (btnSearch) {
            btnSearch.addEventListener('click', doSearch);
        }

        if (searchInput) {
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    doSearch();
                }
            });
        }

        if (tahunAjaranSelect) {
            tahunAjaranSelect.addEventListener('change', doSearch);
        }

        if (btnReset) {
            btnReset.addEventListener('click', function () {
                window.location.href = `{{ route('semester.index') }}`;
            });
        }

        // =========================
        // MODAL CREATE
        // =========================
        function openCreateModal() {
            if (!modalCreate) return;

            modalCreate.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            if (!modalCreate) return;

            modalCreate.style.display = 'none';
            document.body.style.overflow = '';
        }

        if (btnTambahSemester) {
            btnTambahSemester.addEventListener('click', openCreateModal);
        }

        const closeCreate = document.getElementById('closeCreate');
        const cancelCreate = document.getElementById('cancelCreate');
        const overlayCreate = document.getElementById('overlayCreate');

        if (closeCreate) {
            closeCreate.addEventListener('click', closeCreateModal);
        }

        if (cancelCreate) {
            cancelCreate.addEventListener('click', closeCreateModal);
        }

        if (overlayCreate) {
            overlayCreate.addEventListener('click', closeCreateModal);
        }

        // =========================
        // MODAL EDIT
        // =========================
        function openEditModal(id, nama, tahunAjaranId, isAktif) {

            if (!modalEdit) return;

            const inputNama       = document.getElementById('editNamaSemester');
            const inputTahun      = document.getElementById('editIdTahunAjaran');
            const inputIsAktif    = document.getElementById('editIsAktif');
            const formEdit        = document.getElementById('formEdit');

            if (inputNama) {
                inputNama.value = nama || '';
            }

            if (inputTahun) {
                inputTahun.value = tahunAjaranId || '';
            }

            if (inputIsAktif) {
                inputIsAktif.checked = isAktif == 1;
            }

            if (formEdit) {
                formEdit.action = `/semester/${id}`;
            }

            modalEdit.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {

            if (!modalEdit) return;

            modalEdit.style.display = 'none';
            document.body.style.overflow = '';
        }

        const closeEdit = document.getElementById('closeEdit');
        const cancelEdit = document.getElementById('cancelEdit');
        const overlayEdit = document.getElementById('overlayEdit');

        if (closeEdit) {
            closeEdit.addEventListener('click', closeEditModal);
        }

        if (cancelEdit) {
            cancelEdit.addEventListener('click', closeEditModal);
        }

        if (overlayEdit) {
            overlayEdit.addEventListener('click', closeEditModal);
        }

        // =========================
        // BIND EDIT BUTTON
        // =========================
        document.querySelectorAll('.btn-edit').forEach(function (btn) {

            btn.addEventListener('click', function () {

                openEditModal(
                    this.dataset.id,
                    this.dataset.nama,
                    this.dataset.id_tahun_ajaran,
                    this.dataset.is_aktif
                );

            });

        });

        // =========================
        // ESC CLOSE MODAL
        // =========================
        document.addEventListener('keydown', function (e) {

            if (e.key === 'Escape') {

                closeCreateModal();
                closeEditModal();

            }

        });

        // =========================
        // AUTO OPEN CREATE MODAL
        // =========================
        @if ($errors->any())
            openCreateModal();
        @endif

    });
</script>

</x-app-layout>