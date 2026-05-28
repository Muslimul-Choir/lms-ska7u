<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">Ruang Belajar</h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">{{ $jadwalbelajar->mapel->nama_mapel ?? 'Mata Pelajaran' }}</p>
            </div>
        </div>
    </x-slot>

<style>
/* ── Ruang Belajar – Mobile-First ── */
.rb-root {
    --brand:      #0F2145;
    --brand2:     #1B3A6B;
    --gold:       #C8992A;
    --surface:    #ffffff;
    --bg:         #f4f6fb;
    --text:       #1a1f36;
    --muted:      #6b7280;
    --radius-lg:  16px;
    --radius-md:  12px;
    --shadow:     0 2px 12px rgba(0,0,0,.07);
    background: var(--bg);
    min-height: 100vh;
    padding: 16px 0 40px;
}

/* Wrapper */
.rb-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
@media (min-width: 768px) {
    .rb-wrap {
        padding: 0 24px;
        flex-direction: row;
        align-items: flex-start;
        gap: 20px;
    }
}

/* ── SIDEBAR ── */
.rb-sidebar {
    width: 100%;
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
}
@media (min-width: 768px) {
    .rb-sidebar {
        width: 260px;
        flex-shrink: 0;
        position: sticky;
        top: 80px;
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }
}

/* Sidebar toggle (mobile only) */
.rb-sidebar-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 16px;
    background: linear-gradient(135deg, var(--brand), var(--brand2));
    color: #fff;
    cursor: pointer;
    user-select: none;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .03em;
}
@media (min-width: 768px) {
    .rb-sidebar-toggle { cursor: default; }
    .rb-sidebar-toggle .rb-toggle-arrow { display: none; }
}

.rb-toggle-arrow { transition: transform .25s; }
.rb-toggle-arrow.open { transform: rotate(180deg); }

.rb-sidebar-list {
    display: none;
}
.rb-sidebar-list.open { display: block; }
@media (min-width: 768px) {
    .rb-sidebar-list { display: block !important; }
}

/* Pertemuan group */
.rb-pertemuan-label {
    padding: 8px 14px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--muted);
    background: #f8faff;
    border-top: 1px solid #f0f2f7;
    border-bottom: 1px solid #f0f2f7;
}
.rb-materi-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 14px;
    font-size: 13px;
    color: #374151;
    text-decoration: none;
    border-bottom: 1px solid #f4f6fb;
    transition: background .15s;
}
.rb-materi-link:last-child { border-bottom: none; }
.rb-materi-link:hover { background: #f0f4ff; }
.rb-materi-link.active {
    background: #eff6ff;
    border-left: 3px solid var(--brand2);
    color: var(--brand);
    font-weight: 700;
}
.rb-materi-icon {
    width: 28px; height: 28px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

/* ── MAIN ── */
.rb-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Alert */
.rb-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px 16px;
    background: #f0fdf4;
    border: 1.5px solid #bbf7d0;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 600;
    color: #166534;
}

/* Content card */
.rb-content-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.rb-content-body { padding: 20px; }

.rb-content-meta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    background: #eff6ff;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    color: var(--brand2);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 10px;
}

.rb-content-title {
    font-size: clamp(17px, 4vw, 24px);
    font-weight: 800;
    color: var(--text);
    margin-bottom: 16px;
    line-height: 1.3;
}

/* Media box */
.rb-media-box {
    background: #0a0a0a;
    border-radius: var(--radius-md);
    overflow: hidden;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
}
.rb-media-box video { width: 100%; display: block; }
.rb-media-box iframe { width: 100%; min-height: 320px; display: block; border: none; }
@media (min-width: 640px) { .rb-media-box iframe { min-height: 480px; } }

/* Text content */
.rb-text-box {
    background: #f9faff;
    border: 1px solid #e5e7eb;
    border-radius: var(--radius-md);
    padding: 18px;
    font-size: 14px;
    line-height: 1.75;
    color: #374151;
    margin-bottom: 16px;
}

/* Description */
.rb-desc {
    font-size: 13px;
    line-height: 1.7;
    color: var(--muted);
    background: #f8faff;
    border-radius: var(--radius-md);
    padding: 14px 16px;
    border: 1px solid #e5e7eb;
}

/* Nav footer */
.rb-nav-footer {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}

