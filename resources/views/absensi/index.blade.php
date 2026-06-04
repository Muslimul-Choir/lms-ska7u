<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Master Absensi</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-5">

            {{-- Alert Success --}}
            @if (session('success'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-emerald-400 hover:text-emerald-600 transition">
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
                <div
                    class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Daftar Absensi
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Kelola data kehadiran siswa per pertemuan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('absensi.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Tempat Sampah
                        </a>
                        <button type="button" id="btnTambahAbsensi"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Absensi
                        </button>
                    </div>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Search --}}
                        <div class="relative min-w-[180px] flex-1 max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama siswa..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Filter Pertemuan --}}
                        <div class="relative">
                            <select id="pertemuanSelect"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">
                                <option value="">Semua Pertemuan</option>
                                @foreach ($pertemuans as $pertemuan)
                                    <option value="{{ $pertemuan->id }}"
                                        {{ request('id_pertemuan') == $pertemuan->id ? 'selected' : '' }}>
                                        Pertemuan {{ $pertemuan->nomor_pertemuan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        {{-- Filter Status --}}
                        <div class="relative">
                            <select id="statusSelect"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir
                                </option>
                                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin
                                </option>
                                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit
                                </option>
                                <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <button type="button" id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if (request('search') || request('id_pertemuan') || request('status'))
                            <button type="button" id="btnReset"
                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-xl transition">
                                Reset
                            </button>
                        @endif
                    </div>
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
                                    Siswa</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Pertemuan</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-28">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Keterangan</th>
                                <th
                                    class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest w-36">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody" class="divide-y divide-gray-100">
                            @forelse ($absensis as $absensi)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
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
                                            <span
                                                class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">
                                                {{ $absensi->pertemuan->nomor_pertemuan ?? '-' }}
                                            </span>
                                            Pertemuan ke-{{ $absensi->pertemuan->nomor_pertemuan ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusMap = [
                                                'hadir' => [
                                                    'bg-emerald-50',
                                                    'text-emerald-700',
                                                    'border-emerald-200',
                                                    '● Hadir',
                                                ],
                                                'izin' => ['bg-blue-50', 'text-blue-700', 'border-blue-200', '● Izin'],
                                                'sakit' => [
                                                    'bg-amber-50',
                                                    'text-amber-700',
                                                    'border-amber-200',
                                                    '● Sakit',
                                                ],
                                                'alpha' => ['bg-red-50', 'text-red-600', 'border-red-200', '● Alpha'],
                                            ];
                                            [$bg, $text, $border, $label] = $statusMap[$absensi->status] ?? [
                                                'bg-gray-50',
                                                'text-gray-500',
                                                'border-gray-200',
                                                $absensi->status,
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 {{ $bg }} {{ $text }} border {{ $border }} text-[10px] font-bold rounded-full">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 text-sm max-w-xs truncate">
                                        {{ $absensi->keterangan ? \Illuminate\Support\Str::limit($absensi->keterangan, 40) : '—' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" data-id="{{ $absensi->id }}"
                                                data-id_pertemuan="{{ $absensi->id_pertemuan }}"
                                                data-id_siswa="{{ $absensi->id_siswa }}"
                                                data-status="{{ $absensi->status }}"
                                                data-keterangan="{{ $absensi->keterangan }}"
                                                class="btn-edit w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                    title="Hapus">
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
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-semibold">Belum ada data absensi</p>
                                            <p class="text-gray-300 text-xs">Klik <span
                                                    class="font-semibold text-gray-400">+ Tambah Absensi</span> untuk
                                                mulai menambahkan</p>
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
                            <span
                                class="font-semibold text-gray-700">{{ $absensis->firstItem() }}–{{ $absensis->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-700">{{ $absensis->total() }}</span>
                            entri
                        </p>
                        {{ $absensis->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('absensi.modal-create')
    @include('absensi.modal-edit')

    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');
        const searchInput = document.getElementById('searchInput');
        const pertemuanSelect = document.getElementById('pertemuanSelect');
        const statusSelect = document.getElementById('statusSelect');
        const btnSearch = document.getElementById('btnSearch');
        const btnReset = document.getElementById('btnReset');

        function getSearchUrl() {
            const search = encodeURIComponent(searchInput.value);
            const pertemuan = encodeURIComponent(pertemuanSelect.value);
            const status = encodeURIComponent(statusSelect.value);
            return `{{ route('absensi.index') }}?search=${search}&id_pertemuan=${pertemuan}&status=${status}`;
        }

        btnSearch.addEventListener('click', () => window.location.href = getSearchUrl());
        pertemuanSelect.addEventListener('change', () => window.location.href = getSearchUrl());
        statusSelect.addEventListener('change', () => window.location.href = getSearchUrl());
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') window.location.href = getSearchUrl();
        });

        if (btnReset) {
            btnReset.addEventListener('click', () => {
                window.location.href = `{{ route('absensi.index') }}`;
            });
        }

        document.getElementById('btnTambahAbsensi').addEventListener('click', () => modalCreate.style.display = 'flex');
        document.getElementById('closeCreate').addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate').addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click', () => modalCreate.style.display = 'none');
        document.getElementById('closeEdit').addEventListener('click', () => modalEdit.style.display = 'none');
        document.getElementById('cancelEdit').addEventListener('click', () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit').addEventListener('click', () => modalEdit.style.display = 'none');

        function bindEditButtons() {
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('editIdPertemuan').value = this.dataset.id_pertemuan;
                    document.getElementById('editIdSiswa').value = this.dataset.id_siswa;
                    document.getElementById('editKeterangan').value = this.dataset.keterangan ?? '';
                    document.getElementById('formEdit').action = `/absensi/${this.dataset.id}`;

                    const status = this.dataset.status;
                    document.querySelectorAll('.edit-status-radio').forEach(radio => {
                        radio.checked = (radio.value === status);
                    });

                    modalEdit.style.display = 'flex';
                });
            });
        }

        bindEditButtons();

        @if ($errors->any())
            modalCreate.style.display = 'flex';
        @endif
    </script>

</x-app-layout>
