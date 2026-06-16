<x-student-layout>
<x-slot name="heading">Detail Pertemuan</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.pertemuan.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

@php
    $status    = strtolower($pertemuan->status ?? 'dijadwalkan');
    $mapelNama = $pertemuan->jadwalBelajar?->mapel?->nama_mapel ?? $pertemuan->jadwalBelajar?->nama_kegiatan ?? 'Pertemuan';
    $guruNama  = $pertemuan->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? '-';
    $badgeColors = [
        'selesai'     => ['rgba(34,197,94,0.12)','#4ade80','rgba(34,197,94,0.25)'],
        'berlangsung' => ['rgba(59,130,246,0.12)','#60a5fa','rgba(59,130,246,0.25)'],
        'dibatalkan'  => ['rgba(239,68,68,0.12)', '#f87171','rgba(239,68,68,0.25)'],
        'dijadwalkan' => ['rgba(245,158,11,0.12)','#fbbf24','rgba(245,158,11,0.25)'],
    ];
    [$bbg,$btc,$bborder] = $badgeColors[$status] ?? ['rgba(148,163,184,0.12)','#94a3b8','rgba(148,163,184,0.25)'];
@endphp

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Hero --}}
    <div style="background:linear-gradient(135deg,rgba(107,26,43,0.95),rgba(61,10,19,0.9));backdrop-filter:blur(12px);border:1px solid rgba(201,152,42,0.2);border-radius:18px;overflow:hidden;">
        <div style="padding:22px 22px 18px;position:relative;">
            <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(201,152,42,0.15),transparent 70%);pointer-events:none;"></div>
            <div style="font-size:11px;font-weight:700;color:rgba(201,152,42,0.8);text-transform:uppercase;letter-spacing:.1em;margin-bottom:5px;">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</div>
            <div style="font-size:22px;font-weight:900;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelNama }}</div>
        </div>
        <div style="padding:14px 22px 20px;display:flex;flex-direction:column;gap:12px;background:rgba(0,0,0,0.15);border-top:1px solid rgba(255,255,255,0.08);">
            @if($pertemuan->tanggal)
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#e2e8f0;">
                <div style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="15" height="15" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div><div style="font-size:10px;color:rgba(255,255,255,0.5);font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:1px;">Tanggal</div>{{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('l, d F Y') }}</div>
            </div>
            @endif
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#e2e8f0;">
                <div style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="15" height="15" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <div><div style="font-size:10px;color:rgba(255,255,255,0.5);font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:1px;">Guru Pengajar</div>{{ $guruNama }}</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#e2e8f0;">
                <div style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="15" height="15" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.5);font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Status</div>
                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;background:{{ $bbg }};color:{{ $btc }};border:1px solid {{ $bborder }};">{{ ucfirst($status) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Materi --}}
    <div style="background:rgba(22,28,45,0.75);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <span style="font-size:14px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Materi Pertemuan</span>
            </div>
            <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;background:rgba(255,255,255,0.06);color:#64748b;border:1px solid rgba(255,255,255,0.1);">{{ $pertemuan->materis->count() }}</span>
        </div>
        @php
            $typeMap = [
                'dokumen' => ['#60a5fa','rgba(59,130,246,0.12)','M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                'video'   => ['#f472b6','rgba(244,114,182,0.12)','M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z'],
                'link'    => ['#fbbf24','rgba(251,191,36,0.12)','M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
            ];
        @endphp
        @forelse($pertemuan->materis as $materi)
            @php [$ic,$ib,$ip] = $typeMap[$materi->tipe_materi] ?? ['#94a3b8','rgba(148,163,184,0.12)','M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z']; @endphp
            <a href="{{ route('siswa.materi.show', $materi->id) }}" style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid rgba(255,255,255,0.04);text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.background='transparent'">
                <div style="width:38px;height:38px;border-radius:10px;background:{{ $ib }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" fill="none" stroke="{{ $ic }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ip }}"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $materi->judul }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;text-transform:capitalize;">{{ $materi->tipe_materi }}</div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <div style="padding:22px 20px;text-align:center;color:#475569;font-size:13px;">Belum ada materi untuk pertemuan ini.</div>
        @endforelse
    </div>

    {{-- Tugas --}}
    <div style="background:rgba(22,28,45,0.75);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:28px;height:28px;border-radius:8px;background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.2);display:flex;align-items:center;justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                </div>
                <span style="font-size:14px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Tugas Pertemuan</span>
            </div>
            <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;background:rgba(255,255,255,0.06);color:#64748b;border:1px solid rgba(255,255,255,0.1);">{{ $pertemuan->tugas->count() }}</span>
        </div>
        @forelse($pertemuan->tugas as $tugas)
            <a href="{{ route('siswa.tugas.show', $tugas->id) }}" style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid rgba(255,255,255,0.04);border-left:3px solid rgba(245,158,11,0.5);text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(245,158,11,0.05)'" onmouseout="this.style.background='transparent'">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tugas->judul }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:4px;">
                        @if($tugas->batas_waktu)
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y') }}
                        @else Klik untuk melihat tugas @endif
                    </div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <div style="padding:22px 20px;text-align:center;color:#475569;font-size:13px;">Belum ada tugas untuk pertemuan ini.</div>
        @endforelse
    </div>

</div>
</x-student-layout>