.rb-nav-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 18px;
    border-radius: var(--radius-md);
    font-size: 13px; font-weight: 700;
    text-decoration: none;
    transition: opacity .2s, transform .15s;
}
.rb-nav-btn:hover { opacity: .88; transform: translateY(-1px); }
.rb-nav-btn.prev { background: #f1f5f9; color: #374151; }
.rb-nav-btn.done { background: linear-gradient(135deg, var(--gold), #e6ac30); color: #fff; }
.rb-nav-btn.next { background: linear-gradient(135deg, var(--brand), var(--brand2)); color: #fff; }
.rb-nav-btn.disabled { background: #f1f5f9; color: #9ca3af; pointer-events: none; cursor: not-allowed; }
</style>

<div class="rb-root">
    <div class="rb-wrap">

        {{-- ── SIDEBAR ── --}}
        <div class="rb-sidebar">
            <div class="rb-sidebar-toggle" onclick="toggleSidebar()">
                <span>📋 Daftar Materi</span>
                <svg class="rb-toggle-arrow" id="sidebarArrow" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div class="rb-sidebar-list" id="sidebarList">
                @foreach($jadwalbelajar->pertemuan as $pertemuan)
                    <div class="rb-pertemuan-label">Pertemuan {{ $pertemuan->nomor_pertemuan }}</div>
                    @foreach($pertemuan->materi as $m)
                        @php
                            $mIcons = ['video'=>'🎥','dokumen'=>'📄','link'=>'🔗'];
                            $mIcoBg = ['video'=>'#fce7f3','dokumen'=>'#dbeafe','link'=>'#fef3c7'];
                            $ico   = $mIcons[$m->tipe_materi]  ?? '📝';
                            $icoBg = $mIcoBg[$m->tipe_materi]  ?? '#f4f6fb';
                        @endphp
                        <a href="{{ route('ruang-belajar.show', ['jadwalbelajar'=>$jadwalbelajar->id,'materi'=>$m->id]) }}"
                           class="rb-materi-link {{ $materi->id === $m->id ? 'active' : '' }}">
                            <div class="rb-materi-icon" style="background:{{ $icoBg }};">{{ $ico }}</div>
                            <span class="truncate" style="max-width:160px;">{{ $m->judul }}</span>
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>

        {{-- ── MAIN ── --}}
        <div class="rb-main">

            {{-- Alert --}}
            @if(session('success'))
                <div class="rb-alert">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span>✅</span> {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#16a34a;cursor:pointer;font-size:18px;line-height:1;">×</button>
                </div>
            @endif

            {{-- Content Card --}}
            <div class="rb-content-card">
                <div class="rb-content-body">
                    <div class="rb-content-meta">
                        Pertemuan {{ $materi->pertemuan->nomor_pertemuan }} &bull; {{ ucfirst($materi->tipe_materi) }}
                    </div>
                    <h1 class="rb-content-title">{{ $materi->judul }}</h1>

                    {{-- Media --}}
                    @if($materi->tipe_materi === 'video')
                        @if($materi->file_url)
                            <div class="rb-media-box">
                                <video controls>
                                    <source src="{{ asset('storage/' . $materi->file_url) }}" type="video/mp4">
                                    Browser Anda tidak mendukung video HTML5.
                                </video>
                            </div>
                        @else
                            <div class="rb-media-box">
                                <div style="color:#6b7280;font-size:13px;padding:32px;text-align:center;">🎥 Video belum diunggah.</div>
                            </div>
                        @endif

                    @elseif($materi->tipe_materi === 'dokumen')
                        @if($materi->file_url)
                            <div class="rb-media-box">
                                <iframe src="{{ asset('storage/' . $materi->file_url) }}"></iframe>
                            </div>
                            {{-- Download button for mobile (iframe PDF not always usable) --}}
                            <a href="{{ asset('storage/' . $materi->file_url) }}" download
                               style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:#2563eb;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;margin-bottom:16px;">
                                ⬇️ Unduh Dokumen
                            </a>
                        @else
                            <div class="rb-media-box">
                                <div style="color:#6b7280;font-size:13px;padding:32px;text-align:center;">📄 Dokumen belum diunggah.</div>
                            </div>
                        @endif

                    @elseif($materi->tipe_materi === 'link')
                        @if($materi->file_url)
                            <a href="{{ $materi->file_url }}" target="_blank" rel="noopener noreferrer"
                               style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;margin-bottom:16px;word-break:break-all;">
                                <span>🔗 Buka Tautan Materi</span>
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif

                    @else
                        {{-- Text / lainnya --}}
                        @if($materi->deskripsi)
                            <div class="rb-text-box">{!! nl2br(e($materi->deskripsi)) !!}</div>
                        @endif
                    @endif

                    {{-- Deskripsi (for non-text types) --}}
                    @if($materi->tipe_materi !== 'lainnya' && $materi->deskripsi)
                        <div>
                            <div style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Deskripsi Materi</div>
                            <div class="rb-desc">{!! nl2br(e($materi->deskripsi)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Navigation Footer --}}
            <div class="rb-nav-footer">
                <div>
                    @if($prevMateri)
                        <a href="{{ route('ruang-belajar.show', ['jadwalbelajar'=>$jadwalbelajar->id,'materi'=>$prevMateri->id]) }}"
                           class="rb-nav-btn prev">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Sebelumnya
                        </a>
                    @else
                        <span class="rb-nav-btn disabled">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Sebelumnya
                        </span>
                    @endif
                </div>

                <form action="{{ route('ruang-belajar.mark-done', $materi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="rb-nav-btn done">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Tandai Selesai
                    </button>
                </form>

                <div>
                    @if($nextMateri)
                        <a href="{{ route('ruang-belajar.show', ['jadwalbelajar'=>$jadwalbelajar->id,'materi'=>$nextMateri->id]) }}"
                           class="rb-nav-btn next">
                            Berikutnya
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="rb-nav-btn disabled">
                            Berikutnya
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </div>
            </div>

        </div>{{-- /rb-main --}}
    </div>{{-- /rb-wrap --}}
</div>{{-- /rb-root --}}

@push('scripts')
<script>
function toggleSidebar() {
    const list  = document.getElementById('sidebarList');
    const arrow = document.getElementById('sidebarArrow');
    list.classList.toggle('open');
    arrow.classList.toggle('open');
}
</script>
@endpush

</x-app-layout>