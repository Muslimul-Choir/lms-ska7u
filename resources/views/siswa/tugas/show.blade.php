<x-app-layout>

<style>
/* ── Tugas Show – Mobile-First ── */
.ts-root {
    --brand:      #5c1020;
    --surface:    #ffffff;
    --bg:         #f4f6fb;
    --text:       #1a1f36;
    --muted:      #6b7280;
    --radius-lg:  16px;
    --radius-md:  12px;
    --shadow:     0 2px 12px rgba(0,0,0,.07);
    background: var(--bg);
    min-height: 100vh;
    padding-bottom: 32px;
}

/* Top bar */
.ts-topbar {
    background: linear-gradient(135deg, var(--brand) 0%, #8b1a30 100%);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 10;
}
.ts-back-btn {
    display: flex; align-items: center; justify-content: center;
    width: 36px; height: 36px;
    background: rgba(255,255,255,.15);
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    flex-shrink: 0;
    transition: background .2s;
}
.ts-back-btn:hover { background: rgba(255,255,255,.28); }
.ts-topbar-title { font-size: 15px; font-weight: 700; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* Body */
.ts-body {
    padding: 16px;
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
@media (min-width: 640px) { .ts-body { padding: 24px; } }

/* Card */
.ts-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ts-card-body { padding: 20px; }

/* Status badge big */
.ts-status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px; font-weight: 700;
    margin-bottom: 12px;
}

/* Title */
.ts-title {
    font-size: clamp(18px, 4vw, 26px);
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
    margin-bottom: 14px;
}

/* Info grid */
.ts-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}
@media (min-width: 480px) { .ts-info-grid { grid-template-columns: repeat(4, 1fr); } }
.ts-info-cell {
    background: #f8faff;
    border-radius: 10px;
    padding: 10px 12px;
}
.ts-info-label { font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 3px; }
.ts-info-val   { font-size: 13px; font-weight: 700; color: var(--text); }

/* Section heading inside card */
.ts-section-head {
    font-size: 13px; font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 14px 20px 0;
    margin-bottom: -4px;
}

/* Countdown / deadline strip */
.ts-deadline-strip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 600;
}

