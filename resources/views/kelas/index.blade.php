<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-slate-900 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                        <circle cx="12" cy="11" r="1" fill="currentColor" />
                    </svg>
                </div>
                <div>
                    <h2
                        class="font-heading font-bold text-slate-800 dark:text-slate-100 text-base leading-tight tracking-tight">
                        Manajemen Kelas
                    </h2>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">Data
                        Master</p>
                </div>
            </div>
            <div class="flex gap-2 justify-between">
                {{-- Tombol Trash --}}
                <div class="flex items-end">
                    <a href="{{ route('kelas.trash') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800/50 hover:text-red-600 dark:hover:text-red-400 transition-all">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Tempat Sampah
                    </a>
                </div>

                {{-- Tombol Tambah --}}
                <div class="flex items-end">
                    <button type="button" onclick="openCreateModal()"
                        class="inline-flex items-center gap-2 rounded-lg bg-slate-900 dark:bg-slate-100 px-4 py-2 text-sm font-semibold text-white dark:text-slate-900 hover:bg-slate-700 dark:hover:bg-white transition-all shadow-sm">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kelas
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- ── ALERT SUCCESS ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                x-init="setTimeout(() => show = false, 4000)"
                class="flex items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 dark:border-emerald-800/50 dark:bg-emerald-900/20 px-4 py-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span
                        class="text-sm text-emerald-800 dark:text-emerald-300 font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors p-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- ── ALERT ERROR ── --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between gap-3 rounded-xl border border-red-200 bg-red-50 dark:border-red-800/50 dark:bg-red-900/20 px-4 py-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="text-sm text-red-800 dark:text-red-300 font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors p-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- ── TOOLBAR ── --}}
        <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/60 shadow-sm">
            <form method="GET" action="{{ route('kelas.index') }}" id="filterForm">
                <div class="p-4 sm:p-5">

                    {{-- Row 1: Filters --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">

                        {{-- Search --}}
                        <div class="flex-1 min-w-[180px]">
                            <label
                                class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">
                                Cari Kelas
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Tingkatan, jurusan, bagian..."
                                    class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 pl-8 pr-3 text-sm text-slate-700 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:border-slate-400 dark:focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 transition-all outline-none">
                            </div>
                        </div>

                        {{-- Filter Tahun Ajaran --}}
                        <div class="min-w-[150px]">
                            <label
                                class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">
                                Tahun Ajaran
                            </label>
                            <select name="id_tahun_ajaran"
                                class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-slate-400 dark:focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 transition-all outline-none cursor-pointer"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Tahun</option>
                                @foreach ($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}"
                                        {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama_tahun }}@if ($ta->is_aktif)
                                            (Aktif)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Tingkatan --}}
                        <div class="min-w-[130px]">
                            <label
                                class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">
                                Tingkatan
                            </label>
                            <select name="id_tingkatan"
                                class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-slate-400 dark:focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 transition-all outline-none cursor-pointer"
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

                        {{-- Filter Jurusan --}}
                        <div class="min-w-[150px]">
                            <label
                                class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1.5">
                                Jurusan
                            </label>
                            <select name="id_jurusan"
                                class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-slate-400 dark:focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 transition-all outline-none cursor-pointer"
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

                        {{-- Reset --}}
                        @if (request()->hasAny(['search', 'id_tahun_ajaran', 'id_tingkatan', 'id_jurusan']))
                            <div class="flex items-end">
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-700 dark:hover:text-slate-200 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        @endif

                    </div>

                </div>

                {{-- Active Filter Bar --}}
                @if (request()->hasAny(['search', 'id_tahun_ajaran', 'id_tingkatan', 'id_jurusan']))
                    <div
                        class="px-4 sm:px-5 py-2.5 border-t border-slate-100 dark:border-slate-700/60 bg-slate-50 dark:bg-slate-800/40 flex items-center gap-2 flex-wrap">
                        <span
                            class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Filter
                            aktif:</span>
                        @if (request('search'))
                            <span
                                class="inline-flex items-center gap-1 text-xs bg-slate-800 dark:bg-slate-200 text-white dark:text-slate-900 px-2.5 py-1 rounded-md font-medium">
                                "{{ request('search') }}"
                            </span>
                        @endif
                        <span class="text-xs text-slate-400 dark:text-slate-500 ml-auto">{{ $kelas->total() }} hasil
                            ditemukan</span>
                    </div>
                @endif
            </form>
        </div>

        {{-- ── TABLE ── --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/60 shadow-sm overflow-hidden">

            {{-- Table header info --}}
            <div
                class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 dark:border-slate-700/60">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-4 rounded-full bg-slate-900 dark:bg-slate-200"></div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Daftar Kelas</span>
                </div>
                <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                    Total <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $kelas->total() }}</span>
                    kelas
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr
                            class="border-b border-slate-100 dark:border-slate-700/60 bg-slate-50/80 dark:bg-slate-800/40">
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-12">
                                No</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                                Kelas</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden md:table-cell">
                                Jurusan</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden lg:table-cell">
                                Tahun Ajaran</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden lg:table-cell">
                                Wali Kelas</th>
                            <th
                                class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-24">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/60">
                        @forelse ($kelas as $index => $k)
                            <tr
                                class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors duration-100 group">
                                <td
                                    class="px-5 py-3.5 text-xs text-slate-400 dark:text-slate-500 tabular-nums font-medium">
                                    {{ $kelas->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-slate-900 dark:bg-slate-700 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-800 dark:group-hover:bg-slate-600 transition-colors">
                                            <span class="text-[10px] font-bold text-amber-400 tracking-tight">
                                                {{ $k->Tingkatan?->nama_tingkatan ?? '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-tight">
                                                {{ $k->Tingkatan?->nama_tingkatan ?? '-' }}
                                                {{ $k->Bagian?->nama_bagian ?? '-' }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 md:hidden">
                                                {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 hidden md:table-cell">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                    </span>
                                </td>
                                <td
                                    class="px-5 py-3.5 text-sm text-slate-600 dark:text-slate-300 hidden lg:table-cell">
                                    {{ $k->TahunAjaran?->nama_tahun ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center flex-shrink-0">
                                            <span class="text-[9px] font-bold text-slate-500 dark:text-slate-400">
                                                {{ strtoupper(substr($k->WaliKelas?->nama_lengkap ?? '?', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-sm text-slate-600 dark:text-slate-300">
                                            {{ $k->WaliKelas?->nama_lengkap ?? '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Edit --}}
                                        <button type="button" onclick="openEditModal(this)"
                                            data-id="{{ $k->id }}" data-id-tingkatan="{{ $k->id_tingkatan }}"
                                            data-id-jurusan="{{ $k->id_jurusan }}"
                                            data-id-bagian="{{ $k->id_bagian }}"
                                            data-id-tahun-ajaran="{{ $k->id_tahun_ajaran }}"
                                            data-id-wali-kelas="{{ $k->id_wali_kelas }}" title="Edit"
                                            class="inline-flex items-center justify-center h-7 w-7 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 hover:border-amber-200 dark:hover:border-amber-800/50 hover:text-amber-600 dark:hover:text-amber-400 transition-all">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        {{-- Delete --}}
                                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST"
                                            onsubmit="return confirmDelete(event, '{{ $k->Tingkatan?->nama_tingkatan }} {{ $k->Bagian?->nama_bagian }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center h-7 w-7 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800/50 hover:text-red-600 dark:hover:text-red-400 transition-all">
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
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-300 dark:text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Belum
                                                ada data kelas</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Ubah filter atau
                                                tambahkan kelas baru</p>
                                        </div>
                                        <button type="button" onclick="openCreateModal()"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 px-3 py-1.5 rounded-lg transition-colors mt-1">
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
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $kelas->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL CREATE --}}
    @include('kelas.modal-create', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    {{-- MODAL EDIT --}}
    @include('kelas.modal-edit', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    @push('scripts')
        <script>
            function openCreateModal() {
                document.getElementById('modalCreate').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateModal() {
                document.getElementById('modalCreate').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function openEditModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEdit');
                document.getElementById('editFormAction').action = `/kelas/${d.id}`;
                document.getElementById('edit_id').value = d.id;
                document.getElementById('edit_id_tingkatan').value = d.idTingkatan;
                document.getElementById('edit_id_jurusan').value = d.idJurusan;
                document.getElementById('edit_id_bagian').value = d.idBagian;
                document.getElementById('edit_id_tahun_ajaran').value = d.idTahunAjaran;
                document.getElementById('edit_id_wali_kelas').value = d.idWaliKelas;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditModal() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function confirmDelete(event, nama) {
                if (!confirm(`Yakin ingin menghapus kelas "${nama}"?\nData akan dipindahkan ke tempat sampah.`)) {
                    event.preventDefault();
                    return false;
                }
                return true;
            }
            @if ($errors->any())
                @if (old('_modal') === 'create')
                    document.addEventListener('DOMContentLoaded', () => openCreateModal());
                @elseif (old('_modal') === 'edit')
                    document.addEventListener('DOMContentLoaded', () => {
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    });
                @endif
            @endif
            document.addEventListener('DOMContentLoaded', () => {
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