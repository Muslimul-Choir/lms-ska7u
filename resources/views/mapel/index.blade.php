{{-- resources/views/mapel/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944
                        12.083 12.083 0 015.84 10.578L12 14z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">Master Mapel</h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Mata Pelajaran</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide" aria-label="Breadcrumb">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span>Master Data</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-600 font-semibold">Mapel</span>
            </nav>

            {{-- Alert --}}
            @if (session('success'))
                <div role="alert"
                     class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                            aria-label="Tutup notifikasi"
                            class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Card Utama --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header Card --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Mapel</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data mata pelajaran</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('mapel.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" id="btnTambahMapel"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Mapel
                        </button>
                    </div>
                </div>

                {{-- Pencarian --}}
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100">
                    <div class="flex items-center gap-2 max-w-md">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none" aria-hidden="true">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            {{-- ✅ type="search" lebih semantik --}}
                            <input type="search" id="searchInput"
                                   value="{{ request('search') }}"
                                   placeholder="Cari mapel..."
                                   autocomplete="off"
                                   class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                        </div>
                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if(request()->hasAny(['search']))
                            <button type="button" id="btnReset"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Grid Kartu --}}
                <div class="px-6 py-4">
                    <div id="mapelCardsContainer"
                         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($mapels as $mapel)
                            <div class="bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                                {{-- Foto --}}
                                <div class="aspect-square bg-slate-100 flex items-center justify-center p-4">
                                    @if($mapel->foto)
                                        <img src="{{ Storage::url($mapel->foto) }}"
                                             alt="Foto {{ $mapel->nama_mapel }}"
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-[#1B3A6B]/10 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                {{-- Konten --}}
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
                                        <button type="button"
                                                class="btn-edit flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition"
                                                data-id="{{ $mapel->id }}"
                                                data-kode="{{ $mapel->kode_mapel }}"
                                                data-nama="{{ $mapel->nama_mapel }}"
                                                data-deskripsi="{{ $mapel->deskripsi }}"
                                                data-foto="{{ $mapel->foto }}">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        {{-- ✅ data-confirm gantikan onsubmit inline --}}
                                        <form action="{{ route('mapel.destroy', $mapel) }}" method="POST"
                                              class="flex-1" data-confirm="Hapus mapel ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full flex flex-col items-center justify-center py-16">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Belum ada data mapel</p>
                                <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Mapel</span> untuk mulai menambahkan data</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Paginasi --}}
                @if ($mapels->hasPages())
                    <div id="paginationContainer"
                         class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p id="paginationInfo" class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $mapels->firstItem() }}–{{ $mapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $mapels->total() }}</span>
                            entri
                        </p>
                        {{-- ✅ appends() agar filter tidak hilang saat ganti halaman --}}
                        {{ $mapels->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('mapel.modal-create')
    @include('mapel.modal-edit')

    <script>
    (() => {
        'use strict';

        // ─── Referensi DOM ───────────────────────────────────────────────────
        const modalCreate         = document.getElementById('modalCreate');
        const modalEdit           = document.getElementById('modalEdit');
        const cardsContainer      = document.getElementById('mapelCardsContainer');
        const paginationContainer = document.getElementById('paginationContainer');
        const paginationInfo      = document.getElementById('paginationInfo');
        const searchInput         = document.getElementById('searchInput');
        const btnSearch           = document.getElementById('btnSearch');
        const btnReset            = document.getElementById('btnReset');

        // ✅ Base URL storage ditetapkan di PHP, diteruskan ke JS sekali
        // Menghindari asset('storage/') + '/' + foto = double slash
        const STORAGE_URL = '{{ rtrim(Storage::url(""), "/") }}';

        // ─── State terpusat ──────────────────────────────────────────────────
        const state = {
            search : '{{ request("search") }}',
            page   : {{ request("page", 1) }},
        };

        // ─── Helper ──────────────────────────────────────────────────────────

        /**
         * ✅ PERBAIKAN KEAMANAN: Escape teks sebelum disuntikkan ke innerHTML
         * Sebelumnya nama_mapel, kode_mapel, deskripsi langsung masuk innerHTML → XSS
         */
        function esc(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        /**
         * ✅ Debounce — tunda fetch 300ms sejak ketukan terakhir
         */
        function debounce(fn, tunda = 300) {
            let timer;
            return (...args) => { clearTimeout(timer); timer = setTimeout(() => fn(...args), tunda); };
        }

        const bukaModal  = (modal) => modal.style.display = 'block';
        const tutupModal = (modal) => modal.style.display = 'none';

        // ─── Pembuat kartu ───────────────────────────────────────────────────
        function buatKartu(mapel) {
            const nama  = esc(mapel.nama_mapel);
            const kode  = esc(mapel.kode_mapel);
            const desk  = esc(mapel.deskripsi) || 'Tidak ada deskripsi';

            // ✅ Perbaikan URL: tidak ada lagi double slash
            const fotoHtml = mapel.foto
                ? `<img src="${STORAGE_URL}/${esc(mapel.foto)}"
                         alt="Foto ${nama}"
                         class="w-full h-full object-cover rounded-lg"
                         loading="lazy">`
                : `<div class="w-16 h-16 bg-[#1B3A6B]/10 rounded-full flex items-center justify-center">
                       <svg class="w-8 h-8 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                           <path stroke-linecap="round" stroke-linejoin="round"
                               d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944
                               12.083 12.083 0 015.84 10.578L12 14z"/>
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
                            ${kode}
                        </span>
                    </div>
                    <h3 class="font-semibold text-[#0F2145] text-sm mb-1 line-clamp-2">${nama}</h3>
                    <p class="text-slate-500 text-xs mb-4 line-clamp-2">${desk}</p>
                    <div class="flex gap-2">
                        <button type="button"
                            data-id="${mapel.id}"
                            data-kode="${kode}"
                            data-nama="${nama}"
                            data-deskripsi="${esc(mapel.deskripsi ?? '')}"
                            data-foto="${esc(mapel.foto ?? '')}"
                            class="btn-edit flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <form action="/mapel/${mapel.id}" method="POST"
                              class="flex-1" data-confirm="Hapus mapel ini?">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>`;
        }

        // ─── Render kartu ────────────────────────────────────────────────────
        function renderKartu(mapels) {
            cardsContainer.innerHTML = mapels.length
                ? mapels.map(buatKartu).join('')
                : `<div class="col-span-full flex flex-col items-center justify-center py-16">
                       <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                           <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                               <path stroke-linecap="round" stroke-linejoin="round"
                                   d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944
                                   12.083 12.083 0 015.84 10.578L12 14z"/>
                           </svg>
                       </div>
                       <p class="text-slate-400 text-sm font-medium">Belum ada data mapel</p>
                   </div>`;

            ikatTombolEdit();
        }

        // ─── Render paginasi ─────────────────────────────────────────────────
        function renderPaginasi(paginationHtml, meta) {
            if (!paginationContainer) return;

            if (!paginationHtml || meta.total === 0) {
                paginationContainer.classList.add('hidden');
                return;
            }

            paginationContainer.classList.remove('hidden');

            // ✅ Perbaikan bug: hitung firstItem & lastItem berdasarkan halaman aktual
            const perPage   = meta.per_page ?? 4;
            const firstItem = (meta.current_page - 1) * perPage + 1;
            const lastItem  = Math.min(meta.current_page * perPage, meta.total);

            if (paginationInfo) {
                paginationInfo.innerHTML = `Menampilkan
                    <span class="font-semibold text-slate-700">${firstItem}–${lastItem}</span>
                    dari
                    <span class="font-semibold text-slate-700">${meta.total}</span>
                    entri`;
            }

            const existingLinks = paginationContainer.querySelector('nav, ul');
            if (existingLinks) existingLinks.outerHTML = paginationHtml;
            else paginationContainer.insertAdjacentHTML('beforeend', paginationHtml);
        }

        // ─── Fetch data ──────────────────────────────────────────────────────
        async function muatData() {
            const params = new URLSearchParams({
                search : state.search,
                page   : state.page,
            });
            try {
                const res = await fetch(`{{ route('mapel.index') }}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const { mapels, pagination, total, meta } = await res.json();
                renderKartu(mapels);
                renderPaginasi(pagination, meta ?? { total, current_page: state.page, per_page: 4 });
            } catch (err) {
                console.error('Gagal memuat data mapel:', err);
            }
        }

        // ─── Binding tombol Edit ─────────────────────────────────────────────
        function ikatTombolEdit() {
            cardsContainer.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editKodeMapel').value = this.dataset.kode;
                    document.getElementById('editNamaMapel').value = this.dataset.nama;
                    document.getElementById('editDeskripsi').value = this.dataset.deskripsi;
                    document.getElementById('formEdit').action     = `/mapel/${this.dataset.id}`;
                    bukaModal(modalEdit);
                });
            });
        }

        // ─── Konfirmasi hapus (delegated) ────────────────────────────────────
        document.addEventListener('submit', function (e) {
            const form = e.target.closest('form[data-confirm]');
            if (!form) return;
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });

        // ─── Event listener filter ───────────────────────────────────────────
        const muatDebounce = debounce(() => { state.page = 1; muatData(); });

        searchInput.addEventListener('input', function () {
            state.search = this.value;
            muatDebounce();
        });
        btnSearch.addEventListener('click', () => {
            state.search = searchInput.value;
            state.page   = 1;
            muatData();
        });
        if (btnReset) {
            btnReset.addEventListener('click', () => {
                searchInput.value = '';
                state.search = '';
                state.page   = 1;
                muatData();
            });
        }

        // ─── Buka/tutup modal ────────────────────────────────────────────────
        document.getElementById('btnTambahMapel').addEventListener('click', () => bukaModal(modalCreate));

        // ✅ Loop — tidak lagi listener hampir identik berulang
        [
            ['cancelCreate',  modalCreate],
            ['overlayCreate', modalCreate],
            ['cancelEdit',    modalEdit],
            ['overlayEdit',   modalEdit],
        ].forEach(([id, modal]) => {
            document.getElementById(id)?.addEventListener('click', () => tutupModal(modal));
        });

        // ─── Inisialisasi ────────────────────────────────────────────────────
        // ✅ Tidak fetch ulang jika data sudah dirender server-side
        ikatTombolEdit();

        if (state.search) {
            muatData();
        }

        @if ($errors->any())
            bukaModal(modalCreate);
        @endif
    })();
    </script>

</x-app-layout>