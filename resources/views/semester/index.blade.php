<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Master Semester</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Semester</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data periode semester akademik</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('semester.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Arsip
                            @if ($trashCount > 0)
                                <span
                                    class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                            @endif
                        </a>
                        <button type="button" onclick="openCreateModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
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
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama semester..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Tahun Ajaran Filter --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest sr-only">Tahun
                                Ajaran</label>
                            <select id="tahunAjaranSelect"
                                class="rounded-xl border min-w-[160px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach ($tahunAjarans as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->id }}"
                                        {{ request('tahun_ajaran') == $tahunAjaran->id ? 'selected' : '' }}>
                                        {{ $tahunAjaran->nama_tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if (request('search') || request('tahun_ajaran'))
                            <a href="{{ route('semester.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Reset
                            </a>
                        @endif

                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Nama Semester</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Tahun Ajaran</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($semesters as $semester)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($semesters->currentPage() - 1) * $semesters->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($semester->nama_semester, 0, 2) }}
                                                </span>
                                            </div>
                                            <span
                                                class="font-semibold text-gray-800 text-sm">{{ $semester->nama_semester }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ $semester->tahunAjaran->nama_tahun ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($semester->is_aktif)
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-full">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-bold rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Edit --}}
                                            <button type="button" onclick="openEditModal(this)"
                                                data-id="{{ $semester->id }}"
                                                data-route="{{ route('semester.update', $semester->id) }}"
                                                data-nama="{{ $semester->nama_semester }}"
                                                data-id-tahun-ajaran="{{ $semester->id_tahun_ajaran }}"
                                                data-is-aktif="{{ $semester->is_aktif ? '1' : '0' }}" title="Edit"
                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('semester.destroy', $semester->id) }}"
                                                method="POST" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                            <div
                                                class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data semester</p>
                                            <p class="text-gray-300 text-xs">Klik <span
                                                    class="font-semibold text-gray-400">+ Tambah Semester</span> untuk
                                                mulai menambahkan</p>
                                            <button type="button" onclick="openCreateModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Semester
                                            </button>
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
                            <span
                                class="font-semibold text-gray-700">{{ $semesters->firstItem() }}–{{ $semesters->lastItem() }}</span>
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

    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')

    @include('semester.modal-create')
    @include('semester.modal-edit')

    @push('scripts')
        <script>
            /* ── Search ── */
            const searchInput = document.getElementById('searchInput');
            const tahunAjaranSelect = document.getElementById('tahunAjaranSelect');
            const btnSearch = document.getElementById('btnSearch');

            function doSearch() {
                const params = new URLSearchParams();
                if (searchInput.value.trim() !== '') params.append('search', searchInput.value.trim());
                if (tahunAjaranSelect.value !== '') params.append('tahun_ajaran', tahunAjaranSelect.value);
                window.location.href = `{{ route('semester.index') }}?${params.toString()}`;
            }

            btnSearch.addEventListener('click', doSearch);
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') doSearch();
            });
            tahunAjaranSelect.addEventListener('change', doSearch);

            /* ── Modal Create ── */
            function openCreateModal() {
                document.getElementById('modalCreate').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateModal() {
                document.getElementById('modalCreate').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Edit ── */
            function openEditModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEdit');
                const form = document.getElementById('editFormAction');
                const btn = document.getElementById('editSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route').value = d.route;
                document.getElementById('edit_nama_semester').value = d.nama;
                document.getElementById('edit_id_tahun_ajaran').value = d.idTahunAjaran;
                document.getElementById('edit_is_aktif').checked = d.isAktif === '1';

                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditModal() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Confirm Delete ── */
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit */
                const createForm = document.getElementById('createFormAction');
                const createBtn = document.getElementById('createSubmitBtn');
                const editForm = document.getElementById('editFormAction');
                const editBtn = document.getElementById('editSubmitBtn');

                if (createForm) {
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

                if (editForm) {
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

                /* Re-open modal on validation error */
                @if ($errors->any())
                    @if (old('_modal') === 'create')
                        openCreateModal();
                    @elseif (old('_modal') === 'edit')
                        const savedRoute = document.getElementById('edit_route').value;
                        if (savedRoute) document.getElementById('editFormAction').action = savedRoute;
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @endif
                @endif

                /* Close modal on backdrop click */
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
            });
        </script>
    @endpush
</x-app-layout>
