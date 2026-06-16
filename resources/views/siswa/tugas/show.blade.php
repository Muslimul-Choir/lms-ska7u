<x-student-layout>
<x-slot name="heading">{{ Str::limit($tugas->judul, 40) }}</x-slot>
<x-slot name="back">
    @php
        // Get mapel_id from query parameter (from mapel detail page)
        $fromMapel = request('from') === 'mapel';
        $backMapelId = request('mapel_id');
        
        // Determine back URL based on source
        if ($fromMapel && $backMapelId) {
            $backUrl = route('siswa.materi.mapel', $backMapelId);
        } else {
            $backUrl = route('siswa.tugas.index');
        }
    @endphp
    <a href="{{ $backUrl }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:background .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $isPast = $tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast();
    if ($submission && $assessment)    { $sLabel='Sudah Dinilai';       $sBg='rgba(16,185,129,0.12)'; $sText='#34d399'; }
    elseif ($submission)               { $sLabel='Sudah Dikumpulkan';   $sBg='rgba(59,130,246,0.12)';  $sText='#60a5fa'; }
    elseif ($isPast)                   { $sLabel='Waktu Terlewat';      $sBg='rgba(239,68,68,0.12)';   $sText='#f87171'; }
    else                               { $sLabel='Menunggu Pengumpulan';$sBg='rgba(245,158,11,0.12)';  $sText='#fbbf24'; }
