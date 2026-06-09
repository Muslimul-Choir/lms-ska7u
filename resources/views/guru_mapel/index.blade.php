<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Guru Mapel</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Guru Mapel</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola penugasan guru ke mata pelajaran</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('guru_mapel.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Arsip
                            @if ($trashCount > 0)
                                <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                            @endif
                        </a>
                        <button type="button" onclick="openCreateModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Guru Mapel
                        </button>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-2 max-w-sm">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama mapel atau guru..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>
                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('guru_mapel.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">#</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Mapel</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Guru</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Semester</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($guruMapels as $guruMapel)
                                @php $isLocked = in_array($guruMapel->id, $lockedIds); @endphp
                                <tr class="hover:bg-amber-50/40 transition {{ $isLocked ? 'bg-gray-50/60' : '' }}">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($guruMapels->currentPage() - 1) * $guruMapels->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Mapel --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($guruMapel->Mapel->nama_mapel ?? '-', 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-800 text-sm">{{ $guruMapel->Mapel->nama_mapel ?? '-' }}</span>
                                                @if($isLocked)
                                                    <span class="inline-flex items-center gap-1 mt-0.5">
                                                        <svg class="w-2.5 h-2.5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="text-[10px] text-red-400 font-semibold">Terkunci</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Guru --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-gray-500 text-[10px] font-bold uppercase">
                                                    {{ substr($guruMapel->Guru->nama_lengkap ?? '-', 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="text-gray-700 text-sm font-medium">{{ $guruMapel->Guru->nama_lengkap ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Semester --}}
                                    <td class="px-6 py-4">
                                        @if ($guruMapel->Semester->nama_semester ?? null)
                                            <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg">
                                                {{ $guruMapel->Semester->nama_semester }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">

                                            {{-- Detail --}}
                                            <button type="button"
                                                onclick="openDetailModal(this)"
                                                data-mapel="{{ $guruMapel->Mapel->nama_mapel ?? '-' }}"
                                                data-guru="{{ $guruMapel->Guru->nama_lengkap ?? '-' }}"
                                                data-semester="{{ $guruMapel->Semester->nama_semester ?? '-' }}"
                                                data-created="{{ $guruMapel->created_at->format('d F Y, H:i') }}"
                                                data-updated="{{ $guruMapel->updated_at->format('d F Y, H:i') }}"
                                                title="Detail"
                                                class="w-8 h-8 flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-500 border border-blue-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </button>

                                            {{-- Edit --}}
                                            <button type="button"
                                                onclick="openEditModal(this)"
                                                data-id="{{ $guruMapel->id }}"
                                                data-route="{{ route('guru_mapel.update', $guruMapel->id) }}"
                                                data-id-mapel="{{ $guruMapel->id_mapel }}"
                                                data-id-guru="{{ $guruMapel->id_guru }}"
                                                data-guru-label="{{ $guruMapel->Guru->nama_lengkap ?? '-' }}"
                                                data-id-semester="{{ $guruMapel->id_semester }}"
                                                data-locked="{{ $isLocked ? '1' : '0' }}"
                                                title="{{ $isLocked ? 'Data terkunci' : 'Edit' }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg border transition
                                                    {{ $isLocked
                                                        ? 'bg-gray-50 text-gray-300 border-gray-200 cursor-not-allowed'
                                                        : 'bg-amber-50 hover:bg-amber-100 text-amber-600 border-amber-200' }}">
                                                @if($isLocked)
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                @endif
                                            </button>

                                            {{-- Hapus --}}
                                            @if($isLocked)
                                                <button type="button" disabled
                                                    title="Tidak bisa dihapus — data sedang digunakan"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <form action="{{ route('guru_mapel.destroy', $guruMapel->id) }}" method="POST"
                                                    onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus"
                                                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data guru mapel</p>
                                            <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Guru Mapel</span> untuk mulai menambahkan</p>
                                            <button type="button" onclick="openCreateModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Tambah Guru Mapel
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($guruMapels->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $guruMapels->firstItem() }}–{{ $guruMapels->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $guruMapels->total() }}</span>
                            entri
                        </p>
                        {{ $guruMapels->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-delete')
    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')

    @include('guru_mapel.modal-create')
    @include('guru_mapel.modal-edit')
    @include('guru_mapel.modal-detail')

    @push('scripts')
        <script>
            /* ═══════════════════════════════════════
               Search
            ═══════════════════════════════════════ */
            const searchInput = document.getElementById('searchInput');
            const btnSearch   = document.getElementById('btnSearch');

            btnSearch.addEventListener('click', () => {
                window.location.href = `{{ route('guru_mapel.index') }}?search=${encodeURIComponent(searchInput.value)}`;
            });

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') btnSearch.click();
            });

            /* ═══════════════════════════════════════
               Modal Create
            ═══════════════════════════════════════ */
            function openCreateModal() {
                document.getElementById('modalCreate').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateModal() {
                document.getElementById('modalCreate').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ═══════════════════════════════════════
               Modal Edit  ← FIXED: semua toggle via JS
            ═══════════════════════════════════════ */
            function openEditModal(btn) {
                const d        = btn.dataset;
                const isLocked = d.locked === '1';
                const modal    = document.getElementById('modalEdit');
                const form     = document.getElementById('editFormAction');

                /* Route */
                form.action = d.route;
                document.getElementById('edit_route').value = d.route;

                /* ── Header icon ── */
                document.getElementById('editHeaderIconLocked').classList.toggle('hidden', !isLocked);
                document.getElementById('editHeaderIconEdit').classList.toggle('hidden',   isLocked);

                /* ── Judul & subtitle ── */
                document.getElementById('editModalTitle').textContent =
                    isLocked ? 'Detail Guru Mapel' : 'Edit Guru Mapel';
                document.getElementById('editModalSubtitle').textContent = isLocked
                    ? 'Data terkunci — sudah digunakan di jadwal/materi/kuis'
                    : 'Perbarui data penugasan guru ke mapel';

                /* ── Notice bar ── */
                document.getElementById('editNoticeLocked').classList.toggle('hidden', !isLocked);
                document.getElementById('editNoticeNormal').classList.toggle('hidden',  isLocked);

                /* ── Mata Pelajaran ── */
                const mapelSel = document.getElementById('edit_id_mapel');
                mapelSel.value    = d.idMapel;
                mapelSel.disabled = isLocked;
                mapelSel.classList.toggle('bg-gray-100',       isLocked);
                mapelSel.classList.toggle('cursor-not-allowed', isLocked);
                mapelSel.classList.toggle('text-gray-500',     isLocked);
                mapelSel.classList.toggle('bg-gray-50',        !isLocked);
                document.getElementById('edit_id_mapel_hidden').value = d.idMapel;

                /* ── Guru ── */
                const guruSel     = document.getElementById('edit_id_guru');
                const guruDisplay = document.getElementById('editGuruLockedDisplay');

                if (isLocked) {
                    guruSel.classList.add('hidden');
                    guruDisplay.classList.remove('hidden');
                    document.getElementById('edit_guru_label').textContent    = d.guruLabel || '-';
                    document.getElementById('edit_id_guru_locked').value       = d.idGuru;
                } else {
                    guruSel.classList.remove('hidden');
                    guruDisplay.classList.add('hidden');
                    guruSel.value = d.idGuru;
                }

                /* ── Semester ── */
                const semSel = document.getElementById('edit_id_semester');
                semSel.value    = d.idSemester;
                semSel.disabled = isLocked;
                semSel.classList.toggle('bg-gray-100',       isLocked);
                semSel.classList.toggle('cursor-not-allowed', isLocked);
                semSel.classList.toggle('text-gray-500',     isLocked);
                semSel.classList.toggle('bg-gray-50',        !isLocked);
                document.getElementById('edit_id_semester_hidden').value = d.idSemester;

                /* ── Footer buttons ── */
                const submitBtn = document.getElementById('editSubmitBtn');
                const cancelBtn = document.getElementById('editCancelBtn');
                submitBtn.classList.toggle('hidden', isLocked);
                cancelBtn.textContent = isLocked ? 'Tutup' : 'Batal';

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditModal() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ═══════════════════════════════════════
               Modal Detail
            ═══════════════════════════════════════ */
            function openDetailModal(button) {
                const d = button.dataset;
                document.getElementById('detail-mapel').textContent    = d.mapel;
                document.getElementById('detail-guru').textContent     = d.guru;
                document.getElementById('detail-semester').textContent = d.semester;
                document.getElementById('detail-created').textContent  = d.created;
                document.getElementById('detail-updated').textContent  = d.updated;

                document.getElementById('modalDetail').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDetailModal() {
                document.getElementById('modalDetail').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ═══════════════════════════════════════
               Confirm Delete
            ═══════════════════════════════════════ */
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }

            /* ═══════════════════════════════════════
               DOMContentLoaded
            ═══════════════════════════════════════ */
            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit — Create */
                const createForm = document.getElementById('createFormAction');
                const createBtn  = document.getElementById('createSubmitBtn');

                if (createForm && createBtn) {
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

                /* Anti double-submit — Edit (with confirm dialog) */
                const editForm = document.getElementById('editFormAction');
                const editBtn  = document.getElementById('editSubmitBtn');

                if (editForm && editBtn) {
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
                        const savedRoute = document.getElementById('edit_route')?.value;
                        if (savedRoute) document.getElementById('editFormAction').action = savedRoute;
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreate', 'modalEdit', 'modalDetail'].forEach(id => {
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