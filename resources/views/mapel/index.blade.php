<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Icon --}}
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944
                        12.083 12.083 0 015.84 10.578L12 14z" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Master Mapel
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">
                    Manajemen Data Mata Pelajaran
                </p>
            </div>
        </div>
    </x-slot>

    {{-- Page Body --}}
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span>/</span>
                <span>Master Data</span>
                <span>/</span>
                <span class="text-slate-600 font-semibold">Mapel</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div class="px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm">Daftar Mapel</h3>
                        <p class="text-blue-200 text-xs">Kelola data mata pelajaran</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('mapel.trash') }}"
                           class="px-3 py-2 bg-white/10 hover:bg-white/20 text-white text-xs rounded-lg border border-white/20">
                            Trash
                        </a>

                        <button id="btnTambahMapel"
                            class="px-3 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs rounded-lg font-semibold">
                            + Tambah Mapel
                        </button>
                    </div>
                </div>

                {{-- Search --}}
                <div class="px-6 py-3 bg-slate-50 border-b">
                    <form class="flex gap-2 max-w-md">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari mapel..."
                            class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-[#1B3A6B]">

                        <button class="px-4 py-2 bg-[#1B3A6B] text-white text-sm rounded-lg">
                            Cari
                        </button>

                        @if(request('search'))
                            <a href="{{ route('mapel.index') }}"
                               class="px-3 py-2 bg-slate-200 text-sm rounded-lg">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold">#</th>
                                <th class="px-6 py-3 text-left text-xs font-bold">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold">Nama Mapel</th>
                                <th class="px-6 py-3 text-left text-xs font-bold">Deskripsi</th>
                                <th class="px-6 py-3 text-center text-xs font-bold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($mapels as $mapel)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-xs text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 font-bold text-[#1B3A6B]">
                                        {{ $mapel->kode_mapel }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold">
                                        {{ $mapel->nama_mapel }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $mapel->deskripsi ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            <button
                                                class="btn-edit px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs"
                                                data-id="{{ $mapel->id }}"
                                                data-kode="{{ $mapel->kode_mapel }}"
                                                data-nama="{{ $mapel->nama_mapel }}"
                                                data-deskripsi="{{ $mapel->deskripsi }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('mapel.destroy', $mapel) }}" method="POST"
                                                onsubmit="return confirm('Hapus mapel ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-xs">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-slate-400">
                                        Data mapel belum ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t bg-slate-50">
                    {{ $mapels->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- Include Modal --}}
    @include('mapel.modal-create')
    @include('mapel.modal-edit')

    {{-- Script --}}
    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');

        document.getElementById('btnTambahMapel').onclick = () => modalCreate.style.display = 'block';

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.onclick = () => {
                document.getElementById('editKodeMapel').value = btn.dataset.kode;
                document.getElementById('editNamaMapel').value = btn.dataset.nama;
                document.getElementById('editDeskripsi').value = btn.dataset.deskripsi;
                document.getElementById('formEdit').action = `/mapel/${btn.dataset.id}`;
                modalEdit.style.display = 'block';
            };
        });
    </script>

</x-app-layout>