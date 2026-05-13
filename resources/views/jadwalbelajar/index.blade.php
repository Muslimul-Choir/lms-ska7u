<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">Jadwal Belajar</h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Jadwal Belajar</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-50 min-h-screen">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Alert Success --}}
            @if (session('success'))
                <div role="alert" class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm" title="Berhasil disimpan">
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi" class="text-emerald-400 hover:text-emerald-700 transition">&times;</button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div role="alert" class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm" title="Terdapat kesalahan">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Filter Atas --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-6 py-4">
                <form method="GET" action="{{ route('jadwalbelajar.index') }}"
                      class="flex flex-wrap items-center gap-3">

                    {{-- Tingkat --}}
                    <select name="tingkat" id="filterTingkat"
                            class="py-2 pl-3 pr-8 text-sm bg-white border border-slate-200 rounded-lg text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#E8734A]/30 focus:border-[#E8734A]">
                        <option value="">Semua Tingkat</option>
                        @foreach ($tingkatanList as $tkt)
                            <option value="{{ $tkt->id }}" {{ $tingkat == $tkt->id ? 'selected' : '' }}>
                                {{ $tkt->nama_tingkatan }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Kelas --}}
                    <select name="id_kelas" id="filterKelas"
                            class="py-2 pl-3 pr-8 text-sm bg-white border border-slate-200 rounded-lg text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-[#E8734A]/30 focus:border-[#E8734A]">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelasList as $kls)
                            @php
                                $namaKls = trim(
                                    ($kls->Tingkatan->nama_tingkatan ?? '') . ' ' .
                                    ($kls->Jurusan->nama_jurusan ?? '') . ' ' .
                                    ($kls->Bagian->nama_bagian ?? '')
                                );
                            @endphp
                            <option value="{{ $kls->id }}"
                                    data-tingkat="{{ $kls->Tingkatan->id ?? '' }}"
                                    {{ $idKelas == $kls->id ? 'selected' : '' }}>
                                {{ $namaKls }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="px-5 py-2 bg-[#E8734A] hover:bg-[#d4623b] text-white text-sm font-semibold rounded-lg transition">
                        Cari Jadwal
                    </button>

                    @if($idKelas || $tingkat)
                        <a href="{{ route('jadwalbelajar.index') }}"
                           class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tombol Print --}}
            <div>
                <button onclick="window.print()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-lg shadow-sm hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
            </div>

            {{-- GRID JADWAL --}}
            @if (!$idKelas && !$tingkat)
                {{-- Belum ada filter --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-6 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-sm font-semibold">Pilih Tingkat atau Kelas</p>
                        <p class="text-slate-400 text-xs">Silakan pilih tingkat atau kelas terlebih dahulu untuk menampilkan jadwal belajar.</p>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 bg-[#E8734A] text-white text-center font-bold text-xs border border-[#e06030] w-32">
                                    Jam
                                </th>
                                @foreach ($hariList as $hari)
                                    <th class="px-4 py-3 bg-[#E8734A] text-white text-center font-bold text-xs border border-[#e06030] min-w-[140px]">
                                        {{ $hari }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamList as $jam)
                                <tr class="border-b border-slate-200">

                                    {{-- Kolom Jam --}}
                                    <td class="px-3 py-3 text-center border border-slate-200 bg-slate-50 whitespace-nowrap">
                                        <span class="text-[#E8734A] font-semibold text-xs">
                                            {{ $jam->jam_mulai }} - {{ $jam->jam_selesai }}
                                        </span>
                                    </td>

                                    {{-- Kolom per Hari --}}
                                    @foreach ($hariList as $hari)
                                        <td class="px-2 py-2 border border-slate-200 align-top">
                                            @php
                                                $cellJadwals = $grid[$jam->id][$hari] ?? collect();
                                            @endphp

                                            @if ($cellJadwals->isEmpty())
                                                {{-- Cell kosong: tampilkan tombol + --}}
                                                <div class="flex justify-center items-center min-h-[60px]">
                                                    <button type="button"
                                                            onclick="openModalCreate('{{ $hari }}', '{{ $jam->id }}')"
                                                            class="w-7 h-7 rounded-full bg-[#E8734A] hover:bg-[#d4623b] text-white flex items-center justify-center shadow transition">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                {{-- Cell sudah ada isi: tampilkan jadwal saja, tanpa tombol + --}}
                                                <div class="space-y-1.5">
                                                    @foreach ($cellJadwals as $jadwal)
                                                        <div class="bg-slate-50 rounded-md border border-slate-200 px-2 py-1.5">
                                                            <p class="font-semibold text-slate-800 text-xs leading-snug">
                                                                {{ $jadwal->nama_display }}
                                                            </p>
                                                            @if($jadwal->nama_guru)
                                                                <p class="text-slate-400 text-[11px] mt-0.5">
                                                                    {{ $jadwal->nama_guru }}
                                                                </p>
                                                            @endif
                                                            <div class="flex gap-2 mt-1.5">
                                                                {{-- Tombol Edit --}}
                                                                <button type="button"
                                                                        onclick="openModalEdit(
                                                                            {{ $jadwal->id }},
                                                                            '{{ $jadwal->hari }}',
                                                                            {{ $jadwal->id_jam }},
                                                                            {{ $jadwal->id_kelas }},
                                                                            {{ $jadwal->id_guru_mapel ?? 'null' }},
                                                                            {{ $jadwal->id_mapel ?? 'null' }},
                                                                            '{{ addslashes($jadwal->nama_kegiatan ?? '') }}'
                                                                        )"
                                                                        class="text-slate-400 hover:text-amber-500 transition">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                </button>
                                                                {{-- Tombol Hapus --}}
                                                                <form action="{{ route('jadwalbelajar.destroy', $jadwal) }}"
                                                                      method="POST"
                                                                      onsubmit="return confirm('Hapus jadwal ini?')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-slate-400 hover:text-red-500 transition">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

    {{-- Modals --}}
    @include('jadwalbelajar.modal-create')
    @include('jadwalbelajar.modal-edit')

    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit   = document.getElementById('modalEdit');

        function openModalCreate(hari, idJam) {
            document.getElementById('createHari').value        = hari;
            document.getElementById('createIdJam').value       = idJam;
            document.getElementById('createHariDisplay').value = hari;

            const jamMap = {
                @foreach($jamList as $jam)
                    "{{ $jam->id }}": "{{ $jam->jam_mulai }} – {{ $jam->jam_selesai }}",
                @endforeach
            };
            document.getElementById('createJamDisplay').value = jamMap[idJam] ?? idJam;

            // Set kelas dari filter aktif
            const idKelasFilter = "{{ $idKelas ?? '' }}";
            if (idKelasFilter && document.getElementById('createIdKelas')) {
                document.getElementById('createIdKelas').value = idKelasFilter;
            }

            // Reset guru & mapel saat modal dibuka ulang
            if (typeof syncMapelFromGuru === 'function') {
                document.getElementById('createIdGuruMapel').value = '';
                syncMapelFromGuru();
            }

            modalCreate.style.display = 'block';
        }

        function openModalEdit(id, hari, idJam, idKelas, idGuruMapel, idMapel, namaKegiatan) {
            document.getElementById('editHari').value         = hari;
            document.getElementById('editIdJam').value        = idJam;
            document.getElementById('editIdKelas').value      = idKelas;
            document.getElementById('editNamaKegiatan').value = namaKegiatan;
            document.getElementById('formEdit').action        = `/jadwalbelajar/${id}`;

            // Set guru dulu, lalu sync agar mapel ikut terkunci bila perlu
            document.getElementById('editIdGuruMapel').value = idGuruMapel ?? '';
            if (typeof syncMapelFromGuruEdit === 'function') {
                syncMapelFromGuruEdit();
            }

            // Jika mapel tidak di-lock oleh guru, isi manual
            const mapelSelect = document.getElementById('editIdMapel');
            if (!mapelSelect.disabled) {
                mapelSelect.value = idMapel ?? '';
            }

            modalEdit.style.display = 'block';
        }

        // Tutup modal
        ['closeCreate', 'cancelCreate', 'overlayCreate'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', () => modalCreate.style.display = 'none');
        });
        ['closeEdit', 'cancelEdit', 'overlayEdit'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', () => modalEdit.style.display = 'none');
        });

        // Buka modal create otomatis jika ada error validasi
        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif

        // Filter kelas berdasarkan tingkat
        const filterTingkat = document.getElementById('filterTingkat');
        const filterKelas   = document.getElementById('filterKelas');

        function filterKelasByTingkat(selectedTingkat) {
            filterKelas.querySelectorAll('option').forEach(opt => {
                if (!opt.value) return;
                const match = !selectedTingkat || opt.dataset.tingkat == selectedTingkat;
                opt.style.display = match ? '' : 'none';
                if (!match && opt.selected) filterKelas.value = '';
            });
        }

        filterKelasByTingkat(filterTingkat.value);

        filterTingkat.addEventListener('change', function () {
            filterKelas.value = '';
            filterKelasByTingkat(this.value);
        });
    </script>

</x-app-layout>