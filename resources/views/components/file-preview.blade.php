@props(['fileUrl', 'fileType' => 'dokumen', 'title' => 'File'])

@php
    // Determine if it's a URL or storage path
    $isUrl = str_starts_with($fileUrl, 'http');
    $filePath = $isUrl ? $fileUrl : asset('storage/' . $fileUrl);
    
    // Get file extension
    $extension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
    
    // Determine file SVG and label
    $fileLabel = 'Dokumen';
    
    $svgs = [
        'pdf'     => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>',
        'gambar'  => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>',
        'video'   => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>',
        'archive' => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>',
        'doc'     => '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>',
    ];

    $fileSvg = $svgs['doc'];
    
    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
        $fileSvg = $svgs['gambar'];
        $fileLabel = 'Gambar';
        $fileType = 'gambar';
    } elseif ($extension === 'pdf') {
        $fileSvg = $svgs['pdf'];
        $fileLabel = 'PDF';
        $fileType = 'pdf';
    } elseif (in_array($extension, ['mp4', 'webm', 'ogg'])) {
        $fileSvg = $svgs['video'];
        $fileLabel = 'Video';
        $fileType = 'video';
    } elseif (in_array($extension, ['zip', 'rar', '7z'])) {
        $fileSvg = $svgs['archive'];
        $fileLabel = 'Arsip';
    } elseif (in_array($extension, ['doc', 'docx'])) {
        $fileSvg = $svgs['doc'];
        $fileLabel = 'Word';
    } elseif (in_array($extension, ['xls', 'xlsx'])) {
        $fileSvg = $svgs['doc'];
        $fileLabel = 'Excel';
    } elseif (in_array($extension, ['ppt', 'pptx'])) {
        $fileSvg = $svgs['doc'];
        $fileLabel = 'PowerPoint';
    }
    
    // Generate unique ID for this component
    $componentId = 'file-preview-' . md5($fileUrl . time());
@endphp

