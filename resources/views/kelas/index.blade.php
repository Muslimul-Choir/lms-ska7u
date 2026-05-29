<x-app-layout>
    <x-slot name="header">

        <div class="flex items-center justify-between flex-wrap gap-3">

            {{-- Left: Icon + Title --}}
            <div class="flex items-center gap-3.5">
                <div class="relative flex-shrink-0">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-md shadow-amber-200 dark:shadow-amber-900/40">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                            <circle cx="12" cy="11" r="1" fill="currentColor" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-base font-bold tracking-wide text-slate-900 dark:text-white leading-tight">
                        Manajemen Kelas
                    </h1>
                    <p
                        class="text-[11px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">
                        Data Master
                    </p>
                </div>
            </div>


        </div>
    </x-slot>

    <div class="space-y-5">
        {{-- ═══════════════════════════════════════════
             FILTER TOOLBAR
        ═══════════════════════════════════════════ --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm">
            <form method="GET" action="{{ route('kelas.index') }}" id="filterForm">

                <div class="p-4 sm:p-5">
                    <div class="flex flex-col gap-4 xl:gap-16 xl:flex-row xl:items-end xl:justify-between">

                        {{-- Left: Filters --}}
                        <div class="grid flex-1 gap-4 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">

                            {{-- Tingkatan --}}
                            <div class="">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Tingkatan
                                </label>
                                <select name="id_tingkatan"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-amber-400 dark:focus:border-amber-500 focus:ring-2 focus:ring-amber-100 dark:focus:ring-amber-900/30 transition-all outline-none cursor-pointer"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Tingkat</option>
                                    @foreach ($tingkatanList as $t)
                                        <option value="{{ $t->id }}"
                                            {{ request('id_tingkatan') == $t->id ? 'selected' : '' }}>
                                            {{ $t->nama_tingkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Jurusan --}}
                            <div class="">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Jurusan
                                </label>
                                <select name="id_jurusan"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-amber-400 dark:focus:border-amber-500 focus:ring-2 focus:ring-amber-100 dark:focus:ring-amber-900/30 transition-all outline-none cursor-pointer"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($jurusanList as $j)
                                        <option value="{{ $j->id }}"
                                            {{ request('id_jurusan') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Bagian --}}
                            <div class="">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Bagian
                                </label>
                                <select name="id_bagian"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-amber-400 dark:focus:border-amber-500 focus:ring-2 focus:ring-amber-100 dark:focus:ring-amber-900/30 transition-all outline-none cursor-pointer"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Bagian</option>
                                    @foreach ($bagianList as $j)
                                        <option value="{{ $j->id }}"
                                            {{ request('id_bagian') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_bagian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Tahun Ajaran
                                </label>
                                <select name="id_tahun_ajaran"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-amber-400 dark:focus:border-amber-500 focus:ring-2 focus:ring-amber-100 dark:focus:ring-amber-900/30 transition-all outline-none cursor-pointer"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunAjaranList as $ta)
                                        <option value="{{ $ta->id }}"
                                            {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun }}{{ $ta->is_aktif ? ' (Aktif)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Reset --}}
                            @if (request()->filled('id_tahun_ajaran') ||
                                    request()->filled('id_tingkatan') ||
                                    request()->filled('id_jurusan') ||
                                    request()->filled('id_bagian'))
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 hover:border-amber-200 dark:hover:border-amber-800/40 hover:text-amber-500 dark:hover:text-amber-400 transition-all duration-150">
                                    <svg class="h-5 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        {{-- Right: Actions --}}
                        <div class="flex items-center justify-end gap-2 shrink-0">
                            <a href="{{ route('kelas.trash') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-rose-200 dark:border-rose-700/60 bg-rose-50 dark:bg-rose-900/30 px-3.5 py-2 text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-800/60 hover:border-rose-300 dark:hover:border-rose-600 hover:text-rose-700 dark:hover:text-rose-300 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Tempat Sampah</span>
                            </a>

                            <button type="button" onclick="openCreateModal()"
                                class="inline-flex items-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-amber-200 dark:shadow-amber-900/30 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Kelas
                            </button>
                        </div>

                    </div>

                </div>
            </form>
        </div>

        {{-- ═══════════════════════════════════════════
             DATA TABLE
        ═══════════════════════════════════════════ --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm overflow-hidden">

            {{-- Table Top Bar --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="block w-1 h-5 rounded-full bg-amber-500"></span>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-tight">Daftar
                        Kelas</span>
                </div>
                <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                    Total &nbsp;<span class="font-bold text-slate-700 dark:text-slate-200">{{ $kelas->total() }}</span>
                    &nbsp;kelas
                </span>
            </div>

            {{-- Scrollable Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/30">
                            <th
                                class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-12">
                                no</th>
                            <th
                                class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                                Kelas</th>
                            <th
                                class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden md:table-cell">
                                Jurusan</th>
                            <th
                                class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden lg:table-cell">
                                Tahun Ajaran</th>
                            <th
                                class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden lg:table-cell">
                                Wali Kelas</th>
                            <th
                                class="px-5 py-3 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-24">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/70">
                        @forelse ($kelas as $index => $k)
                            <tr
                                class="group even:bg-slate-50 dark:even:bg-slate-800/30 hover:bg-amber-50/40 dark:hover:bg-amber-900/10 transition-colors duration-100">

                                {{-- No --}}
                                <td
                                    class="px-5 py-3.5 text-xs text-slate-400 dark:text-slate-500 tabular-nums font-medium">
                                    {{ $kelas->firstItem() + $index }}
                                </td>

                                {{-- Kelas --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        {{-- Badge Tingkatan --}}
                                        <div
                                            class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-sm shadow-amber-200 dark:shadow-amber-900/30 group-hover:bg-amber-600 transition-colors duration-150">
                                            <span
                                                class="text-[11px] font-extrabold text-white tracking-tight leading-none">
                                                {{ $k->Tingkatan?->nama_tingkatan ?? '?' }}
                                            </span>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-tight">
                                                {{ $k->Tingkatan?->nama_tingkatan ?? '-' }}
                                                {{ $k->Bagian?->nama_bagian ?? '-' }}
                                            </p>
                                            {{-- Jurusan visible on mobile only --}}
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 md:hidden">
                                                {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Jurusan --}}
                                <td class="px-5 py-3.5 hidden md:table-cell">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/70 dark:border-slate-700/50">
                                        {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                    </span>
                                </td>

                                {{-- Tahun Ajaran --}}
                                <td class="px-5 py-3.5 hidden lg:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                                        {{ $k->TahunAjaran?->nama_tahun ?? '-' }}
                                    </span>
                                </td>

                                {{-- Wali Kelas --}}
                                <td class="px-5 py-3.5 hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-900/40 border border-amber-200 dark:border-amber-800/50 flex items-center justify-center flex-shrink-0">
                                            <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400">
                                                {{ strtoupper(substr($k->WaliKelas?->nama_lengkap ?? '?', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-sm text-slate-600 dark:text-slate-300">
                                            {{ $k->WaliKelas?->nama_lengkap ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Edit --}}
                                        <button onclick="openEditModal(this)" data-id="{{ $k->id }}"
                                            data-route="{{ route('kelas.update', $k->id) }}"
                                            data-id-tingkatan="{{ $k->id_tingkatan }}"
                                            data-id-jurusan="{{ $k->id_jurusan }}"
                                            data-id-bagian="{{ $k->id_bagian }}"
                                            data-id-tahun-ajaran="{{ $k->id_tahun_ajaran }}"
                                            data-id-wali-kelas="{{ $k->id_wali_kelas ?? '' }}" title="Edit"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-xl border border-amber-200 dark:border-amber-700/50 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/60 hover:border-amber-300 dark:hover:border-amber-600 hover:text-amber-700 dark:hover:text-amber-300 transition-all duration-150">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST"
                                            onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-xl border border-red-200 dark:border-red-700/50 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/60 hover:border-red-300 dark:hover:border-red-600 hover:text-red-700 dark:hover:text-red-300 transition-all duration-150">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/40 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-amber-300 dark:text-amber-700" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Belum
                                                ada data kelas</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">Ubah filter atau
                                                tambahkan kelas baru</p>
                                        </div>
                                        <button type="button" onclick="openCreateModal()"
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2 text-xs font-semibold text-white shadow-sm shadow-amber-200 dark:shadow-amber-900/30 transition-all duration-150 mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah Kelas
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($kelas->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 dark:border-slate-800">
                    {{ $kelas->links() }}
                </div>
            @endif
        </div>

    </div>
    @include('components.alerts.confirm-update')
    @include('components.alerts.confirm-delete')

    {{-- ═══════════════════════════════════════════
         MODAL CREATE
    ═══════════════════════════════════════════ --}}
    @include('kelas.modal-create', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    {{-- ═══════════════════════════════════════════
         MODAL EDIT
    ═══════════════════════════════════════════ --}}
    @include('kelas.modal-edit', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    @push('scripts')
        <script>
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

                document.getElementById('edit_id_tingkatan').value = d.idTingkatan ?? '';
                document.getElementById('edit_id_jurusan').value = d.idJurusan ?? '';
                document.getElementById('edit_id_bagian').value = d.idBagian ?? '';
                document.getElementById('edit_id_tahun_ajaran').value = d.idTahunAjaran ?? '';
                document.getElementById('edit_id_wali_kelas').value = d.idWaliKelas ?? '';

                // Reset submit button state (jika sebelumnya pernah submit)
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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit edit dan create */
                const editForm = document.getElementById('editFormAction');
                const editBtn = document.getElementById('editSubmitBtn');
                const createForm = document.getElementById('createFormAction');
                const createBtn = document.getElementById('createSubmitBtn');

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
                        if (savedRoute) {
                            document.getElementById('editFormAction').action = savedRoute;
                        }
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
