<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Dashboard
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Ringkasan Data Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- ── Breadcrumb ── --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Ringkasan</span>
            </nav>

            {{-- ── Top Summary Cards ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Card 1 --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-[#1B3A6B]/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">Total Pengguna</p>
                        <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $counts['users'] }}</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-[#C8992A]/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#C8992A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">Guru & Siswa</p>
                        <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['total_users_and_students'] }}</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.833 5.09 9.292 5 8 5a8 8 0 00-6 2.645M12 6.253C13.167 5.09 14.708 5 16 5a8 8 0 016 2.645"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">Kelas & Mapel</p>
                        <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['total_classes_and_subjects'] }}</p>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">Aktivitas</p>
                        <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['learning_activities'] }}</p>
                    </div>
                </div>

            </div>

            {{-- ── Charts Row ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Pie/Donut Chart --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                        <div>
                            <h3 class="text-white font-semibold text-sm tracking-wide">Distribusi Data Utama</h3>
                            <p class="text-blue-200 text-xs mt-0.5">Proporsi data per kategori</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-64">
                            <canvas id="mainDataChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Bar Chart --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                        <div>
                            <h3 class="text-white font-semibold text-sm tracking-wide">Data Akademik</h3>
                            <p class="text-blue-200 text-xs mt-0.5">Perbandingan aktivitas akademik</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-64">
                            <canvas id="academicChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Progress & Activities ── --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Progress & Aktivitas</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Tingkat penyelesaian per kategori</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-5">

                        {{-- Left --}}
                        <div class="space-y-4">
                            @php
                                $left = [
                                    ['label' => 'Pengumpulan Tugas', 'val' => $counts['pengumpulan_tugas'], 'max' => max($counts['tugas'], 1), 'color' => '#1B3A6B'],
                                    ['label' => 'Penilaian Selesai',  'val' => $counts['penilaian'],         'max' => max($counts['pengumpulan_tugas'], 1), 'color' => '#1D9E75'],
                                    ['label' => 'Kehadiran Siswa',    'val' => $counts['absensi'],           'max' => max($counts['siswa'] * 10, 1),       'color' => '#7C3AED'],
                                ];
                            @endphp
                            @foreach ($left as $item)
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-xs text-slate-500 font-medium">{{ $item['label'] }}</span>
                                        <span class="text-xs font-bold text-[#0F2145]">{{ $item['val'] }}</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-700"
                                             style="width: {{ min(($item['val'] / $item['max']) * 100, 100) }}%; background: {{ $item['color'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Right --}}
                        <div class="space-y-4">
                            @php
                                $right = [
                                    ['label' => 'Guru Mapel',          'val' => $counts['guru_mapel'],     'max' => max($counts['guru'], 1),   'color' => '#C8992A'],
                                    ['label' => 'Jadwal Belajar',      'val' => $counts['jadwal_belajar'], 'max' => max($counts['kelas'], 1),  'color' => '#DC2626'],
                                    ['label' => 'Materi Pembelajaran', 'val' => $counts['materi'],         'max' => max($counts['mapel'], 1),  'color' => '#0891B2'],
                                ];
                            @endphp
                            @foreach ($right as $item)
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-xs text-slate-500 font-medium">{{ $item['label'] }}</span>
                                        <span class="text-xs font-bold text-[#0F2145]">{{ $item['val'] }}</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-700"
                                             style="width: {{ min(($item['val'] / $item['max']) * 100, 100) }}%; background: {{ $item['color'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Detail Statistics ── --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-[#0F2145] to-[#1B3A6B]">
                    <div>
                        <h3 class="text-white font-semibold text-sm tracking-wide">Detail Statistik Lengkap</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Semua data per kategori</p>
                    </div>
                </div>
                <div class="p-6 space-y-6">

                    {{-- Main 4 stat groups --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                        @php
                            $groups = [
                                [
                                    'label' => 'Struktur Akademik',
                                    'accent' => '#1B3A6B',
                                    'bg' => 'bg-blue-50',
                                    'text' => 'text-[#1B3A6B]',
                                    'rows' => [
                                        ['Jurusan',   $counts['jurusan']],
                                        ['Tingkatan', $counts['tingkatan']],
                                        ['Kelas',     $counts['kelas']],
                                    ],
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                                ],
                                [
                                    'label' => 'Tenaga Pengajar',
                                    'accent' => '#1D9E75',
                                    'bg' => 'bg-emerald-50',
                                    'text' => 'text-emerald-700',
                                    'rows' => [
                                        ['Guru',       $counts['guru']],
                                        ['Guru Mapel', $counts['guru_mapel']],
                                        ['Mapel',      $counts['mapel']],
                                    ],
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                                ],
                                [
                                    'label' => 'Peserta Didik',
                                    'accent' => '#7C3AED',
                                    'bg' => 'bg-violet-50',
                                    'text' => 'text-violet-700',
                                    'rows' => [
                                        ['Siswa',       $counts['siswa']],
                                        ['Absensi',     $counts['absensi']],
                                        ['Rasio Kelas', ($counts['kelas'] > 0 ? round($counts['siswa'] / $counts['kelas']) : 0) . ':1'],
                                    ],
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>',
                                ],
                                [
                                    'label' => 'Aktivitas Belajar',
                                    'accent' => '#C8992A',
                                    'bg' => 'bg-amber-50',
                                    'text' => 'text-amber-700',
                                    'rows' => [
                                        ['Materi',      $counts['materi']],
                                        ['Tugas',       $counts['tugas']],
                                        ['Pengumpulan', $counts['pengumpulan_tugas']],
                                    ],
                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                ],
                            ];
                        @endphp

                        @foreach ($groups as $group)
                            <div class="border border-slate-100 rounded-xl p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-8 h-8 rounded-lg {{ $group['bg'] }} flex items-center justify-center">
                                        <svg class="w-4 h-4 {{ $group['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            {!! $group['icon'] !!}
                                        </svg>
                                    </div>
                                    <span class="text-[10px] font-semibold {{ $group['text'] }} {{ $group['bg'] }} px-2 py-1 rounded-md uppercase tracking-wide">
                                        {{ $group['label'] }}
                                    </span>
                                </div>
                                <div class="space-y-2.5">
                                    @foreach ($group['rows'] as [$name, $val])
                                        <div class="flex justify-between items-center border-b border-slate-50 pb-2 last:border-0 last:pb-0">
                                            <span class="text-xs text-slate-500">{{ $name }}</span>
                                            <span class="text-sm font-bold text-[#0F2145]">{{ $val }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Secondary 4 groups --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                        @php
                            $secondary = [
                                [
                                    'label' => 'Manajemen Waktu',
                                    'rows'  => [
                                        ['Jam Belajar',    $counts['jam_belajar']],
                                        ['Pertemuan',      $counts['pertemuan']],
                                        ['Jadwal Belajar', $counts['jadwal_belajar']],
                                    ],
                                    'border' => 'border-yellow-200',
                                    'dot'    => 'bg-yellow-400',
                                ],
                                [
                                    'label' => 'Periode Akademik',
                                    'rows'  => [
                                        ['Semester',      $counts['semester']],
                                        ['Tahun Ajaran',  $counts['tahun_ajaran']],
                                        ['Bagian',        $counts['bagian']],
                                    ],
                                    'border' => 'border-cyan-200',
                                    'dot'    => 'bg-cyan-400',
                                ],
                                [
                                    'label' => 'Penilaian',
                                    'rows'  => [
                                        ['Penilaian',     $counts['penilaian']],
                                        ['Tugas Selesai', $counts['pengumpulan_tugas']],
                                        ['Rasio',         ($counts['pengumpulan_tugas'] > 0 ? round(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100) : 0) . '%'],
                                    ],
                                    'border' => 'border-rose-200',
                                    'dot'    => 'bg-rose-400',
                                ],
                                [
                                    'label' => 'Ringkasan Sistem',
                                    'rows'  => [
                                        ['Total Data',  number_format($metrics['total_data'])],
                                        ['Kategori',    $metrics['total_categories']],
                                        ['Status',      'Online'],
                                    ],
                                    'border' => 'border-slate-200',
                                    'dot'    => 'bg-slate-400',
                                ],
                            ];
                        @endphp

                        @foreach ($secondary as $sec)
                            <div class="bg-slate-50 border {{ $sec['border'] }} rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-2 h-2 rounded-full {{ $sec['dot'] }} flex-shrink-0"></span>
                                    <span class="text-[11px] font-semibold text-slate-600 uppercase tracking-wide">{{ $sec['label'] }}</span>
                                </div>
                                <div class="space-y-2">
                                    @foreach ($sec['rows'] as [$name, $val])
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-slate-500">{{ $name }}</span>
                                            <span class="text-xs font-bold text-[#0F2145]">{{ $val }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Advanced Metrics 4 cards --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-[#1B3A6B]/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#0F2145]">Metrik Lanjutan</p>
                                <p class="text-xs text-slate-400">Analisis performa & rasio sistem</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            @php
                                $advanced = [
                                    ['label' => 'Rasio Kelas',       'val' => $metrics['class_ratio'],      'sub' => 'siswa per kelas',         'color' => 'text-[#1B3A6B]', 'bg' => 'bg-blue-50'],
                                    ['label' => 'Tingkat Penilaian', 'val' => $metrics['assessment_ratio'].'%', 'sub' => 'tugas dinilai',        'color' => 'text-emerald-700','bg' => 'bg-emerald-50'],
                                    ['label' => 'Total Data',        'val' => number_format($metrics['total_data']), 'sub' => 'record dalam sistem', 'color' => 'text-violet-700', 'bg' => 'bg-violet-50'],
                                    ['label' => 'Kategori Data',     'val' => $metrics['total_categories'], 'sub' => 'jenis data',              'color' => 'text-amber-700',  'bg' => 'bg-amber-50'],
                                ];
                            @endphp
                            @foreach ($advanced as $adv)
                                <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs text-slate-500 font-medium">{{ $adv['label'] }}</span>
                                        <span class="w-6 h-6 rounded-md {{ $adv['bg'] }} block"></span>
                                    </div>
                                    <p class="text-2xl font-bold {{ $adv['color'] }} leading-tight">{{ $adv['val'] }}</p>
                                    <p class="text-[11px] text-slate-400 mt-1">{{ $adv['sub'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- ── Chart.js Scripts ── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const font = { family: "'Inter', system-ui, sans-serif" };

            // ── Doughnut Chart ──
            new Chart(document.getElementById('mainDataChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Pengguna', 'Guru', 'Siswa', 'Kelas', 'Mapel', 'Materi'],
                    datasets: [{
                        data: [
                            {{ $counts['users'] }},
                            {{ $counts['guru'] }},
                            {{ $counts['siswa'] }},
                            {{ $counts['kelas'] }},
                            {{ $counts['mapel'] }},
                            {{ $counts['materi'] }}
                        ],
                        backgroundColor: ['#1B3A6B','#C8992A','#1D9E75','#7C3AED','#0891B2','#DC2626'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font, color: '#64748b', boxHeight: 8 }
                        }
                    }
                }
            });

            // ── Bar Chart ──
            new Chart(document.getElementById('academicChart'), {
                type: 'bar',
                data: {
                    labels: ['Tugas', 'Pengumpulan', 'Penilaian', 'Absensi', 'Pertemuan'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [
                            {{ $counts['tugas'] }},
                            {{ $counts['pengumpulan_tugas'] }},
                            {{ $counts['penilaian'] }},
                            {{ $counts['absensi'] }},
                            {{ $counts['pertemuan'] }}
                        ],
                        backgroundColor: ['#1B3A6B','#C8992A','#1D9E75','#7C3AED','#0891B2'],
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { font, color: '#94a3b8', padding: 8 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font, color: '#64748b' }
                        }
                    }
                }
            });

        });
    </script>

</x-app-layout>