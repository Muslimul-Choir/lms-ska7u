<div class="space-y-5">

    {{-- ── Top Summary Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Pengguna</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $counts['users'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Guru & Siswa</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $metrics['total_civitas'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Kelas</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $counts['kelas'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Total Mapel</p>
                <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $counts['mapel'] }}</p>
            </div>
        </div>

    </div>

    {{-- ── Charts Row ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div>
                    <h3 class="font-semibold text-sm text-[#0F2145]">Komposisi Civitas</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Proporsi pengguna sistem</p>
                </div>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="civitasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
                <div>
                    <h3 class="font-semibold text-sm text-[#0F2145]">Struktur Akademik</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Distribusi data struktur sekolah</p>
                </div>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="strukturChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Detail Statistics ── --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
            <span class="w-1 h-5 rounded-full bg-amber-500 flex-shrink-0"></span>
            <div>
                <h3 class="font-semibold text-sm text-[#0F2145]">Rekap Data Operasional</h3>
                <p class="text-xs text-slate-400 mt-0.5">Ringkasan seluruh data sistem</p>
            </div>
        </div>
        <div class="p-6 space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                @php
                    $groups = [
                        [
                            'label' => 'Pengguna Sistem',
                            'dot'   => 'bg-amber-400',
                            'rows'  => [
                                ['Total Pengguna', $counts['users']],
                                ['Guru',           $counts['guru']],
                                ['Siswa',          $counts['siswa']],
                            ]
                        ],
                        [
                            'label' => 'Struktur Sekolah',
                            'dot'   => 'bg-blue-500',
                            'rows'  => [
                                ['Jurusan',   $counts['jurusan']],
                                ['Tingkatan', $counts['tingkatan']],
                                ['Bagian',    $counts['bagian']],
                            ]
                        ],
                        [
                            'label' => 'Kelas & Pengajaran',
                            'dot'   => 'bg-violet-500',
                            'rows'  => [
                                ['Kelas',      $counts['kelas']],
                                ['Mapel',      $counts['mapel']],
                                ['Guru Mapel', $counts['guru_mapel']],
                            ]
                        ],
                        [
                            'label' => 'Waktu',
                            'dot'   => 'bg-emerald-500',
                            'rows'  => [
                                ['Tahun Ajaran',   $counts['tahun_ajaran']],
                                ['Jam Belajar',    $counts['jam_belajar']],
                                ['Semester',       $counts['semester']],
                            ]
                        ],
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

            {{-- Metrik ringkasan bawah --}}
            {{-- <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $metrikCards = [
                        ['label' => 'Tahun Ajaran',   'val' => $counts['tahun_ajaran'],   'sub' => 'tahun ajaran terdaftar', 'dot' => 'bg-cyan-400'],
                        ['label' => 'Rasio Kelas',    'val' => $metrics['rasio_kelas'],   'sub' => 'siswa per kelas',        'dot' => 'bg-violet-400'],
                        ['label' => 'Total Record',   'val' => number_format($metrics['total_data']), 'sub' => 'data dalam sistem', 'dot' => 'bg-slate-400'],
                        ['label' => 'Kategori Data',  'val' => $metrics['total_kategori'],'sub' => 'jenis data dikelola',    'dot' => 'bg-amber-400'],
                    ];
                @endphp
                @foreach ($metrikCards as $m)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full {{ $m['dot'] }} flex-shrink-0"></span>
                            <p class="text-[11px] text-slate-500 font-semibold uppercase tracking-wide">{{ $m['label'] }}</p>
                        </div>
                        <p class="text-2xl font-bold text-[#0F2145] leading-tight">{{ $m['val'] }}</p>
                        <p class="text-[11px] text-slate-400 mt-1">{{ $m['sub'] }}</p>
                    </div>
                @endforeach
            </div> --}}

        </div>
    </div>

</div>

{{-- Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const font = { family: "'Lato', system-ui, sans-serif" };

        new Chart(document.getElementById('civitasChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pengguna (non-guru/siswa)', 'Guru', 'Siswa'],
                datasets: [{
                    data: [
                        {{ max($counts['users'] - $counts['guru'], 0) }},
                        {{ $counts['guru'] }},
                        {{ $counts['siswa'] }}
                    ],
                    backgroundColor: ['#f59e0b', '#1B3A6B', '#1D9E75'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6
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

        new Chart(document.getElementById('strukturChart'), {
            type: 'bar',
            data: {
                labels: ['Jurusan', 'Tingkatan', 'Kelas', 'Mapel', 'Guru Mapel', 'Jadwal'],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $counts['jurusan'] }},
                        {{ $counts['tingkatan'] }},
                        {{ $counts['kelas'] }},
                        {{ $counts['mapel'] }},
                        {{ $counts['guru_mapel'] }},
                        {{ $counts['jadwalbelajar'] }}
                    ],
                    backgroundColor: ['#f59e0b','#1B3A6B','#7C3AED','#1D9E75','#0891B2','#DC2626'],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font, color: '#94a3b8', padding: 8 } },
                    x: { grid: { display: false }, ticks: { font, color: '#64748b' } }
                }
            }
        });
    });
</script>