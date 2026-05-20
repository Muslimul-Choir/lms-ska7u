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

        // Function untuk bind edit buttons
        function bindEditButtons() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editNamaTahun').value = this.dataset.nama;
                    document.getElementById('editIsAktif').checked  = this.dataset.is_aktif == '1';
                    document.getElementById('formEdit').action      = `/tahunajaran/${this.dataset.id}`;
                    modalEdit.style.display = 'block';
                });
            });
        }

        // Search: navigasi dengan query param
        searchInput.addEventListener('input', function () {
            const search = encodeURIComponent(searchInput.value);
            window.location.href = `{{ route('tahunajaran.index') }}?search=${search}`;
        });

        btnSearch.addEventListener('click', function () {
            const search = encodeURIComponent(searchInput.value);
            window.location.href = `{{ route('tahunajaran.index') }}?search=${search}`;
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') btnSearch.click();
        });

        if (btnReset) {
            btnReset.addEventListener('click', function () {
                window.location.href = `{{ route('tahunajaran.index') }}`;
            });
        }

        // Modal – Create
        document.getElementById('btnTambahTahun').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('closeCreate').addEventListener('click',    () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate').addEventListener('click',   () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click',  () => modalCreate.style.display = 'none');

        // Modal – Edit
        document.getElementById('closeEdit').addEventListener('click',    () => modalEdit.style.display = 'none');
        document.getElementById('cancelEdit').addEventListener('click',   () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit').addEventListener('click',  () => modalEdit.style.display = 'none');

        // Bind edit buttons on page load
        bindEditButtons();

        // Buka modal create jika ada validation error
        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>