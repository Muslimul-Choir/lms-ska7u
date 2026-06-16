<x-student-layout>
<x-slot name="heading">{{ Str::limit($materi->judul, 40) }}</x-slot>
<x-slot name="back">
    @php 
        // Check if we came from mapel detail page
        $backMapelId = request('mapel_id') ?? ($materi->guruMapel->id_mapel ?? null); 
    @endphp
    <a href="{{ $backMapelId ? route('siswa.materi.mapel', $backMapelId) : route('siswa.materi.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:background .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $typeMap = [
        'dokumen' => ['stroke'=>'#60a5fa','bg'=>'rgba(59,130,246,0.15)','border'=>'rgba(59,130,246,0.3)','label'=>'Dokumen','path'=>'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
        'video'   => ['stroke'=>'#f472b6','bg'=>'rgba(244,114,182,0.15)','border'=>'rgba(244,114,182,0.3)','label'=>'Video','path'=>'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z'],
        'link'    => ['stroke'=>'#fbbf24','bg'=>'rgba(251,191,36,0.15)','border'=>'rgba(251,191,36,0.3)','label'=>'Tautan','path'=>'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
    ];
    $tInfo = $typeMap[$materi->tipe_materi] ?? ['stroke'=>'#94a3b8','bg'=>'rgba(148,163,184,0.15)','border'=>'rgba(148,163,184,0.3)','label'=>'Lainnya','path'=>'M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z'];
@endphp

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Header Card --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px;">
        <span style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;background:{{ $tInfo['bg'] }};color:{{ $tInfo['stroke'] }};border:1px solid {{ $tInfo['border'] }};margin-bottom:14px;">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $tInfo['path'] }}"/></svg>
            {{ $tInfo['label'] }}
        </span>
        <h1 style="font-size:clamp(18px,4vw,24px);font-weight:800;color:#f1f5f9;line-height:1.3;margin:0 0 16px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $materi->judul }}</h1>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:99px;padding:4px 12px;font-size:12px;color:#94a3b8;font-weight:500;">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ $materi->created_at->format('d M Y · H:i') }}
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:99px;padding:4px 12px;font-size:12px;color:#94a3b8;font-weight:500;">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                {{ $materi->guruMapel?->Guru?->nama_lengkap ?? 'Instruktur' }}
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:99px;padding:4px 12px;font-size:12px;color:#94a3b8;font-weight:500;">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                {{ $materi->guruMapel?->Mapel?->nama_mapel ?? $materi->Mapel?->nama_mapel ?? 'Mata Pelajaran' }}
            </span>
        </div>
    </div>

    {{-- Deskripsi --}}
    @if($materi->deskripsi)
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;padding:14px 20px 0;display:flex;align-items:center;gap:6px;">
            <span style="width:4px;height:14px;background:linear-gradient(180deg,#c9982a,#f0be3d);border-radius:99px;display:inline-block;"></span>
            Deskripsi Materi
        </div>
        <div style="padding:12px 20px 20px;font-size:14px;line-height:1.8;color:#cbd5e1;">{!! $materi->deskripsi !!}</div>
    </div>
    @endif

    {{-- File / Video / Link --}}
    @if($materi->file_url)
        @if($materi->tipe_materi === 'link')
            <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;padding:14px 20px;background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:6px;">
                    <svg width="13" height="13" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                    Tautan Pembelajaran
                </div>
                <div style="padding:16px 20px 20px;">
                    <a href="{{ $materi->file_url }}" target="_blank" rel="noopener noreferrer"
                       style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:linear-gradient(135deg,rgba(201,152,42,0.2),rgba(240,190,61,0.1));border:1px solid rgba(201,152,42,0.4);color:#f0be3d;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;transition:opacity .18s;"
                       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                            Buka Tautan Pembelajaran
                        </span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                        </svg>
                    </a>
                </div>
            </div>
        @else
            <x-file-preview
                :fileUrl="$materi->file_url"
                :fileType="$materi->tipe_materi"
                :title="$materi->tipe_materi === 'video' ? 'Video Pembelajaran' : 'Dokumen Pembelajaran'"
            />
        @endif
    @endif

</div>
</x-student-layout>
