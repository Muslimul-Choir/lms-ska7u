<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Icon --}}
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Master Tingkatan
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">
                    Manajemen Data Tingkatan
                </p>
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
                <span class="text-slate-600 font-semibold">Tingkatan</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">&times;</button>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">
                            Daftar Tingkatan
                        </h3>
                        <p class="text-blue-200 text-xs mt-0.5">
                            Kelola data tingkatan pendidikan
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('tingkatan.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition">
                            🗑 Trash
                        </a>

                        <button type="button" id="btnTambahTingkatan"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition">
                            + Tambah
                        </button>
                    </div>
                </div>

                {{-- Search --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <form action="{{ route('tingkatan.index') }}" method="GET" class="flex items-center gap-2 max-w-md">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari tingkatan..."
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B]"
                        >

                        <button class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm rounded-lg">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase">Nama Tingkatan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase w-40">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tingkatans as $tingkatan)
                                <tr class="hover:bg-slate-50/70 transition">

                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{ $loop->iteration + ($tingkatans->currentPage()-1)*$tingkatans->perPage() }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                                    {{ substr($tingkatan->nama_tingkatan,0,2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">
                                                {{ $tingkatan->nama_tingkatan }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-slate-500 text-sm">
                                        {{ $tingkatan->keterangan ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            <button type="button"
                                                data-id="{{ $tingkatan->id }}"
                                                data-nama="{{ $tingkatan->nama_tingkatan }}"
                                                data-keterangan="{{ $tingkatan->keterangan ?? '' }}"
                                                class="btn-edit px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg">
                                                Edit
                                            </button>

                                            <form action="{{ route('tingkatan.destroy', $tingkatan) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus?')">
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
                                        Belum ada data tingkatan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($tingkatans->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                        {{ $tingkatans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('tingkatan.modal-create')
    @include('tingkatan.modal-edit')

    {{-- Script --}}
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');

        // OPEN CREATE
        document.getElementById('btnTambahTingkatan').addEventListener('click', function () {
            modalCreate.style.display = 'block';
        });

        // CLOSE CREATE
        document.getElementById('closeCreate').onclick =
        document.getElementById('cancelCreate').onclick =
        document.getElementById('overlayCreate').onclick = () => {
            modalCreate.style.display = 'none';
        };

        // OPEN EDIT
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                modalEdit.style.display = 'block';

                document.getElementById('formEdit').action = `/tingkatan/${this.dataset.id}`;
                document.getElementById('editNamaTingkatan').value = this.dataset.nama;
                document.getElementById('editKeterangan').value = this.dataset.keterangan;
            });
        });

        // CLOSE EDIT
        document.getElementById('closeEdit').onclick =
        document.getElementById('cancelEdit').onclick =
        document.getElementById('overlayEdit').onclick = () => {
            modalEdit.style.display = 'none';
        };
    </script>

</x-app-layout>