<x-app-layout>

<style>
/* ── Siswa Dashboard – Mobile-First Premium Design ── */
.sd-root {
    --brand:        #5c1020;
    --brand-light:  #7a1a2e;
    --gold:         #d4a017;
    --gold-light:   #f5c842;
    --surface:      #ffffff;
    --bg:           #f4f6fb;
    --text:         #1a1f36;
    --muted:        #6b7280;
    --radius-lg:    16px;
    --radius-md:    12px;
    --shadow-card:  0 2px 12px rgba(0,0,0,.07);
    --shadow-hover: 0 6px 24px rgba(0,0,0,.12);
    min-height: 100vh;
    background: var(--bg);
    padding-bottom: 24px;
}

/* Hero Banner */
.sd-hero {
    background: linear-gradient(135deg, var(--brand) 0%, #8b1a30 60%, #a82040 100%);
    padding: 24px 20px 48px;
    position: relative;
    overflow: hidden;
}
.sd-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
}
.sd-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -30px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(212,160,23,.10);
}
.sd-hero-inner { position: relative; z-index: 1; max-width: 600px; }
.sd-greeting {
    font-size: 13px;
    font-weight: 600;
    color: var(--gold-light);
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.sd-name {
    font-size: clamp(20px, 5vw, 28px);
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 6px;
}
.sd-meta {
    font-size: 13px;
    color: rgba(255,255,255,.7);
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}
.sd-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(4px);
    border-radius: 999px;
    padding: 2px 10px;
    font-size: 12px;
    color: #fff;
}

/* Stats strip – floats over hero */
.sd-stats-strip {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 0 16px;
    margin-top: -36px;
    position: relative;
    z-index: 2;
}
@media (min-width: 640px) {
    .sd-stats-strip { grid-template-columns: repeat(4, 1fr); padding: 0 24px; }
}
@media (min-width: 1024px) {
    .sd-stats-strip { padding: 0 32px; }
}

.sd-stat-card {
    background: var(--surface);
    border-radius: var(--radius-md);
    padding: 14px 14px 10px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: transform .2s, box-shadow .2s;
}
.sd-stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
.sd-stat-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    margin-bottom: 4px;
}
.sd-stat-val {
    font-size: 26px;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
}
.sd-stat-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .04em;
}
.sd-stat-sub {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 6px;
    padding-top: 8px;
    border-top: 1px solid #f0f0f0;
}
.sd-stat-sub span {
    font-size: 11px;
    padding: 1px 7px;
    border-radius: 999px;
    font-weight: 600;
}

/* Content area */
.sd-body {
    padding: 24px 16px 0;
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
@media (min-width: 640px) { .sd-body { padding: 24px 24px 0; } }
@media (min-width: 1024px) { .sd-body { padding: 24px 32px 0; } }

/* Section card */
.sd-section {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.sd-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f7;
}
.sd-section-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 8px;
}
.sd-section-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
}

/* Task items */
.sd-task-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid #f4f6fb;
    transition: background .15s;
    text-decoration: none;
}
.sd-task-item:last-child { border-bottom: none; }
.sd-task-item:hover { background: #f9fafc; }

.sd-task-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 5px;
}
.sd-task-body { flex: 1; min-width: 0; }
.sd-task-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sd-task-meta {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.sd-task-badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}
.sd-arrow {
    flex-shrink: 0;
    width: 20px; height: 20px;
    color: var(--muted);
    margin-top: 2px;
}

/* Materi items */
.sd-materi-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 20px;
    border-bottom: 1px solid #f4f6fb;
    transition: background .15s;
    text-decoration: none;
}
.sd-materi-item:last-child { border-bottom: none; }
.sd-materi-item:hover { background: #f9fafc; }
.sd-materi-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
}
.sd-materi-body { flex: 1; min-width: 0; }
.sd-materi-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sd-materi-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }

/* Grade bar items */
.sd-grade-item {
    padding: 13px 20px;
    border-bottom: 1px solid #f4f6fb;
}
.sd-grade-item:last-child { border-bottom: none; }
.sd-grade-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
}
.sd-grade-name { font-size: 13px; font-weight: 600; color: var(--text); }
.sd-grade-score { font-size: 16px; font-weight: 800; color: #7c3aed; }
.sd-grade-bar-bg {
    height: 6px;
    background: #e9eaf0;
    border-radius: 999px;
    overflow: hidden;
}
.sd-grade-bar-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #7c3aed, #a855f7);
    transition: width .6s ease;
}
.sd-grade-date { font-size: 11px; color: var(--muted); margin-top: 4px; }

