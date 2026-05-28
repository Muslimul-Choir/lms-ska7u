<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Master Jurusan
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Data Master
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">
                    Dashboard
                </a>

                <span class="text-gray-300">/</span>

                <span>Master Data</span>

                <span class="text-gray-300">/</span>

                <span class="text-gray-600 font-semibold">
                    Jurusan
                </span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>

                        <span class="font-medium">
                            {{ session('success') }}
                        </span>
                    </div>

                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                        ✕
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Daftar Jurusan
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5 ml-3">
                            Kelola data program studi / jurusan
                        </p>
                    </div>

                    <div class="flex items-center gap-2">

                        <a href="{{ route('jurusan.trash') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                           <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Tempat Sampah
                        </a>

                        <button type="button"
                                id="btnTambahJurusan"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                             Tambah Jurusan
                        </button>

                    </div>

                </div>

                {{-- Search --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-2 max-w-sm">

                        <input type="text"
                               id="searchInput"
                               value="{{ request('search') }}"
                               placeholder="Cari nama jurusan..."
                               class="w-full px-4 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">

                        <button type="button"
                                id="btnSearch"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if(request('search'))
                            <button type="button"
                                    id="btnReset"
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

                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">
                                    #
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Nama Jurusan
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Keterangan
                                </th>

                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($jurusans as $jurusan)

                                <tr class="hover:bg-amber-50/40 transition">

                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($jurusans->currentPage() - 1) * $jurusans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($jurusan->nama_jurusan, 0, 2) }}
                                                </span>
                                            </div>

                                            <span class="font-semibold text-gray-800 text-sm">
                                                {{ $jurusan->nama_jurusan }}
                                            </span>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 text-sm max-w-xs truncate">
                                        {{ $jurusan->keterangan ?? '—' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Edit --}}
                                            <button type="button"
                                                onclick="openEditModal(
                                                    '{{ $jurusan->id }}',
                                                    @js($jurusan->nama_jurusan),
                                                    @js($jurusan->keterangan)
                                                )"
                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                title="Edit">

                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>

                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('jurusan.destroy', $jurusan) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">

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
                                    <td colspan="4" class="px-6 py-20 text-center text-gray-400">
                                        Belum ada data jurusan
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if ($jurusans->hasPages())

                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $jurusans->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>

    {{-- Modal --}}
    @include('jurusan.modal-create')
    @include('jurusan.modal-edit')

    <script>

        // =========================
        // SEARCH
        // =========================
        const searchInput = document.getElementById('searchInput');
        const btnSearch   = document.getElementById('btnSearch');
        const btnReset    = document.getElementById('btnReset');

        btnSearch.addEventListener('click', () => {

            window.location.href =
                `{{ route('jurusan.index') }}?search=${encodeURIComponent(searchInput.value)}`;

        });

        if (btnReset) {

            btnReset.addEventListener('click', () => {

                window.location.href =
                    `{{ route('jurusan.index') }}`;

            });

        }

        searchInput.addEventListener('keypress', (e) => {

            if (e.key === 'Enter') {
                btnSearch.click();
            }

        });

        // =========================
        // MODAL CREATE
        // =========================
        const modalCreate = document.getElementById('modalCreate');

        document.getElementById('btnTambahJurusan')
            .addEventListener('click', () => {

                modalCreate.style.display = 'flex';

            });

        // =========================
        // AUTO OPEN CREATE ERROR
        // =========================
        @if ($errors->any())

            modalCreate.style.display = 'flex';

        @endif

    </script>
</x-app-layout>