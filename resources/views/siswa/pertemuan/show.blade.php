<x-student-layout>
<x-slot name="heading">Detail Pertemuan</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.pertemuan.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:10px;color:#fff;text-decoration:none;flex-shrink:0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $status    = strtolower($pertemuan->status ?? 'dijadwalkan');
    $mapelNama = $pertemuan->jadwalBelajar?->mapel?->nama_mapel ?? $pertemuan->jadwalBelajar?->nama_kegiatan ?? 'Pertemuan';
    $guruNama  = $pertemuan->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? '-';
    $badgeColors = ['selesai'=>['#dcfce7','#15803d'],'berlangsung'=>['#dbeafe','#1d4ed8'],'dibatalkan'=>['#fee2e2','#991b1b'],'dijadwalkan'=>['#fef3c7','#92400e']];
    [$bbg,$btc] = $badgeColors[$status] ?? ['#f1f5f9','#475569'];
@endphp

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Hero --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="background:linear-gradient(135deg,#1e3a5f,#1e40af);padding:20px;">
            <div style="font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</div>
            <div style="font-size:20px;font-weight:900;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelNama }}</div>
        </div>
        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
            @if($pertemuan->tanggal)
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#0f172a;">
                <span style="font-size:18px;">📅</span>
                <div><div style="font-size:11px;color:#64748b;font-weight:600;margin-bottom:1px;">Tanggal</div>{{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('l, d F Y') }}</div>
            </div>
            @endif
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#0f172a;">
                <span style="font-size:18px;">👨‍🏫</span>
                <div><div style="font-size:11px;color:#64748b;font-weight:600;margin-bottom:1px;">Guru Pengajar</div>{{ $guruNama }}</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#0f172a;">
                <span style="font-size:18px;">📊</span>
                <div><div style="font-size:11px;color:#64748b;font-weight:600;margin-bottom:1px;">Status</div>
                    <span style="font-size:12px;font-weight:700;padding:3px 10px;border-radius:99px;background:{{ $bbg }};color:{{ $btc }};">{{ ucfirst($status) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Materi --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">📚 Materi Pertemuan</span>
            <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;background:#f1f5f9;color:#64748b;">{{ $pertemuan->materis->count() }}</span>
        </div>
        @forelse($pertemuan->materis as $materi)
            @php $icons=['dokumen'=>['📄','#eff6ff'],'video'=>['🎥','#fdf2f8'],'link'=>['🔗','#fffbeb']]; [$ico,$ibg]=$icons[$materi->tipe_materi]??['📁','#f8fafc']; @endphp
            <a href="{{ route('siswa.materi.show', $materi->id) }}" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #f8fafc;text-decoration:none;color:#0f172a;transition:background .15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $ibg }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $ico }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $materi->judul }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;text-transform:capitalize;">{{ $materi->tipe_materi }}</div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:13px;">📭 Belum ada materi untuk pertemuan ini.</div>
        @endforelse
    </div>

    {{-- Tugas --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">📝 Tugas Pertemuan</span>
            <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;background:#f1f5f9;color:#64748b;">{{ $pertemuan->tugas->count() }}</span>
        </div>
        @forelse($pertemuan->tugas as $tugas)
            <a href="{{ route('siswa.tugas.show', $tugas->id) }}" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #f8fafc;text-decoration:none;color:#0f172a;border-left:3px solid #f59e0b;transition:background .15s;" onmouseover="this.style.background='#fffbeb'" onmouseout="this.style.background='transparent'">
                <div style="width:40px;height:40px;border-radius:10px;background:#fff8eb;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">📝</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tugas->judul }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">
                        @if($tugas->batas_waktu)⏱ {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y') }}@else Klik untuk melihat tugas@endif
                    </div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <div style="padding:24px 20px;text-align:center;color:#94a3b8;font-size:13px;">📭 Belum ada tugas untuk pertemuan ini.</div>
        @endforelse
    </div>

</div>
</x-student-layout>