/* Info card */
.sd-info-card {
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    border: 1px solid #dbeafe;
    border-radius: var(--radius-md);
    padding: 16px 20px;
}
.sd-info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(219,234,254,.6);
    font-size: 13px;
    color: #1e3a5f;
}
.sd-info-row:last-child { border-bottom: none; }
.sd-info-row-icon { font-size: 16px; flex-shrink: 0; }

/* Empty state */
.sd-empty {
    padding: 36px 20px;
    text-align: center;
    color: var(--muted);
    font-size: 13px;
}
.sd-empty-emoji { font-size: 36px; display: block; margin-bottom: 8px; }

/* Quick actions row */
.sd-quick-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    padding: 16px 20px;
}
.sd-quick-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 14px 8px;
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    text-align: center;
}
.sd-quick-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.15); }
.sd-quick-btn span { font-size: 24px; }
</style>

<div class="sd-root">

    {{-- ══ HERO ══ --}}
    <div class="sd-hero">
        <div class="sd-hero-inner">
            <p class="sd-greeting">👋 Selamat Datang</p>
            <h1 class="sd-name">{{ $siswa->nama_lengkap }}</h1>
            <div class="sd-meta">
                @if($kelas)
                    <span class="sd-meta-chip">
                        <svg class="w-3.5 h-3.5 mr-1 text-[#f5c842]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18v3H3V3z" />
                        </svg>
                        {{ $kelas->nama_kelas }}
                    </span>
                    @if($kelas->Jurusan)
                        <span class="sd-meta-chip">
                            <svg class="w-3.5 h-3.5 mr-1 text-[#f5c842]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            {{ $kelas->Jurusan->nama_jurusan }}
                        </span>
                    @endif
                    @if($kelas->Tingkatan)
                        <span class="sd-meta-chip">
                            <svg class="w-3.5 h-3.5 mr-1 text-[#f5c842]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M12 21v-3.41" />
                            </svg>
                            {{ $kelas->Tingkatan->nama_tingkatan }}
                        </span>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- ══ STATS STRIP ══ --}}
    <div class="sd-stats-strip">
        {{-- Kehadiran --}}
        <div class="sd-stat-card">
            <div class="sd-stat-icon" style="background:#dbeafe;">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="sd-stat-val">{{ $absensiSummary['hadir'] }}</div>
            <div class="sd-stat-label">Hadir Bulan Ini</div>
            <div class="sd-stat-sub">
                <span style="background:#fef3c7;color:#92400e;">Izin: {{ $absensiSummary['izin'] }}</span>
                <span style="background:#fee2e2;color:#991b1b;">Alpha: {{ $absensiSummary['alpha'] }}</span>
            </div>
        </div>

        {{-- Tugas --}}
        <div class="sd-stat-card">
            <div class="sd-stat-icon" style="background:#fef9c3;">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25h3c.9 0 1.671.531 2.025 1.286m-5.125 0a2.237 2.237 0 011.25-.375h3c.487 0 .939.155 1.305.42M10.5 4.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div class="sd-stat-val">{{ count($tugasProgress) }}</div>
            <div class="sd-stat-label">Tugas Aktif</div>
            <div class="sd-stat-sub">
                <span style="background:#dcfce7;color:#166534;">✓ {{ collect($tugasProgress)->where('status','submitted')->count() }}</span>
                <span style="background:#fee2e2;color:#991b1b;">✗ {{ collect($tugasProgress)->where('status','not_submitted')->count() }}</span>
            </div>
        </div>

        {{-- Materi --}}
        <div class="sd-stat-card">
            <div class="sd-stat-icon" style="background:#dcfce7;">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div class="sd-stat-val">{{ count($materi) }}</div>
            <div class="sd-stat-label">Materi</div>
            <div class="sd-stat-sub">
                <span style="background:#f0fdf4;color:#166534;">Total tersedia</span>
            </div>
        </div>

        {{-- Nilai --}}
        <div class="sd-stat-card">
            <div class="sd-stat-icon" style="background:#ede9fe;">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 0 0-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 0 0-.217-.669s-3.07-2.993-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 0 0 .566-.411l1.9-3.847Z" />
                </svg>
            </div>
            <div class="sd-stat-val">{{ number_format($nilaiStats['average_grade'],1) }}</div>
            <div class="sd-stat-label">Rata-rata Nilai</div>
            <div class="sd-stat-sub">
                <span style="background:#ede9fe;color:#5b21b6;">Max: {{ number_format($nilaiStats['highest_grade'],1) }}</span>
            </div>
        </div>
    </div>

    {{-- ══ BODY ══ --}}
    <div class="sd-body">

        {{-- ── Quick Actions ── --}}
        <div class="sd-section">
            <div class="sd-section-header">
                <div class="sd-section-title">
                    <div class="sd-section-icon" style="background:#fef9c3;">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    Menu Cepat
                </div>
            </div>
            <div class="sd-quick-row">
                <a href="{{ route('siswa.dashboard') }}" class="sd-quick-btn" style="background:linear-gradient(135deg,#2563eb,#3b82f6);">
                    <svg class="w-6 h-6 mb-1 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="#tugas-section" class="sd-quick-btn" style="background:linear-gradient(135deg,#d97706,#f59e0b);">
                    <svg class="w-6 h-6 mb-1 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Tugas Saya
                </a>
                <a href="#materi-section" class="sd-quick-btn" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                    <svg class="w-6 h-6 mb-1 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Materi
                </a>
                <a href="#nilai-section" class="sd-quick-btn" style="background:linear-gradient(135deg,#7c3aed,#a855f7);">
                    <svg class="w-6 h-6 mb-1 text-purple-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Nilai
                </a>
            </div>
        </div>

        {{-- ── Tugas Saya ── --}}
        <div class="sd-section" id="tugas-section">
            <div class="sd-section-header">
                <div class="sd-section-title">
                    <div class="sd-section-icon" style="background:#fef9c3;">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    Tugas Saya
                </div>
                <span style="font-size:12px;color:#6b7280;font-weight:600;">{{ count($tugasProgress) }} tugas</span>
            </div>

            @if(count($tugasProgress) > 0)
                @foreach($tugasProgress as $item)
                    @php
                        $task    = $item['task'];
                        $overdue = $task->batas_waktu && \Carbon\Carbon::parse($task->batas_waktu)->isPast() && $item['status'] === 'not_submitted';

                        if ($item['status'] === 'submitted' && $item['assessment']) {
                            $dotColor   = '#22c55e'; $badgeBg = '#dcfce7'; $badgeText = '#166534'; $badgeLabel = 'Dinilai';
                        } elseif ($item['status'] === 'submitted') {
                            $dotColor   = '#3b82f6'; $badgeBg = '#dbeafe'; $badgeText = '#1d4ed8'; $badgeLabel = 'Dikumpulkan';
                        } elseif ($overdue) {
                            $dotColor   = '#ef4444'; $badgeBg = '#fee2e2'; $badgeText = '#991b1b'; $badgeLabel = 'Terlambat';
                        } else {
                            $dotColor   = '#f59e0b'; $badgeBg = '#fef3c7'; $badgeText = '#92400e'; $badgeLabel = 'Menunggu';
                        }
                    @endphp
                    <a href="{{ route('siswa.tugas.show', $task->id) }}" class="sd-task-item">
                        <div class="sd-task-dot" style="background:{{ $dotColor }};"></div>
                        <div class="sd-task-body">
                            <div class="sd-task-title">{{ $task->judul }}</div>
                            <div class="sd-task-meta">
                                @if($task->batas_waktu)
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($task->batas_waktu)->format('d M Y') }}
                                    </span>
                                @endif
                                <span>Maks: {{ $task->nilai_maksimal }}</span>
                                @if($item['assessment'])
                                    <span style="color:#7c3aed;font-weight:700;">Nilai: {{ $item['assessment']->nilai }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="sd-task-badge" style="background:{{ $badgeBg }};color:{{ $badgeText }};">{{ $badgeLabel }}</span>
                        <svg class="sd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            @else
                <div class="sd-empty">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Belum ada tugas untuk kelas Anda saat ini.
                </div>
            @endif
        </div>

        {{-- ── Materi Pembelajaran ── --}}
        <div class="sd-section" id="materi-section">
            <div class="sd-section-header">
                <div class="sd-section-title">
                    <div class="sd-section-icon" style="background:#dcfce7;">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    Materi Pembelajaran
                </div>
                <span style="font-size:12px;color:#6b7280;font-weight:600;">{{ count($materi) }} materi</span>
            </div>

            @if(count($materi) > 0)
                @foreach($materi->take(6) as $m)
                    @php
                        $icoColor = ['dokumen' => '#dbeafe', 'video' => '#fce7f3', 'link' => '#fef3c7'][$m->tipe_materi] ?? '#f0f9ff';
                    @endphp
                    <a href="{{ route('siswa.materi.show', $m->id) }}" class="sd-materi-item">
                        <div class="sd-materi-icon" style="background:{{ $icoColor }};">
                            @if($m->tipe_materi === 'dokumen')
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            @elseif($m->tipe_materi === 'video')
                                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 12l-7.5 4.5v-9l7.5 4.5z" />
                                </svg>
                            @elseif($m->tipe_materi === 'link')
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z" />
                                </svg>
                            @endif
                        </div>
                        <div class="sd-materi-body">
                            <div class="sd-materi-title">{{ $m->judul }}</div>
                            <div class="sd-materi-sub">{{ $m->created_at->format('d M Y') }}</div>
                        </div>
                        <svg class="sd-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
                @if(count($materi) > 6)
                    <div class="sd-empty" style="padding:12px 20px;border-top:1px solid #f4f6fb;">
                        +{{ count($materi) - 6 }} materi lainnya tersedia
                    </div>
                @endif
            @else
                <div class="sd-empty">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Belum ada materi pembelajaran.
                </div>
            @endif
        </div>

        {{-- ── Penilaian Terbaru ── --}}
        <div class="sd-section" id="nilai-section">
            <div class="sd-section-header">
                <div class="sd-section-title">
                    <div class="sd-section-icon" style="background:#ede9fe;">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 0 0 .566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 0 0-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 0 0-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 0 0-.217-.669s-3.07-2.993-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 0 0 .566-.411l1.9-3.847Z" />
                        </svg>
                    </div>
                    Penilaian Terbaru
                </div>
            </div>

            @if($penilaian->count() > 0)
                @foreach($penilaian->take(5) as $grade)
                    <div class="sd-grade-item">
                        <div class="sd-grade-top">
                            <span class="sd-grade-name">{{ Str::limit($grade->PengumpulanTugas?->Tugas?->judul ?? 'Tugas', 38) }}</span>
                            <span class="sd-grade-score">{{ number_format($grade->nilai,1) }}<small style="font-size:12px;color:#9ca3af;font-weight:500;">/{{ $grade->nilai_maksimal_snapshot }}</small></span>
                        </div>
                        <div class="sd-grade-bar-bg">
                            <div class="sd-grade-bar-fill" style="width:{{ min(($grade->nilai/$grade->nilai_maksimal_snapshot)*100,100) }}%;"></div>
                        </div>
                        <div class="sd-grade-date">{{ $grade->created_at->format('d M Y') }}
                            @if($grade->catatan_guru)
                                · <em>{{ Str::limit($grade->catatan_guru,60) }}</em>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="sd-empty">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25Z" />
                    </svg>
                    Belum ada penilaian.
                </div>
            @endif
        </div>

        {{-- ── Info Profil ── --}}
        <div class="sd-info-card">
            <div style="font-size:13px;font-weight:700;color:#1e3a5f;margin-bottom:6px;display:flex;align-items:center;gap:6px;">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Informasi Akun
            </div>
            <div class="sd-info-row">
                <span class="sd-info-row-icon">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </span>
                <span>{{ $siswa->email }}</span>
            </div>
            @if($siswa->Kelas?->Tingkatan)
            <div class="sd-info-row">
                <span class="sd-info-row-icon">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z" />
                    </svg>
                </span>
                <span>{{ $siswa->Kelas->Tingkatan->nama_tingkatan }}</span>
            </div>
            @endif
            <div class="sd-info-row">
                <span class="sd-info-row-icon">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </span>
                <span>Terdaftar sejak {{ $siswa->created_at->format('d M Y') }}</span>
            </div>
        </div>

    </div>{{-- /sd-body --}}
</div>{{-- /sd-root --}}

</x-app-layout>