<x-student-layout>
@inject('attendanceService', 'App\Services\AttendanceGatewayService')
<x-slot name="heading">
    <div style="display:flex;align-items:center;gap:10px;min-width:0;">
        <a href="{{ route('siswa.materi.index') }}" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:all .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <span style="font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $mapel->nama_mapel }}</span>
    </div>
</x-slot>

<style>
/* ─── SPACING & LAYOUT ─── */
.page-container { max-width:720px; margin:0 auto; padding:16px; }
.content-section { display:flex; flex-direction:column; gap:18px; }

/* ─── SECTION LABEL ─── */
.sec-label { 
    display:flex; 
    align-items:center; 
    gap:8px; 
    font-size:9.5px; 
    font-weight:800; 
    text-transform:uppercase; 
    letter-spacing:.08em; 
    margin-bottom:10px; 
    padding-top:4px;
}
.sec-dot { 
    width:6px; 
    height:6px; 
    border-radius:50%; 
    flex-shrink:0; 
    box-shadow:0 0 8px currentColor;
}

/* ─── CONTENT ROW CARD ─── */
.content-row { 
    display:flex; 
    align-items:center; 
    gap:12px; 
    padding:12px 14px; 
    border-radius:11px; 
    text-decoration:none; 
    transition:all .15s ease; 
    border:1px solid;
    position:relative; 
    overflow:hidden;
    min-height:44px;
}
.content-row::after { 
    content:''; 
    position:absolute; 
    inset:0; 
    background:linear-gradient(135deg,rgba(255,255,255,0.02),transparent); 
    pointer-events:none; 
}
.content-row:hover { 
    transform:translateX(2px);
    border-color:currentColor;
}
.content-row-icon { 
    width:36px; 
    height:36px; 
    border-radius:9px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    flex-shrink:0;
}
.content-row-title { 
    font-size:12.5px; 
    font-weight:700; 
    color:#e2e8f0; 
    flex:1; 
    min-width:0; 
    white-space:nowrap; 
    overflow:hidden; 
    text-overflow:ellipsis; 
    font-family:'Plus Jakarta Sans',sans-serif;
}
.content-row-subtitle { 
    font-size:10px; 
    color:#64748b; 
    margin-top:3px; 
    display:flex; 
    align-items:center; 
    gap:3px;
}
.content-row-badge { 
    font-size:8.5px; 
    font-weight:800; 
    padding:3px 8px; 
    border-radius:99px; 
    white-space:nowrap; 
    border:1px solid;
    letter-spacing:.02em;
}
.content-row.locked { 
    opacity:.4; 
    cursor:not-allowed; 
    pointer-events:none;
}

/* ─── MEETING CARD ─── */
.meeting-card { 
    background:rgba(15,22,38,0.8); 
    backdrop-filter:blur(12px); 
    border:1px solid rgba(255,255,255,0.06); 
    border-radius:14px; 
    overflow:hidden; 
    margin-bottom:16px; 
    transition:all .2s ease;
    animation:slideDown .3s ease both;
}
.meeting-card:hover { 
    border-color:rgba(255,255,255,0.1); 
    box-shadow:0 8px 24px rgba(0,0,0,0.25);
}
.meeting-header { 
    background:rgba(255,255,255,0.02); 
    padding:14px 16px; 
    border-bottom:1px solid rgba(255,255,255,0.05); 
    display:flex; 
    align-items:center; 
    justify-content:space-between; 
    gap:12px;
    cursor:pointer;
    transition:all .15s ease;
    user-select:none;
}
.meeting-header:hover { 
    background:rgba(255,255,255,0.04);
}
.meeting-title-group { 
    display:flex; 
    align-items:center; 
    gap:10px; 
    flex:1; 
    min-width:0;
}
.meeting-num { 
    font-size:12px; 
    font-weight:800; 
    color:#f1f5f9; 
    font-family:'Plus Jakarta Sans',sans-serif;
}
.meeting-num-badge { 
    width:24px; 
    height:24px; 
    border-radius:7px; 
    background:linear-gradient(135deg,rgba(201,152,42,0.2),rgba(240,190,61,0.1)); 
    border:1px solid rgba(201,152,42,0.25); 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    font-size:10px; 
    font-weight:800; 
    color:#f0be3d;
    flex-shrink:0;
}
.meeting-badges { 
    display:flex; 
    align-items:center; 
    gap:6px; 
    flex-wrap:wrap;
}
.meeting-badge { 
    display:flex; 
    align-items:center; 
    gap:3px; 
    font-size:9px; 
    font-weight:700; 
    padding:3px 8px; 
    border-radius:99px; 
    border:1px solid; 
    white-space:nowrap;
}
.meeting-toggle-btn { 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    width:32px; 
    height:32px; 
    background:rgba(255,255,255,0.05); 
    border:1px solid rgba(255,255,255,0.1); 
    border-radius:8px; 
    color:#94a3b8; 
    cursor:pointer; 
    transition:all .2s;
    flex-shrink:0;
}
.meeting-toggle-btn:hover { 
    background:rgba(255,255,255,0.1);
    color:#f1f5f9;
}
.meeting-toggle-btn svg { 
    transition:transform .2s ease;
    width:16px;
    height:16px;
}
.meeting-body { 
    padding:16px 16px; 
    display:flex; 
    flex-direction:column; 
    gap:14px;
}

