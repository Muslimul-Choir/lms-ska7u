<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Trash — Kelas
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Data Kelas Terhapus</p>
            </div>
        </div>

        @if ($kelasTrashed->total() > 0)
                <div class="flex gap-2 flex-shrink-0">
                    <form action="{{ route('kelas.restoreAll') }}" method="POST" id="restoreAllForm">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmRestoreAll(event)"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Restore Semua
                        </button>
                    </form>

                    <form action="{{ route('kelas.forceDeleteAll') }}" method="POST" id="forceDeleteAllForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmForceDeleteAll(event)"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <a href="{{ route('kelas.index') }}" class="hover:text-[#1B3A6B] transition">Kelas</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Trash</span>
            </nav>

            {{-- Filter Toolbar --}}
            <div class="rounded-lg bg-white border border-slate-200 shadow-sm">
                <form method="GET" action="{{ route('kelas.trash') }}" id="filterForm">
                    <div class="p-4 sm:p-5">
                        <div class="flex flex-col gap-4 xl:gap-16 xl:flex-row xl:items-end xl:justify-between">

                            {{-- Left: Filters --}}
                            <div class="grid flex-1 gap-4 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">

                                {{-- Tingkatan --}}
                                <div class="">
                                    <label
                                        class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                        Tingkatan
                                    </label>
                                    <select name="id_tingkatan"
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 px-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all outline-none cursor-pointer"
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
                                        class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                        Jurusan
                                    </label>
                                    <select name="id_jurusan"
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 px-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all outline-none cursor-pointer"
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
                                        class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                        Bagian
                                    </label>
                                    <select name="id_bagian"
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 px-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all outline-none cursor-pointer"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Bagian</option>
                                        @foreach ($bagianList as $b)
                                            <option value="{{ $b->id }}"
                                                {{ request('id_bagian') == $b->id ? 'selected' : '' }}>
                                                {{ $b->nama_bagian }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Tahun Ajaran --}}
                                <div class="">
                                    <label
                                        class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                        Tahun Ajaran
                                    </label>
                                    <select name="id_tahun_ajaran"
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 px-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all outline-none cursor-pointer"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($tahunAjaranList as $ta)
                                            <option value="{{ $ta->id }}"
                                                {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                                {{ $ta->nama_tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Reset --}}
                                @if (request()->filled('id_tahun_ajaran') ||
                                        request()->filled('id_tingkatan') ||
                                        request()->filled('id_jurusan') ||
                                        request()->filled('id_bagian'))
                                    <a href="{{ route('kelas.trash') }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg border border-slate-300 transition">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reset Filter
                                    </a>
                                @endif
                            </div>

                            {{-- Right: Back Button --}}
                            <div class="flex items-center justify-end gap-2 shrink-0">
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Data Utama
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            @if (session('success'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if (session('error'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Data Kelas Terhapus</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Data yang dihapus dapat dipulihkan atau dihapus
                            permanen</p>
                    </div>
                    <a href="{{ route('kelas.index') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Data Utama
                    </a>
                </div>

                {{-- filter --}}

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
                                    Kelas</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Jurusan</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Tahun Ajaran</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Wali Kelas</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Dihapus Pada</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-48">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($kelasTrashed as $index => $kelas)
                                <tr class="hover:bg-slate-50/70 transition group">
                                    {{-- No --}}
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ str_pad($kelasTrashed->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    {{-- Kelas --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-7 h-7 rounded-md bg-red-50 flex items-center justify-center flex-shrink-0">
                                                <span class="text-red-400 text-[10px] font-bold uppercase">
                                                    {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                                </span>
                                            </div>
                                            <span
                                                class="font-semibold text-slate-500 text-sm line-through decoration-slate-300">
                                                {{ $kelas->Tingkatan?->nama_tingkatan ?? '-' }}
                                                {{ $kelas->Bagian?->nama_bagian ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Jurusan --}}
                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        {{ $kelas->Jurusan?->nama_jurusan ?? '—' }}
                                    </td>
                                    {{-- Tahun Ajaran --}}
                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        {{ $kelas->TahunAjaran?->nama_tahun ?? '—' }}
                                    </td>
                                    {{-- Wali Kelas --}}
                                    <td class="px-6 py-4 text-slate-400 text-sm">
                                        {{ $kelas->WaliKelas?->nama_lengkap ?? '—' }}
                                    </td>
                                    {{-- Dihapus Pada --}}
                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 rounded-lg">
                                            <svg class="w-3 h-3 text-red-400 flex-shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-red-500 text-xs font-medium"
                                                title="{{ $kelas->deleted_at }}">
                                                {{ $kelas->deleted_at?->format('d M Y, H:i') ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Restore --}}
                                            <form action="{{ route('kelas.restore', $kelas->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Pulihkan
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('kelas.force-delete', $kelas->id) }}"
                                                method="POST" onsubmit="confirmForceDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus Permanen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Trash kosong</p>
                                            <p class="text-slate-300 text-xs">Tidak ada data kelas yang dihapus</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kelasTrashed->hasPages())
                    <div
                        class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan
                            <span
                                class="font-semibold text-slate-700">{{ $kelasTrashed->firstItem() }}–{{ $kelasTrashed->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $kelasTrashed->total() }}</span>
                            entri
                        </p>
                        {{ $kelasTrashed->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         ALERT COMPONENTS
    ═══════════════════════════════════════════ --}}
    @include('components.alerts.confirm-delete')

    @push('scripts')
        <script>
            function confirmForceDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                showConfirmDelete(false).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               CONFIRM RESTORE ALL
            ════════════════════════════════════════════ */
            function confirmRestoreAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Kembalikan Semua Kelas?',
                    text: 'Kembalikan SEMUA kelas yang ada di trash?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kembalikan semua',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               CONFIRM FORCE DELETE ALL
            ════════════════════════════════════════════ */
            function confirmForceDeleteAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Hapus Permanen Semua?',
                    html: 'Hapus PERMANEN <strong>SEMUA kelas</strong> di trash?<br><small class="text-red-600">Tindakan ini TIDAK BISA dibatalkan!</small>',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus semua permanen',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    @endpush

</x-app-layout>
