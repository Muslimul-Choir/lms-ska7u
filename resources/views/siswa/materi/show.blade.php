<x-app-layout>

<style>
/* ── Materi Show – Mobile-First ── */
.ms-root {
    --brand:       #5c1020;
    --gold:        #d4a017;
    --surface:     #ffffff;
    --bg:          #f4f6fb;
    --text:        #1a1f36;
    --muted:       #6b7280;
    --radius-lg:   16px;
    --radius-md:   12px;
    --shadow:      0 2px 12px rgba(0,0,0,.07);
    background: var(--bg);
    min-height: 100vh;
    padding-bottom: 32px;
}

/* Top bar */
.ms-topbar {
    background: linear-gradient(135deg, var(--brand) 0%, #8b1a30 100%);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 10;
}
.ms-back-btn {
    display: flex; align-items: center; justify-content: center;
    width: 36px; height: 36px;
    background: rgba(255,255,255,.15);
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    transition: background .2s;
    flex-shrink: 0;
}
.ms-back-btn:hover { background: rgba(255,255,255,.25); }
.ms-topbar-title {
    font-size: 15px; font-weight: 700; color: #fff;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Body */
.ms-body {
    padding: 16px;
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
@media (min-width: 640px) { .ms-body { padding: 24px; } }

/* Card */
.ms-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ms-card-body { padding: 20px; }

/* Type chip */
.ms-type-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px; font-weight: 700;
    margin-bottom: 12px;
}

/* Title */
.ms-title {
    font-size: clamp(18px, 4vw, 26px);
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
    margin-bottom: 12px;
}

/* Meta row */
.ms-meta-row {
    display: flex; flex-wrap: wrap; gap: 8px;
}
.ms-meta-pill {
    display: inline-flex; align-items: center; gap: 4px;
    background: #f4f6fb;
    border-radius: 999px;
    padding: 4px 10px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

/* Section heading */
.ms-section-head {
    font-size: 13px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 14px 20px 0;
    margin-bottom: -4px;
}

/* Prose content */
.ms-prose {
    font-size: 14px;
    line-height: 1.75;
    color: #374151;
}
.ms-prose h2, .ms-prose h3, .ms-prose h4 { font-weight: 700; color: var(--text); margin: 16px 0 8px; }
.ms-prose a { color: #2563eb; text-decoration: underline; }
.ms-prose code { background:#f3f4f6; padding:2px 5px; border-radius:4px; font-family:monospace; font-size:13px; }
.ms-prose pre { background:#1f2937; color:#f3f4f6; padding:14px; border-radius:10px; overflow-x:auto; font-size:13px; }

/* File / link block */
.ms-file-block {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8faff;
    border: 1.5px solid #dbeafe;
    border-radius: var(--radius-md);
    padding: 14px 16px;
}
.ms-file-icon { font-size: 32px; flex-shrink: 0; }
.ms-file-info { flex: 1; min-width: 0; }
.ms-file-name { font-size: 13px; font-weight: 600; color: var(--text); word-break: break-all; }
.ms-file-sub  { font-size: 11px; color: var(--muted); margin-top: 2px; }
.ms-file-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 16px;
    background: #2563eb;
    color: #fff;
    border-radius: 10px;
    font-size: 13px; font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s, transform .15s;
    flex-shrink: 0;
}
.ms-file-btn:hover { background: #1d4ed8; transform: translateY(-1px); }

/* Video player */
.ms-video-wrap {
    background: #000;
    border-radius: 10px;
    overflow: hidden;
    aspect-ratio: 16/9;
    margin-bottom: 12px;
}
.ms-video-wrap video { width: 100%; height: 100%; display: block; }

/* Link big button */
.ms-link-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 18px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    word-break: break-all;
    transition: opacity .2s, transform .15s;
}
.ms-link-btn:hover { opacity: .92; transform: translateY(-1px); }
</style>

<div class="ms-root">

    {{-- ── TOP BAR ── --}}
    <div class="ms-topbar">
        <a href="{{ route('siswa.dashboard') }}" class="ms-back-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <span class="ms-topbar-title">{{ $materi->judul }}</span>
    </div>

    {{-- ── BODY ── --}}
    <div class="ms-body">

        {{-- Header card --}}
        <div class="ms-card">
            <div class="ms-card-body">
                @php
                    $typeMap = [
                        'dokumen' => ['📄','Dokumen','#dbeafe','#1d4ed8'],
                        'video'   => ['🎥','Video','#fce7f3','#9d174d'],
                        'link'    => ['🔗','Link','#fef3c7','#92400e'],
                    ];
                    [$tIco,$tLabel,$tBg,$tText] = $typeMap[$materi->tipe_materi] ?? ['📝','Lainnya','#f0f9ff','#0369a1'];
                @endphp

                <div class="ms-type-chip" style="background:{{ $tBg }};color:{{ $tText }};">
                    {{ $tIco }} {{ $tLabel }}
                </div>

                <h1 class="ms-title">{{ $materi->judul }}</h1>

                <div class="ms-meta-row">
                    <span class="ms-meta-pill">📅 {{ $materi->created_at->format('d M Y · H:i') }}</span>
                    <span class="ms-meta-pill">👤 {{ $materi->guruMapel?->Guru?->nama_lengkap ?? 'Instruktur' }}</span>
                    <span class="ms-meta-pill">📚 {{ $materi->guruMapel?->Mapel?->nama_mapel ?? 'Mata Pelajaran' }}</span>
                </div>
            </div>
        </div>

        {{-- Deskripsi / konten --}}
        @if($materi->deskripsi)
        <div class="ms-card">
            <div class="ms-section-head">Deskripsi Materi</div>
            <div class="ms-card-body ms-prose">
                {!! $materi->deskripsi !!}
            </div>
        </div>
        @endif

        {{-- File / video / link --}}
        @if($materi->file_url)
        <div class="ms-card">
            <div class="ms-section-head">
                @if($materi->tipe_materi === 'dokumen') 📄 Dokumen Pembelajaran
                @elseif($materi->tipe_materi === 'video') 🎥 Video Pembelajaran
                @else 🔗 Tautan Pembelajaran
                @endif
            </div>
            <div class="ms-card-body">

                @if($materi->tipe_materi === 'video')
                    <div class="ms-video-wrap">
                        <video controls>
                            <source src="{{ asset($materi->file_url) }}" type="video/mp4">
                            Browser Anda tidak mendukung video HTML5.
                        </video>
                    </div>
                    <div class="ms-file-block">
                        <span class="ms-file-icon">🎥</span>
                        <div class="ms-file-info">
                            <div class="ms-file-name">{{ basename($materi->file_url) }}</div>
                            <div class="ms-file-sub">File Video</div>
                        </div>
                        <a href="{{ asset($materi->file_url) }}" download class="ms-file-btn">
                            ⬇️ Unduh
                        </a>
                    </div>

                @elseif($materi->tipe_materi === 'dokumen')
                    <div class="ms-file-block">
                        <span class="ms-file-icon">📄</span>
                        <div class="ms-file-info">
                            <div class="ms-file-name">{{ basename($materi->file_url) }}</div>
                            <div class="ms-file-sub">File PDF / Dokumen</div>
                        </div>
                        <a href="{{ asset($materi->file_url) }}" download class="ms-file-btn">
                            ⬇️ Unduh
                        </a>
                    </div>

                @elseif($materi->tipe_materi === 'link')
                    <a href="{{ $materi->file_url }}" target="_blank" rel="noopener noreferrer" class="ms-link-btn">
                        <span>🔗 Buka Tautan</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif

            </div>
        </div>
        @endif

        {{-- Kembali button --}}
        <a href="{{ route('siswa.dashboard') }}"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow);font-size:14px;font-weight:700;color:#374151;text-decoration:none;">
            ← Kembali ke Dashboard
        </a>

    </div>
</div>

</x-app-layout>