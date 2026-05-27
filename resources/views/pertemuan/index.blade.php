<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Master Pertemuan
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Data Master
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">
                    Dashboard
                </a>

                <span class="text-gray-300">/</span>

                <span>Master Data</span>

                <span class="text-gray-300">/</span>

                <span class="text-gray-600 font-semibold">
                    Pertemuan
                </span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div
                    class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="font-medium">
                            {{ session('success') }}
                        </span>
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

                {{-- Header --}}
                <div
                    class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Daftar Pertemuan
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5 ml-3">
                            Kelola data pertemuan tiap jadwal belajar
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('pertemuan.trash') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">

                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>

                            Tempat Sampah
                        </a>

                        <button type="button" id="btnTambahPertemuan"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">

                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4v16m8-8H4" />
                            </svg>

                            Tambah Pertemuan
                        </button>
                    </div>
                </div>

                {{-- Filter --}}
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Search --}}
                        <div class="relative min-w-[180px] flex-1 max-w-xs">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <input type="text"
                                id="searchInput"
                                value="{{ request('search') }}"
                                placeholder="Cari nomor / tanggal..."
                                class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition">
                        </div>

                        {{-- Jadwal --}}
                        <div class="relative">
                            <select id="jadwalSelect"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">

                                <option value="">Semua Jadwal</option>

                                @foreach($jadwalBelajars as $jadwal)
                                    <option value="{{ $jadwal->id }}"
                                        {{ request('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->nama_jadwal ?? 'Jadwal #' . $jadwal->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="relative">
                            <select id="statusSelect"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">

                                <option value="">Semua Status</option>
                                <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>
                                    Dijadwalkan
                                </option>

                                <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>
                                    Berlangsung
                                </option>

                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>

                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>

                        <button type="button"
                            id="btnSearch"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                            Cari
                        </button>

                        @if(request('search') || request('id_jadwal') || request('status'))
                            <button type="button"
                                id="btnReset"
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
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    #
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Jadwal Belajar
                                </th>

                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    No Pertemuan
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Tanggal
                                </th>

                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($pertemuans as $pertemuan)

                                <tr class="hover:bg-amber-50/40 transition">

                                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                        {{ str_pad($loop->iteration + ($pertemuans->currentPage() - 1) * $pertemuans->perPage(), 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-amber-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>

                                            <span class="font-semibold text-gray-800 text-sm">
                                                {{ $pertemuan->jadwalBelajar->nama_jadwal ?? 'Jadwal #' . $pertemuan->id_jadwal }}
                                            </span>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                            {{ $pertemuan->nomor_pertemuan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($pertemuan->tanggal)
                                            {{ \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y') }}
                                        @else
                                            <span class="text-gray-300 italic text-xs">
                                                Belum ditentukan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @php
                                            $statusMap = [
                                                'dijadwalkan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'berlangsung' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'selesai'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'dibatalkan'  => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-[10px] font-bold {{ $statusMap[$pertemuan->status] ?? '' }}">
                                            {{ ucfirst($pertemuan->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            <button
                                                type="button"

                                                class="btn-edit w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"

                                                data-id="{{ $pertemuan->id }}"
                                                data-id_jadwal="{{ $pertemuan->id_jadwal }}"
                                                data-nomor_pertemuan="{{ $pertemuan->nomor_pertemuan }}"
                                                data-tanggal="{{ $pertemuan->tanggal }}"
                                                data-status="{{ $pertemuan->status }}"

                                                title="Edit">

                                                <svg class="w-3.5 h-3.5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('pertemuan.destroy', $pertemuan) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">

                                                    <svg class="w-3.5 h-3.5" fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2.5">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>

                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                        Belum ada data pertemuan
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($pertemuans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $pertemuans->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- MODAL CREATE --}}
    @include('pertemuan.modal-create')

    {{-- MODAL EDIT --}}
    @include('pertemuan.modal-edit')

    <script>

        // =========================
        // ELEMENT
        // =========================

        const modalCreate  = document.getElementById('modalCreate');
        const modalEdit    = document.getElementById('modalEdit');

        const searchInput  = document.getElementById('searchInput');
        const jadwalSelect = document.getElementById('jadwalSelect');
        const statusSelect = document.getElementById('statusSelect');

        const btnSearch = document.getElementById('btnSearch');
        const btnReset  = document.getElementById('btnReset');

        // =========================
        // SEARCH
        // =========================

        function getSearchUrl() {

            const search = encodeURIComponent(searchInput.value);
            const jadwal = encodeURIComponent(jadwalSelect.value);
            const status = encodeURIComponent(statusSelect.value);

            return `{{ route('pertemuan.index') }}?search=${search}&id_jadwal=${jadwal}&status=${status}`;
        }

        btnSearch.addEventListener('click', function () {
            window.location.href = getSearchUrl();
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                window.location.href = getSearchUrl();
            }
        });

        jadwalSelect.addEventListener('change', function () {
            window.location.href = getSearchUrl();
        });

        statusSelect.addEventListener('change', function () {
            window.location.href = getSearchUrl();
        });

        if (btnReset) {
            btnReset.addEventListener('click', function () {
                window.location.href = `{{ route('pertemuan.index') }}`;
            });
        }

        // =========================
        // CREATE MODAL
        // =========================

        document.getElementById('btnTambahPertemuan')
            .addEventListener('click', function () {

                modalCreate.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

        // =========================
        // EDIT MODAL
        // =========================

        function openEditModal(data) {

            document.getElementById('formEdit').action =
                `/pertemuan/${data.id}`;

            document.getElementById('editIdJadwal').value =
                data.id_jadwal;

            document.getElementById('editNomorPertemuan').value =
                data.nomor_pertemuan;

            document.getElementById('editTanggal').value =
                data.tanggal ?? '';

            document.getElementById('editStatus').value =
                data.status;

            modalEdit.style.display = 'flex';

            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {

            modalEdit.style.display = 'none';

            document.body.style.overflow = '';
        }

        // bind edit buttons
        document.querySelectorAll('.btn-edit').forEach(button => {

            button.addEventListener('click', function () {

                openEditModal({
                    id: this.dataset.id,
                    id_jadwal: this.dataset.id_jadwal,
                    nomor_pertemuan: this.dataset.nomor_pertemuan,
                    tanggal: this.dataset.tanggal,
                    status: this.dataset.status,
                });

            });

        });

        // close modal
        document.getElementById('closeEdit')
            ?.addEventListener('click', closeEditModal);

        document.getElementById('cancelEdit')
            ?.addEventListener('click', closeEditModal);

        document.getElementById('overlayEdit')
            ?.addEventListener('click', closeEditModal);

        // ESC close
        document.addEventListener('keydown', function (e) {

            if (e.key === 'Escape') {

                closeEditModal();

                if (modalCreate) {
                    modalCreate.style.display = 'none';
                }

                document.body.style.overflow = '';
            }
        });

        // =========================
        // ERROR VALIDATION
        // =========================

        @if ($errors->any())
            modalCreate.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        @endif

    </script>
</x-app-layout>