@endphp

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Header Card --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px;">
        <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 14px;border-radius:99px;font-size:12px;font-weight:700;background:{{ $sBg }};color:{{ $sText }};border:1px solid {{ $sText }}33;margin-bottom:14px;">{{ $sLabel }}</span>
        <h1 style="font-size:clamp(18px,4vw,24px);font-weight:800;color:#f1f5f9;line-height:1.3;margin:0 0 16px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $tugas->judul }}</h1>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Mata Pelajaran</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ $tugas->Mapel?->nama_mapel ?? $tugas->guruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Pengajar</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ $tugas->guruMapel?->Guru?->nama_lengkap ?? '-' }}</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Tipe</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ ucfirst($tugas->tipe_tugas) }}</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Nilai Maks.</div>
                <div style="font-size:13px;font-weight:700;color:#a78bfa;">{{ $tugas->nilai_maksimal }}</div>
            </div>
        </div>
        @if($tugas->batas_waktu)
        <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:12px;margin-top:12px;background:{{ $isPast ? 'rgba(239,68,68,0.1)' : 'rgba(16,185,129,0.1)' }};border:1px solid {{ $isPast ? 'rgba(239,68,68,0.2)' : 'rgba(16,185,129,0.2)' }};font-size:13px;font-weight:600;color:{{ $isPast ? '#f87171' : '#34d399' }};">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <div>Batas: <strong>{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</strong></div>
                <div style="font-size:11px;opacity:.7;">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->diffForHumans() }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Deskripsi --}}
    @if($tugas->deskripsi)
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;padding:14px 20px 0;display:flex;align-items:center;gap:6px;"><span style="width:4px;height:14px;background:linear-gradient(180deg,#c9982a,#f0be3d);border-radius:99px;display:inline-block;"></span>Deskripsi Tugas</div>
        <div style="padding:12px 20px 20px;font-size:14px;line-height:1.8;color:#cbd5e1;">{!! $tugas->deskripsi !!}</div>
    </div>
    @endif

    {{-- File Tugas --}}
    @if($tugas->file_url)
        @if($tugas->tipe_file === 'link')
            {{-- Link Tugas --}}
            <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;padding:14px 20px;background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:6px;">
                    <svg width="13" height="13" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                    Tautan Tugas
                </div>
                <div style="padding:16px 20px 20px;">
                    <a href="{{ $tugas->file_url }}" target="_blank" rel="noopener noreferrer" 
                       style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:linear-gradient(135deg,rgba(201,152,42,0.2),rgba(240,190,61,0.1));border:1px solid rgba(201,152,42,0.4);color:#f0be3d;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                            Buka Tautan Tugas
                        </span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    </a>
                </div>
            </div>
        @else
            {{-- File Tugas (Dokumen/Video/Gambar) --}}
            <x-file-preview 
                :fileUrl="$tugas->file_url" 
                :fileType="$tugas->tipe_file" 
                title="File Tugas" 
            />
        @endif
    @endif

    {{-- Status Pengumpulan --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;padding:14px 20px 0;display:flex;align-items:center;gap:6px;"><span style="width:4px;height:14px;background:linear-gradient(180deg,#34d399,#6ee7b7);border-radius:99px;display:inline-block;"></span>Status Pengumpulan</div>
        <div style="padding:12px 20px 20px;">

            @if($submission)
                <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);border-radius:12px;margin-bottom:14px;">
                    <svg width="20" height="20" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <div style="font-weight:700;color:#34d399;font-size:13px;margin-bottom:2px;">Tugas Sudah Dikumpulkan</div>
                        <div style="color:#6ee7b7;font-size:12px;">{{ $submission->created_at->format('d M Y, H:i') }}</div>
                        @if($submission->catatan)<div style="margin-top:6px;color:#94a3b8;font-size:13px;font-style:italic;">"{{ $submission->catatan }}"</div>@endif
                    </div>
                </div>

                {{-- Preview File yang Dikumpulkan --}}
                @if($submission->file_url)
                    @if(str_starts_with($submission->file_url, 'http'))
                        {{-- Link URL --}}
                        <div style="margin-bottom:14px;">
                            <a href="{{ $submission->file_url }}" target="_blank" rel="noopener noreferrer" 
                               style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#4ade80;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                <span style="display:flex;align-items:center;gap:8px;"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>Buka Tautan Jawaban</span>
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        {{-- File Upload --}}
                        <x-file-preview 
                            :fileUrl="$submission->file_url" 
                            :fileType="$tugas->tipe_file" 
                            title="File Jawaban Anda" 
                        />
                    @endif
                @endif

                @if($assessment)
                    <div style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.25);border-radius:12px;padding:16px;">
                        <div style="font-size:13px;font-weight:700;color:#a78bfa;margin-bottom:12px;display:flex;align-items:center;gap:6px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>Hasil Penilaian</div>
                        <div style="display:flex;gap:12px;margin-bottom:12px;">
                            <div style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;text-align:center;">
                                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;margin-bottom:4px;">Nilai Anda</div>
                                <div style="font-size:32px;font-weight:900;color:#a78bfa;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($assessment->nilai,1) }}</div>
                            </div>
                            <div style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px;text-align:center;">
                                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;margin-bottom:4px;">Maksimal</div>
                                <div style="font-size:32px;font-weight:900;color:#475569;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($assessment->nilai_maksimal_snapshot,1) }}</div>
                            </div>
                        </div>
                        @php $pct = min(($assessment->nilai/$assessment->nilai_maksimal_snapshot)*100,100); @endphp
                        <div class="sl-progress" style="margin-bottom:4px;"><div class="sl-progress-bar" style="width:{{ $pct }}%;"></div></div>
                        <div style="text-align:right;font-size:12px;font-weight:700;color:#a78bfa;margin-bottom:10px;">{{ number_format($pct,1) }}%</div>
                        @if($assessment->catatan_guru)
                        <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(139,92,246,0.2);border-radius:8px;padding:12px;">
                            <div style="font-size:12px;font-weight:700;color:#a78bfa;margin-bottom:4px;">Catatan Pengajar</div>
                            <div style="font-size:13px;color:#cbd5e1;">{{ $assessment->catatan_guru }}</div>
                        </div>
                        @endif
                    </div>
                @else
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);border-radius:12px;margin-bottom:14px;">
                        <svg width="20" height="20" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div style="color:#fcd34d;font-size:13px;"><strong>Menunggu Penilaian</strong><br><span style="font-size:12px;color:#fbbf2499;">Tugas Anda sedang diperiksa oleh pengajar.</span></div>
                    </div>
                    @if(!$isPast || $tugas->allow_late)
                    <form id="formEditPengumpulan" action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data" style="border-top:1px solid rgba(255,255,255,0.07);padding-top:14px;">
                        @csrf
                        <div style="font-size:13px;font-weight:700;color:#e2e8f0;margin-bottom:10px;display:flex;align-items:center;gap:6px;"><svg width="14" height="14" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>Edit Pengumpulan</div>
                        
                        @if($tugas->tipe_file === 'link')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Tautan Jawaban</label>
                                <input type="url" 
                                       name="file_url" 
                                       value="{{ old('file_url', $submission->file_url) }}" 
                                       style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;transition:border-color 0.2s;" 
                                       placeholder="https://..."
                                       onfocus="this.style.borderColor='#3b82f6'"
                                       onblur="this.style.borderColor='#e2e8f0'">
                            </div>
                            
                        @elseif($tugas->tipe_file === 'gambar')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Unggah Gambar Baru</label>
                                @if($submission->file_url && !str_starts_with($submission->file_url, 'http'))
                                <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;margin-bottom:8px;font-size:12px;color:#166534;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>File saat ini: <strong>{{ basename($submission->file_url) }}</strong></span>
                                </div>
                                @endif
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-edit-upload" 
                                       accept=".jpg,.jpeg,.png,.gif,.webp" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-edit-preview', 'file-edit-name')">
                                <p id="file-edit-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">JPG, PNG, GIF (Maks 50MB) - Kosongkan jika tidak ingin mengubah</p>
                                <div id="file-edit-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                            
                        @elseif($tugas->tipe_file === 'dokumen')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Unggah Dokumen Baru</label>
                                @if($submission->file_url && !str_starts_with($submission->file_url, 'http'))
                                <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;margin-bottom:8px;font-size:12px;color:#166534;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>File saat ini: <strong>{{ basename($submission->file_url) }}</strong></span>
                                </div>
                                @endif
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-edit-upload" 
                                       accept=".pdf,.doc,.docx,.zip,.rar" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-edit-preview', 'file-edit-name')">
                                <p id="file-edit-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">PDF, DOC, DOCX, ZIP, RAR (Maks 50MB) - Kosongkan jika tidak ingin mengubah</p>
                                <div id="file-edit-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                            
                        @elseif($tugas->tipe_file === 'video')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Unggah Video Baru</label>
                                @if($submission->file_url && !str_starts_with($submission->file_url, 'http'))
                                <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;margin-bottom:8px;font-size:12px;color:#166534;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>File saat ini: <strong>{{ basename($submission->file_url) }}</strong></span>
                                </div>
                                @endif
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-edit-upload" 
                                       accept=".mp4,.webm,.ogg" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-edit-preview', 'file-edit-name')">
                                <p id="file-edit-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">MP4, WebM, OGG (Maks 50MB) - Kosongkan jika tidak ingin mengubah</p>
                                <div id="file-edit-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                        @endif
                        
                        <div style="margin-bottom:12px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Catatan (Opsional)</label>
                            <textarea name="catatan" 
                                      rows="3" 
                                      style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;resize:vertical;transition:border-color 0.2s;"
                                      onfocus="this.style.borderColor='#3b82f6'"
                                      onblur="this.style.borderColor='#e2e8f0'">{{ old('catatan', $submission->catatan) }}</textarea>
                        </div>
                        
                        <button type="submit" 
                                style="width:100%;padding:12px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:opacity 0.2s;display:flex;align-items:center;justify-content:center;gap:8px;"
                                onmouseover="this.style.opacity='0.9'"
                                onmouseout="this.style.opacity='1'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                            Simpan Perubahan
                        </button>
                    </form>
                    @endif
                @endif

            @else
                @if($isPast && !$tugas->allow_late)
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);border-radius:12px;">
                        <svg width="20" height="20" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div style="color:#fca5a5;font-size:13px;"><strong>Batas Waktu Sudah Terlewat</strong><br><span style="font-size:12px;color:#f8717188;">Pengumpulan terlambat tidak diizinkan untuk tugas ini.</span></div>
                    </div>
                @else
                    @if($isPast)
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);border-radius:12px;margin-bottom:14px;">
                        <svg width="20" height="20" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <div style="color:#fcd34d;font-size:13px;"><strong>Pengumpulan Terlambat Diizinkan</strong><br><span style="font-size:12px;color:#fbbf2499;">Batas waktu telah berakhir, namun Anda masih dapat mengumpulkan.</span></div>
                    </div>
                    @endif
                    <form id="formPengumpulan" action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="font-size:13px;font-weight:700;color:#e2e8f0;margin-bottom:12px;display:flex;align-items:center;gap:6px;"><svg width="14" height="14" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>Form Pengumpulan Tugas</div>
                        
                        @if($tugas->tipe_file === 'link')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">
                                    Tautan Jawaban <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="url" 
                                       name="file_url" 
                                       id="input-url" 
                                       required 
                                       style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;transition:border-color 0.2s;" 
                                       placeholder="https://..." 
                                       value="{{ old('file_url') }}"
                                       onfocus="this.style.borderColor='#3b82f6'"
                                       onblur="this.style.borderColor='#e2e8f0'">
                                <p style="font-size:11px;color:#64748b;margin-top:4px;">
                                    Contoh: https://drive.google.com/..., https://github.com/...
                                </p>
                            </div>
                            
                        @elseif($tugas->tipe_file === 'gambar')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">
                                    Pilih Gambar Jawaban <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-new-upload" 
                                       required 
                                       accept=".jpg,.jpeg,.png,.gif,.webp" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-new-preview', 'file-new-name')">
                                <p id="file-new-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">
                                    JPG, PNG, GIF, WebP (Maks 50MB)
                                </p>
                                <div id="file-new-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                            
                        @elseif($tugas->tipe_file === 'dokumen')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">
                                    Pilih Dokumen Jawaban <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-new-upload" 
                                       required 
                                       accept=".pdf,.doc,.docx,.zip,.rar" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-new-preview', 'file-new-name')">
                                <p id="file-new-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">
                                    PDF, DOC, DOCX, ZIP, RAR (Maks 50MB)
                                </p>
                                <div id="file-new-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                            
                        @elseif($tugas->tipe_file === 'video')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">
                                    Pilih Video Jawaban <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="file" 
                                       name="file_upload" 
                                       id="file-new-upload" 
                                       required 
                                       accept=".mp4,.webm,.ogg" 
                                       style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;background:#fff;" 
                                       onchange="showFilePreview(this, 'file-new-preview', 'file-new-name')">
                                <p id="file-new-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">
                                    MP4, WebM, OGG (Maks 50MB)
                                </p>
                                <div id="file-new-preview" style="display:none;margin-top:10px;"></div>
                            </div>
                        @endif
                        
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" 
                                      rows="3" 
                                      style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;resize:vertical;transition:border-color 0.2s;" 
                                      placeholder="Catatan untuk pengajar..."
                                      onfocus="this.style.borderColor='#3b82f6'"
                                      onblur="this.style.borderColor='#e2e8f0'">{{ old('catatan') }}</textarea>
                        </div>
                        
                        <button type="submit" 
                                id="btnSubmit"
                                style="width:100%;padding:12px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:opacity 0.2s;display:flex;align-items:center;justify-content:center;gap:8px;"
                                onmouseover="this.style.opacity='0.9'"
                                onmouseout="this.style.opacity='1'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                            Kirim Tugas
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
// Preview file yang dipilih (gambar langsung ditampilkan)
function showFilePreview(input, previewId, nameId) {
    const preview = document.getElementById(previewId);
    const nameDisplay = document.getElementById(nameId);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const isTooBig = sizeMB > 50;
        
        // Update nama file
        if (isTooBig) {
            nameDisplay.innerHTML = `<span style="color:#f87171;">File terlalu besar (${sizeMB} MB). Maksimal 50 MB!</span>`;
            nameDisplay.style.color = '#f87171';
            input.value = '';
            preview.style.display = 'none';
            return;
        } else {
            nameDisplay.innerHTML = `Dipilih: <strong>${file.name}</strong> (${sizeMB} MB)`;
            nameDisplay.style.color = '#34d399';
        }
        
        // Jika file adalah gambar, tampilkan preview
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div style="background:#f8faff;border:2px solid #dbeafe;border-radius:12px;padding:10px;text-align:center;">
                        <p style="font-size:12px;font-weight:600;color:#1e40af;margin-bottom:8px;">Preview Gambar:</p>
                        <img src="${e.target.result}" alt="Preview" style="max-width:100%;max-height:300px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    </div>
                `;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
}

// Konfirmasi sebelum submit
document.addEventListener('DOMContentLoaded', function() {
    // Form pengumpulan baru
    const formPengumpulan = document.getElementById('formPengumpulan');
    if (formPengumpulan) {
        formPengumpulan.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Kirim Tugas?',
                text: 'Pastikan semua data sudah benar. Tugas akan dikirim ke pengajar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6B1A2B',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Mengirim...',
                        text: 'Mohon tunggu, file sedang diunggah',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    formPengumpulan.submit();
                }
            });
        });
    }
    
    // Form edit pengumpulan
    const formEdit = document.getElementById('formEditPengumpulan');
    if (formEdit) {
        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Perubahan pengumpulan tugas akan disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6B1A2B',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu, perubahan sedang disimpan',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    formEdit.submit();
                }
            });
        });
    }
});

// Fungsi lama untuk backward compatibility
function showFileName(input, targetId) {
    showFilePreview(input, targetId + '-preview', targetId);
}

function confirmSubmit(event, type) {
    // Function ini sudah digantikan dengan event listener di atas
    // Tapi tetap dipertahankan untuk backward compatibility
    return true;
}
</script>
@endpush
</x-student-layout>
