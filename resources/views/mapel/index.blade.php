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
                                placeholder="Cari mapel..."
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

                {{-- Cards --}}
                <div class="px-6 py-4">
                    <div id="mapelCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                <div id="paginationContainer" class="px-6 py-4 border-t bg-slate-50">
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
        const cardsContainer = document.getElementById('mapelCardsContainer');
        const paginationContainer = document.getElementById('paginationContainer');
        const searchInput = document.getElementById('searchInput');
        const btnSearch = document.getElementById('btnSearch');
        const btnReset = document.getElementById('btnReset');

        let currentPage = 1;
        let currentSearch = '{{ $search }}';

        // Function to load data
        function loadData(search = '', page = 1) {
            fetch(`{{ route('mapel.index') }}?search=${encodeURIComponent(search)}&page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderCards(data.mapels, page);
                renderPagination(data.pagination, data.total);
            })
            .catch(error => console.error('Error:', error));
        }

        // Function to render cards
        function renderCards(mapels, currentPage) {
            if (mapels.length === 0) {
                cardsContainer.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-16">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z" />
                            </svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium mt-4">Belum ada data mapel</p>
                        <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Mapel</span> untuk mulai menambahkan data</p>
                    </div>
                `;
                return;
            }

            cardsContainer.innerHTML = mapels.map((mapel, index) => {
                const fotoHtml = mapel.foto ?
                    `<img src="{{ asset('storage/') }}/${mapel.foto}" alt="Foto ${mapel.nama_mapel}" class="w-full h-full object-cover rounded-lg">` :
                    `<div class="w-16 h-16 bg-[#1B3A6B]/10 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z" />
                        </svg>
                    </div>`;
                return `
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <div class="aspect-square bg-slate-100 flex items-center justify-center p-4">
                            ${fotoHtml}
                        </div>
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="inline-block px-2 py-1 bg-[#1B3A6B]/10 text-[#1B3A6B] text-xs font-bold rounded">
                                    ${mapel.kode_mapel}
                                </span>
                            </div>
                            <h3 class="font-semibold text-[#0F2145] text-sm mb-1 line-clamp-2">${mapel.nama_mapel}</h3>
                            <p class="text-slate-600 text-xs mb-3 line-clamp-2">${mapel.deskripsi || '-'}</p>
                            <div class="flex items-center justify-between">
                                <button type="button"
                                    data-id="${mapel.id}"
                                    data-kode="${mapel.kode_mapel}"
                                    data-nama="${mapel.nama_mapel}"
                                    data-deskripsi="${mapel.deskripsi || ''}"
                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <form action="/mapel/${mapel.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mapel ini?')">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            bindEditButtons();
        }

        // Function to render pagination
        function renderPagination(paginationHtml, total) {
            if (!paginationHtml) {
                paginationContainer.style.display = 'none';
                return;
            }
            paginationContainer.style.display = 'flex';
            paginationContainer.className = 'px-6 py-4 border-t bg-slate-50 flex items-center justify-between gap-4';
            const infoText = `Menampilkan ${Math.min(1, total)}–${Math.min(4, total)} dari ${total} entri`;
            paginationContainer.innerHTML = `
                <p class="text-xs text-slate-500">${infoText}</p>
                ${paginationHtml}
            `;
        }

        // Event listeners
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            currentPage = 1;
            loadData(currentSearch, currentPage);
        });

        btnSearch.addEventListener('click', function() {
            currentSearch = searchInput.value;
            currentPage = 1;
            loadData(currentSearch, currentPage);
        });

        if (btnReset) {
            btnReset.addEventListener('click', function() {
                searchInput.value = '';
                currentSearch = '';
                currentPage = 1;
                loadData('', 1);
            });
        }

        // Initial load if no search
        if (!currentSearch) {
            loadData('', 1);
        }

        // Modal events
        document.getElementById('btnTambahMapel').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('cancelCreate').addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click', () => modalCreate.style.display = 'none');

        document.getElementById('cancelEdit').addEventListener('click', () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit').addEventListener('click', () => modalEdit.style.display = 'none');

        // Edit button events (re-bind after AJAX)
        function bindEditButtons() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editKodeMapel').value = this.dataset.kode;
                    document.getElementById('editNamaMapel').value = this.dataset.nama;
                    document.getElementById('editDeskripsi').value = this.dataset.deskripsi;
                    document.getElementById('formEdit').action = `/mapel/${this.dataset.id}`;
                    modalEdit.style.display = 'block';
                });
            });
        }

        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>