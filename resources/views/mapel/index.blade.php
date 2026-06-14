<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Manajemen Mapel</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Mapel</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data mata pelajaran</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('mapel.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Arsip
                            @if ($trashCount > 0)
                                <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                            @endif
                        </a>
                        <button type="button" onclick="openCreateModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Mapel
                        </button>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-2 max-w-sm">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama/kode mapel..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>
                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if(request('search'))
                            <button type="button" id="btnReset"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Reset
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Cards --}}
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse ($mapels as $mapel)
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-amber-200 transition-all overflow-hidden group">

                                {{-- Foto --}}
                                <div class="aspect-square bg-gray-50 flex items-center justify-center overflow-hidden">
                                    @if ($mapel->foto)
                                        <img src="{{ asset('storage/' . $mapel->foto) }}" alt="{{ $mapel->nama_mapel }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-20 h-20 bg-amber-100 rounded-2xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.944 12.083 12.083 0 015.84 10.578L12 14z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <span class="inline-block px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg mb-2 tracking-wide">
                                        {{ $mapel->kode_mapel }}
                                    </span>
                                    <h3 class="font-bold text-gray-800 truncate text-sm mb-1 line-clamp-2 leading-snug">
                                        {{ $mapel->nama_mapel }}
                                    </h3>

                                    <p class="text-gray-400 text-xs truncate mb-4 line-clamp-2 leading-relaxed">
                                        {{ $mapel->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </p>

                                    {{-- Actions --}}
                                    <div class="flex gap-2">
                                        {{-- Edit --}}
                                        <button type="button"
                                            onclick="openEditModal(
                                                '{{ $mapel->id }}',
                                                '{{ $mapel->kode_mapel }}',
                                                @js($mapel->nama_mapel),
                                                @js($mapel->agama ?? ''),
                                                @js($mapel->deskripsi ?? ''),
                                                '{{ $mapel->foto ? asset('storage/' . $mapel->foto) : '' }}',
                                                '{{ route('mapel.update', $mapel->id) }}'
                                            )"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('mapel.destroy', $mapel) }}" method="POST"
                                            class="flex-1" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm font-semibold">Belum ada data mapel</p>
                                    <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Mapel</span> untuk mulai menambahkan</p>
                                    <button type="button" onclick="openCreateModal()"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Mapel
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                @if ($mapels->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $mapels->firstItem() }}–{{ $mapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $mapels->total() }}</span>
                            entri
                        </p>
                        {{ $mapels->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')

    @include('mapel.modal-create')
    @include('mapel.modal-edit')

    @push('scripts')
        <script>
            /* ── Search ── */
            const searchInput = document.getElementById('searchInput');
            const btnSearch   = document.getElementById('btnSearch');
            const btnReset    = document.getElementById('btnReset');

            btnSearch.addEventListener('click', () => {
                window.location.href = `{{ route('mapel.index') }}?search=${encodeURIComponent(searchInput.value)}`;
            });

            if (btnReset) {
                btnReset.addEventListener('click', () => {
                    window.location.href = `{{ route('mapel.index') }}`;
                });
            }

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') btnSearch.click();
            });

            /* ── Modal Create ── */
            function openCreateModal() {
                document.getElementById('modalCreate').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateModal() {
                document.getElementById('modalCreate').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Modal Edit ── */
            function openEditModal(id, kodeMapel, namaMapel, agama, deskripsi, fotoUrl, route) {
                const modal = document.getElementById('modalEdit');
                const form  = document.getElementById('editFormAction');
                const btn   = document.getElementById('editSubmitBtn');

                form.action = route;
                document.getElementById('edit_route').value        = route;
                document.getElementById('editKodeMapel').value     = kodeMapel  || '';
                document.getElementById('editNamaMapel').value     = namaMapel  || '';
                document.getElementById('editAgama').value         = agama      || '';
                document.getElementById('editDeskripsi').value     = deskripsi  || '';

                const previewWrap = document.getElementById('editFotoPreviewWrap');
                const previewImg  = document.getElementById('editFotoPreview');
                if (fotoUrl) {
                    previewImg.src             = fotoUrl;
                    previewWrap.classList.remove('hidden');
                } else {
                    previewWrap.classList.add('hidden');
                }

                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditModal() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ── Confirm Delete ── */
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit create */
                const createForm = document.getElementById('createFormAction');
                const createBtn  = document.getElementById('createSubmitBtn');

                if (createForm) {
                    createForm.addEventListener('submit', () => {
                        createBtn.disabled = true;
                        createBtn.innerHTML = `
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Menyimpan...
                        `;
                    });
                }

                /* Confirm update + anti double-submit edit */
                const editForm = document.getElementById('editFormAction');
                const editBtn  = document.getElementById('editSubmitBtn');

                if (editForm) {
                    editForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        showConfirmUpdate().then((result) => {
                            if (result.isConfirmed) {
                                editBtn.disabled = true;
                                editBtn.innerHTML = `
                                    <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Menyimpan...
                                `;
                                editForm.submit();
                            }
                        });
                    });
                }

                /* Re-open modal on validation error */
                @if ($errors->any())
                    @if (old('_modal') === 'create')
                        openCreateModal();
                    @elseif (old('_modal') === 'edit')
                        const savedRoute = document.getElementById('edit_route').value;
                        if (savedRoute) document.getElementById('editFormAction').action = savedRoute;
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreate', 'modalEdit'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal) {
                        modal.addEventListener('click', function (e) {
                            if (e.target === this) {
                                this.classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                            }
                        });
                    }
                });

            });
        </script>
    @endpush
</x-app-layout>