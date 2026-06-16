<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Manajemen Absensi</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            @if ($belumAdaKelas)
            {{-- Belum ditugaskan sebagai wali kelas --}}
            <div class="bg-white rounded-xl border border-dashed border-amber-200 p-10 text-center">
                <svg class="w-10 h-10 text-amber-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <p class="text-sm font-medium text-slate-500">Anda belum ditugaskan sebagai wali kelas</p>
                <p class="text-xs text-slate-400 mt-1">Hubungi admin untuk mengatur penugasan kelas</p>
            </div>
            @else
            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">Daftar Absensi</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Kelola data kehadiran siswa per pertemuan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('absensi.trash') }}"
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
                            Tambah Absensi
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Search --}}
                        <div class="relative flex-1 min-w-[180px] max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ $search }}"
                                placeholder="Cari nama siswa..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Filter Pertemuan --}}
                        <select id="pertemuanSelect"
                            class="rounded-xl border min-w-[160px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="">Semua Pertemuan</option>
                            @foreach ($pertemuans as $pertemuan)
                                <option value="{{ $pertemuan->id }}" {{ $pertemuan_filter == $pertemuan->id ? 'selected' : '' }}>
                                    Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                    @if($pertemuan->tanggal) — {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }} @endif
                                </option>
                            @endforeach
                        </select>

                        {{-- Filter Status --}}
                        <select id="statusSelect"
                            class="rounded-xl border min-w-[130px] border-gray-200 bg-white py-2 px-3 text-xs text-gray-700 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none cursor-pointer transition">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ $status_filter == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin"  {{ $status_filter == 'izin'  ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ $status_filter == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ $status_filter == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>

                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if ($search || $pertemuan_filter || $status_filter)
                            <a href="{{ route('absensi.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-gray-100 text-gray-500 text-xs font-semibold rounded-xl border border-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
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
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Siswa</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Pertemuan</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Waktu Absen</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-32">Keterlambatan</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">Status</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">Keterangan</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($absensis as $index => $absensi)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($absensis->firstItem() + $index, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-amber-600 text-[10px] font-bold uppercase">
                                                    {{ substr($absensi->siswa->nama_lengkap ?? 'NA', 0, 2) }}
                                                </span>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">
                                                {{ $absensi->siswa->nama_lengkap ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-gray-600 text-sm">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">
                                                {{ $absensi->pertemuan->nomor_pertemuan ?? '-' }}
                                            </span>
                                            Pertemuan ke-{{ $absensi->pertemuan->nomor_pertemuan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm whitespace-nowrap">
                                        {{ $absensi->waktu_absen ? $absensi->waktu_absen->format('d M Y, H:i') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($absensi->status === 'hadir')
                                            @php
                                                $lateMap = [
                                                    'tepat_waktu' => ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'Tepat Waktu'],
                                                    'terlambat'  => ['bg-amber-50',    'text-amber-700',    'border-amber-200',    'Terlambat'],
                                                    'sangat_terlambat' => ['bg-red-50',   'text-red-700',   'border-red-200',   'Sangat Terlambat'],
                                                ];
                                                [$lBg, $lText, $lBorder, $lLabel] = $lateMap[$absensi->status_keterlambatan] ?? ['bg-gray-50','text-gray-500','border-gray-200', 'Tepat Waktu'];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 {{ $lBg }} {{ $lText }} border {{ $lBorder }} text-[10px] font-bold rounded-full">
                                                {{ $lLabel }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusMap = [
                                                'hadir' => ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200', '● Hadir'],
                                                'izin'  => ['bg-blue-50',    'text-blue-700',    'border-blue-200',    '● Izin'],
                                                'sakit' => ['bg-amber-50',   'text-amber-700',   'border-amber-200',   '● Sakit'],
                                                'alpha' => ['bg-red-50',     'text-red-600',     'border-red-200',     '● Alpha'],
                                            ];
                                            [$bg, $text, $border, $label] = $statusMap[$absensi->status] ?? ['bg-gray-50','text-gray-500','border-gray-200',$absensi->status];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 {{ $bg }} {{ $text }} border {{ $border }} text-[10px] font-bold rounded-full">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm max-w-xs truncate">
                                        {{ $absensi->keterangan ? \Illuminate\Support\Str::limit($absensi->keterangan, 40) : '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Edit --}}
                                            <button type="button"
                                                data-id="{{ $absensi->id }}"
                                                data-id_pertemuan="{{ $absensi->id_pertemuan }}"
                                                data-id_siswa="{{ $absensi->id_siswa }}"
                                                data-status="{{ $absensi->status }}"
                                                data-keterangan="{{ $absensi->keterangan }}"
                                                data-route="{{ route('absensi.update', $absensi->id) }}"
                                                class="btn-edit w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                    title="Hapus">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data absensi</p>
                                            <p class="text-gray-300 text-xs">Klik <span class="font-semibold text-gray-400">+ Tambah Absensi</span> untuk mulai menambahkan</p>
                                            <button type="button" onclick="openCreateModal()"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Tambah Absensi
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($absensis->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-700">{{ $absensis->firstItem() }}–{{ $absensis->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $absensis->total() }}</span>
                            entri
                        </p>
                        {{ $absensis->links() }}
                    </div>
                @endif

            </div>
            @endif
        </div>
    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.success')
    @include('components.alerts.error')
    @include('components.alerts.confirm-delete')

    @include('absensi.modal-create')
    @include('absensi.modal-edit')

    @push('scripts')
        <script>
            /* ── Search ── */
            const searchInput     = document.getElementById('searchInput');
            const pertemuanSelect = document.getElementById('pertemuanSelect');
            const statusSelect    = document.getElementById('statusSelect');
            const btnSearch       = document.getElementById('btnSearch');

            function getSearchUrl() {
                const params = new URLSearchParams();
                if (searchInput.value.trim())   params.append('search',        searchInput.value.trim());
                if (pertemuanSelect.value)       params.append('id_pertemuan',  pertemuanSelect.value);
                if (statusSelect.value)          params.append('status',        statusSelect.value);
                return `{{ route('absensi.index') }}?${params.toString()}`;
            }

            btnSearch.addEventListener('click', () => window.location.href = getSearchUrl());
            pertemuanSelect.addEventListener('change', () => window.location.href = getSearchUrl());
            statusSelect.addEventListener('change', () => window.location.href = getSearchUrl());
            searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') window.location.href = getSearchUrl(); });

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
            function openEditModal(btn) {
                const d      = btn.dataset;
                const modal  = document.getElementById('modalEdit');
                const form   = document.getElementById('editFormAction');
                const subBtn = document.getElementById('editSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route').value      = d.route;
                document.getElementById('editIdPertemuan').value = d.id_pertemuan || '';
                document.getElementById('editIdSiswa').value     = d.id_siswa     || '';
                document.getElementById('editKeterangan').value  = d.keterangan   || '';

                document.querySelectorAll('.edit-status-radio').forEach(radio => {
                    radio.checked = (radio.value === d.status);
                    syncStatusCard(radio.value, radio.value === d.status, 'edit');
                });

                subBtn.disabled = false;
                subBtn.innerHTML = `
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

                /* Bind edit buttons */
                document.querySelectorAll('.btn-edit').forEach(btn => {
                    btn.addEventListener('click', function () { openEditModal(this); });
                });

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

                /* Re-open modal on validation error */
                @if ($errors->any())
                    openCreateModal();
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