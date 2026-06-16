<x-student-layout>
    <x-slot name="heading">Tugas &amp; Evaluasi</x-slot>

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
    .status-tab-btn.active-red { background:linear-gradient(135deg,#7f1d1d,#991b1b); color:#fca5a5; box-shadow:0 2px 14px rgba(127,29,29,0.5); }
    .status-tab-btn.active-blue { background:linear-gradient(135deg,#1e3a5f,#1d4ed8); color:#93c5fd; box-shadow:0 2px 14px rgba(29,78,216,0.4); }
    .status-tab-btn.active-green { background:linear-gradient(135deg,#14532d,#15803d); color:#86efac; box-shadow:0 2px 14px rgba(21,128,61,0.4); }

    .task-card { display:flex; align-items:center; gap:14px; background:rgba(18,24,40,0.75); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:16px 18px; text-decoration:none; transition:transform .2s,box-shadow .2s,border-color .2s; position:relative; overflow:hidden; }
    .task-card::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.02),transparent); pointer-events:none; }
    .task-card:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,0,0,0.45); }
    .task-icon { width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

    .sl-progress { height:4px; background:rgba(255,255,255,0.07); border-radius:2px; overflow:hidden; margin-top:8px; }
    .sl-progress-bar { height:100%; border-radius:2px; transition:width .6s ease; }

    .empty-state { padding:56px 20px; text-align:center; background:rgba(15,20,35,0.5); border-radius:18px; border:1px dashed rgba(255,255,255,0.09); }
    .empty-icon { width:64px; height:64px; margin:0 auto 16px; border-radius:18px; display:flex; align-items:center; justify-content:center; }
    .badge { font-size:10px; font-weight:800; padding:3px 10px; border-radius:99px; white-space:nowrap; flex-shrink:0; border-width:1px; border-style:solid; letter-spacing:.02em; }
    </style>

    <div style="max-width:960px;margin:0 auto;padding:20px 16px;" x-data="{ tab: 'belum' }">

    {{-- Main tab navigation --}}
        <div class="mp-tab-nav">
            <a href="{{ route('siswa.materi.index') }}" class="mp-tab-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                Mata Pelajaran
            </a>
            <a href="{{ route('siswa.tugas.index') }}" class="mp-tab-btn active">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                Tugas Saya
                @if($tugasBelumCount > 0)
                    <span class="tab-badge" style="background:#ef4444;">{{ $tugasBelumCount > 99 ? '99+' : $tugasBelumCount }}</span>
                @endif
            </a>
            <a href="{{ route('siswa.kuis.index') }}" class="mp-tab-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                Kuis Saya
                @if($kuisTersediaCount > 0)
                    <span class="tab-badge">{{ $kuisTersediaCount > 99 ? '99+' : $kuisTersediaCount }}</span>
                @endif
            </a>
        </div>

        {{-- Status tabs --}}
        <div class="status-tabs">
            <button @click="tab='belum'"
                :class="tab==='belum' ? 'status-tab-btn active-red' : 'status-tab-btn'"
                class="status-tab-btn">
                Belum ({{ count($belumDikerjakan) }})
            </button>
            <button @click="tab='pending'"
                :class="tab==='pending' ? 'status-tab-btn active-blue' : 'status-tab-btn'"
                class="status-tab-btn">
                Diperiksa ({{ count($menungguDinilai) }})
            </button>
            <button @click="tab='selesai'"
                :class="tab==='selesai' ? 'status-tab-btn active-green' : 'status-tab-btn'"
                class="status-tab-btn">
                Selesai ({{ count($selesai) }})
            </button>
        </div>

        {{-- Tab: Belum Dikerjakan --}}
        <div x-show="tab==='belum'" style="display:flex;flex-direction:column;gap:10px;">
            @forelse($belumDikerjakan as $item)
                @php $task=$item['task']; $isPast=$task->batas_waktu && \Carbon\Carbon::parse($task->batas_waktu)->isPast(); @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}"
                   class="task-card"
                   style="border-color:{{ $isPast ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.15)' }};"
                   onmouseover="this.style.borderColor='{{ $isPast ? 'rgba(239,68,68,0.4)' : 'rgba(245,158,11,0.35)' }}'"
                   onmouseout="this.style.borderColor='{{ $isPast ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.15)' }}'">
                    <div class="task-icon" style="background:{{ $isPast ? 'rgba(239,68,68,0.12)' : 'rgba(245,158,11,0.12)' }};border:1px solid {{ $isPast ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)' }};">
                        @if($isPast)
                            <svg width="20" height="20" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        @else
                            <svg width="20" height="20" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                            <span style="font-weight:600;color:#94a3b8;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            @if($task->batas_waktu)
                            <span style="color:{{ $isPast ? '#f87171' : '#34d399' }};display:flex;align-items:center;gap:3px;font-weight:600;">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($task->batas_waktu)->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <span class="badge" style="background:{{ $isPast ? 'rgba(239,68,68,0.12)' : 'rgba(245,158,11,0.12)' }};color:{{ $isPast ? '#f87171' : '#fbbf24' }};border-color:{{ $isPast ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)' }};">{{ $isPast ? 'Terlewat' : 'Aktif' }}</span>
                    <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;margin-bottom:4px;">Semua tugas sudah dikerjakan!</div>
                    <div style="font-size:12px;color:#334155;">Tidak ada tugas yang tersisa.</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Menunggu Dinilai --}}
        <div x-show="tab==='pending'" style="display:flex;flex-direction:column;gap:10px;" x-cloak>
            @forelse($menungguDinilai as $item)
                @php $task=$item['task']; @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}"
                   class="task-card"
                   style="border-color:rgba(59,130,246,0.15);"
                   onmouseover="this.style.borderColor='rgba(59,130,246,0.35)'"
                   onmouseout="this.style.borderColor='rgba(59,130,246,0.15)'">
                    <div class="task-icon" style="background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.25);">
                        <svg width="20" height="20" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;display:flex;flex-wrap:wrap;gap:8px;">
                            <span style="font-weight:600;color:#94a3b8;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            <span>Dikumpulkan {{ $item['submission']->created_at->format('d M, H:i') }}</span>
                        </div>
                    </div>
                    <span class="badge" style="background:rgba(59,130,246,0.12);color:#60a5fa;border-color:rgba(59,130,246,0.25);">Diperiksa</span>
                    <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;">Tidak ada tugas yang sedang diperiksa</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Selesai --}}
        <div x-show="tab==='selesai'" style="display:flex;flex-direction:column;gap:10px;" x-cloak>
            @forelse($selesai as $item)
                @php $task=$item['task']; $pct=min(($item['assessment']->nilai/$task->nilai_maksimal)*100,100); @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}"
                   class="task-card"
                   style="border-color:rgba(34,197,94,0.15);"
                   onmouseover="this.style.borderColor='rgba(34,197,94,0.35)'"
                   onmouseout="this.style.borderColor='rgba(34,197,94,0.15)'">
                    <div class="task-icon" style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.25);">
                        <svg width="20" height="20" fill="none" stroke="#4ade80" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;margin-bottom:4px;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;display:flex;flex-wrap:wrap;gap:8px;margin-bottom:2px;">
                            <span style="font-weight:600;color:#94a3b8;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            <span style="color:#a78bfa;font-weight:700;">Nilai: {{ $item['assessment']->nilai }}/{{ $task->nilai_maksimal }}</span>
                        </div>
                        <div class="sl-progress">
                            <div class="sl-progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#22c55e,#86efac);"></div>
                        </div>
                    </div>
                    <span class="badge" style="background:rgba(34,197,94,0.12);color:#4ade80;border-color:rgba(34,197,94,0.25);">Selesai</span>
                    <svg width="15" height="15" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);">
                        <svg width="28" height="28" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#64748b;">Belum ada tugas yang selesai dinilai</div>
                </div>
            @endforelse
        </div>

    </div>
</x-student-layout>
