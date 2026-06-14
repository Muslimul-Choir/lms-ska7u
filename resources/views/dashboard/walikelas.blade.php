@php
    $kelas            = $waliKelasData['kelas'] ?? null;
    $summary          = $waliKelasData['summary'] ?? [];
    $mapelData        = $waliKelasData['mapel_data'] ?? [];
    $siswaList        = $waliKelasData['siswa_list'] ?? collect();
    $pengumpulanMap   = $waliKelasData['pengumpulan_by_tugas_siswa'] ?? collect();
    $hasilMap         = $waliKelasData['hasil_by_kuis_siswa'] ?? collect();
    $absensiMap       = $waliKelasData['absensi_map'] ?? collect();
    $pertemuanAbsensi = $waliKelasData['pertemuan_absensi'] ?? collect();
@endphp

<div class="space-y-5" x-data="{
    activeMapel: {{ !empty($mapelData) ? $mapelData[0]['id_mapel'] : 'null' }},
    activePertemuanMap: {
        @foreach ($mapelData as $mp)
            {{ $mp['id_mapel'] }}: {{ !empty($mp['pertemuan']) ? $mp['pertemuan'][0]['id'] ?? 'null' : 'null' }}, @endforeach
    },
    getActivePertemuan(mapelId) {
        return this.activePertemuanMap[mapelId] ?? null;
    },
    setPertemuan(mapelId, pertemuanId) {
        this.activePertemuanMap[mapelId] = pertemuanId;
    }
}">

    {{-- ── Greeting ── --}}
    {{-- <div class="bg-gradient-to-r from-[#5c1020] to-[#7a1a2e] rounded-xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
            <span class="text-lg font-bold text-white font-heading">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-white font-semibold text-sm font-heading">{{ auth()->user()->name }}</p>
            <p class="text-[#fde68a] text-xs mt-0.5">Wali Kelas</p>
        </div>
        @if ($waliKelasData)
            <div class="hidden sm:block text-right flex-shrink-0">
                <p class="text-[#fde68a] text-[11px] uppercase tracking-widest font-semibold">Kelas</p>
                <p class="text-white font-bold text-sm font-heading">{{ $kelas->nama_kelas }}</p>
            </div>
        @endif
    </div> --}}

    @if ($waliKelasData)

        {{-- ── Ringkasan ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600 leading-tight">{{ $summary['total_siswa'] }}</p>
                <p class="text-[10px] text-amber-500 font-semibold uppercase tracking-widest mt-1">Siswa</p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-600 leading-tight">{{ $summary['total_mapel'] }}</p>
                <p class="text-[10px] text-blue-500 font-semibold uppercase tracking-widest mt-1">Mapel</p>
            </div>
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600 leading-tight">{{ $summary['total_tugas'] }}</p>
                <p class="text-[10px] text-emerald-500 font-semibold uppercase tracking-widest mt-1">Tugas</p>
            </div>
            <div class="bg-violet-50 border border-violet-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-violet-600 leading-tight">{{ $summary['total_kuis'] }}</p>
                <p class="text-[10px] text-violet-500 font-semibold uppercase tracking-widest mt-1">Kuis</p>
            </div>
        </div>

        {{-- ── Monitoring Absensi ── --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div>
                    <h3 class="font-semibold text-sm text-[#0F2145]">Monitoring Absensi</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Rekap kehadiran seluruh siswa per pertemuan</p>
                </div>
            </div>

            @if ($pertemuanAbsensi->isEmpty())
                <div class="p-10 text-center">
                    <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs text-slate-400">Belum ada pertemuan tercatat</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-slate-50">
                                <th
                                    class="sticky left-0 z-10 bg-slate-50 text-left px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] w-8 border-b border-r border-slate-200">
                                    No
                                </th>
                                <th
                                    class="sticky left-8 z-10 bg-slate-50 text-left px-4 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[160px] border-b border-r border-slate-200">
                                    Nama Siswa
                                </th>
                                @foreach ($pertemuanAbsensi as $pt)
                                    <th
                                        class="text-center px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[90px] border-b border-slate-200">
                                        <div>P{{ $pt->nomor_pertemuan }}</div>
                                        @if ($pt->tanggal)
                                            <div
                                                class="text-[9px] text-slate-400 font-normal normal-case tracking-normal mt-0.5">
                                                {{ \Carbon\Carbon::parse($pt->tanggal)->format('d/m') }}
                                            </div>
                                        @endif
                                    </th>
                                @endforeach
                                <th
                                    class="text-center px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[80px] border-b border-slate-200">
                                    Rekap
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($siswaList as $i => $siswa)
                                @php
                                    $totalHadir = 0;
                                    $totalIzin = 0;
                                    $totalSakit = 0;
                                    $totalAlpha = 0;
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td
                                        class="sticky left-0 z-10 bg-white px-3 py-3 text-slate-400 font-medium border-r border-slate-100">
                                        {{ $i + 1 }}
                                    </td>
                                    <td
                                        class="sticky left-8 z-10 bg-white px-4 py-3 font-semibold text-[#0F2145] whitespace-nowrap border-r border-slate-100">
                                        {{ $siswa->nama_lengkap }}
                                    </td>
                                    @foreach ($pertemuanAbsensi as $pt)
                                        @php
                                            $key = $pt->id . '_' . $siswa->id;
                                            $absen = $absensiMap->get($key)?->first();
                                            $status = $absen?->status ?? null;
                                            if ($status === 'hadir') {
                                                $totalHadir++;
                                            } elseif ($status === 'izin') {
                                                $totalIzin++;
                                            } elseif ($status === 'sakit') {
                                                $totalSakit++;
                                            } elseif ($status === 'alpha') {
                                                $totalAlpha++;
                                            }
                                        @endphp
                                        <td class="px-3 py-3 text-center">
                                            @if ($status === 'hadir')
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 font-bold text-[10px]">H</span>
                                            @elseif($status === 'izin')
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-bold text-[10px]">I</span>
                                            @elseif($status === 'sakit')
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-50 border border-amber-200 text-amber-600 font-bold text-[10px]">S</span>
                                            @elseif($status === 'alpha')
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-rose-50 border border-rose-200 text-rose-600 font-bold text-[10px]">A</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 border border-slate-200 text-slate-300 font-bold text-[10px]">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    {{-- Kolom Rekap --}}
                                    <td class="px-3 py-3 text-center">
                                        <div class="flex flex-wrap justify-center gap-0.5">
                                            @if ($totalHadir > 0)
                                                <span
                                                    class="px-1.5 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded text-[9px] font-bold">{{ $totalHadir }}H</span>
                                            @endif
                                            @if ($totalIzin > 0)
                                                <span
                                                    class="px-1.5 py-0.5 bg-blue-50 text-blue-600 border border-blue-200 rounded text-[9px] font-bold">{{ $totalIzin }}I</span>
                                            @endif
                                            @if ($totalSakit > 0)
                                                <span
                                                    class="px-1.5 py-0.5 bg-amber-50 text-amber-600 border border-amber-200 rounded text-[9px] font-bold">{{ $totalSakit }}S</span>
                                            @endif
                                            @if ($totalAlpha > 0)
                                                <span
                                                    class="px-1.5 py-0.5 bg-rose-50 text-rose-600 border border-rose-200 rounded text-[9px] font-bold">{{ $totalAlpha }}A</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Legend --}}
                <div class="flex flex-wrap gap-4 px-5 py-3 border-t border-slate-100">
                    <div class="flex items-center gap-1.5"><span
                            class="w-5 h-5 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-[9px] font-bold text-emerald-600">H</span><span
                            class="text-[10px] text-slate-400">Hadir</span></div>
                    <div class="flex items-center gap-1.5"><span
                            class="w-5 h-5 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center text-[9px] font-bold text-blue-600">I</span><span
                            class="text-[10px] text-slate-400">Izin</span></div>
                    <div class="flex items-center gap-1.5"><span
                            class="w-5 h-5 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-[9px] font-bold text-amber-600">S</span><span
                            class="text-[10px] text-slate-400">Sakit</span></div>
                    <div class="flex items-center gap-1.5"><span
                            class="w-5 h-5 rounded-full bg-rose-50 border border-rose-200 flex items-center justify-center text-[9px] font-bold text-rose-600">A</span><span
                            class="text-[10px] text-slate-400">Alpha</span></div>
                    <div class="flex items-center gap-1.5"><span
                            class="w-5 h-5 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-[9px] font-bold text-slate-300">—</span><span
                            class="text-[10px] text-slate-400">Belum dicatat</span></div>
                </div>
            @endif

        </div>

        {{-- ── Panel Monitoring ── --}}
        @if (!empty($mapelData))
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                    <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <div>
                        <h3 class="font-semibold text-sm text-[#0F2145]">Monitoring Tugas & Kuis</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Pilih mapel lalu pertemuan untuk melihat rekap</p>
                    </div>
                </div>

                {{-- ── Level 1: Tab Mapel ── --}}
                <div class="flex flex-wrap gap-2 px-5 py-3 border-b border-slate-100 bg-slate-50">
                    @foreach ($mapelData as $mp)
                        <button @click="activeMapel = {{ $mp['id_mapel'] }}"
                            :class="activeMapel === {{ $mp['id_mapel'] }} ?
                                'bg-[#5c1020] text-white border-[#5c1020]' :
                                'bg-white text-slate-600 border-slate-200 hover:border-amber-400 hover:text-amber-600'"
                            class="px-4 py-2 rounded-lg text-xs font-semibold border transition-all duration-150 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                                :class="activeMapel === {{ $mp['id_mapel'] }} ? 'bg-amber-400' : 'bg-slate-300'"></span>
                            {{ $mp['nama_mapel'] }}
                        </button>
                    @endforeach
                </div>

                {{-- ── Konten per Mapel ── --}}
                @foreach ($mapelData as $mp)
                    <div x-show="activeMapel === {{ $mp['id_mapel'] }}" x-cloak>

                        {{-- Info pengajar + Level 2: Tab Pertemuan --}}
                        <div class="px-5 py-3 border-b border-slate-100 space-y-3">
                            <p class="text-[11px] text-slate-400">
                                Pengajar: <span class="font-semibold text-slate-600">{{ $mp['guru_nama'] }}</span>
                            </p>

                            {{-- Tab Pertemuan --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach ($mp['pertemuan'] as $pt)
                                    <button @click="setPertemuan({{ $mp['id_mapel'] }}, {{ $pt['id'] ?? 'null' }})"
                                        :class="getActivePertemuan({{ $mp['id_mapel'] }}) === {{ $pt['id'] ?? 'null' }} ?
                                            'bg-[#1B3A6B] text-white border-[#1B3A6B]' :
                                            'bg-white text-slate-600 border-slate-200 hover:border-blue-400 hover:text-blue-600'"
                                        class="px-3 py-1.5 rounded-lg text-[11px] font-semibold border transition-all duration-150 flex items-center gap-1.5">
                                        {{ $pt['nama_pertemuan'] }}
                                        @if ($pt['ada_konten'])
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- ── Konten per Pertemuan ── --}}
                        @foreach ($mp['pertemuan'] as $pt)
                            <div x-show="getActivePertemuan({{ $mp['id_mapel'] }}) === {{ $pt['id'] ?? 'null' }}"
                                x-cloak class="p-5 space-y-6">

                                @if (!$pt['ada_konten'])
                                    {{-- Kosong --}}
                                    <div class="rounded-lg border border-dashed border-slate-200 py-10 text-center">
                                        <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <p class="text-sm font-medium text-slate-400">Tidak ada tugas/kuis di pertemuan
                                            ini</p>
                                    </div>
                                @else
                                    {{-- ── TABEL TUGAS ── --}}
                                    @if ($pt['tugas']->isNotEmpty())
                                        <div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                                <h4 class="text-xs font-bold text-slate-600 uppercase tracking-wide">
                                                    Rekap Tugas</h4>
                                                <span
                                                    class="text-[10px] px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200 font-semibold">
                                                    {{ $pt['tugas']->count() }} tugas
                                                </span>
                                            </div>

                                            <div class="overflow-x-auto rounded-lg border border-slate-200">
                                                <table class="w-full text-xs border-separate border-spacing-0">
                                                    <thead>
                                                        <tr class="bg-slate-50">
                                                            {{-- Sticky: No --}}
                                                            <th
                                                                class="sticky left-0 z-10 bg-slate-50 text-left px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] w-8 border-b border-r border-slate-200">
                                                                No
                                                            </th>
                                                            {{-- Sticky: Nama --}}
                                                            <th
                                                                class="sticky left-8 z-10 bg-slate-50 text-left px-4 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[160px] border-b border-r border-slate-200">
                                                                Nama Siswa
                                                            </th>
                                                            {{-- Kolom tugas (scrollable) --}}
                                                            @foreach ($pt['tugas'] as $tugas)
                                                                <th
                                                                    class="text-center px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[130px] border-b border-slate-200">
                                                                    <div class="truncate max-w-[120px] mx-auto"
                                                                        title="{{ $tugas->judul }}">
                                                                        {{ Str::limit($tugas->judul, 16) }}
                                                                    </div>
                                                                    <div
                                                                        class="text-[9px] text-slate-400 font-normal normal-case tracking-normal mt-0.5">
                                                                        Maks: {{ $tugas->nilai_maksimal ?? 100 }}
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach ($siswaList as $i => $siswa)
                                                            <tr class="hover:bg-slate-50 transition-colors">
                                                                {{-- Sticky: No --}}
                                                                <td
                                                                    class="sticky left-0 z-10 bg-white px-3 py-3 text-slate-400 font-medium border-r border-slate-100 hover:bg-slate-50">
                                                                    {{ $i + 1 }}
                                                                </td>
                                                                {{-- Sticky: Nama --}}
                                                                <td
                                                                    class="sticky left-8 z-10 bg-white px-4 py-3 font-semibold text-[#0F2145] whitespace-nowrap border-r border-slate-100 hover:bg-slate-50">
                                                                    {{ $siswa->nama_lengkap }}
                                                                </td>
                                                                {{-- Nilai per tugas --}}
                                                                @foreach ($pt['tugas'] as $tugas)
                                                                    @php
                                                                        $key = $tugas->id . '_' . $siswa->id;
                                                                        $pengumpulan = $pengumpulanMap->get($key);
                                                                        $nilai =
                                                                            $pengumpulan?->first()?->Penilaian
                                                                                ?->nilai ?? null;
                                                                    @endphp
                                                                    <td class="px-3 py-3 text-center">
                                                                        @if ($pengumpulan)
                                                                            @if ($nilai !== null)
                                                                                <span
                                                                                    class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold
                                                                    {{ $nilai >= 75 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-rose-50 text-rose-600 border border-rose-200' }}">
                                                                                    {{ $nilai }}
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-500 border border-blue-200">
                                                                                    Dikumpul
                                                                                </span>
                                                                            @endif
                                                                        @else
                                                                            <span
                                                                                class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                                                                Belum
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Legend --}}
                                            <div class="flex flex-wrap gap-3 mt-2">
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-emerald-500"></span><span
                                                        class="text-[10px] text-slate-400">Nilai ≥ 75</span></div>
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-rose-500"></span><span
                                                        class="text-[10px] text-slate-400">Nilai &lt; 75</span></div>
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-blue-500"></span><span
                                                        class="text-[10px] text-slate-400">Dikumpul, belum
                                                        dinilai</span></div>
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-slate-300"></span><span
                                                        class="text-[10px] text-slate-400">Belum dikumpul</span></div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- ── TABEL KUIS ── --}}
                                    @if ($pt['kuis']->isNotEmpty())
                                        <div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <svg class="w-4 h-4 text-violet-500 flex-shrink-0" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                                <h4 class="text-xs font-bold text-slate-600 uppercase tracking-wide">
                                                    Rekap Kuis</h4>
                                                <span
                                                    class="text-[10px] px-2 py-0.5 bg-violet-50 text-violet-600 rounded-full border border-violet-200 font-semibold">
                                                    {{ $pt['kuis']->count() }} kuis
                                                </span>
                                            </div>

                                            <div class="overflow-x-auto rounded-lg border border-slate-200">
                                                <table class="w-full text-xs border-separate border-spacing-0">
                                                    <thead>
                                                        <tr class="bg-slate-50">
                                                            <th
                                                                class="sticky left-0 z-10 bg-slate-50 text-left px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] w-8 border-b border-r border-slate-200">
                                                                No
                                                            </th>
                                                            <th
                                                                class="sticky left-8 z-10 bg-slate-50 text-left px-4 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[160px] border-b border-r border-slate-200">
                                                                Nama Siswa
                                                            </th>
                                                            @foreach ($pt['kuis'] as $kuis)
                                                                <th
                                                                    class="text-center px-3 py-3 font-semibold text-slate-500 uppercase tracking-wide text-[10px] min-w-[130px] border-b border-slate-200">
                                                                    <div class="truncate max-w-[120px] mx-auto"
                                                                        title="{{ $kuis->judul }}">
                                                                        {{ Str::limit($kuis->judul, 16) }}
                                                                    </div>
                                                                    <div
                                                                        class="text-[9px] text-slate-400 font-normal normal-case tracking-normal mt-0.5">
                                                                        Maks: {{ $kuis->nilai_maksimal ?? 100 }}
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100">
                                                        @foreach ($siswaList as $i => $siswa)
                                                            <tr class="hover:bg-slate-50 transition-colors">
                                                                <td
                                                                    class="sticky left-0 z-10 bg-white px-3 py-3 text-slate-400 font-medium border-r border-slate-100">
                                                                    {{ $i + 1 }}
                                                                </td>
                                                                <td
                                                                    class="sticky left-8 z-10 bg-white px-4 py-3 font-semibold text-[#0F2145] whitespace-nowrap border-r border-slate-100">
                                                                    {{ $siswa->nama_lengkap }}
                                                                </td>
                                                                @foreach ($pt['kuis'] as $kuis)
                                                                    @php
                                                                        $key = $kuis->id . '_' . $siswa->id;
                                                                        $hasil = $hasilMap->get($key)?->first();
                                                                    @endphp
                                                                    <td class="px-3 py-3 text-center">
                                                                        @if ($hasil)
                                                                            <span
                                                                                class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold
                                                                {{ $hasil->nilai >= 75 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-rose-50 text-rose-600 border border-rose-200' }}">
                                                                                {{ $hasil->nilai }}
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                                                                Belum
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Legend --}}
                                            <div class="flex flex-wrap gap-3 mt-2">
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-emerald-500"></span><span
                                                        class="text-[10px] text-slate-400">Nilai ≥ 75</span></div>
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-rose-500"></span><span
                                                        class="text-[10px] text-slate-400">Nilai &lt; 75</span></div>
                                                <div class="flex items-center gap-1.5"><span
                                                        class="w-2 h-2 rounded-full bg-slate-300"></span><span
                                                        class="text-[10px] text-slate-400">Belum mengerjakan</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endforeach

            </div>
        @else
            <div class="bg-white rounded-xl border border-dashed border-slate-200 p-10 text-center">
                <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="text-sm font-medium text-slate-400">Belum ada data mapel untuk kelas ini</p>
            </div>
        @endif
        
    @else
        <div class="bg-white rounded-xl border border-dashed border-amber-200 p-10 text-center">
            <svg class="w-10 h-10 text-amber-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <p class="text-sm font-medium text-slate-500">Anda belum ditugaskan sebagai wali kelas</p>
            <p class="text-xs text-slate-400 mt-1">Hubungi admin untuk mengatur penugasan kelas</p>
        </div>
    @endif

</div>