<div class="file-preview-container" style="background:rgba(22, 28, 45, 0.7);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
    <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px;background:rgba(255,255,255,0.03);border-bottom:1.5px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:8px;">
        {!! $fileSvg !!}
        <span>{{ $title }}</span>
    </div>
    
    <div style="padding:18px;">
        @if($fileType === 'gambar')
            {{-- Image Preview --}}
            <div style="background:rgba(255,255,255,0.02);border-radius:12px;overflow:hidden;margin-bottom:12px;border:1.5px solid rgba(255,255,255,0.08);">
                <img src="{{ $filePath }}" alt="{{ $title }}" 
                     style="width:100%;height:auto;display:block;max-height:500px;object-fit:contain;"
                     onerror="this.parentElement.innerHTML='<div style=\'padding:40px;text-align:center;color:#94a3b8;\'><svg style=\'width:48px;height:48px;margin:0 auto 12px;opacity:0.5;\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><div style=\'font-size:13px;font-weight:600;\'>Gambar tidak dapat dimuat</div></div>';">
            </div>
            
            {{-- Image Info & Actions --}}
            <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:rgba(16,185,129,0.08);border:1.5px solid rgba(16,185,129,0.2);border-radius:10px;color:#34d399;">
                <div style="width:34px;height:34px;border-radius:8px;background:rgba(16,185,129,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    {!! $fileSvg !!}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#f1f5f9;word-break:break-all;">{{ basename($fileUrl) }}</div>
                    <div style="font-size:11px;color:#34d399;margin-top:2px;font-weight:600;">{{ $fileLabel }} · {{ strtoupper($extension) }}</div>
                </div>
                <div style="display:flex;gap:6px;flex-shrink:0;">
                    <button onclick="window.open('{{ $filePath }}', '_blank')" 
                       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.25);border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;white-space:nowrap;transition:opacity .15s;"
                       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Buka
                    </button>
                </div>
            </div>
            
        @elseif($fileType === 'pdf')
            {{-- PDF - Beautiful Dark Glass Card --}}
            <div style="background:rgba(201,152,42,0.05);border:1.5px solid rgba(201,152,42,0.25);border-radius:12px;overflow:hidden;margin-bottom:12px;position:relative;">
                <div style="padding:40px 20px;text-align:center;">
                    {{-- Large PDF Icon --}}
                    <div style="width:72px;height:72px;margin:0 auto 16px;background:rgba(201,152,42,0.15);border:1.5px solid rgba(201,152,42,0.25);border-radius:16px;display:flex;align-items:center;justify-content:center;color:#fbbf24;box-shadow:0 4px 16px rgba(0,0,0,0.2);">
                        <svg style="width:36px;height:36px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    
                    {{-- File Name --}}
                    <h3 style="font-size:15px;font-weight:700;color:#fff;margin:0 0 12px;font-family:'Plus Jakarta Sans',sans-serif;word-break:break-all;padding:0 10px;">
                        {{ basename($fileUrl) }}
                    </h3>
                    
                    {{-- File Type Badge --}}
                    <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:20px;margin-bottom:18px;color:#fbbf24;">
                        {!! $fileSvg !!}
                        <span style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.05em;">DOKUMEN PDF</span>
                    </div>
                    
                    {{-- Description --}}
                    <p style="font-size:12px;color:#94a3b8;margin:0 0 20px;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.5;">
                        Klik tombol di bawah untuk membuka dokumen PDF di tab baru atau mengunduh ke perangkat Anda.
                    </p>
                    
                    {{-- Action Buttons --}}
                    <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                        <button onclick="window.open('{{ $filePath }}', '_blank')" 
                           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:linear-gradient(135deg,#c9982a,#f0be3d);color:#1a0a00;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(201,152,42,0.25);transition:all 0.2s;font-family:'Plus Jakarta Sans',sans-serif;"
                           onmouseover="this.style.transform='translateY(-1.5px)';this.style.boxShadow='0 6px 16px rgba(201,152,42,0.35)'"
                           onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(201,152,42,0.25)'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            Buka PDF di Tab Baru
                        </button>
                        
                        <button onclick="window.location.href='{{ $filePath }}'" 
                           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:rgba(255,255,255,0.05);color:#f1f5f9;border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.2s;font-family:'Plus Jakarta Sans',sans-serif;"
                           onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-1.5px)'"
                           onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform='none'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh PDF
                        </button>
                    </div>
                    
                    {{-- Tips --}}
                    <div style="margin-top:20px;padding:10px 14px;background:rgba(255,255,255,0.03);border:1.5px solid rgba(255,255,255,0.06);border-radius:8px;max-width:480px;margin-left:auto;margin-right:auto;">
                        <p style="font-size:11px;color:#94a3b8;margin:0;display:flex;align-items:center;gap:8px;justify-content:center;">
                            <svg width="14" height="14" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            <span>Pastikan browser Anda memiliki PDF reader built-in atau gunakan aplikasi PDF reader</span>
                        </p>
                    </div>
                </div>
            </div>
            
        @elseif($fileType === 'video')
            {{-- Video Preview --}}
            <div style="background:#000;border-radius:12px;overflow:hidden;margin-bottom:12px;border:1.5px solid rgba(255,255,255,0.08);">
                <video controls style="width:100%;height:auto;display:block;max-height:500px;">
                    <source src="{{ $filePath }}" type="video/{{ $extension }}">
                    Browser Anda tidak mendukung video.
                </video>
            </div>
            
            {{-- Video Info & Actions --}}
            <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:rgba(244,114,182,0.08);border:1.5px solid rgba(244,114,182,0.2);border-radius:10px;color:#f472b6;">
                <div style="width:34px;height:34px;border-radius:8px;background:rgba(244,114,182,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    {!! $fileSvg !!}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#f1f5f9;word-break:break-all;">{{ basename($fileUrl) }}</div>
                    <div style="font-size:11px;color:#f472b6;margin-top:2px;font-weight:600;">{{ $fileLabel }} · {{ strtoupper($extension) }}</div>
                </div>
                <button onclick="window.open('{{ $filePath }}', '_blank')" 
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:rgba(244,114,182,0.15);color:#f472b6;border:1px solid rgba(244,114,182,0.25);border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;white-space:nowrap;flex-shrink:0;transition:opacity .15s;"
                   onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Buka
                </button>
            </div>
            
        @else
            {{-- Other File Types - Attractive Dark Glass Card --}}
            @php
                $cardColors = [
                    'doc' => ['bg' => 'rgba(59,130,246,0.05)', 'border' => 'rgba(59,130,246,0.25)', 'primary' => '#60a5fa', 'text' => '#93c5fd'],
                    'docx' => ['bg' => 'rgba(59,130,246,0.05)', 'border' => 'rgba(59,130,246,0.25)', 'primary' => '#60a5fa', 'text' => '#93c5fd'],
                    'xls' => ['bg' => 'rgba(16,185,129,0.05)', 'border' => 'rgba(16,185,129,0.25)', 'primary' => '#34d399', 'text' => '#6ee7b7'],
                    'xlsx' => ['bg' => 'rgba(16,185,129,0.05)', 'border' => 'rgba(16,185,129,0.25)', 'primary' => '#34d399', 'text' => '#6ee7b7'],
                    'ppt' => ['bg' => 'rgba(245,158,11,0.05)', 'border' => 'rgba(245,158,11,0.25)', 'primary' => '#fbbf24', 'text' => '#fcd34d'],
                    'pptx' => ['bg' => 'rgba(245,158,11,0.05)', 'border' => 'rgba(245,158,11,0.25)', 'primary' => '#fbbf24', 'text' => '#fcd34d'],
                    'zip' => ['bg' => 'rgba(139,92,246,0.05)', 'border' => 'rgba(139,92,246,0.25)', 'primary' => '#a78bfa', 'text' => '#c084fc'],
                    'rar' => ['bg' => 'rgba(139,92,246,0.05)', 'border' => 'rgba(139,92,246,0.25)', 'primary' => '#a78bfa', 'text' => '#c084fc'],
                ];
                $colors = $cardColors[$extension] ?? ['bg' => 'rgba(255,255,255,0.02)', 'border' => 'rgba(255,255,255,0.08)', 'primary' => '#94a3b8', 'text' => '#cbd5e1'];
            @endphp
            
            <div style="background:{{ $colors['bg'] }};border-radius:12px;overflow:hidden;margin-bottom:12px;border:1.5px solid {{ $colors['border'] }};position:relative;">
                <div style="padding:40px 20px;text-align:center;">
                    {{-- Large File Icon --}}
                    <div style="width:72px;height:72px;margin:0 auto 16px;background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:16px;display:flex;align-items:center;justify-content:center;color:{{ $colors['primary'] }};box-shadow:0 4px 16px rgba(0,0,0,0.25);">
                        {!! $fileSvg !!}
                    </div>
                    
                    {{-- File Name --}}
                    <h3 style="font-size:15px;font-weight:700;color:#fff;margin:0 0 12px;font-family:'Plus Jakarta Sans',sans-serif;word-break:break-all;padding:0 10px;">
                        {{ basename($fileUrl) }}
                    </h3>
                    
                    {{-- File Type Badge --}}
                    <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;background:{{ $colors['bg'] }};border:1.5px solid {{ $colors['border'] }};border-radius:20px;margin-bottom:18px;color:{{ $colors['primary'] }};">
                        {!! $fileSvg !!}
                        <span style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.05em;">{{ $fileLabel }} · {{ strtoupper($extension) }}</span>
                    </div>
                    
                    {{-- Description --}}
                    <p style="font-size:12px;color:#94a3b8;margin:0 0 20px;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.5;">
                        @if(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                            Klik "Preview Online" untuk melihat dokumen atau "Unduh" untuk menyimpan ke perangkat.
                        @else
                            Klik tombol di bawah untuk mengunduh file ke perangkat Anda.
                        @endif
                    </p>
                    
                    {{-- Action Buttons --}}
                    <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                        @if(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                        <button onclick="window.open('https://view.officeapps.live.com/op/view.aspx?src={{ urlencode($filePath) }}', '_blank')" 
                           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:{{ $colors['primary'] }};color:#1a0a00;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.2);transition:all 0.2s;font-family:'Plus Jakarta Sans',sans-serif;"
                           onmouseover="this.style.transform='translateY(-1.5px)';this.style.boxShadow='0 6px 16px rgba(0,0,0,0.25)'"
                           onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Preview Online
                        </button>
                        @endif
                        
                        <button onclick="window.location.href='{{ $filePath }}'" 
                           style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:rgba(255,255,255,0.05);color:#f1f5f9;border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.2s;font-family:'Plus Jakarta Sans',sans-serif;"
                           onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.transform='translateY(-1.5px)'"
                           onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.transform='none'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Unduh File
                        </button>
                    </div>
                    
                    @if(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                    {{-- Tips for Office Files --}}
                    <div style="margin-top:20px;padding:10px 14px;background:rgba(255,255,255,0.03);border:1.5px solid rgba(255,255,255,0.06);border-radius:8px;max-width:480px;margin-left:auto;margin-right:auto;">
                        <p style="font-size:11px;color:#94a3b8;margin:0;display:flex;align-items:center;gap:8px;justify-content:center;">
                            <svg width="14" height="14" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            <span>Preview online memerlukan koneksi internet dan file harus dapat diakses publik</span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
