<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Master Jam Belajar
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
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Master Data</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Jam Belajar</span>
            </nav>

            {{-- Alert --}}
            @if(session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>

                    <button onclick="this.parentElement.remove()">
                        ✕
                    </button>
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500"></span>
                            Daftar Jam Belajar
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5 ml-3">
                            Kelola data waktu belajar
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Filter --}}
                        <form method="GET" action="{{ route('jambelajar.index') }}">
                            <select name="tingkatan"
                                    onchange="this.form.submit()"
                                    class="px-3 py-2 text-xs border border-gray-200 rounded-xl">
                                <option value="">Semua Tingkatan</option>

                                @foreach($tingkatanList as $tingkatan)
                                    <option value="{{ $tingkatan->id }}"
                                        {{ $filterTingkatan == $tingkatan->id ? 'selected' : '' }}>
                                        {{ $tingkatan->nama_tingkatan }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        {{-- Trash --}}
                        <a href="{{ route('jambelajar.trash') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Tempat Sampah
                        </a>

                        {{-- Tambah --}}
                        <button type="button"
                                id="btnTambahJamBelajar"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                             Tambah Jam Belajar
                        </button>

                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border-collapse">

                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase">
                                    Tingkatan
                                </th>

                                @foreach($jamKe as $ke => $label)
                                    <th class="px-4 py-3 text-center text-[11px] font-bold text-gray-500 uppercase border-l border-gray-100">
                                        {{ $label }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($groupedJamBelajar as $tingkatanNama => $rowJams)

                                <tr class="border-b border-gray-100 hover:bg-amber-50/40">

                                    {{-- Tingkatan --}}
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">
                                            {{ $tingkatanNama }}
                                        </div>
                                    </td>

                                    {{-- Jam --}}
                                    @foreach($jamKe as $ke => $label)

                                        <td class="px-4 py-3 text-center border-l border-gray-100">

                                            @if(isset($rowJams[$ke]))

                                                @php $jam = $rowJams[$ke]; @endphp

                                                <div class="text-xs font-semibold text-gray-700 mb-2">
                                                    {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                                                </div>

                                                <div class="flex items-center justify-center gap-1">

                                                    {{-- EDIT --}}
                                                    <button type="button"
                                                            class="btn-edit w-7 h-7 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                            data-id="{{ $jam->id }}"
                                                            data-id_tingkatan="{{ $jam->id_tingkatan }}"
                                                            data-jam_mulai="{{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}"
                                                            data-jam_selesai="{{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                    </button>

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('jambelajar.destroy', $jam) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="w-7 h-7 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition">
                                                             <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>

                                            @else
                                                <span class="text-gray-300 text-xs">—</span>
                                            @endif

                                        </td>

                                    @endforeach

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="{{ count($jamKe) + 1 }}"
                                        class="px-6 py-16 text-center text-gray-400">
                                        Belum ada data jam belajar
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>

    {{-- MODAL CREATE --}}
    @include('jambelajar.modal-create')

    {{-- MODAL EDIT --}}
    <div id="modalEdit"
         class="fixed inset-0 z-[9999] hidden items-center justify-center">

        {{-- Overlay --}}
        <div id="overlayEdit"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Box --}}
        <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-[#6B1A2B] to-[#2D0810] flex items-center justify-between">
                <div>
                    <h3 class="text-white font-bold text-lg">
                        Edit Jam Belajar
                    </h3>

                    <p class="text-white/60 text-xs">
                        Perbarui data jam belajar
                    </p>
                </div>

                <button type="button"
                        id="closeEdit"
                        class="text-white text-xl">
                    ✕
                </button>
            </div>

            {{-- Form --}}
            <form id="formEdit"
                  method="POST"
                  class="p-6 space-y-5">

                @csrf
                @method('PUT')

                {{-- Tingkatan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                        Tingkatan
                    </label>

                    <select id="editIdTingkatan"
                            name="id_tingkatan"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-400 outline-none">

                        <option value="">-- Pilih Tingkatan --</option>

                        @foreach($tingkatanList as $tingkatan)
                            <option value="{{ $tingkatan->id }}">
                                {{ $tingkatan->nama_tingkatan }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Jam --}}
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                            Jam Mulai
                        </label>

                        <input type="time"
                               id="editJamMulai"
                               name="jam_mulai"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                            Jam Selesai
                        </label>

                        <input type="time"
                               id="editJamSelesai"
                               name="jam_selesai"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t">

                    <button type="button"
                            id="cancelEdit"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold">
                        Batal
                    </button>

                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold">
                        Update
                    </button>

                </div>

            </form>

        </div>
    </div>

    <script>

        // =========================
        // MODAL CREATE
        // =========================
        const modalCreate = document.getElementById('modalCreate');

        document.getElementById('btnTambahJamBelajar')
            .addEventListener('click', () => {
                modalCreate.style.display = 'flex';
            });

        if (document.getElementById('closeCreate')) {
            document.getElementById('closeCreate')
                .addEventListener('click', () => {
                    modalCreate.style.display = 'none';
                });
        }

        if (document.getElementById('cancelCreate')) {
            document.getElementById('cancelCreate')
                .addEventListener('click', () => {
                    modalCreate.style.display = 'none';
                });
        }

        if (document.getElementById('overlayCreate')) {
            document.getElementById('overlayCreate')
                .addEventListener('click', () => {
                    modalCreate.style.display = 'none';
                });
        }

        // =========================
        // MODAL EDIT
        // =========================
        const modalEdit = document.getElementById('modalEdit');

        function openEditModal(id, idTingkatan, jamMulai, jamSelesai) {

            document.getElementById('formEdit').action =
                `/jambelajar/${id}`;

            document.getElementById('editIdTingkatan').value =
                idTingkatan;

            document.getElementById('editJamMulai').value =
                jamMulai;

            document.getElementById('editJamSelesai').value =
                jamSelesai;

            modalEdit.classList.remove('hidden');
            modalEdit.classList.add('flex');

            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');

            document.body.style.overflow = '';
        }

        // bind edit button
        document.querySelectorAll('.btn-edit').forEach(btn => {

            btn.addEventListener('click', function () {

                openEditModal(
                    this.dataset.id,
                    this.dataset.id_tingkatan,
                    this.dataset.jam_mulai,
                    this.dataset.jam_selesai
                );

            });

        });

        // close
        document.getElementById('closeEdit')
            .addEventListener('click', closeEditModal);

        document.getElementById('cancelEdit')
            .addEventListener('click', closeEditModal);

        document.getElementById('overlayEdit')
            .addEventListener('click', closeEditModal);

        // esc
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });

    </script>

</x-app-layout>