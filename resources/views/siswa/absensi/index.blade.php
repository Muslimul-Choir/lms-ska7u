<x-student-layout>
<x-slot name="heading">Kehadiran Saya</x-slot>

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Clock-In Card --}}
    <div style="background:linear-gradient(135deg,#6B1A2B,#9B3045);border-radius:16px;box-shadow:0 4px 16px rgba(107,26,43,.25);padding:24px;position:relative;overflow:hidden;">
        {{-- Decorative circles --}}
        <div style="position:absolute;top:-40px;right:-40px;width:150px;height:150px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-30px;left:-30px;width:120px;height:120px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
        
        <div style="position:relative;z-index:1;">
            <div style="display:flex;align-items:center;justify-content:between;gap:16px;margin-bottom:20px;">
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.8);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">Absensi Hari Ini</div>
                    <div id="currentTime" style="font-size:clamp(28px,8vw,36px);font-weight:900;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;line-height:1;"></div>
                    <div id="currentDate" style="font-size:14px;color:rgba(255,255,255,0.9);margin-top:6px;font-weight:600;"></div>
                </div>
                <div style="width:80px;height:80px;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:36px;flex-shrink:0;">
                    🕐
                </div>
            </div>

            @if($todayAbsensi)
                {{-- Already Clocked In --}}
                <div style="background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:12px;padding:16px;border:2px solid rgba(255,255,255,0.3);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:48px;height:48px;background:rgba(255,255,255,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">
                            @if($todayAbsensi->status === 'hadir') ✅ @else ❌ @endif
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:16px;font-weight:800;color:#fff;margin-bottom:2px;font-family:'Plus Jakarta Sans',sans-serif;">
                                @if($todayAbsensi->status === 'hadir')
                                    Sudah Absen - Hadir
                                @else
                                    Sudah Absen - Terlambat
                                @endif
                            </div>
                            <div style="font-size:13px;color:rgba(255,255,255,0.9);font-weight:600;">
                                Waktu: {{ $todayAbsensi->waktu_absen->format('H:i:s') }}
                            </div>
                            @if($todayAbsensi->keterangan)
                            <div style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:4px;font-style:italic;">
                                {{ $todayAbsensi->keterangan }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                {{-- Clock In Button --}}
                <div id="clockInContainer">
                    <form action="{{ route('siswa.absensi.clockIn') }}" method="POST" onsubmit="return confirmClockIn(event)">
                        @csrf
                        <button type="submit" id="clockInButton" style="width:100%;padding:16px;background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);color:#6B1A2B;border:none;border-radius:12px;font-size:16px;font-weight:800;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:10px;transition:all 0.2s;box-shadow:0 4px 12px rgba(0,0,0,.15);" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 16px rgba(0,0,0,.2)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(0,0,0,.15)'">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Clock In Sekarang</span>
                        </button>
                    </form>
                </div>
                <div id="clockInInfo" style="margin-top:12px;text-align:center;font-size:12px;color:rgba(255,255,255,0.85);font-weight:600;">
                    ⏰ Waktu Absensi: <strong>05:00 - 12:00 WIB</strong><br>
                    <span style="font-size:11px;">Tepat Waktu: ≤ 07:00 | Terlambat: > 07:00</span>
                </div>
            @endif
        </div>
    </div>

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
                                  ?? 'Absensi Harian';
                        $statusColors = ['hadir'=>['#dcfce7','#15803d'],'izin'=>['#fef3c7','#b45309'],'sakit'=>['#dbeafe','#1d4ed8'],'alpha'=>['#fee2e2','#991b1b']];
                        [$sbg,$stc] = $statusColors[strtolower($record->status)] ?? ['#f1f5f9','#475569'];
                        $statusEmoji = ['hadir'=>'✅','izin'=>'📋','sakit'=>'🤒','alpha'=>'❌'][strtolower($record->status)] ?? '📌';
                    @endphp
                    <div style="display:flex;align-items:center;gap:12px;background:#fff;border-radius:12px;padding:14px 16px;box-shadow:0 1px 4px rgba(0,0,0,.06);border:1px solid #e2e8f0;">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $sbg }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $statusEmoji }}</div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelName }}</div>
                            <div style="font-size:12px;color:#64748b;margin-top:2px;">
                                @if($record->waktu_absen)
                                    {{ $record->waktu_absen->format('d M Y · H:i') }}
                                @else
                                    {{ $record->created_at->format('d M Y') }}
                                @endif
                                @if($record->Pertemuan)
                                · Pertemuan ke-{{ $record->Pertemuan->nomor_pertemuan }}
                                @endif
                            </div>
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

