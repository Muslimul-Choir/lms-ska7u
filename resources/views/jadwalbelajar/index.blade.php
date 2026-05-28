<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">Jadwal Belajar</h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">Data Master</p>
            </div>
        </div>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-gray-400 font-medium">
                <a href="#" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
                <span class="text-gray-300">/</span>
                <span>Master Data</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600 font-semibold">Jadwal Belajar</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                            Filter Jadwal
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 ml-3">Pilih tingkat dan kelas untuk menampilkan jadwal</p>
                    </div>
                    @if($isAdmin)
                    <div class="flex items-center gap-2">
                        <a href="{{ route('jadwalbelajar.trash') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Tempat Sampah
                        </a>
                        <button onclick="window.print()"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                    </div>
                    @else
                    <div class="flex items-center gap-2">
                        <button onclick="window.print()"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                        <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-50 text-blue-600 text-xs font-semibold rounded-xl border border-blue-200">
                            👁️ Mode Lihat Saja
                        </span>
                    </div>
                    @endif
                </div>

                <form method="GET" action="{{ route('jadwalbelajar.index') }}"
                      class="flex flex-wrap items-center gap-2">

                    {{-- Filter Tingkat --}}
                    <div class="relative">
                        <select name="tingkat" id="filterTingkat"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer">
                            <option value="">Semua Tingkat</option>
                            @foreach ($tingkatanList as $tkt)
                                <option value="{{ $tkt->id }}" {{ $tingkat == $tkt->id ? 'selected' : '' }}>
                                    {{ $tkt->nama_tingkatan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="relative">
                        <select name="id_kelas" id="filterKelas"
                                class="appearance-none pl-3 pr-8 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition cursor-pointer"
                                @if($isGuru && $kelasList->isEmpty()) disabled @endif>
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
                        <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari Jadwal
                    </button>

                    @if($idKelas || $tingkat)
                        <a href="{{ route('jadwalbelajar.index') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl border border-gray-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- GRID JADWAL --}}
            @if ($isGuru && $kelasList->isEmpty())
                {{-- Guru belum diassign ke mapel apapun --}}
                <div class="bg-white rounded-2xl border border-blue-200 shadow-sm px-6 py-20 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-blue-600 text-sm font-semibold">Belum Ada Kelas yang Ditugaskan</p>
                        <p class="text-blue-400 text-xs max-w-xs">Anda belum diassign ke mapel apapun. Hubungi administrator untuk diassign mengajar di kelas-kelas tertentu.</p>
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-left text-xs text-blue-700">
                            <p class="font-semibold mb-1">📋 Langkah untuk administrator:</p>
                            <p>Buka menu <strong>Guru Mapel</strong>, lalu tambahkan guru ini dengan memilih:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Guru: Nama guru ini</li>
                                <li>Mapel: Mata pelajaran yang akan diajarkan</li>
                                <li>Kelas: Kelas yang akan diajarkan</li>
                                <li>Semester: Semester yang berlaku</li>
                            </ul>
                        </div>
                    </div>
                </div>

            @elseif (!$idKelas && !$tingkat && !$isGuru)
                {{-- Belum ada filter (hanya tampilkan ke admin yang belum filter) --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-20 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm font-semibold">Pilih Tingkat atau Kelas</p>
                        <p class="text-gray-300 text-xs">Silakan pilih tingkat atau kelas terlebih dahulu untuk menampilkan jadwal belajar.</p>
                        <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-left text-xs text-amber-700 max-w-sm">
                            <p class="font-semibold mb-2">📚 Setup Jadwal Belajar untuk Guru Baru:</p>
                            <ol class="list-decimal list-inside space-y-1">
                                <li><strong>Guru Mapel</strong> - Assign guru ke mapel dan kelas (menentukan apa+siapa+di mana)</li>
                                <li><strong>Jadwal Belajar</strong> - Tentukan hari, jam, dan alokasi guru untuk setiap kelas (di sini)</li>
                            </ol>
                        </div>
                    </div>
                </div>

            @else
                {{-- Jadwal Grid Card --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                    {{-- Card Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                                <span class="w-1 h-5 rounded-full bg-amber-500 inline-block"></span>
                                Jadwal Mingguan
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5 ml-3">Klik <span class="font-semibold text-amber-500">+</span> pada sel kosong untuk menambah jadwal</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-4 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest border-r border-gray-200 w-32 whitespace-nowrap">
                                        Jam
                                    </th>
                                    @foreach ($hariList as $hari)
                                        <th class="px-4 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-widest border-r border-gray-200 min-w-[150px]">
                                            {{ $hari }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jamList as $jam)
                                    <tr class="border-b border-gray-100 hover:bg-amber-50/20 transition">

                                        {{-- Kolom Jam --}}
                                        <td class="px-3 py-3 text-center border-r border-gray-200 bg-gray-50 whitespace-nowrap align-middle">
                                            <div class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $jam->jam_mulai }} – {{ $jam->jam_selesai }}
                                            </div>
                                        </td>

                                        {{-- Kolom per Hari --}}
                                        @foreach ($hariList as $hari)
                                            <td class="px-2 py-2 border-r border-gray-100 align-top">
                                                @php
                                                    $cellJadwals = $grid[$jam->id][$hari] ?? collect();
                                                @endphp

                                                @if ($cellJadwals->isEmpty())
                                                    <div class="flex justify-center items-center min-h-[80px]">
                                                        @if($isAdmin)
                                                        {{-- Admin: tombol tambah --}}
                                                        <button type="button"
                                                                onclick="openModalCreate('{{ $hari }}', '{{ $jam->id }}')"
                                                                class="w-8 h-8 rounded-full bg-amber-500 hover:bg-amber-600 text-white flex items-center justify-center shadow-sm transition">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                        @else
                                                        {{-- Guru: sel kosong --}}
                                                        <span class="text-gray-200 text-xs">—</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="space-y-2 py-1">
                                                        @foreach ($cellJadwals as $jadwal)
                                                            <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2.5">
                                                                <p class="font-bold text-gray-800 text-xs leading-tight">
                                                                    {{ $jadwal->nama_display }}
                                                                </p>
                                                                @if($jadwal->nama_guru)
                                                                    <p class="text-gray-500 text-[10px] mt-1 flex items-center gap-1">
                                                                        <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                        </svg>
                                                                        {{ $jadwal->nama_guru }}
                                                                    </p>
                                                                @endif
                                                                @if($isAdmin)
                                                                {{-- Admin: tombol edit & hapus --}}
                                                                <div class="flex items-center gap-1.5 mt-2">
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
                                                                            class="w-6 h-6 flex items-center justify-center bg-white hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                                                            title="Edit">
                                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                        </svg>
                                                                    </button>
                                                                    <form action="{{ route('jadwalbelajar.destroy', $jadwal) }}"
                                                                          method="POST"
                                                                          onsubmit="return confirm('Hapus jadwal ini?')">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit"
                                                                                class="w-6 h-6 flex items-center justify-center bg-white hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition"
                                                                                title="Hapus">
                                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                            </svg>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @endif
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
                </div>

                @if($jadwals->isEmpty() && ($idKelas || $tingkat))
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl px-6 py-4 mt-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-blue-900 text-sm font-semibold">Belum ada jadwal belajar di kelas ini</p>
                                <p class="text-blue-700 text-xs mt-1">Klik tombol <strong>+</strong> pada sel kosong di atas untuk menambah jadwal belajar pertama.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <style>
                    @media print {
                        .bg-amber-50 { background-color: #fffbeb !important; }
                        table { border: 1px solid #d1d5db; }
                        th, td { border: 1px solid #d1d5db; }
                    }
                </style>
            @endif

        </div>
    </div>

    @if($isAdmin)
    @include('jadwalbelajar.modal-create')
    @include('jadwalbelajar.modal-edit')
    @endif

    <script>
        @if($isAdmin)
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

            const idKelasFilter = "{{ $idKelas ?? '' }}";
            if (idKelasFilter && document.getElementById('createIdKelas')) {
                document.getElementById('createIdKelas').value = idKelasFilter;
            }

            if (typeof syncMapelFromGuru === 'function') {
                document.getElementById('createIdGuruMapel').value = '';
                syncMapelFromGuru();
            }

            modalCreate.style.display = 'flex';
        }

        function openModalEdit(id, hari, idJam, idKelas, idGuruMapel, idMapel, namaKegiatan) {
            document.getElementById('editHari').value         = hari;
            document.getElementById('editIdJam').value        = idJam;
            document.getElementById('editIdKelas').value      = idKelas;
            document.getElementById('editNamaKegiatan').value = namaKegiatan;
            document.getElementById('formEdit').action        = `/jadwalbelajar/${id}`;

            document.getElementById('editIdGuruMapel').value = idGuruMapel ?? '';
            if (typeof syncMapelFromGuruEdit === 'function') {
                syncMapelFromGuruEdit();
            }

            const mapelSelect = document.getElementById('editIdMapel');
            if (!mapelSelect.disabled) {
                mapelSelect.value = idMapel ?? '';
            }

            modalEdit.style.display = 'flex';
        }

        ['closeCreate', 'cancelCreate', 'overlayCreate'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', () => modalCreate.style.display = 'none');
        });
        ['closeEdit', 'cancelEdit', 'overlayEdit'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', () => modalEdit.style.display = 'none');
        });

        @if ($errors->any())
            modalCreate.style.display = 'flex';
        @endif
        @endif

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