/* Prose */
.ts-prose { font-size: 14px; line-height: 1.75; color: #374151; }
.ts-prose h2,.ts-prose h3,.ts-prose h4 { font-weight:700;color:var(--text);margin:16px 0 8px; }
.ts-prose a { color:#2563eb;text-decoration:underline; }
.ts-prose code { background:#f3f4f6;padding:2px 5px;border-radius:4px;font-family:monospace;font-size:13px; }
.ts-prose pre { background:#1f2937;color:#f3f4f6;padding:14px;border-radius:10px;overflow-x:auto;font-size:13px; }

/* File block */
.ts-file-block {
    display: flex; align-items: center; gap: 12px;
    background: #f8faff; border: 1.5px solid #dbeafe;
    border-radius: var(--radius-md); padding: 14px 16px;
}
.ts-file-icon { font-size: 30px; flex-shrink: 0; }
.ts-file-info { flex: 1; min-width: 0; }
.ts-file-name { font-size: 13px; font-weight: 600; color: var(--text); word-break: break-all; }
.ts-file-sub  { font-size: 11px; color: var(--muted); margin-top: 2px; }
.ts-file-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 14px;
    background: #2563eb; color: #fff;
    border-radius: 10px;
    font-size: 13px; font-weight: 700;
    text-decoration: none; white-space: nowrap; flex-shrink: 0;
    transition: background .2s;
}
.ts-file-btn:hover { background: #1d4ed8; }

/* Video */
.ts-video-wrap { background:#000; border-radius:10px; overflow:hidden; aspect-ratio:16/9; margin-bottom:12px; }
.ts-video-wrap video { width:100%; height:100%; display:block; }

/* Link btn */
.ts-link-btn {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    padding: 14px 18px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff; border-radius: var(--radius-md);
    text-decoration: none; font-size: 14px; font-weight: 700;
    word-break: break-all; transition: opacity .2s;
}
.ts-link-btn:hover { opacity: .9; }

/* Score display */
.ts-score-row {
    display: flex; gap: 16px; margin-bottom: 14px; flex-wrap: wrap;
}
.ts-score-box {
    flex: 1; min-width: 100px;
    background: #f8faff; border-radius: var(--radius-md); padding: 14px;
    text-align: center;
}
.ts-score-label { font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
.ts-score-val   { font-size: 32px; font-weight: 900; line-height: 1; }

/* Progress bar */
.ts-progress-wrap { margin-bottom: 6px; }
.ts-progress-bg { height: 10px; background: #e5e7eb; border-radius: 999px; overflow: hidden; }
.ts-progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #7c3aed, #a855f7); transition: width .6s ease; }
.ts-progress-label { text-align: right; font-size: 12px; font-weight: 700; color: #7c3aed; margin-top: 4px; }

/* Alert block */
.ts-alert {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 14px 16px;
    border-radius: var(--radius-md);
    font-size: 13px;
}
.ts-alert-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
</style>

<div class="ts-root">

    {{-- ── TOP BAR ── --}}
    <div class="ts-topbar">
        <a href="{{ route('siswa.dashboard') }}" class="ts-back-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <span class="ts-topbar-title">{{ $tugas->judul }}</span>
    </div>

    {{-- ── BODY ── --}}
    <div class="ts-body">

        {{-- ── Header card ── --}}
        <div class="ts-card">
            <div class="ts-card-body">

                @php
                    $isPast   = $tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast();
                    if ($submission && $assessment) {
                        $sLabel='✓ Sudah Dinilai';       $sBg='#dcfce7'; $sText='#166534';
                    } elseif ($submission) {
                        $sLabel='✓ Sudah Dikumpulkan';   $sBg='#dbeafe'; $sText='#1d4ed8';
                    } elseif ($isPast) {
                        $sLabel='⏰ Waktu Terlewat';      $sBg='#fee2e2'; $sText='#991b1b';
                    } else {
                        $sLabel='⏳ Menunggu Pengumpulan';$sBg='#fef3c7'; $sText='#92400e';
                    }
                @endphp

                <div class="ts-status-badge" style="background:{{ $sBg }};color:{{ $sText }};">
                    {{ $sLabel }}
                </div>

                <h1 class="ts-title">{{ $tugas->judul }}</h1>

                <div class="ts-info-grid">
                    <div class="ts-info-cell">
                        <div class="ts-info-label">Mata Pelajaran</div>
                        <div class="ts-info-val">{{ $tugas->guruMapel?->Mapel?->nama_mapel }}</div>
                    </div>
                    <div class="ts-info-cell">
                        <div class="ts-info-label">Pengajar</div>
                        <div class="ts-info-val">{{ $tugas->guruMapel?->Guru?->nama_lengkap }}</div>
                    </div>
                    <div class="ts-info-cell">
                        <div class="ts-info-label">Tipe</div>
                        <div class="ts-info-val">{{ ucfirst($tugas->tipe_tugas) }}</div>
                    </div>
                    <div class="ts-info-cell">
                        <div class="ts-info-label">Nilai Maks.</div>
                        <div class="ts-info-val" style="color:#7c3aed;">{{ $tugas->nilai_maksimal }}</div>
                    </div>
                </div>

                @if($tugas->batas_waktu)
                    <div class="ts-deadline-strip mt-3"
                         style="background:{{ $isPast ? '#fee2e2' : '#f0fdf4' }};color:{{ $isPast ? '#991b1b' : '#166534' }};">
                        <span style="font-size:20px;">{{ $isPast ? '⏰' : '📅' }}</span>
                        <div>
                            <div>Batas Waktu: <strong>{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</strong></div>
                            <div style="font-size:12px;opacity:.8;">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->diffForHumans() }}</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- ── Deskripsi Tugas ── --}}
        @if($tugas->deskripsi)
        <div class="ts-card">
            <div class="ts-section-head">📋 Deskripsi Tugas</div>
            <div class="ts-card-body ts-prose">{!! $tugas->deskripsi !!}</div>
        </div>
        @endif

        {{-- ── File/Link Tugas ── --}}
        @if($tugas->file_url)
        <div class="ts-card">
            <div class="ts-section-head">
                @if($tugas->tipe_file === 'video') 🎥 Video Tugas
                @elseif($tugas->tipe_file === 'link') 🔗 Tautan Tugas
                @else 📄 Dokumen Tugas
                @endif
            </div>
            <div class="ts-card-body">
                @if($tugas->tipe_file === 'video')
                    <div class="ts-video-wrap">
                        <video controls>
                            <source src="{{ asset($tugas->file_url) }}" type="video/mp4">
                            Browser Anda tidak mendukung video HTML5.
                        </video>
                    </div>
                    <div class="ts-file-block">
                        <span class="ts-file-icon">🎥</span>
                        <div class="ts-file-info">
                            <div class="ts-file-name">{{ basename($tugas->file_url) }}</div>
                            <div class="ts-file-sub">File Video</div>
                        </div>
                        <a href="{{ asset($tugas->file_url) }}" download class="ts-file-btn">⬇️ Unduh</a>
                    </div>
                @elseif($tugas->tipe_file === 'link')
                    <a href="{{ $tugas->file_url }}" target="_blank" rel="noopener noreferrer" class="ts-link-btn">
                        <span>🔗 Buka Tautan</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <div class="ts-file-block">
                        <span class="ts-file-icon">📄</span>
                        <div class="ts-file-info">
                            <div class="ts-file-name">{{ basename($tugas->file_url) }}</div>
                            <div class="ts-file-sub">File PDF / Dokumen</div>
                        </div>
                        <a href="{{ asset($tugas->file_url) }}" download class="ts-file-btn">⬇️ Unduh</a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ── Status Pengumpulan ── --}}
        <div class="ts-card">
            <div class="ts-section-head">📤 Status Pengumpulan</div>
            <div class="ts-card-body">

                @if($submission)
                    {{-- Sudah dikumpulkan --}}
                    <div class="ts-alert" style="background:#f0fdf4;border:1.5px solid #bbf7d0;margin-bottom:14px;">
                        <span class="ts-alert-icon">✅</span>
                        <div>
                            <div style="font-weight:700;color:#166534;margin-bottom:2px;">Tugas Sudah Dikumpulkan</div>
                            <div style="color:#15803d;">{{ $submission->created_at->format('d M Y, H:i') }}</div>
                            @if($submission->catatan)
                                <div style="margin-top:6px;color:#374151;font-style:italic;">"{{ $submission->catatan }}"</div>
                            @endif
                        </div>
                    </div>

                    @if($submission->file_url)
                        <div class="ts-file-block" style="margin-bottom:14px;">
                            <span class="ts-file-icon">📎</span>
                            <div class="ts-file-info">
                                <div class="ts-file-name">File yang dikumpulkan</div>
                                <div class="ts-file-sub">{{ basename($submission->file_url) }}</div>
                            </div>
                            <a href="{{ asset($submission->file_url) }}" download class="ts-file-btn">⬇️ Lihat</a>
                        </div>
                    @endif

                    @if($assessment)
                        {{-- Sudah dinilai --}}
                        <div style="background:#faf5ff;border:1.5px solid #e9d5ff;border-radius:var(--radius-md);padding:16px;">
                            <div style="font-size:13px;font-weight:700;color:#6b21a8;margin-bottom:12px;">📊 Hasil Penilaian</div>

                            <div class="ts-score-row">
                                <div class="ts-score-box">
                                    <div class="ts-score-label">Nilai Anda</div>
                                    <div class="ts-score-val" style="color:#7c3aed;">{{ number_format($assessment->nilai,1) }}</div>
                                </div>
                                <div class="ts-score-box">
                                    <div class="ts-score-label">Maksimal</div>
                                    <div class="ts-score-val" style="color:#6b7280;">{{ number_format($assessment->nilai_maksimal_snapshot,1) }}</div>
                                </div>
                            </div>

                            <div class="ts-progress-wrap">
                                <div class="ts-progress-bg">
                                    <div class="ts-progress-fill" style="width:{{ min(($assessment->nilai/$assessment->nilai_maksimal_snapshot)*100,100) }}%;"></div>
                                </div>
                                <div class="ts-progress-label">{{ number_format(($assessment->nilai/$assessment->nilai_maksimal_snapshot)*100,1) }}%</div>
                            </div>

                            @if($assessment->catatan_guru)
                                <div style="background:#fff;border:1px solid #e9d5ff;border-radius:8px;padding:12px;margin-top:10px;">
                                    <div style="font-size:12px;font-weight:700;color:#6b21a8;margin-bottom:4px;">Catatan Pengajar</div>
                                    <div style="font-size:13px;color:#374151;">{{ $assessment->catatan_guru }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        {{-- Menunggu penilaian --}}
                        <div class="ts-alert" style="background:#fefce8;border:1.5px solid #fef08a;">
                            <span class="ts-alert-icon">⏳</span>
                            <div style="color:#854d0e;">
                                <strong>Menunggu Penilaian</strong><br>
                                <span style="font-size:12px;">Tugas Anda sedang diperiksa oleh pengajar. Cek kembali nanti.</span>
                            </div>
                        </div>
                    @endif

                @else
                    {{-- Belum dikumpulkan --}}
                    @if($isPast)
                        <div class="ts-alert" style="background:#fff1f2;border:1.5px solid #fecdd3;">
                            <span class="ts-alert-icon">⏰</span>
                            <div style="color:#9f1239;">
                                <strong>Batas Waktu Sudah Terlewat</strong><br>
                                <span style="font-size:12px;">Terlewat pada {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</span>
                                @if($tugas->allow_late ?? false)
                                    <br><span style="font-size:12px;color:#c026d3;">Pengajar masih memperbolehkan pengumpulan terlambat.</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="ts-alert" style="background:#fffbeb;border:1.5px solid #fde68a;">
                            <span class="ts-alert-icon">📬</span>
                            <div style="color:#92400e;">
                                <strong>Belum Dikumpulkan</strong><br>
                                <span style="font-size:12px;">Hubungi pengajar Anda untuk informasi cara pengumpulan tugas.</span>
                                @if($tugas->batas_waktu)
                                    <div style="margin-top:6px;font-weight:700;">⏰ Batas: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>

        {{-- ── Kembali ── --}}
        <a href="{{ route('siswa.dashboard') }}"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow);font-size:14px;font-weight:700;color:#374151;text-decoration:none;">
            ← Kembali ke Dashboard
        </a>

    </div>
</div>

</x-app-layout>