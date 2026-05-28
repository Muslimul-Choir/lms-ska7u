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
    <div style="background:linear-gradient(135deg,#6B1A2B 0%,#8b1a30 60%,#9B3045 100%);padding:28px 20px 60px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.05);"></div>
        <div style="position:absolute;bottom:-30px;left:-20px;width:120px;height:120px;border-radius:50%;background:rgba(201,152,42,.08);"></div>
        <div style="max-width:900px;margin:0 auto;position:relative;z-index:1;">
            <p style="font-size:12px;font-weight:600;color:#fde68a;letter-spacing:.08em;text-transform:uppercase;margin-bottom:4px;">👋 Selamat Datang</p>
            <h1 style="font-size:clamp(20px,5vw,28px);font-weight:800;color:#fff;margin:0 0 8px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $siswa->nama_lengkap }}</h1>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @if($kelas)
                <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.15);backdrop-filter:blur(4px);border-radius:99px;padding:3px 12px;font-size:12px;color:#fff;font-weight:500;">
                    🏫 {{ $kelas->Tingkatan?->nama_tingkatan }} {{ $kelas->Jurusan?->nama_jurusan }} {{ $kelas->Bagian?->nama_bagian }}
                </span>
                @endif
                <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(201,152,42,.3);border-radius:99px;padding:3px 12px;font-size:12px;color:#fde68a;font-weight:600;">
                    ⭐ Siswa Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- ══ STATS CARDS (float over hero) ══ --}}
    <div style="max-width:900px;margin:-36px auto 0;padding:0 16px;position:relative;z-index:2;">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
            <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 4px 20px rgba(0,0,0,.1);display:flex;flex-direction:column;gap:4px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div style="font-size:28px;font-weight:900;color:#0f172a;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ $totalTugas }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;">Total Tugas</div>
                <div style="display:flex;gap:6px;margin-top:4px;padding-top:8px;border-top:1px solid #f1f5f9;">
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#dcfce7;color:#166534;font-weight:600;">✓ {{ $submitted }}</span>
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#fee2e2;color:#991b1b;font-weight:600;">✗ {{ $pending }}</span>
                </div>
            </div>
            <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 4px 20px rgba(0,0,0,.1);display:flex;flex-direction:column;gap:4px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="font-size:28px;font-weight:900;color:#0f172a;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ $hadirRate }}%</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;">Kehadiran</div>
                <div style="display:flex;gap:6px;margin-top:4px;padding-top:8px;border-top:1px solid #f1f5f9;">
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#fef3c7;color:#92400e;font-weight:600;">Izin: {{ $absensiSummary['izin'] }}</span>
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#fee2e2;color:#991b1b;font-weight:600;">Alpha: {{ $absensiSummary['alpha'] }}</span>
                </div>
            </div>
            <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 4px 20px rgba(0,0,0,.1);display:flex;flex-direction:column;gap:4px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#7c3aed" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>
                </div>
                <div style="font-size:28px;font-weight:900;color:#0f172a;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($nilaiStats['average_grade'],1) }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;">Rata-rata Nilai</div>
                <div style="display:flex;gap:6px;margin-top:4px;padding-top:8px;border-top:1px solid #f1f5f9;">
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#ede9fe;color:#5b21b6;font-weight:600;">Max: {{ number_format($nilaiStats['highest_grade'],1) }}</span>
                </div>
            </div>
            <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 4px 20px rgba(0,0,0,.1);display:flex;flex-direction:column;gap:4px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div style="font-size:28px;font-weight:900;color:#0f172a;line-height:1;font-family:'Plus Jakarta Sans',sans-serif;">{{ count($materi) }}</div>
                <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.04em;">Materi Tersedia</div>
                <div style="display:flex;gap:6px;margin-top:4px;padding-top:8px;border-top:1px solid #f1f5f9;">
                    <span style="font-size:11px;padding:2px 7px;border-radius:99px;background:#fef9c3;color:#854d0e;font-weight:600;">Semua mapel</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ BODY CONTENT ══ --}}
    <div style="max-width:900px;margin:20px auto 0;padding:0 16px;display:flex;flex-direction:column;gap:16px;">

        {{-- ── Tugas Aktif ── --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:9px;background:#dbeafe;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Tugas Saya</span>
                </div>
                <a href="{{ route('siswa.tugas.index') }}" style="font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;">Lihat semua →</a>
            </div>
            @forelse($tugasProgress as $item)
                @php
                    $task = $item['task'];
                    $isPast = $task->batas_waktu && \Carbon\Carbon::parse($task->batas_waktu)->isPast();
                    if ($item['assessment'])         { $bg='#dcfce7';$tc='#166534';$label='Dinilai'; }
                    elseif ($item['submission'])      { $bg='#dbeafe';$tc='#1d4ed8';$label='Dikumpulkan'; }
                    elseif ($isPast)                  { $bg='#fee2e2';$tc='#991b1b';$label='Terlewat'; }
                    else                              { $bg='#fef3c7';$tc='#92400e';$label='Aktif'; }
                @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #f8fafc;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="width:8px;height:8px;border-radius:50%;background:{{ $tc }};flex-shrink:0;"></div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;display:flex;gap:8px;flex-wrap:wrap;">
                            @if($task->batas_waktu)<span>📅 {{ \Carbon\Carbon::parse($task->batas_waktu)->format('d M Y') }}</span>@endif
                            @if($item['assessment'])<span style="color:#7c3aed;font-weight:700;">Nilai: {{ $item['assessment']->nilai }}</span>@endif
                        </div>
                    </div>
                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;background:{{ $bg }};color:{{ $tc }};white-space:nowrap;">{{ $label }}</span>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div style="padding:32px 20px;text-align:center;color:#94a3b8;font-size:13px;">
                    <div style="font-size:32px;margin-bottom:8px;">🎉</div>
                    Tidak ada tugas aktif saat ini.
                </div>
            @endforelse
        </div>

        {{-- ── Materi Terbaru ── --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:9px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Materi Terbaru</span>
                </div>
                <a href="{{ route('siswa.materi.index') }}" style="font-size:12px;font-weight:600;color:#1e40af;text-decoration:none;">Lihat semua →</a>
            </div>
            @php $typeIcons = ['dokumen'=>['📄','#dbeafe'],'video'=>['🎥','#fce7f3'],'link'=>['🔗','#fef3c7'],'lainnya'=>['📁','#f0f9ff']]; @endphp
            @forelse($materi->take(5) as $m)
                @php [$ico,$ibg] = $typeIcons[$m->tipe_materi] ?? ['📁','#f0f9ff']; @endphp
                <a href="{{ route('siswa.materi.show', $m->id) }}" style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid #f8fafc;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $ibg }};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $ico }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">{{ $m->created_at->format('d M Y') }}</div>
                    </div>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div style="padding:32px 20px;text-align:center;color:#94a3b8;font-size:13px;">
                    <div style="font-size:32px;margin-bottom:8px;">📚</div>
                    Belum ada materi tersedia.
                </div>
            @endforelse
        </div>

        {{-- ── Nilai Terbaru ── --}}
        @if($penilaian->count() > 0)
        <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:9px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="#7c3aed" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.377.728-.377.879 0l1.9 3.847a.75.75 0 00.566.411l4.244.617c.417.06.583.57.281.868l-3.07 2.993a.75.75 0 00-.217.669l.724 4.226c.071.417-.367.734-.741.538l-3.795-1.996a.75.75 0 00-.707 0l-3.795 1.996c-.374.196-.812-.12-.741-.538l.724-4.226a.75.75 0 00-.217-.669l-3.07-2.993c-.301-.298-.136-.807.28-.868l4.245-.617a.75.75 0 00.566-.411l1.9-3.847z"/></svg>
                </div>
                <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Nilai Terbaru</span>
            </div>
            @foreach($penilaian->take(4) as $grade)
                @php $pct = min(($grade->nilai/$grade->nilai_maksimal_snapshot)*100,100); @endphp
                <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <span style="font-size:13px;font-weight:600;color:#0f172a;">{{ Str::limit($grade->PengumpulanTugas?->Tugas?->judul ?? 'Tugas',36) }}</span>
                        <span style="font-size:16px;font-weight:800;color:#7c3aed;font-family:'Plus Jakarta Sans',sans-serif;">{{ number_format($grade->nilai,1) }}<small style="font-size:11px;color:#94a3b8;font-weight:500;">/{{ $grade->nilai_maksimal_snapshot }}</small></span>
                    </div>
                    <div style="height:6px;background:#e2e8f0;border-radius:99px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#7c3aed,#a855f7);border-radius:99px;transition:width .6s;"></div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>
</x-student-layout>
