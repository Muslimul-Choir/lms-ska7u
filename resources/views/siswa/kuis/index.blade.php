<x-student-layout>
    <x-slot name="heading">Kuis &amp; Ulangan</x-slot>

    <style>
    .mp-tab-nav { display:flex; gap:6px; background:rgba(15,20,35,0.7); backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:5px; margin-bottom:22px; }
    .mp-tab-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:7px; padding:9px 8px; font-size:12px; font-weight:700; text-decoration:none; border-radius:10px; transition:all .22s cubic-bezier(.4,0,.2,1); color:#64748b; letter-spacing:.02em; position:relative; overflow:visible; }
    .mp-tab-btn:hover { color:#cbd5e1; background:rgba(255,255,255,0.05); }
    .mp-tab-btn.active { background:linear-gradient(135deg,#c9982a,#f0be3d); color:#1a0800; box-shadow:0 4px 16px rgba(201,152,42,0.35); }
    .mp-tab-btn.active svg { stroke:#1a0800; }
    .mp-tab-btn svg { stroke:#64748b; transition:stroke .22s; flex-shrink:0; }
    .mp-tab-btn:hover svg { stroke:#cbd5e1; }
    .tab-badge { position:absolute; top:-6px; right:-6px; min-width:20px; height:20px; background:#ef4444; color:#fff; font-size:11px; font-weight:800; border-radius:99px; display:flex; align-items:center; justify-content:center; padding:0 5px; line-height:1; box-shadow:0 2px 8px rgba(239,68,68,0.4); animation:badgePop .3s cubic-bezier(.34,1.56,.64,1); }
    @keyframes badgePop { from{transform:scale(0)} to{transform:scale(1)} }

    .status-tabs { display:grid; grid-template-columns:repeat(3,1fr); background:rgba(15,20,35,0.8); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:4px; gap:4px; margin-bottom:18px; }
    .status-tab-btn { padding:10px 4px; font-size:11px; font-weight:700; border-radius:10px; border:none; cursor:pointer; transition:all .25s cubic-bezier(.4,0,.2,1); text-transform:uppercase; letter-spacing:.05em; font-family:'Plus Jakarta Sans',sans-serif; color:#64748b; background:transparent; }
    .status-tab-btn.active-blue { background:linear-gradient(135deg,#1e3a5f,#1d4ed8); color:#93c5fd; box-shadow:0 2px 14px rgba(29,78,216,0.4); }
    .status-tab-btn.active-green { background:linear-gradient(135deg,#14532d,#15803d); color:#86efac; box-shadow:0 2px 14px rgba(21,128,61,0.4); }
    .status-tab-btn.active-red { background:linear-gradient(135deg,#7f1d1d,#991b1b); color:#fca5a5; box-shadow:0 2px 14px rgba(127,29,29,0.5); }

    .task-card { display:flex; align-items:center; gap:14px; background:rgba(18,24,40,0.75); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:16px 18px; text-decoration:none; transition:transform .2s,box-shadow .2s,border-color .2s; position:relative; overflow:hidden; }
    .task-card::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.02),transparent); pointer-events:none; }
    .task-card:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,0,0,0.45); }
    .task-icon { width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

    .sl-progress { height:4px; background:rgba(255,255,255,0.07); border-radius:2px; overflow:hidden; margin-top:8px; }
    .sl-progress-bar { height:100%; border-radius:2px; transition:width .6s ease; }

    .empty-state { padding:56px 20px; text-align:center; background:rgba(15,20,35,0.5); border-radius:18px; border:1px dashed rgba(255,255,255,0.09); }
    .empty-icon { width:64px; height:64px; margin:0 auto 16px; border-radius:18px; display:flex; align-items:center; justify-content:center; }
    .badge { font-size:10px; font-weight:800; padding:3px 10px; border-radius:99px; white-space:nowrap; flex-shrink:0; border-width:1px; border-style:solid; letter-spacing:.02em; }
    
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

    <div style="max-width:960px;margin:0 auto;padding:20px 16px;">

        {{-- Main tab navigation --}}
        <div class="mp-tab-nav">
            <a href="{{ route('siswa.materi.index') }}" class="mp-tab-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                Mata Pelajaran
            </a>
            <a href="{{ route('siswa.tugas.index') }}" class="mp-tab-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                Tugas Saya
                @if($tugasBelumCount > 0)
                    <span class="tab-badge">{{ $tugasBelumCount > 99 ? '99+' : $tugasBelumCount }}</span>
                @endif
            </a>
            <a href="{{ route('siswa.kuis.index') }}" class="mp-tab-btn active">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                Kuis Saya
                @if($kuisTersediaCount > 0)
                    <span class="tab-badge">{{ $kuisTersediaCount > 99 ? '99+' : $kuisTersediaCount }}</span>
                @endif
            </a>
        </div>

        {{-- Status tabs --}}
        <div class="status-tabs">
            <a href="{{ route('siswa.kuis.index', ['status' => 'tersedia']) }}"
                class="status-tab-btn {{ $currentTab === 'tersedia' ? 'active-blue' : '' }}"
                style="text-decoration:none;">
                Tersedia ({{ $totalTersediaCount }})
            </a>
            <a href="{{ route('siswa.kuis.index', ['status' => 'selesai']) }}"
                class="status-tab-btn {{ $currentTab === 'selesai' ? 'active-green' : '' }}"
                style="text-decoration:none;">
                Selesai ({{ $totalSelesaiCount }})
            </a>
            <a href="{{ route('siswa.kuis.index', ['status' => 'ditutup']) }}"
                class="status-tab-btn {{ $currentTab === 'ditutup' ? 'active-red' : '' }}"
                style="text-decoration:none;">
                Ditutup ({{ $totalDitutupCount }})
            </a>
        </div>

        {{-- Tab: Tersedia --}}
        <div style="display:{{ $currentTab === 'tersedia' ? 'flex' : 'none' }};flex-direction:column;gap:10px;">
            @forelse($tersedia as $item)
                @php
                    $kuis = $item['kuis'];
                    $isUrgent = \Carbon\Carbon::parse($kuis->batas_selesai)->diffInHours(now()) < 24;
                @endphp
                <a href="{{ route('siswa.kuis.show', $kuis->id) }}"
                   class="task-card"
                   style="border-color:{{ $isUrgent ? 'rgba(239,68,68,0.2)' : 'rgba(59,130,246,0.15)' }};"
                   onmouseover="this.style.borderColor='{{ $isUrgent ? 'rgba(239,68,68,0.4)' : 'rgba(59,130,246,0.35)' }}'"
                   onmouseout="this.style.borderColor='{{ $isUrgent ? 'rgba(239,68,68,0.2)' : 'rgba(59,130,246,0.15)' }}'">
                    <div class="task-icon" style="background:{{ $isUrgent ? 'rgba(239,68,68,0.12)' : 'rgba(59,130,246,0.12)' }};border:1px solid {{ $isUrgent ? 'rgba(239,68,68,0.25)' : 'rgba(59,130,246,0.25)' }};">
                        <svg width="20" height="20" fill="none" stroke="{{ $isUrgent ? '#f87171' : '#60a5fa' }}" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $kuis->judul }}</div>
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;font-size:12px;">
                            <span style="color:#94a3b8;font-weight:600;">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            <span style="display:flex;align-items:center;gap:3px;color:{{ $isUrgent ? '#f87171' : '#34d399' }};font-weight:600;">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}
                            </span>
                            <span style="display:flex;align-items:center;gap:3px;color:#64748b;font-weight:500;">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                {{ $kuis->durasi }} menit
                            </span>
                        </div>
                    </div>
                    <span class="badge" style="background:{{ $isUrgent ? 'rgba(239,68,68,0.12)' : 'rgba(59,130,246,0.12)' }};color:{{ $isUrgent ? '#f87171' : '#60a5fa' }};border-color:{{ $isUrgent ? 'rgba(239,68,68,0.25)' : 'rgba(59,130,246,0.25)' }};">{{ $isUrgent ? 'Segera!' : 'Tersedia' }}</span>
                    <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;margin-bottom:4px;">Tidak ada kuis yang tersedia saat ini</div>
                    <div style="font-size:12px;color:#334155;">Kuis baru akan muncul di sini</div>
                </div>
            @endforelse
            
            {{-- Pagination for Tersedia --}}
            @if($kuisList->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $kuisList->firstItem() ?? 0 }} - {{ $kuisList->lastItem() ?? 0 }} dari {{ $kuisList->total() }} kuis
                    </div>
                    <nav class="pagination-nav">
                        @if ($kuisList->onFirstPage())
                            <span class="disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $kuisList->previousPageUrl() }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif

                        @foreach ($kuisList->getUrlRange(1, $kuisList->lastPage()) as $page => $url)
                            @if ($page == $kuisList->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($kuisList->hasMorePages())
                            <a href="{{ $kuisList->nextPageUrl() }}">
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
        </div>

        {{-- Tab: Sudah Dikerjakan --}}
        <div style="display:{{ $currentTab === 'selesai' ? 'flex' : 'none' }};flex-direction:column;gap:10px;">
            @forelse($sudahDikerjakan as $item)
                @php
                    $kuis = $item['kuis'];
                    $hasil = $item['hasil'];
                    $pct = $hasil && $kuis->nilai_maksimal > 0 ? min(($hasil->nilai / $kuis->nilai_maksimal) * 100, 100) : 0;
                @endphp
                <a href="{{ route('siswa.kuis.hasil', $kuis->id) }}"
                   class="task-card"
                   style="border-color:rgba(34,197,94,0.15);"
                   onmouseover="this.style.borderColor='rgba(34,197,94,0.35)'"
                   onmouseout="this.style.borderColor='rgba(34,197,94,0.15)'">
                    <div class="task-icon" style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);">
                        <svg width="20" height="20" fill="none" stroke="#4ade80" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $kuis->judul }}</div>
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;font-size:12px;margin-bottom:2px;">
                            <span style="color:#94a3b8;font-weight:600;">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            @if($hasil)
                            <span style="color:#a78bfa;font-weight:700;">Nilai: {{ number_format($hasil->nilai,1) }}/{{ number_format($kuis->nilai_maksimal,1) }}</span>
                            <span style="color:#34d399;font-weight:600;display:flex;align-items:center;gap:3px;">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                                {{ $hasil->jumlah_benar }} benar
                            </span>
                            @endif
                        </div>
                        @if($hasil)
                        <div class="sl-progress"><div class="sl-progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#22c55e,#86efac);"></div></div>
                        @endif
                    </div>
                    <span class="badge" style="background:rgba(34,197,94,0.12);color:#4ade80;border-color:rgba(34,197,94,0.25);">Selesai</span>
                    <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#4ade80" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;">Belum ada kuis yang selesai dikerjakan</div>
                </div>
            @endforelse
            
            {{-- Pagination for Selesai --}}
            @if($kuisList->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $kuisList->firstItem() ?? 0 }} - {{ $kuisList->lastItem() ?? 0 }} dari {{ $kuisList->total() }} kuis
                    </div>
                    <nav class="pagination-nav">
                        @if ($kuisList->onFirstPage())
                            <span class="disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $kuisList->previousPageUrl() }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif

                        @foreach ($kuisList->getUrlRange(1, $kuisList->lastPage()) as $page => $url)
                            @if ($page == $kuisList->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($kuisList->hasMorePages())
                            <a href="{{ $kuisList->nextPageUrl() }}">
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
        </div>

        {{-- Tab: Ditutup --}}
        <div style="display:{{ $currentTab === 'ditutup' ? 'flex' : 'none' }};flex-direction:column;gap:10px;">
            @forelse($ditutup as $item)
                @php $kuis = $item['kuis']; @endphp
                <div class="task-card" style="border-color:rgba(239,68,68,0.12);opacity:0.72;cursor:default;">
                    <div class="task-icon" style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.18);">
                        <svg width="20" height="20" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $kuis->judul }}</div>
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;font-size:12px;">
                            <span style="color:#475569;font-weight:600;">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</span>
                            <span style="color:#f87171;font-weight:600;">Ditutup {{ \Carbon\Carbon::parse($kuis->batas_selesai)->diffForHumans() }}</span>
                        </div>
                    </div>
                    <span class="badge" style="background:rgba(239,68,68,0.1);color:#f87171;border-color:rgba(239,68,68,0.2);">Ditutup</span>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;">Tidak ada kuis yang ditutup</div>
                </div>
            @endforelse
            
            {{-- Pagination for Ditutup --}}
            @if($kuisList->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $kuisList->firstItem() ?? 0 }} - {{ $kuisList->lastItem() ?? 0 }} dari {{ $kuisList->total() }} kuis
                    </div>
                    <nav class="pagination-nav">
                        @if ($kuisList->onFirstPage())
                            <span class="disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $kuisList->previousPageUrl() }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif

                        @foreach ($kuisList->getUrlRange(1, $kuisList->lastPage()) as $page => $url)
                            @if ($page == $kuisList->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($kuisList->hasMorePages())
                            <a href="{{ $kuisList->nextPageUrl() }}">
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
        </div>

    </div>
</x-student-layout>
