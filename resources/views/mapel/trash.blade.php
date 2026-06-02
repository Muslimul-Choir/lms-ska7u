<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-red-700 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                        Trash — Mapel
                    </h2>
                    <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Data Terhapus Sementara</p>
                </div>
            </div>

            @if ($mapels->total() > 0)
                <div class="flex gap-2 flex-shrink-0">
                    <form action="{{ route('mapel.restoreAll') }}" method="POST" id="restoreAllMapelForm">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmRestoreAllMapel(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Pulihkan Semua
                        </button>
                    </form>
                    <form action="{{ route('mapel.forceDeleteAll') }}" method="POST" id="forceDeleteAllMapelForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmForceDeleteAllMapel(event)"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
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
                <a href="{{ route('mapel.index') }}" class="hover:text-[#1B3A6B] transition">Mapel</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Trash</span>
            </nav>


            {{-- Warning Banner --}}
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-sm shadow-sm">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-red-700 text-xs font-medium leading-relaxed">
                    Data dalam trash telah dihapus sementara. Gunakan <span class="font-bold">Pulihkan</span> untuk
                    mengembalikan,
                    atau <span class="font-bold">Hapus Permanen</span> untuk menghapus selamanya tanpa bisa dipulihkan.
                </p>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4
                            border-b border-slate-100 bg-gradient-to-r from-[#6B1A1A] to-[#B91C1C]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Data Mapel Terhapus</h3>
                        <p class="text-red-200 text-xs mt-0.5">Daftar record yang telah dipindahkan ke trash</p>
                    </div>
                    <a href="{{ route('mapel.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20
                              text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Data Utama
                    </a>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <form method="GET" action="{{ route('mapel.trash') }}">
                        <div class="flex flex-wrap items-end gap-3">
                            {{-- Search --}}
                            <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
                                <label
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cari</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari nama / kode mapel..."
                                        class="w-full pl-9 pr-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400 transition">
                                </div>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                                Cari
                            </button>

                            @if (request()->filled('search'))
                                <a href="{{ route('mapel.trash') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                    </svg>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Kode Mapel</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Nama Mapel</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Deskripsi</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Dihapus Pada</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-52">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($mapels as $mapel)
                                <tr class="hover:bg-red-50/40 transition group">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($mapels->currentPage() - 1) * $mapels->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Kode Mapel --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 bg-red-50 border border-red-100 rounded-md text-[11px] font-bold text-red-400 tracking-widest line-through decoration-red-300">
                                            {{ $mapel->kode_mapel }}
                                        </span>
                                    </td>

                                    {{-- Nama Mapel --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-7 h-7 rounded-md bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-red-400 text-[10px] font-bold uppercase">
                                                    {{ substr($mapel->nama_mapel, 0, 2) }}
                                                </span>
                                            </div>
                                            <span
                                                class="font-semibold text-slate-500 text-sm line-through decoration-red-300">
                                                {{ $mapel->nama_mapel }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td class="px-6 py-4 text-slate-400 text-sm max-w-xs truncate">
                                        {{ $mapel->deskripsi ?? '—' }}
                                    </td>

                                    {{-- Deleted At --}}
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1
                                                    bg-red-50 border border-red-100 rounded-md">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-red-500 text-[11px] font-medium whitespace-nowrap">
                                                {{ $mapel->deleted_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('mapel.restore', $mapel->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" onclick="confirmRestoreMapel(event)"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                                               bg-emerald-50 hover:bg-emerald-100
                                                               text-emerald-700 border border-emerald-200
                                                               text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </button>
                                            </form>

                                            {{-- Force Delete --}}
                                            <form action="{{ route('mapel.force-delete', $mapel->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmForceDeleteMapel(event)"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5
                                                               bg-red-50 hover:bg-red-100
                                                               text-red-600 border border-red-200
                                                               text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
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
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">
                                                {{ request()->hasAny(['search']) ? 'Tidak ada data yang sesuai filter.' : 'Arsip kosong' }}
                                            </p>
                                            @if (request()->hasAny(['search']))
                                                <a href="{{ route('mapel.trash') }}" 
                                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                                </svg>
                                                Reset
                                            </a>
                                            @else
                                                <p class="text-gray-300 text-xs">Tidak ada mata pelajaran yang dihapus sementara</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($mapels->hasPages())
                    <div
                        class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span
                                class="font-semibold text-slate-700">{{ $mapels->firstItem() }}–{{ $mapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $mapels->total() }}</span>
                            entri
                        </p>
                        {{ $mapels->links() }}
                    </div>
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
            function confirmRestoreMapel(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmRestore('mapel').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmForceDeleteMapel(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(false).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmRestoreAllMapel(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmRestoreAll('Mapel').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            function confirmForceDeleteAllMapel(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmForceDeleteAll('Mapel').then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }
        </script>
    @endpush
</x-app-layout>
