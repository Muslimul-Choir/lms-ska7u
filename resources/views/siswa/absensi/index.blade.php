<x-student-layout>
<x-slot name="heading">Kehadiran Saya</x-slot>

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Summary Card --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);padding:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <span style="font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Tingkat Kehadiran</span>
            <span style="font-size:28px;font-weight:900;color:#16a34a;font-family:'Plus Jakarta Sans',sans-serif;">{{ $presentRate }}%</span>
        </div>
        <div style="height:10px;background:#e2e8f0;border-radius:99px;overflow:hidden;margin-bottom:16px;">
            <div style="height:100%;width:{{ $presentRate }}%;background:linear-gradient(90deg,#16a34a,#4ade80);border-radius:99px;transition:width .6s;"></div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;text-align:center;">
            <div style="background:#f0fdf4;border-radius:10px;padding:10px 4px;border-top:3px solid #16a34a;">
                <div style="font-size:20px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['hadir'] }}</div>
                <div style="font-size:10px;font-weight:600;color:#15803d;text-transform:uppercase;margin-top:2px;">Hadir</div>
            </div>
            <div style="background:#fefce8;border-radius:10px;padding:10px 4px;border-top:3px solid #f59e0b;">
                <div style="font-size:20px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['izin'] }}</div>
                <div style="font-size:10px;font-weight:600;color:#b45309;text-transform:uppercase;margin-top:2px;">Izin</div>
            </div>
            <div style="background:#eff6ff;border-radius:10px;padding:10px 4px;border-top:3px solid #3b82f6;">
                <div style="font-size:20px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['sakit'] }}</div>
                <div style="font-size:10px;font-weight:600;color:#1d4ed8;text-transform:uppercase;margin-top:2px;">Sakit</div>
            </div>
            <div style="background:#fff1f2;border-radius:10px;padding:10px 4px;border-top:3px solid #ef4444;">
                <div style="font-size:20px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">{{ $absensiSummary['alpha'] }}</div>
                <div style="font-size:10px;font-weight:600;color:#b91c1c;text-transform:uppercase;margin-top:2px;">Alpha</div>
            </div>
        </div>
    </div>

    {{-- History --}}
    <div>
        <h3 style="font-size:15px;font-weight:700;color:#0f172a;margin:0 0 12px;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:8px;">
            <span style="width:4px;height:16px;background:#f59e0b;border-radius:99px;display:inline-block;"></span>
            Riwayat Absensi
        </h3>

        @if($absensi->count() > 0)
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($absensi as $record)
                    @php
                        $mapelName = $record->Pertemuan?->JadwalBelajar?->Mapel?->nama_mapel
                                  ?? $record->Pertemuan?->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel
                                  ?? 'Kegiatan Belajar';
                        $statusColors = ['hadir'=>['#dcfce7','#15803d'],'izin'=>['#fef3c7','#b45309'],'sakit'=>['#dbeafe','#1d4ed8'],'alpha'=>['#fee2e2','#991b1b']];
                        [$sbg,$stc] = $statusColors[strtolower($record->status)] ?? ['#f1f5f9','#475569'];
                        $statusEmoji = ['hadir'=>'✅','izin'=>'📋','sakit'=>'🤒','alpha'=>'❌'][strtolower($record->status)] ?? '📌';
                    @endphp
                    <div style="display:flex;align-items:center;gap:12px;background:#fff;border-radius:12px;padding:14px 16px;box-shadow:0 1px 4px rgba(0,0,0,.06);border:1px solid #e2e8f0;">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $sbg }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $statusEmoji }}</div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelName }}</div>
                            <div style="font-size:12px;color:#64748b;margin-top:2px;">Pertemuan ke-{{ $record->Pertemuan?->nomor_pertemuan ?? '-' }} · {{ $record->created_at->format('d M Y') }}</div>
                        </div>
                        <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:{{ $sbg }};color:{{ $stc }};white-space:nowrap;text-transform:uppercase;flex-shrink:0;">{{ $record->status }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
                <div style="font-size:40px;margin-bottom:10px;">📅</div>
                <div style="font-size:14px;font-weight:600;color:#475569;">Belum ada riwayat absensi.</div>
            </div>
        @endif
    </div>

</div>
</x-student-layout>
