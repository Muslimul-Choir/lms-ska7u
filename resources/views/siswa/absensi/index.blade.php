<x-student-layout>
<x-slot name="heading">Statistik Kehadiran</x-slot>

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Hero banner --}}
    <div style="background:linear-gradient(135deg,#6B1A2B 0%,#3D0A13 55%,#1a0a00 100%);border-radius:18px;padding:26px 22px;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;"></div>
        <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(201,152,42,0.2),transparent 70%);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px;">
            <div>
                <div style="font-size:11px;font-weight:700;color:rgba(201,152,42,0.8);text-transform:uppercase;letter-spacing:.1em;margin-bottom:4px;">Tingkat Kehadiran</div>
                <div style="font-size:clamp(38px,10vw,52px);font-weight:900;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;line-height:1;">{{ $presentRate }}%</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.8);margin-top:5px;font-weight:500;">{{ $absensiSummary['hadir'] }} dari {{ $absensi->count() }} pertemuan</div>
            </div>
            <div style="width:72px;height:72px;background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.2);border-radius:18px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="32" height="32" fill="none" stroke="rgba(201,152,42,0.9)" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
            </div>
        </div>

        {{-- Progress bar --}}
        <div style="background:rgba(255,255,255,0.1);border-radius:10px;padding:14px 16px;border:1px solid rgba(255,255,255,0.15);">
            <div style="height:10px;background:rgba(0,0,0,0.25);border-radius:99px;overflow:hidden;margin-bottom:12px;">
                <div style="height:100%;width:{{ $presentRate }}%;background:linear-gradient(90deg,#16a34a,#4ade80);border-radius:99px;transition:width .8s;"></div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-around;flex-wrap:wrap;gap:8px;">
                <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#4ade80;">
                    <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;"></span>Hadir {{ $absensiSummary['hadir'] }}
                </span>
                <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#fbbf24;">
                    <span style="width:8px;height:8px;background:#fbbf24;border-radius:50%;display:inline-block;"></span>Izin {{ $absensiSummary['izin'] }}
                </span>
                <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#60a5fa;">
                    <span style="width:8px;height:8px;background:#60a5fa;border-radius:50%;display:inline-block;"></span>Sakit {{ $absensiSummary['sakit'] }}
                </span>
                <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#f87171;">
                    <span style="width:8px;height:8px;background:#f87171;border-radius:50%;display:inline-block;"></span>Alpha {{ $absensiSummary['alpha'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- Summary 4-col grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
        <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(16,185,129,0.25);border-top:3px solid #16a34a;border-radius:12px;padding:12px 4px;text-align:center;">
            <div style="font-size:22px;font-weight:900;color:#34d399;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['hadir'] }}</div>
            <div style="font-size:10px;font-weight:700;color:#6ee7b7;text-transform:uppercase;margin-top:3px;letter-spacing:.04em;">Hadir</div>
        </div>
        <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(245,158,11,0.25);border-top:3px solid #f59e0b;border-radius:12px;padding:12px 4px;text-align:center;">
            <div style="font-size:22px;font-weight:900;color:#fbbf24;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['izin'] }}</div>
            <div style="font-size:10px;font-weight:700;color:#fcd34d;text-transform:uppercase;margin-top:3px;letter-spacing:.04em;">Izin</div>
        </div>
        <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(59,130,246,0.25);border-top:3px solid #3b82f6;border-radius:12px;padding:12px 4px;text-align:center;">
            <div style="font-size:22px;font-weight:900;color:#60a5fa;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['sakit'] }}</div>
            <div style="font-size:10px;font-weight:700;color:#93c5fd;text-transform:uppercase;margin-top:3px;letter-spacing:.04em;">Sakit</div>
        </div>
        <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(239,68,68,0.25);border-top:3px solid #ef4444;border-radius:12px;padding:12px 4px;text-align:center;">
            <div style="font-size:22px;font-weight:900;color:#f87171;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['alpha'] }}</div>
            <div style="font-size:10px;font-weight:700;color:#fca5a5;text-transform:uppercase;margin-top:3px;letter-spacing:.04em;">Alpha</div>
        </div>
    </div>

    {{-- Lateness Statistics --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:18px 20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">
                <svg width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Statistik Keterlambatan
            </div>
            <span style="font-size:22px;font-weight:900;color:{{ $lateRate > 30 ? '#f87171' : ($lateRate > 10 ? '#fbbf24' : '#34d399') }};font-family:'Plus Jakarta Sans',sans-serif;">{{ $lateRate }}%</span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;text-align:center;">
            <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:10px;padding:12px 4px;">
                <div style="font-size:24px;font-weight:800;color:#34d399;font-family:'Plus Jakarta Sans',sans-serif;">{{ $latenessStats['tepat_waktu'] }}</div>
                <div style="font-size:10px;font-weight:700;color:#6ee7b7;text-transform:uppercase;margin-top:3px;">Tepat Waktu</div>
                <div style="font-size:9px;color:#475569;margin-top:2px;">≤0 menit</div>
            </div>
            <div style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:10px;padding:12px 4px;">
                <div style="font-size:24px;font-weight:800;color:#fbbf24;font-family:'Plus Jakarta Sans',sans-serif;">{{ $latenessStats['terlambat'] }}</div>
                <div style="font-size:10px;font-weight:700;color:#fcd34d;text-transform:uppercase;margin-top:3px;">Terlambat</div>
                <div style="font-size:9px;color:#475569;margin-top:2px;">1–15 menit</div>
            </div>
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:12px 4px;">
                <div style="font-size:24px;font-weight:800;color:#f87171;font-family:'Plus Jakarta Sans',sans-serif;">{{ $latenessStats['sangat_terlambat'] }}</div>
                <div style="font-size:10px;font-weight:700;color:#fca5a5;text-transform:uppercase;margin-top:3px;">Sangat Terlambat</div>
                <div style="font-size:9px;color:#475569;margin-top:2px;">&gt;15 menit</div>
            </div>
        </div>
    </div>

    {{-- Calendar View --}}
    @php
        // Group attendance by date
        $absensiByDate = $absensi->groupBy(function($item) {
            return $item->Pertemuan?->tanggal ? \Carbon\Carbon::parse($item->Pertemuan->tanggal)->format('Y-m-d') : null;
        })->filter();
        
        // Get min and max dates
        $allDates = $absensi->map(function($item) {
            return $item->Pertemuan?->tanggal ? \Carbon\Carbon::parse($item->Pertemuan->tanggal) : null;
        })->filter();
        
        $minDate = $allDates->min();
        $maxDate = $allDates->max();
        
        if (!$minDate || !$maxDate) {
            $minDate = \Carbon\Carbon::now()->startOfMonth();
            $maxDate = \Carbon\Carbon::now()->endOfMonth();
        }
    @endphp

    @if($absensi->count() > 0)
    <div style="background:linear-gradient(135deg,rgba(22,28,45,0.8) 0%,rgba(16,22,40,0.9) 100%);border:1px solid rgba(201,152,42,0.2);border-radius:14px;padding:20px 16px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:14px;font-weight:700;color:#f1f5f9;margin:0;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Kalender Kehadiran
            </h3>
            <span style="font-size:11px;font-weight:700;color:#c9982a;">{{ $minDate->format('M Y') }} - {{ $maxDate->format('M Y') }}</span>
        </div>

        {{-- Legend --}}
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.08);">
            <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#cbd5e1;">
                <span style="width:18px;height:18px;background:#34d399;border-radius:6px;border:1px solid rgba(52,211,153,0.3);"></span>
                <span>Hadir</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#cbd5e1;">
                <span style="width:18px;height:18px;background:#fbbf24;border-radius:6px;border:1px solid rgba(251,191,36,0.3);"></span>
                <span>Izin</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#cbd5e1;">
                <span style="width:18px;height:18px;background:#60a5fa;border-radius:6px;border:1px solid rgba(96,165,250,0.3);"></span>
                <span>Sakit</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#cbd5e1;">
                <span style="width:18px;height:18px;background:#f87171;border-radius:6px;border:1px solid rgba(248,113,113,0.3);"></span>
                <span>Alpha</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#cbd5e1;">
                <span style="width:18px;height:18px;background:rgba(148,163,184,0.2);border-radius:6px;border:1px solid rgba(148,163,184,0.3);"></span>
                <span>Tidak Ada Absensi</span>
            </div>
        </div>

        {{-- Calendar Grid --}}
        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px;">
            @php
                // Days of week headers
                $daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            @endphp
            @foreach($daysOfWeek as $day)
                <div style="text-align:center;padding:8px 4px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;">{{ $day }}</div>
            @endforeach

            @php
                // Generate calendar grid
                $currentDate = $minDate->copy()->startOfMonth();
                $endDate = $maxDate->copy()->endOfMonth();
                
                // Pad first week
                $firstDayOfWeek = $currentDate->dayOfWeek;
                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                    echo '<div></div>';
                }
                
                while ($currentDate <= $endDate) {
                    $dateStr = $currentDate->format('Y-m-d');
                    $attendanceForDay = $absensiByDate->get($dateStr, collect());
                    
                    $status = 'none';
                    $statusColor = 'rgba(148,163,184,0.2)';
                    $statusBorder = 'rgba(148,163,184,0.3)';
                    $statusText = '';
                    
                    if ($attendanceForDay->count() > 0) {
                        $firstRecord = $attendanceForDay->first();
                        $status = strtolower($firstRecord->status);
                        $statusText = ucfirst($status);
                        
                        $statusConfig = [
                            'hadir' => ['#34d399', 'rgba(52,211,153,0.2)', 'rgba(52,211,153,0.3)'],
                            'izin' => ['#fbbf24', 'rgba(251,191,36,0.2)', 'rgba(251,191,36,0.3)'],
                            'sakit' => ['#60a5fa', 'rgba(96,165,250,0.2)', 'rgba(96,165,250,0.3)'],
                            'alpha' => ['#f87171', 'rgba(248,113,113,0.2)', 'rgba(248,113,113,0.3)'],
                        ];
                        
                        if (isset($statusConfig[$status])) {
                            $statusColor = $statusConfig[$status][1];
                            $statusBorder = $statusConfig[$status][2];
                        }
                    }
            @endphp
                    <div style="aspect-ratio:1/1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:{{ $statusColor }};border:1px solid {{ $statusBorder }};border-radius:10px;padding:6px;cursor:pointer;transition:all 0.2s ease;hover:transform:scale(1.05);hover:box-shadow:0 4px 12px rgba(0,0,0,0.2);" title="{{ $statusText ? $currentDate->format('d M Y') . ' - ' . $statusText : $currentDate->format('d M Y') }}">
                        <div style="font-size:12px;font-weight:700;color:#f1f5f9;">{{ $currentDate->day }}</div>
                        @if($attendanceForDay->count() > 0)
                            @php
                                $firstRecord = $attendanceForDay->first();
                                $recordStatus = strtolower($firstRecord->status);
                                $dotColor = '#34d399';
                                if ($recordStatus === 'izin') $dotColor = '#fbbf24';
                                elseif ($recordStatus === 'sakit') $dotColor = '#60a5fa';
                                elseif ($recordStatus === 'alpha') $dotColor = '#f87171';
                            @endphp
                            <div style="width:6px;height:6px;background:{{ $dotColor }};border-radius:50%;margin-top:2px;"></div>
                        @endif
                    </div>
            @php
                    $currentDate->addDay();
                }
            @endphp
        </div>

        {{-- Calendar Stats --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:16px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.08);">
            <div style="text-align:center;padding:12px 8px;background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);border-radius:10px;">
                <div style="font-size:18px;font-weight:800;color:#34d399;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiByDate->map(fn($group) => $group->where('status', 'hadir')->count())->sum() }}</div>
                <div style="font-size:10px;font-weight:700;color:#6ee7b7;text-transform:uppercase;margin-top:3px;">Hari Hadir</div>
            </div>
            <div style="text-align:center;padding:12px 8px;background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:10px;">
                <div style="font-size:18px;font-weight:800;color:#fbbf24;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiByDate->map(fn($group) => $group->where('status', 'izin')->count())->sum() }}</div>
                <div style="font-size:10px;font-weight:700;color:#fcd34d;text-transform:uppercase;margin-top:3px;">Hari Izin</div>
            </div>
            <div style="text-align:center;padding:12px 8px;background:rgba(96,165,250,0.08);border:1px solid rgba(96,165,250,0.2);border-radius:10px;">
                <div style="font-size:18px;font-weight:800;color:#60a5fa;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiByDate->map(fn($group) => $group->where('status', 'sakit')->count())->sum() }}</div>
                <div style="font-size:10px;font-weight:700;color:#93c5fd;text-transform:uppercase;margin-top:3px;">Hari Sakit</div>
            </div>
            <div style="text-align:center;padding:12px 8px;background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);border-radius:10px;">
                <div style="font-size:18px;font-weight:800;color:#f87171;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiByDate->map(fn($group) => $group->where('status', 'alpha')->count())->sum() }}</div>
                <div style="font-size:10px;font-weight:700;color:#fca5a5;text-transform:uppercase;margin-top:3px;">Hari Alpha</div>
            </div>
        </div>
    </div>
    @endif

    {{-- History --}}
    <div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <h3 style="font-size:15px;font-weight:700;color:#f1f5f9;margin:0;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:8px;">
                <span style="width:4px;height:16px;background:linear-gradient(180deg,#c9982a,#f0be3d);border-radius:99px;display:inline-block;"></span>
                Riwayat Absensi Per Pertemuan
            </h3>
            @if($absensi->count() > 0)
                <span style="font-size:11px;font-weight:700;padding:4px 12px;border-radius:99px;background:rgba(201,152,42,0.15);color:#c9982a;border:1px solid rgba(201,152,42,0.3);">{{ $absensi->count() }} Riwayat</span>
            @endif
        </div>

        @if($absensi->count() > 0)
            <div style="border:2px solid rgba(201,152,42,0.2);border-radius:14px;overflow:hidden;background:linear-gradient(135deg,rgba(22,28,45,0.6) 0%,rgba(16,22,40,0.8) 100%);box-shadow:inset 0 2px 8px rgba(0,0,0,0.3);">
                <div style="max-height:650px;overflow-y:auto;padding:12px;scroll-behavior:smooth;" class="custom-scrollbar-attendance" id="attendanceScroller">
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @foreach($absensi as $index => $record)
                            @php
                                $mapelName = $record->Pertemuan?->JadwalBelajar?->Mapel?->nama_mapel
                                          ?? $record->Pertemuan?->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel
                                          ?? 'Mata Pelajaran';
                                
                                $guruName = $record->Pertemuan?->JadwalBelajar?->GuruMapel?->Guru?->user?->nama
                                         ?? $record->Pertemuan?->JadwalBelajar?->Guru?->user?->nama
                                         ?? 'Guru';
                                
                                $kelasName = $record->Pertemuan?->JadwalBelajar?->Kelas?->nama_kelas ?? '';
                                $jamBelajar = '';
                                if ($record->Pertemuan?->JadwalBelajar?->JamBelajar?->jam_mulai && $record->Pertemuan?->JadwalBelajar?->JamBelajar?->jam_selesai) {
                                    $jamMulai = $record->Pertemuan->JadwalBelajar->JamBelajar->jam_mulai;
                                    $jamSelesai = $record->Pertemuan->JadwalBelajar->JamBelajar->jam_selesai;
                                    $jamMulaiFormatted = is_string($jamMulai) ? $jamMulai : (is_object($jamMulai) ? $jamMulai->format('H:i') : $jamMulai);
                                    $jamSelesaiFormatted = is_string($jamSelesai) ? $jamSelesai : (is_object($jamSelesai) ? $jamSelesai->format('H:i') : $jamSelesai);
                                    $jamBelajar = $jamMulaiFormatted . ' - ' . $jamSelesaiFormatted;
                                }

                                $statusConfig = [
                                    'hadir' => ['rgba(16,185,129,0.12)','#34d399','rgba(16,185,129,0.25)','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    'izin'  => ['rgba(245,158,11,0.12)', '#fbbf24','rgba(245,158,11,0.25)','M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z'],
                                    'sakit' => ['rgba(59,130,246,0.12)', '#60a5fa','rgba(59,130,246,0.25)','M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
                                    'alpha' => ['rgba(239,68,68,0.12)',  '#f87171','rgba(239,68,68,0.25)', 'M6 18L18 6M6 6l12 12'],
                                ];
                                [$sbg,$stc,$sborder,$spath] = $statusConfig[strtolower($record->status)] ?? ['rgba(148,163,184,0.12)','#94a3b8','rgba(148,163,184,0.25)','M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226z'];

                                $latenessConfig = [
                                    'tepat_waktu'    => ['#34d399','Tepat Waktu'],
                                    'terlambat'      => ['#fbbf24','Terlambat'],
                                    'sangat_terlambat' => ['#f87171','Sangat Terlambat'],
                                ];
                                [$ltc,$llabel] = $latenessConfig[$record->status_keterlambatan ?? ''] ?? ['#64748b',''];
                            @endphp
                            <div style="background:rgba(22,28,45,0.9);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.08);border-left:4px solid {{ $stc }};border-radius:12px;padding:14px 16px;transition:all 0.3s ease;cursor:pointer;hover:background:rgba(30,40,60,0.9);hover:border-color:rgba(255,255,255,0.12);hover:box-shadow:0 4px 12px rgba({{ str_contains($stc, '#34d399') ? '52,211,153' : (str_contains($stc, '#fbbf24') ? '251,191,36' : (str_contains($stc, '#60a5fa') ? '96,165,250' : '248,113,113')) }},0.15);" class="attendance-item" data-index="{{ $index }}">
                                <div style="display:flex;align-items:start;gap:12px;">
                                    <div style="width:44px;height:44px;border-radius:11px;background:{{ $sbg }};border:1.5px solid {{ $sborder }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="20" height="20" fill="none" stroke="{{ $stc }}" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $spath }}"/>
                                        </svg>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <!-- Header: Mapel & Status -->
                                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;gap:8px;flex-wrap:wrap;">
                                            <div style="font-size:14px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelName }}</div>
                                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                                <span style="font-size:10px;font-weight:700;padding:4px 11px;border-radius:99px;background:{{ $sbg }};color:{{ $stc }};text-transform:uppercase;border:1px solid {{ $sborder }};letter-spacing:0.5px;">{{ strtoupper($record->status) }}</span>
                                                @if($record->status_keterlambatan)
                                                    <span style="font-size:10px;font-weight:700;padding:4px 11px;border-radius:99px;background:{{ $ltc }}1a;color:{{ $ltc }};border:1px solid {{ $ltc }}33;letter-spacing:0.5px;">{{ $llabel }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Main Info Row -->
                                        <div style="background:rgba(255,255,255,0.03);border-radius:9px;padding:10px 12px;margin-bottom:10px;border:1px solid rgba(255,255,255,0.05);">
                                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                                <!-- Pertemuan & Tanggal -->
                                                <div style="display:flex;align-items:flex-start;gap:6px;">
                                                    <svg width="13" height="13" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2.2" style="flex-shrink:0;margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                                    <div style="font-size:12px;color:#cbd5e1;line-height:1.3;">
                                                        @if($record->Pertemuan)
                                                        <div style="font-weight:600;color:#f1f5f9;">Pertemuan ke-{{ $record->Pertemuan->nomor_pertemuan }}</div>
                                                        @if($record->Pertemuan->tanggal)
                                                        <div style="color:#94a3b8;font-size:11px;margin-top:2px;">{{ \Carbon\Carbon::parse($record->Pertemuan->tanggal)->format('d M Y') }}</div>
                                                        @endif
                                                        @else
                                                        <div style="color:#94a3b8;">-</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Jam Pelajaran -->
                                                <div style="display:flex;align-items:flex-start;gap:6px;">
                                                    <svg width="13" height="13" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2.2" style="flex-shrink:0;margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <div style="font-size:12px;color:#cbd5e1;line-height:1.3;">
                                                        @if($jamBelajar)
                                                        <div style="font-weight:600;color:#f1f5f9;">Jam Pelajaran</div>
                                                        <div style="color:#94a3b8;font-size:11px;margin-top:2px;">{{ $jamBelajar }}</div>
                                                        @else
                                                        <div style="color:#94a3b8;">Jam tidak tersedia</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Details Grid -->
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                                            <!-- Kelas -->
                                            @if($kelasName)
                                            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#cbd5e1;">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.008v.008H6.75V6.75zm12 0h.008v.008h-.008V6.75z"/></svg>
                                                <span><span style="color:#f1f5f9;font-weight:600;">Kelas:</span> {{ $kelasName }}</span>
                                            </div>
                                            @endif

                                            <!-- Guru -->
                                            @if($guruName && $guruName !== 'Guru')
                                            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#cbd5e1;">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                                <span><span style="color:#f1f5f9;font-weight:600;">Guru:</span> {{ $guruName }}</span>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Waktu Absen -->
                                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#cbd5e1;margin-bottom:10px;padding:10px 12px;background:rgba(255,255,255,0.03);border-radius:9px;border:1px solid rgba(255,255,255,0.05);">
                                            <svg width="13" height="13" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @if($record->waktu_absen)
                                            <span><span style="color:#f1f5f9;font-weight:600;">Dicatat:</span> 
                                            @if(is_string($record->waktu_absen))
                                                {{ \Carbon\Carbon::parse($record->waktu_absen)->format('d M Y · H:i') }}
                                            @else
                                                {{ $record->waktu_absen->format('d M Y · H:i') }}
                                            @endif
                                            </span>
                                            @else
                                            <span style="color:#ef4444;font-style:italic;">Belum dicatat</span>
                                            @endif
                                        </div>

                                        <!-- Keterangan -->
                                        @if($record->keterangan)
                                            <div style="font-size:11px;color:#cbd5e1;padding:10px 12px;background:rgba(201,152,42,0.08);border-radius:9px;border-left:3px solid #c9982a;border-radius:8px;">
                                                <div style="color:#c9982a;font-weight:700;margin-bottom:4px;">💬 Keterangan:</div>
                                                <div style="color:#cbd5e1;font-style:italic;">{{ $record->keterangan }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Scroll Indicator -->
                <div style="height:6px;background:linear-gradient(90deg,transparent,rgba(201,152,42,0.3),transparent);border-top:1px solid rgba(201,152,42,0.2);"></div>
            </div>

            <!-- Custom Scrollbar Styling -->
            <style>
                .custom-scrollbar-attendance::-webkit-scrollbar {
                    width: 8px;
                }
                .custom-scrollbar-attendance::-webkit-scrollbar-track {
                    background: rgba(255,255,255,0.03);
                }
                .custom-scrollbar-attendance::-webkit-scrollbar-thumb {
                    background: linear-gradient(180deg, rgba(201,152,42,0.5), rgba(201,152,42,0.3));
                    border-radius: 10px;
                    transition: all 0.3s ease;
                }
                .custom-scrollbar-attendance::-webkit-scrollbar-thumb:hover {
                    background: linear-gradient(180deg, rgba(201,152,42,0.8), rgba(201,152,42,0.6));
                    box-shadow: 0 0 8px rgba(201,152,42,0.4);
                }
                
                .attendance-item {
                    animation: slideIn 0.3s ease-out;
                }
                
                @keyframes slideIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .attendance-item:hover {
                    background: rgba(30,40,60,0.9) !important;
                    border-color: rgba(255,255,255,0.12) !important;
                }
            </style>
        
        @else
            <div style="padding:52px 20px;text-align:center;background:rgba(22,28,45,0.6);border-radius:14px;border:1px dashed rgba(255,255,255,0.1);">
                <div style="width:60px;height:60px;margin:0 auto 14px;border-radius:16px;background:rgba(201,152,42,0.1);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                    <svg width="26" height="26" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                </div>
                <div style="font-size:14px;font-weight:600;color:#64748b;">Belum ada riwayat absensi</div>
                <div style="font-size:12px;color:#475569;margin-top:5px;max-width:280px;margin-left:auto;margin-right:auto;">Absensi akan tercatat saat Anda mengakses materi, tugas, atau kuis yang memerlukan absensi.</div>
            </div>
        @endif
    </div>

</div>
</x-student-layout>
