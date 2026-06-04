<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                    <circle cx="12" cy="11" r="1" fill="currentColor" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Manajemen Kelas</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Kelas</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data kelas dan unit organisasi</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('kelas.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Arsip
                            @if ($trashCount > 0)
                                <span
                                    class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold leading-none">{{ $trashCount }}</span>
                            @endif
                        </a>
                        <button type="button" onclick="openCreateModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Kelas
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <form method="GET" action="{{ route('kelas.index') }}" id="filterForm">
                        <div class="flex flex-wrap items-end gap-3">

                            {{-- Tingkatan --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tingkatan</label>
                                <select name="id_tingkatan"
                                    class="rounded-xl border min-w-[120px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Tingkat</option>
                                    @foreach ($tingkatanList as $t)
                                        <option value="{{ $t->id }}"
                                            {{ request('id_tingkatan') == $t->id ? 'selected' : '' }}>
                                            {{ $t->nama_tingkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Jurusan --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jurusan</label>
                                <select name="id_jurusan"
                                    class="rounded-xl border min-w-[120px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($jurusanList as $j)
                                        <option value="{{ $j->id }}"
                                            {{ request('id_jurusan') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Bagian --}}
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bagian</label>
                                <select name="id_bagian"
                                    class="rounded-xl border min-w-[120px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Bagian</option>
                                    @foreach ($bagianList as $j)
                                        <option value="{{ $j->id }}"
                                            {{ request('id_bagian') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_bagian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tahun Ajaran --}}
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tahun
                                    Ajaran</label>
                                <select name="id_tahun_ajaran"
                                    class="rounded-xl border min-w-[120px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunAjaranList as $ta)
                                        <option value="{{ $ta->id }}"
                                            {{ request('id_tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun }}{{ $ta->is_aktif ? ' (Aktif)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Reset --}}
                            @if (request()->filled('id_tahun_ajaran') ||
                                    request()->filled('id_tingkatan') ||
                                    request()->filled('id_jurusan') ||
                                    request()->filled('id_bagian'))
                                <a href="{{ route('kelas.index') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                    Reset
                                </a>
                            @endif

                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest w-12">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Kelas</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden md:table-cell">
                                    Jurusan</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden lg:table-cell">
                                    Tahun Ajaran</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest hidden lg:table-cell">
                                    Wali Kelas</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-24">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($kelas as $index => $k)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($kelas->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <span
                                                    class="text-[11px] font-extrabold text-white tracking-tight leading-none">
                                                    {{ $k->Tingkatan?->nama_tingkatan ?? '?' }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm leading-tight">
                                                    {{ $k->Tingkatan?->nama_tingkatan ?? '-' }}
                                                    {{ $k->Bagian?->nama_bagian ?? '-' }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-0.5 md:hidden">
                                                    {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ $k->Jurusan?->nama_jurusan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm hidden lg:table-cell">
                                        {{ $k->TahunAjaran?->nama_tahun ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-full bg-amber-100 border border-amber-200 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[10px] font-bold text-amber-600">
                                                    {{ strtoupper(substr($k->WaliKelas?->nama_lengkap ?? '?', 0, 1)) }}
                                                </span>
                                            </div>
                                            <span
                                                class="text-sm text-gray-600">{{ $k->WaliKelas?->nama_lengkap ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Edit --}}
                                            <button onclick="openEditModal(this)" data-id="{{ $k->id }}"
                                                data-route="{{ route('kelas.update', $k->id) }}"
                                                data-id-tingkatan="{{ $k->id_tingkatan }}"
                                                data-id-jurusan="{{ $k->id_jurusan }}"
                                                data-id-bagian="{{ $k->id_bagian }}"
                                                data-id-tahun-ajaran="{{ $k->id_tahun_ajaran }}"
                                                data-id-wali-kelas="{{ $k->id_wali_kelas ?? '' }}" title="Edit"
                                                class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('kelas.destroy', $k->id) }}" method="POST"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 21h18M5 21V5a1 1 0 011-1h12a1 1 0 011 1v16M9 21v-6h6v6" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data kelas</p>
                                            <p class="text-gray-300 text-xs">Ubah filter atau klik <span
                                                    class="font-semibold text-gray-400">+ Tambah Kelas</span></p>
                                            <button type="button" onclick="openCreateModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Kelas
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($kelas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span
                                class="font-semibold text-gray-700">{{ $kelas->firstItem() }}–{{ $kelas->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $kelas->total() }}</span>
                            entri
                        </p>
                        {{ $kelas->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')

    @include('kelas.modal-create', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    @include('kelas.modal-edit', [
        'tingkatanList' => $tingkatanList,
        'jurusanList' => $jurusanList,
        'bagianList' => $bagianList,
        'tahunAjaranList' => $tahunAjaranList,
        'guruList' => $guruList,
    ])

    @push('scripts')
        <script>
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
            function openEditModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEdit');
                const form = document.getElementById('editFormAction');
                const btn = document.getElementById('editSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route').value = d.route;

                document.getElementById('edit_id_tingkatan').value = d.idTingkatan ?? '';
                document.getElementById('edit_id_jurusan').value = d.idJurusan ?? '';
                document.getElementById('edit_id_bagian').value = d.idBagian ?? '';
                document.getElementById('edit_id_tahun_ajaran').value = d.idTahunAjaran ?? '';
                document.getElementById('edit_id_wali_kelas').value = d.idWaliKelas ?? '';

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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit */
                const editForm = document.getElementById('editFormAction');
                const editBtn = document.getElementById('editSubmitBtn');
                const createForm = document.getElementById('createFormAction');
                const createBtn = document.getElementById('createSubmitBtn');

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
                        if (savedRoute) {
                            document.getElementById('editFormAction').action = savedRoute;
                        }
                        document.getElementById('modalEdit').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreate', 'modalEdit'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal) {
                        modal.addEventListener('click', function(e) {
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
