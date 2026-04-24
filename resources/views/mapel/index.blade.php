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

                {{-- Cards --}}
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($mapels as $mapel)
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                                {{-- Foto --}}
                                <div class="aspect-square bg-slate-100 flex items-center justify-center p-4">
                                    @if($mapel->foto)
                                        <img src="{{ asset('storage/' . $mapel->foto) }}" alt="Foto {{ $mapel->nama_mapel }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-[#1B3A6B]/10 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <div class="mb-2">
                                        <span class="inline-block px-2 py-1 bg-[#1B3A6B]/10 text-[#1B3A6B] text-xs font-bold rounded">
                                            {{ $mapel->kode_mapel }}
                                        </span>
                                    </div>

                                    <h3 class="font-semibold text-[#0F2145] text-sm mb-1 line-clamp-2">
                                        {{ $mapel->nama_mapel }}
                                    </h3>

                                    <p class="text-slate-500 text-xs mb-4 line-clamp-2">
                                        {{ $mapel->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </p>

                                    {{-- Aksi --}}
                                    <div class="flex gap-2">
                                        <button
                                            class="btn-edit flex-1 px-3 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium rounded-lg transition"
                                            data-id="{{ $mapel->id }}"
                                            data-kode="{{ $mapel->kode_mapel }}"
                                            data-nama="{{ $mapel->nama_mapel }}"
                                            data-deskripsi="{{ $mapel->deskripsi }}"
                                            data-foto="{{ $mapel->foto }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('mapel.destroy', $mapel) }}" method="POST" class="flex-1"
                                              onsubmit="return confirm('Hapus mapel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 text-xs font-medium rounded-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full flex flex-col items-center justify-center py-16">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Belum ada data mapel</p>
                                <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Mapel</span> untuk mulai menambahkan data</p>
                            </div>
                        @endforelse
                    </div>
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
    {{-- Script --}}
<script>
    const modalCreate = document.getElementById('modalCreate');
    const modalEdit = document.getElementById('modalEdit');

    // Buka modal create
    document.getElementById('btnTambahMapel').onclick = () => modalCreate.style.display = 'block';

    // Tutup modal create
    document.getElementById('cancelCreate').onclick = () => modalCreate.style.display = 'none';
    document.getElementById('overlayCreate').onclick = () => modalCreate.style.display = 'none';

    // Buka modal edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('editKodeMapel').value = btn.dataset.kode;
            document.getElementById('editNamaMapel').value = btn.dataset.nama;
            document.getElementById('editDeskripsi').value = btn.dataset.deskripsi;
            document.getElementById('formEdit').action = `/mapel/${btn.dataset.id}`;
            modalEdit.style.display = 'block';
        };
    });

    // Tutup modal edit (sesuaikan id tombol batal di modal-edit)
    document.getElementById('cancelEdit').onclick = () => modalEdit.style.display = 'none';
    document.getElementById('overlayEdit').onclick = () => modalEdit.style.display = 'none';
</script>

</x-app-layout>