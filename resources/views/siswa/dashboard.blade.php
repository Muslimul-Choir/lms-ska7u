<x-student-layout>
    <x-slot name="heading">Dashboard</x-slot>

    @php
        $totalTugas   = count($tugasProgress);
        $submitted    = collect($tugasProgress)->where('status','submitted')->count();
        $graded       = collect($tugasProgress)->filter(fn($i) => $i['assessment'])->count();
        $pending      = $totalTugas - $submitted;
        $totalAbsensi = array_sum($absensiSummary);
        $hadirRate    = $totalAbsensi > 0 ? round(($absensiSummary['hadir'] / $totalAbsensi) * 100) : 100;
    @endphp

    {{-- ══ HERO BANNER ══ --}}
    <div style="background:linear-gradient(135deg,#6B1A2B 0%,#3D0A13 55%,#1a0a00 100%);padding:32px 20px 70px;position:relative;overflow:hidden;">
        {{-- Grid overlay --}}
        <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;"></div>
        {{-- Glow orbs --}}
        <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(201,152,42,0.25),transparent 70%);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-40px;left:-30px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(107,26,43,0.5),transparent 70%);pointer-events:none;"></div>

        <div style="max-width:960px;margin:0 auto;position:relative;z-index:1;">
            <p style="font-size:11px;font-weight:700;color:rgba(201,152,42,0.8);letter-spacing:.12em;text-transform:uppercase;margin-bottom:6px;display:flex;align-items:center;gap:6px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                Selamat Datang
            </p>
            <h1 style="font-size:clamp(22px,5vw,30px);font-weight:800;color:#fff;margin:0 0 12px;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;text-shadow:0 2px 12px rgba(0,0,0,0.4);">{{ $siswa->nama_lengkap }}</h1>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @if($kelas)
                <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.15);border-radius:99px;padding:4px 14px;font-size:12px;color:#e2e8f0;font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                    {{ $kelas->Tingkatan?->nama_tingkatan }} {{ $kelas->Jurusan?->nama_jurusan }} {{ $kelas->Bagian?->nama_bagian }}
                </span>
                @endif
                <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(201,152,42,0.2);border:1px solid rgba(201,152,42,0.35);border-radius:99px;padding:4px 14px;font-size:12px;color:#f0be3d;font-weight:700;">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"/></svg>
                    Siswa Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- ══ STATS CARDS (float over hero) ══ --}}
    <div style="max-width:960px;margin:-44px auto 0;padding:0 16px;position:relative;z-index:2;">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">

            {{-- Tugas Card --}}
            <div style="background:rgba(22,28,45,0.9);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:18px;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                <div style="width:38px;height:38px;border-radius:11px;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <svg width="18" height="18" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div style="font-size:30px;font-weight:900;color:#f1f5f9;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ $totalTugas }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-top:4px;">Total Tugas</div>
                <div style="display:flex;gap:6px;margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.07);">
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(16,185,129,0.12);color:#34d399;font-weight:700;border:1px solid rgba(16,185,129,0.2);">Selesai {{ $submitted }}</span>
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(239,68,68,0.12);color:#f87171;font-weight:700;border:1px solid rgba(239,68,68,0.2);">Sisa {{ $pending }}</span>
                </div>
            </div>

            {{-- Kehadiran Card --}}
            <div style="background:rgba(22,28,45,0.9);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:18px;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                <div style="width:38px;height:38px;border-radius:11px;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <svg width="18" height="18" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="font-size:30px;font-weight:900;color:#f1f5f9;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ $hadirRate }}%</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-top:4px;">Kehadiran</div>
                <div style="display:flex;gap:6px;margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.07);">
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(245,158,11,0.12);color:#fbbf24;font-weight:700;border:1px solid rgba(245,158,11,0.2);">Izin {{ $absensiSummary['izin'] }}</span>
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(239,68,68,0.12);color:#f87171;font-weight:700;border:1px solid rgba(239,68,68,0.2);">Alpha {{ $absensiSummary['alpha'] }}</span>
                </div>
            </div>

            {{-- Nilai Card --}}
            <div style="background:rgba(22,28,45,0.9);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:18px;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                <div style="width:38px;height:38px;border-radius:11px;background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <svg width="18" height="18" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>
                </div>
                <div style="font-size:30px;font-weight:900;color:#f1f5f9;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($nilaiStats['average_grade'],1) }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-top:4px;">Rata-rata Nilai</div>
                <div style="display:flex;gap:6px;margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.07);">
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(139,92,246,0.12);color:#a78bfa;font-weight:700;border:1px solid rgba(139,92,246,0.2);">Max {{ number_format($nilaiStats['highest_grade'],1) }}</span>
                </div>
            </div>

            {{-- Materi Card --}}
            <div style="background:rgba(22,28,45,0.9);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:18px;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                <div style="width:38px;height:38px;border-radius:11px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <svg width="18" height="18" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div style="font-size:30px;font-weight:900;color:#f1f5f9;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ count($materi) }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-top:4px;">Materi Tersedia</div>
                <div style="display:flex;gap:6px;margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.07);">
                    <span style="font-size:10px;padding:2px 8px;border-radius:99px;background:rgba(201,152,42,0.12);color:#c9982a;font-weight:700;border:1px solid rgba(201,152,42,0.2);">Semua mapel</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ BODY CONTENT ══ --}}
    <div style="max-width:960px;margin:20px auto 0;padding:0 16px;display:flex;flex-direction:column;gap:16px;">

        {{-- ── Tugas Saya ── --}}
        <div style="background:rgba(22,28,45,0.7);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.07);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:9px;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span style="font-size:15px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Tugas Saya</span>
                </div>
                <a href="{{ route('siswa.tugas.index') }}" style="font-size:12px;font-weight:600;color:#c9982a;text-decoration:none;display:flex;align-items:center;gap:4px;">
                    Lihat semua
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div style="max-height:400px;overflow-y:auto;">
            @forelse($tugasProgress as $item)
                @php
                    $task = $item['task'];
                    $isPast = $task->batas_waktu && \Carbon\Carbon::parse($task->batas_waktu)->isPast();
                    if ($item['assessment'])      { $bg='rgba(16,185,129,0.12)';$tc='#34d399';$label='Dinilai'; }
                    elseif ($item['submission'])   { $bg='rgba(59,130,246,0.12)';$tc='#60a5fa';$label='Dikumpulkan'; }
                    elseif ($isPast)               { $bg='rgba(239,68,68,0.12)';$tc='#f87171';$label='Terlewat'; }
                    else                           { $bg='rgba(245,158,11,0.12)';$tc='#fbbf24';$label='Aktif'; }
                @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.04);text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.background='transparent'">
                    <div style="width:8px;height:8px;border-radius:50%;background:{{ $tc }};flex-shrink:0;box-shadow:0 0 6px {{ $tc }};"></div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                            @if($task->batas_waktu)
                            <span style="display:flex;align-items:center;gap:4px;">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                {{ \Carbon\Carbon::parse($task->batas_waktu)->format('d M Y') }}
                            </span>
                            @endif
                            @if($item['assessment'])<span style="color:#a78bfa;font-weight:700;">Nilai: {{ $item['assessment']->nilai }}</span>@endif
                        </div>
                    </div>
                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;background:{{ $bg }};color:{{ $tc }};white-space:nowrap;border:1px solid {{ $tc }}33;">{{ $label }}</span>
                    <svg width="16" height="16" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
            </div>
                <div style="padding:36px 20px;text-align:center;color:#475569;">
                    <div style="width:52px;height:52px;margin:0 auto 12px;border-radius:14px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);display:flex;align-items:center;justify-content:center;">
                        <svg width="24" height="24" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:600;color:#64748b;">Semua tugas selesai!</div>
                    <div style="font-size:12px;color:#475569;margin-top:4px;">Tidak ada tugas aktif saat ini.</div>
                </div>
            @endforelse
            @if(count($tugasProgress) > 0)
            </div>
            @endif
        </div>

        {{-- ── Materi Terbaru ── --}}
        <div style="background:rgba(22,28,45,0.7);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.07);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:9px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <span style="font-size:15px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Materi Terbaru</span>
                </div>
                <a href="{{ route('siswa.materi.index') }}" style="font-size:12px;font-weight:600;color:#c9982a;text-decoration:none;display:flex;align-items:center;gap:4px;">
                    Lihat semua
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div style="max-height:400px;overflow-y:auto;">
            @php
                $typeIconMap = [
                    'dokumen' => ['stroke'=>'#60a5fa','bg'=>'rgba(59,130,246,0.15)','path'=>'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                    'video'   => ['stroke'=>'#f472b6','bg'=>'rgba(244,114,182,0.15)','path'=>'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z'],
                    'link'    => ['stroke'=>'#fbbf24','bg'=>'rgba(251,191,36,0.15)','path'=>'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
                    'lainnya' => ['stroke'=>'#94a3b8','bg'=>'rgba(148,163,184,0.15)','path'=>'M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z'],
                ];
            @endphp
            @forelse($materi->take(5) as $m)
                @php $tInfo = $typeIconMap[$m->tipe_materi] ?? $typeIconMap['lainnya']; @endphp
                <a href="{{ route('siswa.materi.show', $m->id) }}" style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid rgba(255,255,255,0.04);text-decoration:none;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.background='transparent'">
                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $tInfo['bg'] }};border:1px solid {{ $tInfo['stroke'] }}33;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="18" height="18" fill="none" stroke="{{ $tInfo['stroke'] }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $tInfo['path'] }}"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">{{ $m->created_at->format('d M Y') }}</div>
                    </div>
                    <svg width="16" height="16" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
            </div>
                <div style="padding:36px 20px;text-align:center;">
                    <div style="width:52px;height:52px;margin:0 auto 12px;border-radius:14px;background:rgba(201,152,42,0.1);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                        <svg width="24" height="24" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div style="font-size:14px;font-weight:600;color:#64748b;">Belum ada materi tersedia.</div>
                </div>
            @endforelse
            @if($materi->count() > 0)
            </div>
            @endif
        </div>

        {{-- ── Nilai Terbaru ── --}}
        @if($penilaian->count() > 0)
        <div style="background:rgba(22,28,45,0.7);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.2);display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="#a78bfa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>
                </div>
                <span style="font-size:15px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Nilai Terbaru</span>
            </div>
            @foreach($penilaian->take(4) as $grade)
                @php $pct = min(($grade->nilai/$grade->nilai_maksimal_snapshot)*100,100); @endphp
                <div style="padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.04);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <span style="font-size:13px;font-weight:600;color:#e2e8f0;">{{ Str::limit($grade->PengumpulanTugas?->Tugas?->judul ?? 'Tugas',36) }}</span>
                        <span style="font-size:17px;font-weight:800;color:#a78bfa;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($grade->nilai,1) }}<small style="font-size:11px;color:#475569;font-weight:500;">/{{ $grade->nilai_maksimal_snapshot }}</small></span>
                    </div>
                    <div class="sl-progress">
                        <div class="sl-progress-bar" style="width:{{ $pct }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>
</x-student-layout>
