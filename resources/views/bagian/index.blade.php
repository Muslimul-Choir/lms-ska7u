{{-- resources/views/bagian/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">Master Bagian</h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Divisi</p>
            </div>
        </div>
    </x-slot>

    @php
        // ✅ Offset dihitung sekali di luar loop
        $offset = ($bagians->currentPage() - 1) * $bagians->perPage();
    @endphp

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide" aria-label="Breadcrumb">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span>Master Data</span>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-600 font-semibold">Bagian</span>
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
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Daftar Bagian</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Kelola data unit/divisi organisasi</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('bagian.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-medium rounded-lg border border-white/20 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                        <button type="button" id="btnTambahBagian"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C8992A] hover:bg-[#b5861f] text-white text-xs font-semibold rounded-lg transition shadow-md shadow-amber-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Bagian
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
                                   placeholder="Cari nama bagian..."
                                   autocomplete="off"
                                   class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/20 focus:border-[#1B3A6B] transition">
                        </div>
                        <button type="button" id="btnSearch"
                                class="px-4 py-2 bg-[#1B3A6B] hover:bg-[#0F2145] text-white text-sm font-medium rounded-lg transition">
                            Cari
                        </button>
                        {{-- ✅ hasAny() lebih ringkas --}}
                        @if(request()->hasAny(['search']))
                            <button type="button" id="btnReset"
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" aria-label="Daftar Bagian">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest w-12">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Bagian</th>
                                <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bagianTableBody" class="divide-y divide-slate-100">
                            @forelse ($bagians as $bagian)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                                        {{-- ✅ Pakai $offset yang sudah dihitung di luar loop --}}
                                        {{ str_pad($loop->iteration + $offset, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                                                <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">
                                                    {{ Str::upper(Str::substr($bagian->nama_bagian, 0, 2)) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-[#0F2145] text-sm">{{ $bagian->nama_bagian }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-sm max-w-xs truncate">
                                        {{ $bagian->deskripsi ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                    data-id="{{ $bagian->id }}"
                                                    data-nama="{{ $bagian->nama_bagian }}"
                                                    data-deskripsi="{{ $bagian->deskripsi ?? '' }}"
                                                    class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            {{-- ✅ data-confirm menggantikan onsubmit inline --}}
                                            <form action="{{ route('bagian.destroy', $bagian) }}" method="POST"
                                                  data-confirm="Yakin ingin menghapus bagian ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">Belum ada data bagian</p>
                                            <p class="text-slate-300 text-xs">Klik <span class="font-semibold text-slate-400">Tambah Bagian</span> untuk mulai menambahkan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                @if ($bagians->hasPages())
                    <div id="paginationContainer"
                         class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                        <p id="paginationInfo" class="text-xs text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $bagians->firstItem() }}–{{ $bagians->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $bagians->total() }}</span>
                            entri
                        </p>
                        {{-- ✅ appends() agar filter tidak hilang saat ganti halaman --}}
                        {{ $bagians->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('bagian.modal-create')
    @include('bagian.modal-edit')

    <script>
    (() => {
        'use strict';

        // ─── Referensi DOM ───────────────────────────────────────────────────
        const modalCreate       = document.getElementById('modalCreate');
        const modalEdit         = document.getElementById('modalEdit');
        const searchInput       = document.getElementById('searchInput');
        const btnSearch         = document.getElementById('btnSearch');
        const btnReset          = document.getElementById('btnReset');
        const tableBody         = document.getElementById('bagianTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const paginationInfo    = document.getElementById('paginationInfo');

        // ─── State terpusat ──────────────────────────────────────────────────
        const state = {
            search : '{{ request("search") }}',
            page   : {{ request("page", 1) }},
        };

        // ─── Helper ──────────────────────────────────────────────────────────

        /**
         * ✅ PERBAIKAN KEAMANAN: Escape teks sebelum disuntikkan ke innerHTML
         * Tanpa ini, nama_bagian atau deskripsi yang mengandung karakter HTML bisa jadi XSS
         */
        function esc(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        /**
         * ✅ Debounce — tunda eksekusi 300ms sejak ketukan terakhir
         * Mencegah fetch dikirim di setiap huruf yang diketik
         */
        function debounce(fn, tunda = 300) {
            let timer;
            return (...args) => { clearTimeout(timer); timer = setTimeout(() => fn(...args), tunda); };
        }

        const bukaModal  = (modal) => modal.style.display = 'block';
        const tutupModal = (modal) => modal.style.display = 'none';

        // ─── Pembuat baris tabel ─────────────────────────────────────────────
        function buatBaris(bagian, index, page) {
            const no    = String((page - 1) * 5 + index + 1).padStart(3, '0');
            const nama  = esc(bagian.nama_bagian);
            const inits = nama.substring(0, 2).toUpperCase();
            const desk  = esc(bagian.deskripsi) || '—';

            return `
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-6 py-4 text-slate-400 text-xs font-mono">${no}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-md bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0" aria-hidden="true">
                            <span class="text-[#1B3A6B] text-[10px] font-bold uppercase">${inits}</span>
                        </div>
                        <span class="font-semibold text-[#0F2145] text-sm">${nama}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-500 text-sm max-w-xs truncate">${desk}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <button type="button"
                            data-id="${bagian.id}"
                            data-nama="${nama}"
                            data-deskripsi="${esc(bagian.deskripsi ?? '')}"
                            class="btn-edit inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        {{-- ✅ data-confirm — tidak ada lagi onsubmit inline --}}
                        <form action="/bagian/${bagian.id}" method="POST"
                              data-confirm="Yakin ingin menghapus bagian ini?">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>`;
        }

        // ─── Render tabel ────────────────────────────────────────────────────
        function renderTabel(baris, page) {
            tableBody.innerHTML = baris.length
                ? baris.map((b, i) => buatBaris(b, i, page)).join('')
                : `<tr><td colspan="4" class="px-6 py-16 text-center">
                       <div class="flex flex-col items-center gap-3">
                           <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                               <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                               </svg>
                           </div>
                           <p class="text-slate-400 text-sm font-medium">Belum ada data bagian</p>
                       </div>
                   </td></tr>`;

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

            // ✅ Perbaikan bug: hitung firstItem & lastItem berdasarkan page & perPage aktual
            const perPage   = meta.per_page ?? 5;
            const firstItem = (meta.current_page - 1) * perPage + 1;
            const lastItem  = Math.min(meta.current_page * perPage, meta.total);

            if (paginationInfo) {
                paginationInfo.innerHTML = `Menampilkan
                    <span class="font-semibold text-slate-700">${firstItem}–${lastItem}</span>
                    dari
                    <span class="font-semibold text-slate-700">${meta.total}</span>
                    entri`;
            }

            // Ganti hanya bagian link paginasi (bukan info teks)
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
                const res = await fetch(`{{ route('bagian.index') }}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const { bagians, pagination, total, meta } = await res.json();
                renderTabel(bagians, state.page);
                renderPaginasi(pagination, meta ?? { total, current_page: state.page, per_page: 5 });
            } catch (err) {
                console.error('Gagal memuat data bagian:', err);
            }
        }

        // ─── Binding tombol Edit ─────────────────────────────────────────────
        function ikatTombolEdit() {
            tableBody.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('editNamaBagian').value = this.dataset.nama;
                    document.getElementById('editDeskripsi').value  = this.dataset.deskripsi;
                    document.getElementById('formEdit').action      = `/bagian/${this.dataset.id}`;
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
        document.getElementById('btnTambahBagian').addEventListener('click', () => bukaModal(modalCreate));

        // ✅ Loop — tidak lagi 6 baris listener hampir identik
        [
            ['closeCreate',   modalCreate],
            ['cancelCreate',  modalCreate],
            ['overlayCreate', modalCreate],
            ['closeEdit',     modalEdit],
            ['cancelEdit',    modalEdit],
            ['overlayEdit',   modalEdit],
        ].forEach(([id, modal]) => {
            document.getElementById(id)?.addEventListener('click', () => tutupModal(modal));
        });

        // ─── Inisialisasi ────────────────────────────────────────────────────
        // ✅ Perbaikan bug: jangan fetch ulang jika data sudah dirender server-side
        // Hanya bind tombol edit pada render awal
        ikatTombolEdit();

        // Fetch hanya jika ada search aktif (AJAX perlu sinkronisasi state)
        // Untuk navigasi normal, server-side render sudah cukup
        if (state.search) {
            muatData();
        }

        @if ($errors->any())
            bukaModal(modalCreate);
        @endif
    })();
    </script>

</x-app-layout>