/* ─── ATTENDANCE PILLS ─── */
.attendance-pill { 
    display:flex; 
    align-items:center; 
    gap:12px; 
    padding:12px 14px; 
    border-radius:11px; 
    border:1px solid;
}
.attendance-icon { 
    width:36px; 
    height:36px; 
    border-radius:9px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    flex-shrink:0;
}
.attendance-content { 
    flex:1; 
    min-width:0;
}

.attendance-cta { 
    display:flex; 
    align-items:center; 
    justify-content:space-between; 
    gap:12px; 
    flex-wrap:wrap; 
    padding:13px 14px; 
    border-radius:11px; 
    border:1.5px dashed rgba(239,68,68,0.25); 
    background:rgba(239,68,68,0.04);
}
.attendance-cta-left { 
    display:flex; 
    align-items:center; 
    gap:11px; 
    flex:1; 
    min-width:180px;
}
.attendance-cta-icon { 
    width:38px; 
    height:38px; 
    border-radius:10px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    flex-shrink:0;
}
.attendance-cta-text { 
    display:flex; 
    flex-direction:column; 
    gap:2px;
}
.attendance-cta-title { 
    font-size:12px; 
    font-weight:800; 
    font-family:'Plus Jakarta Sans',sans-serif;
}
.attendance-cta-desc { 
    font-size:10px; 
    font-weight:500; 
    opacity:.8; 
    line-height:1.3;
}
.attendance-cta-btn { 
    display:inline-flex; 
    align-items:center; 
    gap:5px; 
    background:linear-gradient(135deg,#c9982a,#f0be3d); 
    color:#1a0a00; 
    font-size:11px; 
    font-weight:800; 
    padding:9px 16px; 
    border-radius:9px; 
    text-decoration:none; 
    white-space:nowrap; 
    box-shadow:0 4px 12px rgba(201,152,42,0.3); 
    transition:all .15s;
    border:none;
    cursor:pointer;
}
.attendance-cta-btn:hover { 
    opacity:.88;
    transform:translateY(-1px);
}

/* ─── COUNTDOWN CARD ─── */
.countdown-card { 
    padding:12px 14px; 
    border-radius:11px; 
    border-left:3px solid; 
    border:1px solid; 
    border-left-width:3px;
    transition:all .15s;
}
.countdown-content { 
    display:flex; 
    align-items:center; 
    gap:11px;
}
.countdown-icon { 
    width:36px; 
    height:36px; 
    border-radius:9px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    flex-shrink:0;
}
.countdown-info { 
    flex:1; 
    min-width:0;
}
.countdown-title { 
    font-size:12.5px; 
    font-weight:700; 
    color:#fcd34d; 
    font-family:'Plus Jakarta Sans',sans-serif; 
    white-space:nowrap; 
    overflow:hidden; 
    text-overflow:ellipsis;
}
.countdown-detail { 
    display:flex; 
    align-items:center; 
    gap:6px; 
    margin-top:2px; 
    flex-wrap:wrap;
}
.countdown-time { 
    font-size:10px; 
    color:#92400e; 
    font-weight:600;
}
.countdown-timer { 
    font-size:10px; 
    font-weight:800; 
    color:#ea580c; 
    font-family:'Courier New',monospace; 
    background:rgba(234,88,12,0.1); 
    padding:1px 6px; 
    border-radius:4px;
}

/* ─── SUBJECT BANNER ─── */
.subject-banner { 
    background:linear-gradient(135deg,rgba(15,22,38,0.95),rgba(25,33,55,0.9)); 
    backdrop-filter:blur(12px); 
    border:1px solid rgba(201,152,42,0.16); 
    border-radius:14px; 
    padding:18px 20px; 
    display:flex; 
    align-items:center; 
    gap:14px; 
    margin-bottom:18px; 
    position:relative; 
    overflow:hidden;
}
.subject-banner::before { 
    content:''; 
    position:absolute; 
    top:-25px; 
    right:-25px; 
    width:100px; 
    height:100px; 
    background:radial-gradient(circle,rgba(201,152,42,0.08),transparent 70%); 
    pointer-events:none;
}
.subject-icon { 
    width:50px; 
    height:50px; 
    border-radius:12px; 
    background:rgba(201,152,42,0.12); 
    border:1px solid rgba(201,152,42,0.22); 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    flex-shrink:0; 
    color:#f0be3d;
}
.subject-info { 
    flex:1; 
    min-width:0;
}
.subject-title { 
    font-size:14px; 
    font-weight:800; 
    color:#f1f5f9; 
    margin:0; 
    margin-bottom:4px; 
    font-family:'Plus Jakarta Sans',sans-serif; 
    line-height:1.3;
    overflow:hidden;
    text-overflow:ellipsis;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}
.subject-meta { 
    display:flex; 
    align-items:center; 
    gap:8px; 
    flex-wrap:wrap;
}
.subject-meta-item { 
    font-size:10px; 
    font-weight:600; 
    color:#94a3b8;
}
.subject-meta-badge { 
    font-size:9px; 
    font-weight:700; 
    color:#64748b; 
    background:rgba(255,255,255,0.04); 
    padding:2px 8px; 
    border-radius:5px; 
    border:1px solid rgba(255,255,255,0.08);
}

/* ─── EMPTY STATE ─── */
.empty-state { 
    padding:32px 20px; 
    text-align:center; 
    background:rgba(255,255,255,0.02); 
    border-radius:12px; 
    border:1px dashed rgba(255,255,255,0.06);
}
.empty-icon { 
    width:56px; 
    height:56px; 
    margin:0 auto 14px; 
    border-radius:14px; 
    background:rgba(201,152,42,0.08); 
    border:1px solid rgba(201,152,42,0.16); 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    color:#c9982a;
}
.empty-title { 
    font-size:12px; 
    font-weight:700; 
    color:#64748b; 
    margin-bottom:4px; 
    font-family:'Plus Jakarta Sans',sans-serif;
}
.empty-desc { 
    font-size:11px; 
    color:#475569; 
    line-height:1.5;
}

/* ─── ANIMATIONS ─── */
@keyframes slideDown { 
    from { opacity:0; transform:translateY(-6px); } 
    to { opacity:1; transform:translateY(0); }
}
@keyframes pulse-glow { 
    0%,100% { box-shadow:0 0 0 0 rgba(239,68,68,0.4); } 
    50% { box-shadow:0 0 0 5px rgba(239,68,68,0); }
}

/* ─── PAGINATION STYLE ─── */
.pagination-wrapper { 
    display:flex; 
    align-items:center; 
    justify-content:space-between; 
    padding:16px 18px; 
    background:rgba(15,20,35,0.6); 
    backdrop-filter:blur(12px); 
    border:1px solid rgba(255,255,255,0.06); 
    border-radius:12px; 
    margin-top:18px;
    gap:12px;
    flex-wrap:wrap;
}
.pagination-info { 
    font-size:11px; 
    color:#64748b; 
    font-weight:600; 
    letter-spacing:0.02em;
}
.pagination-nav { 
    display:flex; 
    align-items:center; 
    gap:6px;
    flex-wrap:wrap;
}
.pagination-nav a,
.pagination-nav span { 
    min-width:36px; 
    height:36px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    border-radius:8px; 
    font-size:12px; 
    font-weight:700; 
    text-decoration:none; 
    transition:all .2s ease;
    border:1px solid rgba(255,255,255,0.08);
    background:rgba(255,255,255,0.03);
    color:#94a3b8;
}
.pagination-nav a:hover { 
    background:rgba(201,152,42,0.15); 
    border-color:rgba(201,152,42,0.3); 
    color:#f0be3d; 
    transform:translateY(-1px);
}
.pagination-nav .active { 
    background:linear-gradient(135deg,#c9982a,#f0be3d); 
    border-color:transparent; 
    color:#1a0800; 
    box-shadow:0 4px 12px rgba(201,152,42,0.3);
}
.pagination-nav .disabled { 
    opacity:0.3; 
    cursor:not-allowed; 
    pointer-events:none;
}
.pagination-nav svg { 
    width:14px; 
    height:14px;
}
@media (max-width:640px) {
    .pagination-wrapper { padding:12px 14px; }
    .pagination-info { font-size:10px; }
    .pagination-nav a,
    .pagination-nav span { min-width:32px; height:32px; font-size:11px; }
}
</style>

<div class="page-container">

    {{-- Subject Banner --}}
    <div class="subject-banner">
        <div class="subject-icon">
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
        </div>
        <div class="subject-info">
            <h1 class="subject-title">{{ $mapel->nama_mapel }}</h1>
            <div class="subject-meta">
                @if($mapel->kode_mapel)
                <span class="subject-meta-badge">{{ $mapel->kode_mapel }}</span>
                @endif
                <span class="subject-meta-item">{{ $siswa->Kelas?->Tingkatan?->nama_tingkatan ?? 'N/A' }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan ?? '' }}</span>
                <span class="subject-meta-item">{{ $pertemuans->count() }} Pertemuan</span>
            </div>
        </div>
    </div>

    {{-- Pertemuan List --}}
    @if($pertemuans->count() > 0)
        @foreach($pertemuans as $idx => $pertemuan)
        @php
            $absensiSiswa = $pertemuan->absensis->first();
            $alreadyAbsen = $absensiSiswa !== null;
            $exempted = $attendanceService->isExemptedFromPertemuan($siswa->id, $pertemuan->id);
            $requiresAttendance = $attendanceService->pertemuanRequiresAttendance($pertemuan);
            $batasAbsensi = $attendanceService->getPertemuanAttendanceDeadline($pertemuan);
            $deadlinePassed = $batasAbsensi && now()->gt($batasAbsensi);
            $isGated = $requiresAttendance && !$alreadyAbsen && !$exempted && !$deadlinePassed;

            $hasMateri = $pertemuan->materis->count() > 0;
            $hasTugas = $pertemuan->tugas->count() > 0;
            $hasKuis = $pertemuan->kuis->count() > 0;
            $hasAnyContent = $hasMateri || $hasTugas || $hasKuis;

            // Count pending tasks
            $pendingTugasCount = 0;
            $pendingKuisCount = 0;
            foreach ($pertemuan->tugas as $t) {
                $sub = \App\Models\PengumpulanTugas::where('id_tugas',$t->id)->where('id_siswa',$siswa->id)->first();
                $isExpired = $t->batas_waktu && \Carbon\Carbon::parse($t->batas_waktu)->isPast();
                if (!$sub && !$isExpired && $t->isReleased()) {
                    $pendingTugasCount++;
                }
            }
            foreach ($pertemuan->kuis as $k) {
                $kuisExpired = $k->batas_selesai && \Carbon\Carbon::parse($k->batas_selesai)->isPast();
                if (!$k->HasilKuis->first() && !$kuisExpired && $k->isReleased()) {
                    $pendingKuisCount++;
                }
            }
            $totalPending = $pendingTugasCount + $pendingKuisCount;
        @endphp

        <div class="meeting-card" x-data="{ expanded: false }">
            {{-- Header --}}
            <div class="meeting-header" @click.stop="expanded = !expanded">
                <div class="meeting-title-group">
                    <div class="meeting-num-badge">{{ $pertemuan->nomor_pertemuan }}</div>
                    <div>
                        <div class="meeting-num">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</div>
                        @if($pertemuan->tanggal)
                        <div class="meeting-date" style="font-size:10px;color:#64748b;display:flex;align-items:center;gap:4px;margin-top:2px;">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="meeting-badges">
                    {{-- Pending badge --}}
                    @if($totalPending > 0)
                        <span class="meeting-badge" style="background:rgba(239,68,68,0.12);color:#f87171;border-color:rgba(239,68,68,0.2);">
                            <svg width="8" height="8" fill="#f87171" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12"/></svg>
                            {{ $totalPending }} belum
                        </span>
                    @endif

                    {{-- Attendance badge --}}
                    @if($requiresAttendance)
                        @if($alreadyAbsen)
                            <span class="meeting-badge" style="background:rgba(16,185,129,0.12);color:#34d399;border-color:rgba(16,185,129,0.2);">
                                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75"/></svg>
                                Hadir
                            </span>
                        @elseif($exempted)
                            <span class="meeting-badge" style="background:rgba(59,130,246,0.12);color:#60a5fa;border-color:rgba(59,130,246,0.2);">Dispensasi</span>
                        @elseif($deadlinePassed)
                            <span class="meeting-badge" style="background:rgba(239,68,68,0.1);color:#f87171;border-color:rgba(239,68,68,0.2);">Alpha</span>
                        @else
                            <span class="meeting-badge" style="background:rgba(245,158,11,0.1);color:#fbbf24;border-color:rgba(245,158,11,0.2);animation:pulse-glow 2s infinite;">
                                <svg width="8" height="8" fill="#fbbf24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12"/></svg>
                                Absen
                            </span>
                        @endif
                    @endif
                </div>

                <button type="button" class="meeting-toggle-btn" @click.stop="expanded = !expanded">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" :class="expanded ? 'rotate-180' : ''" style="transition:transform .2s;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="meeting-body" x-show="expanded" x-transition style="display:none;">

                {{-- Attendance Section --}}
                @if($requiresAttendance)
                    @if($alreadyAbsen)
                        <div class="attendance-pill" style="background:rgba(16,185,129,0.07);border-color:rgba(16,185,129,0.18);">
                            <div class="attendance-icon" style="background:rgba(16,185,129,0.15);color:#34d399;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="attendance-content">
                                <div style="font-size:10px;font-weight:700;color:#34d399;margin-bottom:2px;">Absensi Tercatat</div>
                                <div style="font-size:11px;color:#94a3b8;line-height:1.4;">
                                    Status: <span style="font-weight:800;color:#f1f5f9;text-transform:capitalize;">{{ $absensiSiswa->status }}</span>
                                    @if($absensiSiswa->status_keterlambatan === 'tepat_waktu')
                                        <span style="color:#34d399;font-weight:700;"> · Tepat Waktu</span>
                                    @elseif($absensiSiswa->status_keterlambatan === 'terlambat')
                                        <span style="color:#fbbf24;font-weight:700;"> · Terlambat</span>
                                    @elseif($absensiSiswa->status_keterlambatan === 'sangat_terlambat')
                                        <span style="color:#f87171;font-weight:700;"> · Sangat Terlambat</span>
                                    @endif
                                    <span style="color:#475569;"> · {{ $absensiSiswa->waktu_absen->format('H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>
                    @elseif($exempted)
                        <div class="attendance-pill" style="background:rgba(59,130,246,0.07);border-color:rgba(59,130,246,0.18);">
                            <div class="attendance-icon" style="background:rgba(59,130,246,0.15);color:#60a5fa;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div style="font-size:11px;font-weight:600;color:#93c5fd;">Dispensasi — Dibebaskan dari absensi pertemuan ini</div>
                        </div>
                    @elseif($deadlinePassed)
                        <div class="attendance-pill" style="background:rgba(239,68,68,0.07);border-color:rgba(239,68,68,0.18);">
                            <div class="attendance-icon" style="background:rgba(239,68,68,0.15);color:#f87171;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            </div>
                            <div style="font-size:11px;font-weight:600;color:#fca5a5;line-height:1.5;">
                                Batas absensi terlewati — Kehadiran dicatat sebagai <span style="color:#f87171;font-weight:800;">ALPHA</span>
                            </div>
                        </div>
                    @else
                        <div class="attendance-cta">
                            <div class="attendance-cta-left">
                                <div class="attendance-cta-icon" style="background:rgba(239,68,68,0.15);color:#f87171;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/></svg>
                                </div>
                                <div class="attendance-cta-text">
                                    <div class="attendance-cta-title" style="color:#fca5a5;">Absensi Diperlukan</div>
                                    <div class="attendance-cta-desc" style="color:#f87171;">Lakukan absensi untuk mengakses konten</div>
                                </div>
                            </div>
                            <a href="{{ route('siswa.attendance.modal', ['pertemuan' => $pertemuan->id, 'redirect_to' => url()->current()]) }}"
                               class="attendance-cta-btn">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Absen Sekarang
                            </a>
                        </div>
                    @endif
                @endif

                {{-- Content Sections --}}
                @if($hasAnyContent)

                    {{-- Materi --}}
                    @if($hasMateri)
                    <div class="content-section">
                        <div class="sec-label" style="color:#60a5fa;">
                            <div class="sec-dot" style="background:#60a5fa;"></div>
                            Materi Pembelajaran
                        </div>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($pertemuan->materis as $materi)
                                @php
                                    $iconData = [
                                        'dokumen' => ['#60a5fa','rgba(59,130,246,0.15)','rgba(59,130,246,0.25)','M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                                        'video'   => ['#f472b6','rgba(244,114,182,0.15)','rgba(244,114,182,0.25)','M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z'],
                                        'link'    => ['#fbbf24','rgba(251,191,36,0.15)','rgba(251,191,36,0.25)','M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
                                    ];
                                    [$ic,$ib,$iborder,$ip] = $iconData[$materi->tipe_materi] ?? ['#94a3b8','rgba(148,163,184,0.12)','rgba(148,163,184,0.2)','M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z'];
                                    $isReleased = $materi->isReleased();
                                    $mStatus = $materi->status_label;
                                    [$sBg, $sTc, $sBorder] = match($mStatus) {
                                        'Belum Dirilis' => ['rgba(245,158,11,0.12)','#fbbf24','rgba(245,158,11,0.25)'],
                                        'Tersedia'      => ['rgba(16,185,129,0.12)','#34d399','rgba(16,185,129,0.25)'],
                                        'Berakhir'      => ['rgba(239,68,68,0.12)','#f87171','rgba(239,68,68,0.25)'],
                                        default         => ['rgba(99,102,241,0.12)','#818cf8','rgba(99,102,241,0.25)'],
                                    };
                                @endphp

                                @if($isReleased)
                                    @if($isGated)
                                        <a href="javascript:void(0)"
                                           onclick="Swal.fire({title:'Absensi Diperlukan',text:'Lakukan absensi pertemuan terlebih dahulu untuk membuka materi ini.',icon:'warning',confirmButtonText:'Absen Sekarang',showCancelButton:true,cancelButtonText:'Nanti'}).then(r=>{if(r.isConfirmed)window.location.href='{{ route('siswa.attendance.modal', ['pertemuan' => $pertemuan->id, 'redirect_to' => url()->current()]) }}'})"
                                           class="content-row locked"
                                           style="background:rgba(255,255,255,0.02);border-color:rgba(255,255,255,0.05);">
                                            <div class="content-row-icon" style="background:rgba(255,255,255,0.05);">
                                                <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <span class="content-row-title" style="color:#475569;">{{ $materi->judul }}</span>
                                            <span class="content-row-badge" style="background:rgba(255,255,255,0.05);color:#475569;border-color:rgba(255,255,255,0.08);">Terkunci</span>
                                        </a>
                                    @else
                                        <a href="{{ route('siswa.materi.show', $materi->id) . '?from=mapel&mapel_id=' . $mapel->id }}"
                                           class="content-row"
                                           style="background:rgba(59,130,246,0.05);border-color:rgba(59,130,246,0.14);"
                                           onmouseover="this.style.background='rgba(59,130,246,0.09)';this.style.borderColor='rgba(59,130,246,0.28)'"
                                           onmouseout="this.style.background='rgba(59,130,246,0.05)';this.style.borderColor='rgba(59,130,246,0.14)'">
                                            <div class="content-row-icon" style="background:{{ $ib }};border:1px solid {{ $iborder }};">
                                                <svg width="15" height="15" fill="none" stroke="{{ $ic }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ip }}"/></svg>
                                            </div>
                                            <div style="flex:1;min-width:0;">
                                                <div class="content-row-title">{{ $materi->judul }}</div>
                                            </div>
                                            <span class="content-row-badge" style="background:{{ $sBg }};color:{{ $sTc }};border-color:{{ $sBorder }};">{{ $mStatus }}</span>
                                            <svg width="13" height="13" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endif
                                @else
                                    <div x-data="{
                                            releaseTime:'{{ $materi->waktu_rilis }}',
                                            countdown:'',interval:null,
                                            updateCountdown(){
                                                if(!this.releaseTime)return;
                                                const r=new Date(this.releaseTime).getTime(),n=new Date().getTime(),d=r-n;
                                                if(d<0){this.countdown='Sedang dirilis...';clearInterval(this.interval);setTimeout(()=>location.reload(),2000);return;}
                                                const dy=Math.floor(d/(86400000)),h=Math.floor((d%86400000)/3600000),m=Math.floor((d%3600000)/60000),s=Math.floor((d%60000)/1000);
                                                let p=[];if(dy>0)p.push(dy+'h');if(h>0||dy>0)p.push(h+'j');if(m>0||h>0||dy>0)p.push(m+'m');p.push(s+'d');
                                                this.countdown=p.join(' ');
                                            }
                                        }" x-init="updateCountdown();interval=setInterval(()=>updateCountdown(),1000);"
                                        class="countdown-card"
                                        style="background:rgba(245,158,11,0.06);border-color:rgba(245,158,11,0.18);border-left-color:#f59e0b;">
                                        <div class="countdown-content">
                                            <div class="countdown-icon" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);">
                                                <svg width="15" height="15" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <div class="countdown-info">
                                                <div class="countdown-title">{{ $materi->judul }}</div>
                                                <div class="countdown-detail">
                                                    <span class="countdown-time">{{ \Carbon\Carbon::parse($materi->waktu_rilis)->format('d M Y, H:i') }}</span>
                                                    <div class="countdown-timer" x-text="countdown">Menghitung...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Tugas --}}
                    @if($hasTugas)
                    <div class="content-section">
                        <div class="sec-label" style="color:#fbbf24;">
                            <div class="sec-dot" style="background:#fbbf24;"></div>
                            Tugas / Penugasan
                        </div>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($pertemuan->tugas as $tugas)
                                @php
                                    $sub = \App\Models\PengumpulanTugas::where('id_tugas',$tugas->id)->where('id_siswa',$siswa->id)->first();
                                    $graded = $sub ? \App\Models\Penilaian::where('id_pengumpulan_tugas',$sub->id)->exists() : false;
                                    $isReleased = $tugas->isReleased();
                                    if ($sub && $graded)                                                                   { $bl='Dinilai';     $bbg='rgba(139,92,246,0.12)'; $btc='#a78bfa'; $bbo='rgba(139,92,246,0.25)'; }
                                    elseif ($sub)                                                                          { $bl='Dikumpulkan'; $bbg='rgba(59,130,246,0.12)';  $btc='#60a5fa'; $bbo='rgba(59,130,246,0.25)'; }
                                    elseif ($tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast())   { $bl='Terlewat';    $bbg='rgba(239,68,68,0.12)';   $btc='#f87171'; $bbo='rgba(239,68,68,0.25)'; }
                                    else                                                                                   { $bl='Belum';       $bbg='rgba(245,158,11,0.12)';  $btc='#fbbf24'; $bbo='rgba(245,158,11,0.25)'; }
                                @endphp

                                @if($isReleased)
                                    @if($isGated)
                                        <a href="javascript:void(0)"
                                           onclick="Swal.fire({title:'Absensi Diperlukan',text:'Lakukan absensi pertemuan terlebih dahulu untuk membuka tugas ini.',icon:'warning',confirmButtonText:'Absen Sekarang',showCancelButton:true,cancelButtonText:'Nanti'}).then(r=>{if(r.isConfirmed)window.location.href='{{ route('siswa.attendance.modal', ['pertemuan' => $pertemuan->id, 'redirect_to' => url()->current()]) }}'})"
                                           class="content-row locked"
                                           style="background:rgba(255,255,255,0.02);border-color:rgba(255,255,255,0.05);">
                                            <div class="content-row-icon" style="background:rgba(255,255,255,0.05);">
                                                <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <span class="content-row-title" style="color:#475569;">{{ $tugas->judul }}</span>
                                            <span class="content-row-badge" style="background:rgba(255,255,255,0.05);color:#475569;border-color:rgba(255,255,255,0.08);">Terkunci</span>
                                        </a>
                                    @else
                                        <a href="{{ route('siswa.tugas.show', $tugas->id) . '?from=mapel&mapel_id=' . $mapel->id }}"
                                           class="content-row"
                                           style="background:rgba(245,158,11,0.05);border-color:rgba(245,158,11,0.15);"
                                           onmouseover="this.style.background='rgba(245,158,11,0.09)';this.style.borderColor='rgba(245,158,11,0.3)'"
                                           onmouseout="this.style.background='rgba(245,158,11,0.05)';this.style.borderColor='rgba(245,158,11,0.15)'">
                                            <div class="content-row-icon" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);">
                                                <svg width="15" height="15" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                            </div>
                                            <div style="flex:1;min-width:0;">
                                                <div class="content-row-title">{{ $tugas->judul }}</div>
                                                @if($tugas->batas_waktu)
                                                <div class="content-row-subtitle">
                                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            <span class="content-row-badge" style="background:{{ $bbg }};color:{{ $btc }};border-color:{{ $bbo }};">{{ $bl }}</span>
                                            <svg width="13" height="13" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endif
                                @else
                                    <div x-data="{
                                            releaseTime:'{{ $tugas->waktu_rilis }}',
                                            countdown:'',interval:null,
                                            updateCountdown(){
                                                if(!this.releaseTime)return;
                                                const r=new Date(this.releaseTime).getTime(),n=new Date().getTime(),d=r-n;
                                                if(d<0){this.countdown='Sedang dirilis...';clearInterval(this.interval);setTimeout(()=>location.reload(),2000);return;}
                                                const dy=Math.floor(d/(86400000)),h=Math.floor((d%86400000)/3600000),m=Math.floor((d%3600000)/60000),s=Math.floor((d%60000)/1000);
                                                let p=[];if(dy>0)p.push(dy+'h');if(h>0||dy>0)p.push(h+'j');if(m>0||h>0||dy>0)p.push(m+'m');p.push(s+'d');
                                                this.countdown=p.join(' ');
                                            }
                                        }" x-init="updateCountdown();interval=setInterval(()=>updateCountdown(),1000);"
                                        class="countdown-card"
                                        style="background:rgba(245,158,11,0.06);border-color:rgba(245,158,11,0.18);border-left-color:#f59e0b;">
                                        <div class="countdown-content">
                                            <div class="countdown-icon" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);">
                                                <svg width="15" height="15" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <div class="countdown-info">
                                                <div class="countdown-title">{{ $tugas->judul }}</div>
                                                <div class="countdown-detail">
                                                    <span class="countdown-time">{{ \Carbon\Carbon::parse($tugas->waktu_rilis)->format('d M Y, H:i') }}</span>
                                                    <div class="countdown-timer" x-text="countdown">Menghitung...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Kuis --}}
                    @if($hasKuis)
                    <div class="content-section">
                        <div class="sec-label" style="color:#a78bfa;">
                            <div class="sec-dot" style="background:#a78bfa;"></div>
                            Kuis / Ujian Online
                        </div>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($pertemuan->kuis as $kuis)
                                @php
                                    $hasilKuis = $kuis->HasilKuis->first();
                                    $isReleased = $kuis->isReleased();
                                    $kStatus = $kuis->status_label;
                                    [$kBg,$kTc,$kBo] = match($kStatus) {
                                        'Tersedia' => ['rgba(16,185,129,0.12)','#34d399','rgba(16,185,129,0.25)'],
                                        'Berakhir' => ['rgba(239,68,68,0.12)','#f87171','rgba(239,68,68,0.25)'],
                                        default    => ['rgba(245,158,11,0.12)','#fbbf24','rgba(245,158,11,0.25)'],
                                    };
                                @endphp

                                @if($isReleased)
                                    @if($isGated)
                                        <a href="javascript:void(0)"
                                           onclick="Swal.fire({title:'Absensi Diperlukan',text:'Lakukan absensi pertemuan terlebih dahulu untuk membuka kuis ini.',icon:'warning',confirmButtonText:'Absen Sekarang',showCancelButton:true,cancelButtonText:'Nanti'}).then(r=>{if(r.isConfirmed)window.location.href='{{ route('siswa.attendance.modal', ['pertemuan' => $pertemuan->id, 'redirect_to' => url()->current()]) }}'})"
                                           class="content-row locked"
                                           style="background:rgba(255,255,255,0.02);border-color:rgba(255,255,255,0.05);">
                                            <div class="content-row-icon" style="background:rgba(255,255,255,0.05);">
                                                <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <span class="content-row-title" style="color:#475569;">{{ $kuis->judul }}</span>
                                            <span class="content-row-badge" style="background:rgba(255,255,255,0.05);color:#475569;border-color:rgba(255,255,255,0.08);">Terkunci</span>
                                        </a>
                                    @else
                                        <a href="{{ $hasilKuis ? route('siswa.kuis.hasil', $kuis->id) . '?from=mapel&mapel_id=' . $mapel->id : route('siswa.kuis.show', $kuis->id) . '?from=mapel&mapel_id=' . $mapel->id }}"
                                           class="content-row"
                                           style="background:rgba(139,92,246,0.05);border-color:rgba(139,92,246,0.15);"
                                           onmouseover="this.style.background='rgba(139,92,246,0.09)';this.style.borderColor='rgba(139,92,246,0.3)'"
                                           onmouseout="this.style.background='rgba(139,92,246,0.05)';this.style.borderColor='rgba(139,92,246,0.15)'">
                                            <div class="content-row-icon" style="background:rgba(139,92,246,0.12);border:1px solid rgba(139,92,246,0.25);">
                                                <svg width="15" height="15" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                                            </div>
                                            <div style="flex:1;min-width:0;">
                                                <div class="content-row-title">{{ $kuis->judul }}</div>
                                                @if($kuis->durasi)
                                                <div class="content-row-subtitle">
                                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                    {{ $kuis->durasi }} menit
                                                </div>
                                                @endif
                                            </div>
                                            @if($hasilKuis)
                                                <span class="content-row-badge" style="background:rgba(16,185,129,0.12);color:#34d399;border-color:rgba(16,185,129,0.25);">Nilai: {{ $hasilKuis->nilai }}</span>
                                            @else
                                                <span class="content-row-badge" style="background:{{ $kBg }};color:{{ $kTc }};border-color:{{ $kBo }};">{{ $kStatus }}</span>
                                            @endif
                                            <svg width="13" height="13" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endif
                                @else
                                    <div x-data="{
                                            releaseTime:'{{ $kuis->waktu_rilis }}',
                                            countdown:'',interval:null,
                                            updateCountdown(){
                                                if(!this.releaseTime)return;
                                                const r=new Date(this.releaseTime).getTime(),n=new Date().getTime(),d=r-n;
                                                if(d<0){this.countdown='Sedang dirilis...';clearInterval(this.interval);setTimeout(()=>location.reload(),2000);return;}
                                                const dy=Math.floor(d/(86400000)),h=Math.floor((d%86400000)/3600000),m=Math.floor((d%3600000)/60000),s=Math.floor((d%60000)/1000);
                                                let p=[];if(dy>0)p.push(dy+'h');if(h>0||dy>0)p.push(h+'j');if(m>0||h>0||dy>0)p.push(m+'m');p.push(s+'d');
                                                this.countdown=p.join(' ');
                                            }
                                        }" x-init="updateCountdown();interval=setInterval(()=>updateCountdown(),1000);"
                                        class="countdown-card"
                                        style="background:rgba(139,92,246,0.06);border-color:rgba(139,92,246,0.18);border-left-color:#a78bfa;">
                                        <div class="countdown-content">
                                            <div class="countdown-icon" style="background:rgba(139,92,246,0.12);border:1px solid rgba(139,92,246,0.25);">
                                                <svg width="15" height="15" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            </div>
                                            <div class="countdown-info">
                                                <div class="countdown-title" style="color:#c4b5fd;">{{ $kuis->judul }}</div>
                                                <div class="countdown-detail">
                                                    <span class="countdown-time" style="color:#6d28d9;">{{ \Carbon\Carbon::parse($kuis->waktu_rilis)->format('d M Y, H:i') }}</span>
                                                    <div class="countdown-timer" x-text="countdown" style="color:#7c3aed;background:rgba(124,58,237,0.1);">Menghitung...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                @else
                    <div class="empty-state">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 12px;color:#c9982a;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        <div class="empty-title">Belum ada konten</div>
                        <div class="empty-desc">Materi, tugas, dan kuis akan ditampilkan di sini setelah dirilis oleh guru</div>
                    </div>
                @endif

            </div>
        </div>
        @endforeach
        
        {{-- Pagination --}}
        @if($pertemuans->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Menampilkan {{ $pertemuans->firstItem() ?? 0 }} - {{ $pertemuans->lastItem() ?? 0 }} dari {{ $pertemuans->total() }} pertemuan
                </div>
                <nav class="pagination-nav">
                    @if ($pertemuans->onFirstPage())
                        <span class="disabled">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $pertemuans->previousPageUrl() }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    @foreach ($pertemuans->getUrlRange(1, $pertemuans->lastPage()) as $page => $url)
                        @if ($page == $pertemuans->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($pertemuans->hasMorePages())
                        <a href="{{ $pertemuans->nextPageUrl() }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="disabled">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    @else
        <div class="empty-state" style="margin-top:20px;">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <div class="empty-title">Belum ada pertemuan</div>
            <div class="empty-desc">Pertemuan akan ditampilkan di sini setelah guru menambahkannya ke kelas ini</div>
        </div>
    @endif

</div>

</x-student-layout>