@push('scripts')
<script>
// Update clock every second and check time window
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    
    const timeEl = document.getElementById('currentTime');
    const dateEl = document.getElementById('currentDate');
    
    if (timeEl) timeEl.textContent = timeString;
    if (dateEl) dateEl.textContent = dateString;
    
    // Check time window (05:00 - 12:00)
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const clockInButton = document.getElementById('clockInButton');
    const clockInInfo = document.getElementById('clockInInfo');
    
    if (clockInButton && clockInInfo) {
        if (hours < 5 || hours >= 12) {
            // Outside window - disable button
            clockInButton.disabled = true;
            clockInButton.style.opacity = '0.5';
            clockInButton.style.cursor = 'not-allowed';
            clockInButton.style.background = 'rgba(255,255,255,0.5)';
            
            if (hours < 5) {
                clockInInfo.innerHTML = '🔒 <strong>Belum Dibuka</strong><br><span style="font-size:11px;">Absensi dibuka mulai jam 05:00 WIB</span>';
            } else {
                clockInInfo.innerHTML = '🔒 <strong>Sudah Ditutup</strong><br><span style="font-size:11px;">Absensi ditutup pada jam 12:00 WIB</span>';
            }
        } else {
            // Inside window - enable button
            clockInButton.disabled = false;
            clockInButton.style.opacity = '1';
            clockInButton.style.cursor = 'pointer';
            clockInButton.style.background = 'rgba(255,255,255,0.95)';
            
            if (hours < 7 || (hours === 7 && minutes === 0)) {
                clockInInfo.innerHTML = '✅ <strong>Waktu Tepat - Status: Hadir</strong><br><span style="font-size:11px;">Clock in sebelum 07:00 untuk status Hadir</span>';
            } else {
                clockInInfo.innerHTML = '⚠️ <strong>Terlambat - Status: Alpha</strong><br><span style="font-size:11px;">Anda clock in setelah jam 07:00</span>';
            }
        }
    }
}

updateClock();
setInterval(updateClock, 1000);

// Confirm clock-in
function confirmClockIn(event) {
    event.preventDefault();
    const form = event.target;
    
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    
    // Double check time window
    if (hours < 5) {
        Swal.fire({
            title: '🔒 Belum Dibuka',
            text: 'Absensi dibuka mulai jam 05:00 WIB',
            icon: 'error',
            confirmButtonColor: '#6B1A2B'
        });
        return false;
    }
    
    if (hours >= 12) {
        Swal.fire({
            title: '🔒 Sudah Ditutup',
            text: 'Absensi ditutup pada jam 12:00 WIB',
            icon: 'error',
            confirmButtonColor: '#6B1A2B'
        });
        return false;
    }
    
    const timeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    
    let statusText = '';
    let icon = 'question';
    
    if (hours < 7 || (hours === 7 && minutes === 0)) {
        statusText = '<div style="background:#dcfce7;border:2px solid #16a34a;border-radius:8px;padding:12px;margin-top:8px;"><strong style="color:#15803d;">✅ Status: Hadir (Tepat Waktu)</strong></div>';
        icon = 'success';
    } else {
        statusText = '<div style="background:#fee2e2;border:2px solid #ef4444;border-radius:8px;padding:12px;margin-top:8px;"><strong style="color:#991b1b;">❌ Status: Alpha (Terlambat)</strong><br><small>Anda clock in setelah jam 07:00</small></div>';
        icon = 'warning';
    }
    
    Swal.fire({
        title: '🕐 Clock In Absensi?',
        html: `<div style="text-align:left;">
            <p style="margin-bottom:8px;">Waktu saat ini: <strong>${timeString}</strong></p>
            ${statusText}
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px;margin-top:8px;font-size:12px;color:#64748b;">
                <strong>ℹ️ Informasi:</strong><br>
                • Waktu Clock-In: 05:00 - 12:00 WIB<br>
                • Batas Tepat Waktu: 07:00 WIB<br>
                • Absensi hanya 1x per hari
            </div>
        </div>`,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#6B1A2B',
        cancelButtonColor: '#64748b',
        confirmButtonText: '✓ Ya, Clock In',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        width: '500px'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    
    return false;
}
</script>
@endpush
</x-student-layout>
