<x-student-layout>
<x-slot name="heading">{{ Str::limit($materi->judul, 40) }}</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.materi.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:10px;color:#fff;text-decoration:none;flex-shrink:0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $typeMap = ['dokumen'=>['📄','Dokumen','#dbeafe','#1d4ed8'],'video'=>['🎥','Video','#fce7f3','#9d174d'],'link'=>['🔗','Tautan','#fef3c7','#92400e']];
    [$tIco,$tLabel,$tBg,$tText] = $typeMap[$materi->tipe_materi] ?? ['📝','Lainnya','#f0f9ff','#0369a1'];
@endphp

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Header --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);padding:20px;">
        <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;background:{{ $tBg }};color:{{ $tText }};margin-bottom:12px;">{{ $tIco }} {{ $tLabel }}</span>
        <h1 style="font-size:clamp(18px,4vw,24px);font-weight:800;color:#0f172a;line-height:1.3;margin:0 0 14px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $materi->judul }}</h1>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            <span style="display:inline-flex;align-items:center;gap:4px;background:#f4f6fb;border-radius:99px;padding:4px 10px;font-size:12px;color:#64748b;font-weight:500;">📅 {{ $materi->created_at->format('d M Y · H:i') }}</span>
            <span style="display:inline-flex;align-items:center;gap:4px;background:#f4f6fb;border-radius:99px;padding:4px 10px;font-size:12px;color:#64748b;font-weight:500;">👤 {{ $materi->guruMapel?->Guru?->nama_lengkap ?? 'Instruktur' }}</span>
            <span style="display:inline-flex;align-items:center;gap:4px;background:#f4f6fb;border-radius:99px;padding:4px 10px;font-size:12px;color:#64748b;font-weight:500;">📚 {{ $materi->guruMapel?->Mapel?->nama_mapel ?? $materi->Mapel?->nama_mapel ?? 'Mata Pelajaran' }}</span>
        </div>
    </div>

    {{-- Deskripsi --}}
    @if($materi->deskripsi)
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px 0;">Deskripsi Materi</div>
        <div style="padding:12px 20px 20px;font-size:14px;line-height:1.75;color:#374151;">{!! $materi->deskripsi !!}</div>
    </div>
    @endif

    {{-- File / Video / Link --}}
    @if($materi->file_url)
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px 0;">
            @if($materi->tipe_materi==='video') 🎥 Video Pembelajaran
            @elseif($materi->tipe_materi==='link') 🔗 Tautan Pembelajaran
            @else 📄 Dokumen Pembelajaran
            @endif
        </div>
        <div style="padding:12px 20px 20px;">
            @if($materi->tipe_materi === 'video')
                <div style="background:#000;border-radius:10px;overflow:hidden;aspect-ratio:16/9;margin-bottom:12px;">
                    <video controls style="width:100%;height:100%;display:block;"><source src="{{ asset($materi->file_url) }}" type="video/mp4">Browser Anda tidak mendukung video.</video>
                </div>
                <div style="display:flex;align-items:center;gap:12px;background:#f8faff;border:1.5px solid #dbeafe;border-radius:12px;padding:14px 16px;">
                    <span style="font-size:28px;">🎥</span>
                    <div style="flex:1;min-width:0;"><div style="font-size:13px;font-weight:600;color:#0f172a;word-break:break-all;">{{ basename($materi->file_url) }}</div></div>
                    <a href="{{ asset($materi->file_url) }}" download style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#1e40af;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;white-space:nowrap;">⬇️ Unduh</a>
                </div>
            @elseif($materi->tipe_materi === 'link')
                <a href="{{ $materi->file_url }}" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;word-break:break-all;">
                    <span>🔗 Buka Tautan</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <div style="display:flex;align-items:center;gap:12px;background:#f8faff;border:1.5px solid #dbeafe;border-radius:12px;padding:14px 16px;">
                    <span style="font-size:28px;">📄</span>
                    <div style="flex:1;min-width:0;"><div style="font-size:13px;font-weight:600;color:#0f172a;word-break:break-all;">{{ basename($materi->file_url) }}</div><div style="font-size:11px;color:#64748b;margin-top:2px;">File PDF / Dokumen</div></div>
                    <a href="{{ asset($materi->file_url) }}" download style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#1e40af;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;white-space:nowrap;">⬇️ Unduh</a>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>
</x-student-layout>
