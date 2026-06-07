<x-student-layout>
<x-slot name="heading">{{ Str::limit($tugas->judul, 40) }}</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.tugas.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:10px;color:#fff;text-decoration:none;flex-shrink:0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $isPast = $tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast();
    if ($submission && $assessment)    { $sLabel='✓ Sudah Dinilai';        $sBg='#dcfce7'; $sText='#166534'; }
    elseif ($submission)               { $sLabel='✓ Sudah Dikumpulkan';    $sBg='#dbeafe'; $sText='#1d4ed8'; }
    elseif ($isPast)                   { $sLabel='⏰ Waktu Terlewat';       $sBg='#fee2e2'; $sText='#991b1b'; }
    else                               { $sLabel='⏳ Menunggu Pengumpulan'; $sBg='#fef3c7'; $sText='#92400e'; }
@endphp

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Header Card --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);padding:20px;">
        <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;background:{{ $sBg }};color:{{ $sText }};margin-bottom:12px;">{{ $sLabel }}</span>
        <h1 style="font-size:clamp(18px,4vw,24px);font-weight:800;color:#0f172a;line-height:1.3;margin:0 0 16px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $tugas->judul }}</h1>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
            <div style="background:#f8faff;border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Mata Pelajaran</div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $tugas->Mapel?->nama_mapel ?? $tugas->guruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
            </div>
            <div style="background:#f8faff;border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Pengajar</div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $tugas->guruMapel?->Guru?->nama_lengkap ?? '-' }}</div>
            </div>
            <div style="background:#f8faff;border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Tipe</div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ ucfirst($tugas->tipe_tugas) }}</div>
            </div>
            <div style="background:#f8faff;border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Nilai Maks.</div>
                <div style="font-size:13px;font-weight:700;color:#7c3aed;">{{ $tugas->nilai_maksimal }}</div>
            </div>
        </div>
        @if($tugas->batas_waktu)
        <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:12px;margin-top:12px;background:{{ $isPast ? '#fee2e2' : '#f0fdf4' }};color:{{ $isPast ? '#991b1b' : '#166534' }};font-size:13px;font-weight:600;">
            <span style="font-size:20px;">{{ $isPast ? '⏰' : '📅' }}</span>
            <div>
                <div>Batas: <strong>{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}</strong></div>
                <div style="font-size:11px;opacity:.8;">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->diffForHumans() }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Deskripsi --}}
    @if($tugas->deskripsi)
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px 0;">📋 Deskripsi Tugas</div>
        <div style="padding:12px 20px 20px;font-size:14px;line-height:1.75;color:#374151;">{!! $tugas->deskripsi !!}</div>
    </div>
    @endif

    {{-- File Tugas --}}
    @if($tugas->file_url)
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px 0;">📄 File Tugas</div>
        <div style="padding:12px 20px 20px;">
            @if($tugas->tipe_file === 'link')
                <a href="{{ $tugas->file_url }}" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 18px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;border-radius:12px;text-decoration:none;font-size:14px;font-weight:700;">
                    <span>🔗 Buka Tautan</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @elseif($tugas->tipe_file === 'video')
                <div style="background:#000;border-radius:10px;overflow:hidden;aspect-ratio:16/9;margin-bottom:12px;">
                    <video controls style="width:100%;height:100%;display:block;"><source src="{{ \Storage::disk('public')->exists($tugas->file_url) ? asset('storage/'.$tugas->file_url) : asset($tugas->file_url) }}" type="video/mp4">Browser Anda tidak mendukung video.</video>
                </div>
                <div style="display:flex;align-items:center;gap:12px;background:#f8faff;border:1.5px solid #dbeafe;border-radius:12px;padding:14px 16px;">
                    <span style="font-size:28px;">🎥</span>
                    <div style="flex:1;min-width:0;"><div style="font-size:13px;font-weight:600;color:#0f172a;word-break:break-all;">{{ basename($tugas->file_url) }}</div><div style="font-size:11px;color:#64748b;margin-top:2px;">File Video</div></div>
                    <a href="{{ \Storage::disk('public')->exists($tugas->file_url) ? asset('storage/'.$tugas->file_url) : asset($tugas->file_url) }}" download style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#1e40af;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;white-space:nowrap;">⬇️ Unduh</a>
                </div>
            @else
                <div style="display:flex;align-items:center;gap:12px;background:#f8faff;border:1.5px solid #dbeafe;border-radius:12px;padding:14px 16px;">
                    <span style="font-size:30px;">📄</span>
                    <div style="flex:1;min-width:0;"><div style="font-size:13px;font-weight:600;color:#0f172a;word-break:break-all;">{{ basename($tugas->file_url) }}</div><div style="font-size:11px;color:#64748b;margin-top:2px;">File Dokumen</div></div>
                    <a href="{{ \Storage::disk('public')->exists($tugas->file_url) ? asset('storage/'.$tugas->file_url) : asset($tugas->file_url) }}" download style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#1e40af;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;white-space:nowrap;">⬇️ Unduh</a>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Status Pengumpulan --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;padding:14px 20px 0;">📤 Status Pengumpulan</div>
        <div style="padding:12px 20px 20px;">

            @if($submission)
                <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;margin-bottom:14px;">
                    <span style="font-size:20px;">✅</span>
                    <div>
                        <div style="font-weight:700;color:#166534;font-size:13px;margin-bottom:2px;">Tugas Sudah Dikumpulkan</div>
                        <div style="color:#15803d;font-size:12px;">{{ $submission->created_at->format('d M Y, H:i') }}</div>
                        @if($submission->catatan)<div style="margin-top:6px;color:#374151;font-size:13px;font-style:italic;">"{{ $submission->catatan }}"</div>@endif
                    </div>
                </div>

                @if($assessment)
                    <div style="background:#faf5ff;border:1.5px solid #e9d5ff;border-radius:12px;padding:16px;">
                        <div style="font-size:13px;font-weight:700;color:#6b21a8;margin-bottom:12px;">📊 Hasil Penilaian</div>
                        <div style="display:flex;gap:12px;margin-bottom:12px;">
                            <div style="flex:1;background:#fff;border-radius:10px;padding:12px;text-align:center;">
                                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;margin-bottom:4px;">Nilai Anda</div>
                                <div style="font-size:32px;font-weight:900;color:#7c3aed;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($assessment->nilai,1) }}</div>
                            </div>
                            <div style="flex:1;background:#fff;border-radius:10px;padding:12px;text-align:center;">
                                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;margin-bottom:4px;">Maksimal</div>
                                <div style="font-size:32px;font-weight:900;color:#94a3b8;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($assessment->nilai_maksimal_snapshot,1) }}</div>
                            </div>
                        </div>
                        @php $pct = min(($assessment->nilai/$assessment->nilai_maksimal_snapshot)*100,100); @endphp
                        <div style="height:10px;background:#e9d5ff;border-radius:99px;overflow:hidden;margin-bottom:4px;">
                            <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#7c3aed,#a855f7);border-radius:99px;"></div>
                        </div>
                        <div style="text-align:right;font-size:12px;font-weight:700;color:#7c3aed;margin-bottom:10px;">{{ number_format($pct,1) }}%</div>
                        @if($assessment->catatan_guru)
                        <div style="background:#fff;border:1px solid #e9d5ff;border-radius:8px;padding:12px;">
                            <div style="font-size:12px;font-weight:700;color:#6b21a8;margin-bottom:4px;">Catatan Pengajar</div>
                            <div style="font-size:13px;color:#374151;">{{ $assessment->catatan_guru }}</div>
                        </div>
                        @endif
                    </div>
                @else
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#fefce8;border:1.5px solid #fef08a;border-radius:12px;margin-bottom:14px;">
                        <span style="font-size:20px;">⏳</span>
                        <div style="color:#854d0e;font-size:13px;"><strong>Menunggu Penilaian</strong><br><span style="font-size:12px;">Tugas Anda sedang diperiksa oleh pengajar.</span></div>
                    </div>
                    @if(!$isPast || $tugas->allow_late)
                    <form action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data" style="border-top:1px solid #f1f5f9;padding-top:14px;" onsubmit="return confirmSubmit(event, 'edit')">
                        @csrf
                        <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:10px;">📝 Edit Pengumpulan</div>
                        @if($tugas->tipe_file === 'link')
                            <div style="margin-bottom:12px;"><label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Tautan Jawaban</label><input type="url" name="file_url" value="{{ old('file_url',$submission->file_url) }}" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;" placeholder="https://..."></div>
                        @elseif($tugas->tipe_file !== 'tanpa')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Unggah File Baru</label>
                                @if($submission->file_url && !str_starts_with($submission->file_url, 'http'))
                                <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;margin-bottom:8px;font-size:12px;color:#166534;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>File saat ini: <strong>{{ basename($submission->file_url) }}</strong></span>
                                </div>
                                @endif
                                <input type="file" name="file_upload" id="file-edit-upload" accept=".pdf,.doc,.docx,.zip,.rar,.jpg,.jpeg,.png" style="width:100%;font-size:13px;" onchange="showFileName(this, 'file-edit-name')">
                                <p id="file-edit-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">PDF, Docx, Zip, Gambar (Maks 50MB)</p>
                            </div>
                        @endif
                        <div style="margin-bottom:12px;"><label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Catatan (Opsional)</label><textarea name="catatan" rows="3" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;resize:vertical;">{{ old('catatan',$submission->catatan) }}</textarea></div>
                        <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">💾 Simpan Perubahan</button>
                    </form>
                    @endif
                @endif

            @else
                @if($isPast && !$tugas->allow_late)
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#fff1f2;border:1.5px solid #fecdd3;border-radius:12px;">
                        <span style="font-size:20px;">⏰</span>
                        <div style="color:#9f1239;font-size:13px;"><strong>Batas Waktu Sudah Terlewat</strong><br><span style="font-size:12px;">Pengumpulan terlambat tidak diizinkan untuk tugas ini.</span></div>
                    </div>
                @else
                    @if($isPast)
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;margin-bottom:14px;">
                        <span style="font-size:20px;">⚠️</span>
                        <div style="color:#92400e;font-size:13px;"><strong>Pengumpulan Terlambat Diizinkan</strong><br><span style="font-size:12px;">Batas waktu telah berakhir, namun Anda masih dapat mengumpulkan.</span></div>
                    </div>
                    @endif
                    <form action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmSubmit(event, 'new')">
                        @csrf
                        <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:10px;">📝 Form Pengumpulan Tugas</div>
                        @if($tugas->tipe_file === 'link')
                            <div style="margin-bottom:12px;"><label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Tautan Jawaban <span style="color:#ef4444;">*</span></label><input type="url" name="file_url" required style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;" placeholder="https://..."></div>
                        @elseif($tugas->tipe_file !== 'tanpa')
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Pilih File Jawaban <span style="color:#ef4444;">*</span></label>
                                <input type="file" name="file_upload" id="file-new-upload" required accept=".pdf,.doc,.docx,.zip,.rar,.jpg,.jpeg,.png" style="width:100%;font-size:13px;" onchange="showFileName(this, 'file-new-name')">
                                <p id="file-new-name" style="font-size:11px;color:#94a3b8;margin-top:4px;">PDF, Docx, Zip, Gambar (Maks 50MB)</p>
                            </div>
                        @endif
                        <div style="margin-bottom:14px;"><label style="display:block;font-size:12px;font-weight:600;color:#64748b;margin-bottom:5px;">Catatan (Opsional)</label><textarea name="catatan" rows="3" style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;resize:vertical;" placeholder="Catatan untuk pengajar..."></textarea></div>
                        <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;">📤 Kirim Tugas</button>
                    </form>
                @endif
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
function showFileName(input, targetId) {
    const target = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const isTooBig = sizeMB > 50;
        target.innerHTML = isTooBig 
            ? `<span style="color:#ef4444;">⚠️ File terlalu besar (${sizeMB} MB). Maksimal 50 MB!</span>`
            : `✓ Dipilih: <strong>${file.name}</strong> (${sizeMB} MB)`;
        target.style.color = isTooBig ? '#ef4444' : '#166534';
    }
}

function confirmSubmit(event, type) {
    event.preventDefault();
    const form = event.target;
    
    const title = type === 'edit' ? 'Simpan Perubahan?' : 'Kirim Tugas?';
    const text = type === 'edit' 
        ? 'Perubahan pengumpulan tugas akan disimpan.' 
        : 'Pastikan semua data sudah benar. Tugas akan dikirim ke pengajar.';
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6B1A2B',
        cancelButtonColor: '#64748b',
        confirmButtonText: type === 'edit' ? '💾 Ya, Simpan' : '📤 Ya, Kirim',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    
    return false;
}
</script>
@endpush
</x-student-layout>
