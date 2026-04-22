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
                    <form action="{{ route('tahunajaran.index') }}" method="GET" class="flex items-center gap-2 max-w-md">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari tahun ajaran..."
                            class="w-full px-3 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B]"
                        >
                        <button type="submit"
                                class="px-4 py-2 bg-[#1B3A6B] text-white text-sm rounded-lg">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('tahunajaran.index') }}"
                               class="px-3 py-2 bg-slate-100 text-sm rounded-lg">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase w-12">#</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Nama Tahun</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
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

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button type="button"
                                                data-id="{{ $tahun->id }}"
                                                data-nama="{{ $tahun->nama_tahun }}"
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
                                    <td colspan="3" class="px-6 py-16 text-center text-slate-400">
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

        document.getElementById('btnTambahTahun').onclick = () => modalCreate.style.display = 'block';
        document.getElementById('closeCreate').onclick = () => modalCreate.style.display = 'none';
        document.getElementById('cancelCreate').onclick = () => modalCreate.style.display = 'none';
        document.getElementById('overlayCreate').onclick = () => modalCreate.style.display = 'none';

        document.getElementById('closeEdit').onclick = () => modalEdit.style.display = 'none';
        document.getElementById('cancelEdit').onclick = () => modalEdit.style.display = 'none';
        document.getElementById('overlayEdit').onclick = () => modalEdit.style.display = 'none';

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.onclick = function () {
                document.getElementById('editNamaTahun').value = this.dataset.nama;
                document.getElementById('formEdit').action = `/tahunajaran/${this.dataset.id}`;
                modalEdit.style.display = 'block';
            };
        });

        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>