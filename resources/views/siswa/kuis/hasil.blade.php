<x-student-layout>
<x-slot name="heading">Hasil Kuis</x-slot>
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
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
</x-slot>

@php
    $pct = $kuis->nilai_maksimal > 0 ? min(($hasilKuis->nilai / $kuis->nilai_maksimal) * 100, 100) : 0;
    $grade = $pct >= 90 ? 'A' : ($pct >= 80 ? 'B' : ($pct >= 70 ? 'C' : ($pct >= 60 ? 'D' : 'E')));
    
    // Theme accent configuration
    if ($pct >= 80) {
        $themeColor = '#10b981';
        $themeBg = 'rgba(16,185,129,0.12)';
        $themeBorder = 'rgba(16,185,129,0.25)';
        $celebrationText = 'Luar Biasa!';
        $celebrationSvg = '<svg width="48" height="48" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>';
    } elseif ($pct >= 60) {
        $themeColor = '#fbbf24';
        $themeBg = 'rgba(245,158,11,0.12)';
        $themeBorder = 'rgba(245,158,11,0.25)';
        $celebrationText = 'Bagus!';
        $celebrationSvg = '<svg width="48" height="48" fill="none" stroke="#fbbf24" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>';
    } else {
        $themeColor = '#ef4444';
        $themeBg = 'rgba(239,68,68,0.12)';
        $themeBorder = 'rgba(239,68,68,0.25)';
        $celebrationText = 'Tetap Semangat!';
        $celebrationSvg = '<svg width="48" height="48" fill="none" stroke="#ef4444" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21m0 0l-.813-5.096M9 21h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }
@endphp

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Hero Score Card --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1.5px solid {{ $themeColor }}33;border-radius:18px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.35);">
        
        {{-- Celebration Header --}}
        <div style="background:linear-gradient(135deg,#6B1A2B 0%,#3D0A13 55%,#1a0a00 100%);padding:26px 20px;text-align:center;position:relative;overflow:hidden;border-bottom:1px solid rgba(255,255,255,0.06);">
            <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;"></div>
            
            <div style="position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;">
                <div style="width:72px;height:72px;border-radius:20px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;margin-bottom:12px;animation:floatY 3s ease-in-out infinite;">
                    {!! $celebrationSvg !!}
                </div>
                <h1 style="font-size:24px;font-weight:900;color:#fff;margin:0 0 6px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $celebrationText }}</h1>
                <p style="font-size:13px;color:rgba(255,255,255,0.8);margin:0;font-weight:600;max-width:320px;">{{ $kuis->judul }}</p>
            </div>
        </div>

        {{-- Score Display --}}
        <div style="padding:22px 20px;display:flex;flex-direction:column;align-items:center;border-bottom:1px solid rgba(255,255,255,0.06);">
            <div style="position:relative;margin-bottom:16px;">
                <div style="width:110px;height:110px;border-radius:50%;background:linear-gradient(135deg,#c9982a,#f0be3d);display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(201,152,42,0.35);border:6px solid rgba(255,255,255,0.1);">
                    <span style="font-size:44px;font-weight:900;color:#1a0a00;font-family:'Plus Jakarta Sans',sans-serif;">{{ $grade }}</span>
                </div>
                <div style="position:absolute;bottom:-6px;left:50%;transform:translateX(-50%);padding:3px 12px;background:{{ $themeColor }};color:#fff;font-size:11px;font-weight:800;border-radius:99px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,0.3);">
                    {{ number_format($pct, 1) }}%
                </div>
            </div>
            
            <div style="text-align:center;">
                <div style="font-size:38px;font-weight:900;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;line-height:1;margin-bottom:4px;">{{ number_format($hasilKuis->nilai, 1) }}</div>
                <div style="font-size:13px;color:#64748b;font-weight:600;">dari {{ number_format($kuis->nilai_maksimal, 1) }} poin</div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(255,255,255,0.06);">
            <div style="background:rgba(22,28,45,0.5);padding:14px;text-align:center;">
                <div style="display:flex;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="font-size:18px;font-weight:800;color:#34d399;font-family:'Plus Jakarta Sans',sans-serif;">{{ $hasilKuis->jumlah_benar }}</div>
                <div style="font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">Benar</div>
            </div>
            <div style="background:rgba(22,28,45,0.5);padding:14px;text-align:center;">
                <div style="display:flex;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#f87171" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="font-size:18px;font-weight:800;color:#f87171;font-family:'Plus Jakarta Sans',sans-serif;">{{ $jumlahSalah }}</div>
                <div style="font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">Salah</div>
            </div>
            <div style="background:rgba(22,28,45,0.5);padding:14px;text-align:center;">
                <div style="display:flex;justify-content:center;margin-bottom:4px;">
                    <svg width="18" height="18" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div style="font-size:18px;font-weight:800;color:#60a5fa;font-family:'Plus Jakarta Sans',sans-serif;">{{ $soalList->count() }}</div>
                <div style="font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;">Total Soal</div>
            </div>
        </div>

        {{-- Time Info --}}
        @if($hasilKuis->waktu_mulai && $hasilKuis->waktu_selesai)
        <div style="padding:16px 20px;background:rgba(255,255,255,0.02);display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(244,114,182,0.15);border:1px solid rgba(244,114,182,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" fill="none" stroke="#f472b6" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div style="font-size:11px;color:#94a3b8;line-height:1.4;">
                    <div>Mulai: <strong>{{ $hasilKuis->waktu_mulai->format('d M, H:i') }}</strong></div>
                    <div>Selesai: <strong>{{ $hasilKuis->waktu_selesai->format('d M, H:i') }}</strong></div>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:18px;font-weight:800;color:#f472b6;font-family:'Plus Jakarta Sans',sans-serif;">{{ $hasilKuis->waktu_mulai->diffInMinutes($hasilKuis->waktu_selesai) }}</div>
                <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;">Menit</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Answer Review Section --}}
    <div style="margin-top:8px;display:flex;flex-direction:column;gap:14px;">
        
        {{-- Section Header --}}
        <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:16px 20px;display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 style="font-size:15px;font-weight:800;color:#f1f5f9;margin:0 0 2px;font-family:'Plus Jakarta Sans',sans-serif;">Pembahasan Soal</h2>
                <p style="font-size:12px;color:#64748b;margin:0;">Review jawaban dan kunci jawaban</p>
            </div>
        </div>

        {{-- Questions Review --}}
        @foreach($soalList as $soal)
            @php
                $jawabanSiswa = $jawaban[$soal->nomor_soal] ?? null;
                $isBenar = $jawabanSiswa === $soal->kunci_jawaban;
                $borderColor = $isBenar ? '#10b981' : '#ef4444';
                $bgGradient = $isBenar ? 'linear-gradient(90deg, rgba(16,185,129,0.1) 0%, transparent 100%)' : 'linear-gradient(90deg, rgba(239,68,68,0.1) 0%, transparent 100%)';
            @endphp
            
            <div style="background:rgba(22,28,45,0.7);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.07);border-left:4px solid {{ $borderColor }};border-radius:14px;overflow:hidden;">
                {{-- Question Header --}}
                <div style="background:{{ $bgGradient }};padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:30px;height:30px;border-radius:8px;background:{{ $borderColor }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:14px;box-shadow:0 2px 6px {{ $borderColor }}4D;">
                            {{ $soal->nomor_soal }}
                        </div>
                        <span style="font-size:13px;font-weight:700;color:#e2e8f0;font-family:'Plus Jakarta Sans',sans-serif;">Soal {{ $soal->nomor_soal }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;padding:3px 10px;background:{{ $isBenar ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)' }};border:1px solid {{ $isBenar ? 'rgba(16,185,129,0.25)' : 'rgba(239,68,68,0.25)' }};border-radius:99px;font-size:10px;font-weight:800;color:{{ $borderColor }};text-transform:uppercase;letter-spacing:.05em;">
                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            @if($isBenar)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            @endif
                        </svg>
                        <span>{{ $isBenar ? 'BENAR' : 'SALAH' }}</span>
                    </div>
                </div>

                <div style="padding:16px;">
                    {{-- Question Text --}}
                    <div style="margin-bottom:14px;">
                        <p style="font-size:15px;font-weight:700;color:#f1f5f9;line-height:1.6;margin:0 0 10px;">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                        
                        {{-- Question Image --}}
                        @if($soal->gambar_soal)
                        <div style="margin-top:12px;border-radius:12px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);padding:6px;">
                            <img src="{{ Storage::url($soal->gambar_soal) }}" 
                                 alt="Gambar Soal {{ $soal->nomor_soal }}" 
                                 style="width:100%;height:auto;max-height:280px;object-contain;border-radius:8px;">
                        </div>
                        @endif
                    </div>

                    {{-- Answer Options --}}
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach(['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d] as $huruf => $pilihan)
                            @php
                                $isKunci = $huruf === $soal->kunci_jawaban;
                                $isPilihan = $huruf === $jawabanSiswa;
                                
                                if ($isKunci && $isPilihan) {
                                    // Correct answer selected
                                    $optionBg = 'rgba(16,185,129,0.12)';
                                    $optionBorder = '#10b981';
                                    $badgeBg = '#10b981';
                                    $iconSvg = '<svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
                                    $textColor = '#34d399';
                                } elseif ($isKunci) {
                                    // Correct answer (not selected)
                                    $optionBg = 'rgba(16,185,129,0.04)';
                                    $optionBorder = 'rgba(16,185,129,0.5)';
                                    $badgeBg = 'rgba(16,185,129,0.5)';
                                    $iconSvg = '<svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
                                    $textColor = '#34d399';
                                } elseif ($isPilihan) {
                                    // Wrong answer selected
                                    $optionBg = 'rgba(239,68,68,0.12)';
                                    $optionBorder = '#ef4444';
                                    $badgeBg = '#ef4444';
                                    $iconSvg = '<svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                                    $textColor = '#f87171';
                                } else {
                                    // Not selected
                                    $optionBg = 'rgba(255,255,255,0.02)';
                                    $optionBorder = 'rgba(255,255,255,0.08)';
                                    $badgeBg = 'rgba(255,255,255,0.1)';
                                    $iconSvg = '';
                                    $textColor = '#e2e8f0';
                                }
                            @endphp
                            
                            <div style="display:flex;align-items:center;gap:12px;padding:10px 14px;background:{{ $optionBg }};border:1.5px solid {{ $optionBorder }};border-radius:12px;position:relative;">
                                <div style="width:28px;height:28px;border-radius:8px;background:{{ $badgeBg }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 1px 4px rgba(0,0,0,0.2);">
                                    <span style="font-size:13px;font-weight:900;color:{{ ($isKunci||$isPilihan)?'#fff':'#94a3b8' }};">{{ $huruf }}</span>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <span style="font-size:13px;color:{{ $textColor }};font-weight:{{ ($isKunci || $isPilihan) ? '700' : '500' }};line-height:1.4;">{{ $pilihan }}</span>
                                </div>
                                @if($iconSvg)
                                <div style="width:20px;height:20px;border-radius:50%;background:{{ $badgeBg }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    {!! $iconSvg !!}
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Feedback / Answer Result Info --}}
                    <div style="margin-top:12px;padding:12px 14px;background:{{ $isBenar ? 'rgba(16,185,129,0.06)' : 'rgba(239,68,68,0.06)' }};border:1px solid {{ $isBenar ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)' }};border-radius:10px;">
                        @if($isBenar)
                            <div style="display:flex;align-items:center;gap:8px;font-size:12px;font-weight:700;color:#34d399;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>Jawaban Anda Benar</span>
                            </div>
                        @else
                            <div style="display:flex;flex-direction:column;gap:6px;font-size:12px;font-weight:700;">
                                <div style="display:flex;align-items:center;gap:8px;color:#f87171;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span>Jawaban Anda: <strong>{{ $jawabanSiswa ?? 'Tidak dijawab' }}</strong></span>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;color:#34d399;padding-top:4px;border-top:1px dashed rgba(255,255,255,0.06);">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    <span>Jawaban Benar: <strong>{{ $soal->kunci_jawaban }}</strong></span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Back Button --}}
        <div style="text-align:center;padding:16px 0 32px;">
            <a href="{{ route('siswa.kuis.index') }}" 
               style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:linear-gradient(135deg,#c9982a,#f0be3d);color:#1a0a00;font-size:14px;font-weight:700;border-radius:12px;text-decoration:none;box-shadow:0 4px 16px rgba(201,152,42,0.3);transition:transform .18s, opacity .18s;"
               onmouseover="this.style.transform='translateY(-1px)';this.style.opacity='.9'"
               onmouseout="this.style.transform='none';this.style.opacity='1'">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Kuis
            </a>
        </div>
    </div>

</div>
</x-student-layout>
