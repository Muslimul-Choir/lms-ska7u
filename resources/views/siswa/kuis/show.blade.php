<x-student-layout>
<x-slot name="heading">{{ Str::limit($kuis->judul, 40) }}</x-slot>
<x-slot name="back">
    @php
        // Get mapel_id from query parameter (from mapel detail page)
        $fromMapel = request('from') === 'mapel';
        $backMapelId = request('mapel_id');
        
        // Determine back URL based on source
        if ($fromMapel && $backMapelId) {
            $backUrl = route('siswa.materi.mapel', $backMapelId);
        } else {
            $backUrl = route('siswa.kuis.index');
        }
    @endphp
    <a href="{{ $backUrl }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:background .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

<div style="max-width:680px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Header Card --}}
    <div style="background:rgba(22,28,45,0.85);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:18px;padding:24px;">
        <span style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;background:rgba(59,130,246,0.12);color:#60a5fa;border:1px solid rgba(59,130,246,0.25);margin-bottom:16px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
            Kuis Tersedia
        </span>
        <h1 style="font-size:clamp(18px,4vw,24px);font-weight:800;color:#f1f5f9;line-height:1.3;margin:0 0 18px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $kuis->judul }}</h1>

        @if($kuis->deskripsi)
        <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.18);border-radius:12px;padding:14px;margin-bottom:16px;">
            <div style="font-size:13px;line-height:1.75;color:#94a3b8;">{!! nl2br(e($kuis->deskripsi)) !!}</div>
        </div>
        @endif

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:16px;">
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Mata Pelajaran</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }}</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Pengajar</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ $kuis->GuruMapel?->Guru?->nama_lengkap ?? '-' }}</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Jumlah Soal</div>
                <div style="font-size:13px;font-weight:700;color:#e2e8f0;">{{ $jumlahSoal }} Soal</div>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 12px;">
                <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Durasi</div>
                <div style="font-size:13px;font-weight:700;color:#a78bfa;">{{ $kuis->durasi }} Menit</div>
            </div>
        </div>

        <div style="display:flex;align-items:start;gap:10px;padding:14px;border-radius:12px;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.2);">
            <svg width="18" height="18" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            <div style="font-size:13px;color:#6ee7b7;font-weight:500;">
                <div><strong style="color:#34d399;">Batas Mulai:</strong> {{ \Carbon\Carbon::parse($kuis->batas_mulai)->format('d M Y, H:i') }}</div>
                <div style="margin-top:4px;"><strong style="color:#34d399;">Batas Selesai:</strong> {{ \Carbon\Carbon::parse($kuis->batas_selesai)->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- Informasi Penting --}}
    <div style="background:rgba(22,28,45,0.85);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
        <div style="display:flex;align-items:center;gap:8px;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.07);">
            <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <span style="font-size:12px;font-weight:700;color:#fbbf24;text-transform:uppercase;letter-spacing:.07em;">Informasi Penting</span>
        </div>
        <div style="padding:16px 20px;">
            <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                @php
                    $rules = [
                        "Kuis ini hanya dapat dikerjakan <strong style='color:#f1f5f9;'>satu kali</strong>",
                        "Waktu pengerjaan: <strong style='color:#f1f5f9;'>$kuis->durasi menit</strong>",
                        "Timer akan berjalan otomatis setelah Anda memulai kuis",
                        "Jika waktu habis, jawaban akan otomatis dikumpulkan",
                        "Pastikan koneksi internet Anda stabil",
                        "Nilai maksimal: <strong style='color:#a78bfa;'>" . number_format($kuis->nilai_maksimal,1) . "</strong>",
                    ];
                @endphp
                @foreach($rules as $rule)
                <li style="display:flex;align-items:start;gap:10px;">
                    <div style="width:18px;height:18px;border-radius:50%;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                        <svg width="10" height="10" fill="#60a5fa" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                    <span style="font-size:13px;color:#94a3b8;line-height:1.5;">{!! $rule !!}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Tombol Mulai --}}
    <div style="background:rgba(22,28,45,0.85);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center;">
        <div style="font-size:13px;font-weight:500;color:#64748b;margin-bottom:18px;">Pastikan Anda sudah siap sebelum memulai kuis</div>
        <form action="{{ route('siswa.kuis.mulai', $kuis->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memulai kuis? Timer akan langsung berjalan.');">
            @csrf
            <button type="submit" style="width:100%;max-width:340px;padding:14px 24px;background:linear-gradient(135deg,#6B1A2B,#9B2C2C);color:#fff;border:none;border-radius:14px;font-size:15px;font-weight:800;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;display:inline-flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 4px 20px rgba(107,26,43,0.5);transition:transform .18s,box-shadow .18s;letter-spacing:.02em;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 32px rgba(107,26,43,0.6)'"
                onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(107,26,43,0.5)'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Mulai Kuis Sekarang
            </button>
        </form>
        <div style="margin-top:16px;">
            <a href="{{ route('siswa.kuis.index') }}" style="font-size:13px;color:#64748b;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:color .15s;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#64748b'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
               
            </a>
        </div>
    </div>

</div>
</x-student-layout>
