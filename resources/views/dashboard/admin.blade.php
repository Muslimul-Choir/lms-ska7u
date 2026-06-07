<div class="space-y-5">

    {{-- ── Top Summary Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Pengguna</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $counts['users'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Guru & Siswa</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['total_users_and_students'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Kelas & Mapel</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['total_classes_and_subjects'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Aktivitas</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['learning_activities'] }}</p>
            </div>
        </div>

    </div>

    {{-- ── Charts Row ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div>
                    <h3 class="font-semibold text-sm text-[#0F2145]">Distribusi Data Utama</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Proporsi data per kategori</p>
                </div>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="mainDataChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div>
                    <h3 class="font-semibold text-sm text-[#0F2145]">Data Akademik</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Perbandingan aktivitas akademik</p>
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
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Progress & Aktivitas</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tingkat penyelesaian per kategori</p>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-5">
                <div class="space-y-4">
                    @php
                        $left = [
                            ['label' => 'Pengumpulan Tugas', 'val' => $counts['pengumpulan_tugas'], 'max' => max($counts['tugas'], 1),           'color' => '#f59e0b'],
                            ['label' => 'Penilaian Selesai', 'val' => $counts['penilaian'],         'max' => max($counts['pengumpulan_tugas'], 1), 'color' => '#1D9E75'],
                            ['label' => 'Kehadiran Siswa',   'val' => $counts['absensi'],           'max' => max($counts['siswa'] * 10, 1),        'color' => '#7C3AED'],
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
                                     style="width: {{ min(($item['val'] / $item['max']) * 100, 100) }}%; background: {{ $item['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="space-y-4">
                    @php
                        $right = [
                            ['label' => 'Guru Mapel',          'val' => $counts['guru_mapel'],    'max' => max($counts['guru'], 1),  'color' => '#f59e0b'],
                            ['label' => 'Jadwal Belajar',      'val' => $counts['jadwalbelajar'], 'max' => max($counts['kelas'], 1), 'color' => '#DC2626'],
                            ['label' => 'Materi Pembelajaran', 'val' => $counts['materi'],        'max' => max($counts['mapel'], 1), 'color' => '#0891B2'],
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
                                     style="width: {{ min(($item['val'] / $item['max']) * 100, 100) }}%; background: {{ $item['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Detail Statistics ── --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Detail Statistik Lengkap</h3>
                <p class="text-xs text-slate-400 mt-0.5">Semua data per kategori</p>
            </div>
        </div>
        <div class="p-6 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                @php
                    $groups = [
                        ['label' => 'Struktur Akademik', 'dot' => 'bg-[#1B3A6B]', 'rows' => [['Jurusan', $counts['jurusan']], ['Tingkatan', $counts['tingkatan']], ['Kelas', $counts['kelas']]]],
                        ['label' => 'Tenaga Pengajar',   'dot' => 'bg-emerald-500','rows' => [['Guru', $counts['guru']], ['Guru Mapel', $counts['guru_mapel']], ['Mapel', $counts['mapel']]]],
                        ['label' => 'Peserta Didik',     'dot' => 'bg-violet-500', 'rows' => [['Siswa', $counts['siswa']], ['Absensi', $counts['absensi']], ['Rasio Kelas', ($counts['kelas'] > 0 ? round($counts['siswa'] / $counts['kelas']) : 0) . ':1']]],
                        ['label' => 'Aktivitas Belajar', 'dot' => 'bg-amber-500',  'rows' => [['Materi', $counts['materi']], ['Tugas', $counts['tugas']], ['Pengumpulan', $counts['pengumpulan_tugas']]]],
                    ];
                @endphp
                @foreach ($groups as $group)
                    <div class="border border-slate-200 rounded-xl p-4 hover:shadow-sm transition-shadow duration-200">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 rounded-full {{ $group['dot'] }} flex-shrink-0"></span>
                            <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wide">{{ $group['label'] }}</span>
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

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $secondary = [
                        ['label' => 'Manajemen Waktu',   'dot' => 'bg-yellow-400', 'rows' => [['Jam Belajar', $counts['jam_belajar']], ['Pertemuan', $counts['pertemuan']], ['Jadwal Belajar', $counts['jadwalbelajar']]]],
                        ['label' => 'Periode Akademik',  'dot' => 'bg-cyan-400',   'rows' => [['Semester', $counts['semester']], ['Tahun Ajaran', $counts['tahun_ajaran']], ['Bagian', $counts['bagian']]]],
                        ['label' => 'Penilaian',         'dot' => 'bg-rose-400',   'rows' => [['Penilaian', $counts['penilaian']], ['Tugas Selesai', $counts['pengumpulan_tugas']], ['Rasio', ($counts['pengumpulan_tugas'] > 0 ? round(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100) : 0) . '%']]],
                        ['label' => 'Ringkasan Sistem',  'dot' => 'bg-slate-400',  'rows' => [['Total Data', number_format($metrics['total_data'])], ['Kategori', $metrics['total_categories']], ['Status', 'Online']]],
                    ];
                @endphp
                @foreach ($secondary as $sec)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
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

            <div class="border border-slate-200 rounded-xl p-5">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm font-bold text-[#0F2145]">Metrik Lanjutan</p>
                        <p class="text-xs text-slate-400">Analisis performa & rasio sistem</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @php
                        $advanced = [
                            ['label' => 'Rasio Kelas',       'val' => $metrics['class_ratio'],             'sub' => 'siswa per kelas'],
                            ['label' => 'Tingkat Penilaian', 'val' => $metrics['assessment_ratio'] . '%',  'sub' => 'tugas dinilai'],
                            ['label' => 'Total Data',        'val' => number_format($metrics['total_data']),'sub' => 'record dalam sistem'],
                            ['label' => 'Kategori Data',     'val' => $metrics['total_categories'],        'sub' => 'jenis data'],
                        ];
                    @endphp
                    @foreach ($advanced as $adv)
                        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-sm transition-shadow duration-200">
                            <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wide mb-2">{{ $adv['label'] }}</p>
                            <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $adv['val'] }}</p>
                            <p class="text-[11px] text-slate-400 mt-1">{{ $adv['sub'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const font = { family: "'Lato', system-ui, sans-serif" };

        new Chart(document.getElementById('mainDataChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pengguna', 'Guru', 'Siswa', 'Kelas', 'Mapel', 'Materi'],
                datasets: [{ data: [{{ $counts['users'] }}, {{ $counts['guru'] }}, {{ $counts['siswa'] }}, {{ $counts['kelas'] }}, {{ $counts['mapel'] }}, {{ $counts['materi'] }}], backgroundColor: ['#f59e0b','#1B3A6B','#1D9E75','#7C3AED','#0891B2','#DC2626'], borderWidth: 3, borderColor: '#ffffff', hoverOffset: 6 }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font, color: '#64748b', boxHeight: 8 } } } }
        });

        new Chart(document.getElementById('academicChart'), {
            type: 'bar',
            data: {
                labels: ['Tugas', 'Pengumpulan', 'Penilaian', 'Absensi', 'Pertemuan'],
                datasets: [{ label: 'Jumlah', data: [{{ $counts['tugas'] }}, {{ $counts['pengumpulan_tugas'] }}, {{ $counts['penilaian'] }}, {{ $counts['absensi'] }}, {{ $counts['pertemuan'] }}], backgroundColor: ['#f59e0b','#1B3A6B','#1D9E75','#7C3AED','#0891B2'], borderRadius: 6, borderSkipped: false }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font, color: '#94a3b8', padding: 8 } }, x: { grid: { display: false }, ticks: { font, color: '#64748b' } } } }
        });
    });
</script>