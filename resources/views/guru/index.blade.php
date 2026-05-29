{{-- index guru --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">

            {{-- Left: Icon + Title --}}
            <div class="flex items-center gap-3.5">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-indigo-900/40">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-base font-bold tracking-wide text-slate-900 dark:text-white leading-tight">
                        Manajemen Guru
                    </h1>
                    <p class="text-[11px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">
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
        <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm">
            <form method="GET" action="{{ route('guru.index') }}" id="filterForm">
                <div class="p-4 sm:p-5">
                    <div class="flex flex-col gap-4 xl:gap-16 xl:flex-row xl:items-end xl:justify-between">

                        {{-- Left: Filters --}}
                        <div class="grid flex-1 gap-4 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">

                            {{-- Search --}}
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Cari Guru
                                </label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau email..."
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 transition-all outline-none">
                            </div>

                            {{-- Status Pengajar --}}
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">
                                    Status
                                </label>
                                <select name="status_pengajar"
                                    class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2 px-3 text-sm text-slate-700 dark:text-slate-200 focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-900/30 transition-all outline-none cursor-pointer"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pengajar"  {{ request('status_pengajar') == 'pengajar'  ? 'selected' : '' }}>Pengajar</option>
                                    <option value="walikelas" {{ request('status_pengajar') == 'walikelas' ? 'selected' : '' }}>Wali Kelas</option>
                                    <option value="keduanya"  {{ request('status_pengajar') == 'keduanya'  ? 'selected' : '' }}>Keduanya</option>
                                </select>
                            </div>

                            {{-- Reset --}}
                            @if (request()->filled('search') || request()->filled('status_pengajar'))
                                <div class="flex items-end">
                                    <a href="{{ route('guru.index') }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-200 dark:hover:border-indigo-800/40 hover:text-indigo-500 dark:hover:text-indigo-400 transition-all duration-150">
                                        <svg class="h-5 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </a>
                                </div>
                            @endif

                        </div>

                        {{-- Right: Actions --}}
                        <div class="flex items-center justify-end gap-2 shrink-0 flex-wrap">

                            {{-- Trash --}}
                            <a href="{{ route('guru.trash') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-rose-200 dark:border-rose-700/60 bg-rose-50 dark:bg-rose-900/30 px-3.5 py-2 text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-800/60 hover:border-rose-300 dark:hover:border-rose-600 hover:text-rose-700 dark:hover:text-rose-300 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="hidden sm:inline">Arsip</span>
                                @if ($trashCount > 0)
                                    <span class="bg-rose-500 text-white text-[10px] font-bold rounded-full px-1.5 py-0.5 leading-none">{{ $trashCount }}</span>
                                @endif
                            </a>

                            {{-- Send Email Semua --}}
                            <form action="{{ route('guru.sendEmailAll') }}" method="POST"
                                onsubmit="return confirm('Kirim email akun ke SEMUA guru? Password mereka akan direset.')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-amber-200 dark:border-amber-700/60 bg-amber-50 dark:bg-amber-900/30 px-3.5 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/60 hover:border-amber-300 dark:hover:border-amber-600 hover:text-amber-700 dark:hover:text-amber-300 transition-all duration-150">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Kirim Email Semua</span>
                                </button>
                            </form>

                            {{-- Export --}}
                            <a href="{{ route('guru.export') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 dark:border-emerald-700/60 bg-emerald-50 dark:bg-emerald-900/30 px-3.5 py-2 text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-800/60 hover:border-emerald-300 dark:hover:border-emerald-600 hover:text-emerald-700 dark:hover:text-emerald-300 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="hidden sm:inline">Export Excel</span>
                            </a>

                            {{-- Import --}}
                            <button type="button" onclick="openImportGuruModal()"
                                class="inline-flex items-center gap-2 rounded-xl border border-sky-200 dark:border-sky-700/60 bg-sky-50 dark:bg-sky-900/30 px-3.5 py-2 text-sm font-medium text-sky-600 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800/60 hover:border-sky-300 dark:hover:border-sky-600 hover:text-sky-700 dark:hover:text-sky-300 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span class="hidden sm:inline">Import Excel</span>
                            </button>

                            {{-- Tambah --}}
                            <button type="button" onclick="openCreateGuruModal()"
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-500 hover:bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-indigo-200 dark:shadow-indigo-900/30 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Guru
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ═══════════════════════════════════════════
             ALERTS
        ═══════════════════════════════════════════ --}}
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-700/50 px-5 py-3.5 text-sm font-medium text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-700/50 px-5 py-3.5 text-sm font-medium text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif
        @if (session('skipped_details'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50 dark:bg-amber-900/20 dark:border-amber-700/50 px-5 py-4 text-sm text-amber-700 dark:text-amber-300">
                <p class="font-semibold mb-2">Baris yang ditolak:</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="border-b border-amber-200 dark:border-amber-700/50">
                                <th class="py-1.5 pr-4 text-left font-bold">Baris</th>
                                <th class="py-1.5 pr-4 text-left font-bold">Email</th>
                                <th class="py-1.5 text-left font-bold">Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100 dark:divide-amber-800/40">
                            @foreach (session('skipped_details') as $skipped)
                                <tr>
                                    <td class="py-1.5 pr-4">{{ $skipped['row'] }}</td>
                                    <td class="py-1.5 pr-4">{{ $skipped['email'] }}</td>
                                    <td class="py-1.5">{{ $skipped['reason'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════
             DATA TABLE
        ═══════════════════════════════════════════ --}}
        <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm overflow-hidden">

            {{-- Table Top Bar --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="block w-1 h-5 rounded-full bg-indigo-500"></span>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-tight">Daftar Guru</span>
                </div>
                <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                    Total &nbsp;<span class="font-bold text-slate-700 dark:text-slate-200">{{ $gurus->total() }}</span>&nbsp;guru
                </span>
            </div>

            {{-- Scrollable Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/30">
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-12">no</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">Nama Lengkap</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden md:table-cell">Email</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 hidden lg:table-cell">Status</th>
                            <th class="px-5 py-3 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/70">
                        @forelse ($gurus as $index => $guru)
                            <tr class="group even:bg-slate-50 dark:even:bg-slate-800/30 hover:bg-indigo-50/40 dark:hover:bg-indigo-900/10 transition-colors duration-100">

                                {{-- No --}}
                                <td class="px-5 py-3.5 text-xs text-slate-400 dark:text-slate-500 tabular-nums font-medium">
                                    {{ $gurus->firstItem() + $index }}
                                </td>

                                {{-- Nama --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-sm shadow-indigo-200 dark:shadow-indigo-900/30 group-hover:bg-indigo-600 transition-colors duration-150">
                                            <span class="text-[11px] font-extrabold text-white tracking-tight leading-none">
                                                {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-tight">
                                                {{ $guru->nama_lengkap }}
                                            </p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 md:hidden">
                                                {{ $guru->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-5 py-3.5 hidden md:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-300">
                                        {{ $guru->email }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-3.5 hidden lg:table-cell">
                                    @php
                                        $badgeClass = match($guru->status_pengajar) {
                                            'pengajar'  => 'bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 border-sky-200/70 dark:border-sky-700/50',
                                            'walikelas' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 border-purple-200/70 dark:border-purple-700/50',
                                            'keduanya'  => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border-emerald-200/70 dark:border-emerald-700/50',
                                            default     => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200/70 dark:border-slate-700/50',
                                        };
                                        $badgeLabel = match($guru->status_pengajar) {
                                            'pengajar'  => 'Pengajar',
                                            'walikelas' => 'Wali Kelas',
                                            'keduanya'  => 'Keduanya',
                                            default     => ucfirst($guru->status_pengajar),
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $badgeClass }}">
                                        {{ $badgeLabel }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">

                                        {{-- Send Email --}}
                                        <form action="{{ route('guru.sendEmail', $guru->id) }}" method="POST"
                                            onsubmit="return confirm('Kirim email akun ke {{ $guru->nama_lengkap }}? Password akan direset.')">
                                            @csrf
                                            <button type="submit" title="Kirim Email"
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-xl border border-amber-200 dark:border-amber-700/50 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/60 hover:border-amber-300 dark:hover:border-amber-600 hover:text-amber-700 dark:hover:text-amber-300 transition-all duration-150">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- Edit --}}
                                        <button onclick="openEditGuruModal(this)"
                                            data-id="{{ $guru->id }}"
                                            data-route="{{ route('guru.update', $guru->id) }}"
                                            data-nama="{{ $guru->nama_lengkap }}"
                                            data-email="{{ $guru->email }}"
                                            data-status="{{ $guru->status_pengajar }}"
                                            title="Edit"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-xl border border-indigo-200 dark:border-indigo-700/50 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-200 dark:hover:bg-indigo-800/60 hover:border-indigo-300 dark:hover:border-indigo-600 hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-150">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST"
                                            onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-xl border border-red-200 dark:border-red-700/50 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/60 hover:border-red-300 dark:hover:border-red-600 hover:text-red-700 dark:hover:text-red-300 transition-all duration-150">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/40 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-indigo-300 dark:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Belum ada data guru</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">Ubah filter atau tambahkan guru baru</p>
                                        </div>
                                        <button type="button" onclick="openCreateGuruModal()"
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-500 hover:bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm shadow-indigo-200 dark:shadow-indigo-900/30 transition-all duration-150 mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Guru
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($gurus->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 dark:border-slate-800">
                    {{ $gurus->links() }}
                </div>
            @endif
        </div>

    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.confirm-delete')

    @include('guru.modal-create')
    @include('guru.modal-edit')
    @include('guru.import')

    @push('scripts')
        <script>
            /* ── Modal Create ── */
            function openCreateGuruModal() {
                document.getElementById('modalCreateGuru').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            function closeCreateGuruModal() {
                document.getElementById('modalCreateGuru').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Edit ── */
            function openEditGuruModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEditGuru');
                const form  = document.getElementById('editGuruForm');
                const btn   = document.getElementById('editGuruSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route_guru').value = d.route;

                document.getElementById('edit_guru_id').value          = d.id    ?? '';
                document.getElementById('edit_nama_lengkap').value     = d.nama  ?? '';
                document.getElementById('edit_email').value            = d.email ?? '';
                document.getElementById('edit_status_pengajar').value  = d.status ?? '';

                // Reset submit button state
                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Simpan Perubahan
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            function closeEditGuruModal() {
                document.getElementById('modalEditGuru').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Import ── */
            function openImportGuruModal() {
                document.getElementById('modalImportGuru').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            function closeImportGuruModal() {
                document.getElementById('modalImportGuru').classList.add('hidden');
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
                const createForm = document.getElementById('createGuruFormAction');
                const createBtn  = document.getElementById('createGuruSubmitBtn');
                const editForm   = document.getElementById('editGuruForm');
                const editBtn    = document.getElementById('editGuruSubmitBtn');

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
                        openCreateGuruModal();
                    @elseif (old('_modal') === 'edit')
                        const savedRoute = document.getElementById('edit_route_guru').value;
                        if (savedRoute) {
                            document.getElementById('editGuruForm').action = savedRoute;
                        }
                        document.getElementById('modalEditGuru').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @elseif (old('_modal') === 'import')
                        openImportGuruModal();
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreateGuru', 'modalEditGuru', 'modalImportGuru'].forEach(id => {
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