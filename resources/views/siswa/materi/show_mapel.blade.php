<x-student-layout>
<x-slot name="heading">{{ $mapel->nama_mapel }}</x-slot>
<x-slot name="back">
    <a href="{{ route('siswa.materi.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:10px;color:#fff;text-decoration:none;flex-shrink:0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:14px;">

    {{-- Subject banner --}}
    <div style="background:#fff;border-radius:14px;padding:16px 20px;box-shadow:0 1px 6px rgba(0,0,0,.07);display:flex;align-items:center;gap:14px;">
        <div style="width:52px;height:52px;border-radius:14px;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">📚</div>
        <div>
            <h2 style="font-size:16px;font-weight:800;color:#0f172a;margin:0 0 2px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapel->nama_mapel }}</h2>
            <p style="font-size:12px;color:#64748b;margin:0;">Kode: {{ $mapel->kode_mapel ?? '-' }} · {{ $siswa->Kelas?->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan }}</p>
        </div>
    </div>

    @if($pertemuans->count() > 0)
        @foreach($pertemuans as $pertemuan)
        <div style="background:#fff;border-radius:14px;box-shadow:0 1px 6px rgba(0,0,0,.07);overflow:hidden;">
            {{-- Meeting header --}}
            <div style="background:#f8fafc;padding:14px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:14px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</span>
                @if($pertemuan->tanggal)
                <span style="font-size:12px;color:#64748b;font-weight:500;">📅 {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }}</span>
                @endif
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:14px;">

                {{-- Materi --}}
                <div>
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#3b82f6;display:inline-block;"></span> Materi Pembelajaran
                    </div>
                    @if($pertemuan->materis->count() > 0)
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($pertemuan->materis as $materi)
                                @php
                                    $icons = ['dokumen'=>['📄','#eff6ff'],'video'=>['🎥','#fdf2f8'],'link'=>['🔗','#fffbeb']];
                                    [$ico,$ibg] = $icons[$materi->tipe_materi] ?? ['📁','#f8fafc'];
                                @endphp
                                <a href="{{ route('siswa.materi.show', $materi->id) }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;text-decoration:none;color:#0f172a;transition:border-color .15s,background .15s;" onmouseover="this.style.borderColor='#3b82f6';this.style.background='#eff6ff'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                                    <div style="width:32px;height:32px;border-radius:8px;background:{{ $ibg }};display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">{{ $ico }}</div>
                                    <span style="font-size:13px;font-weight:600;flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $materi->judul }}</span>
                                    <span style="font-size:11px;color:#94a3b8;text-transform:capitalize;">{{ $materi->tipe_materi }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size:12px;color:#94a3b8;font-style:italic;padding:4px 0;">Tidak ada materi pada pertemuan ini.</p>
                    @endif
                </div>

                {{-- Tugas --}}
                <div>
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;"></span> Tugas / Penugasan
                    </div>
                    @if($pertemuan->tugas->count() > 0)
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($pertemuan->tugas as $tugas)
                                @php
                                    $sub = \App\Models\PengumpulanTugas::where('id_tugas',$tugas->id)->where('id_siswa',$siswa->id)->first();
                                    $graded = $sub ? \App\Models\Penilaian::where('id_pengumpulan_tugas',$sub->id)->exists() : false;
                                    if ($sub && $graded)       { $bl='Selesai Dinilai'; $bbg='#faf5ff'; $btc='#6b21a8'; }
                                    elseif ($sub)              { $bl='Dikumpulkan';     $bbg='#dbeafe'; $btc='#1d4ed8'; }
                                    elseif ($tugas->batas_waktu && \Carbon\Carbon::parse($tugas->batas_waktu)->isPast()) { $bl='Terlewat'; $bbg='#fee2e2'; $btc='#991b1b'; }
                                    else                       { $bl='Belum';           $bbg='#fef3c7'; $btc='#92400e'; }
                                @endphp
                                <a href="{{ route('siswa.tugas.show', $tugas->id) }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border:1px solid #fde68a;border-left:3px solid #f59e0b;border-radius:10px;text-decoration:none;color:#0f172a;transition:background .15s;" onmouseover="this.style.background='#fffbeb'" onmouseout="this.style.background='#f8fafc'">
                                    <div style="width:32px;height:32px;border-radius:8px;background:#fff8eb;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">📝</div>
                                    <span style="font-size:13px;font-weight:600;flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tugas->judul }}</span>
                                    <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;background:{{ $bbg }};color:{{ $btc }};white-space:nowrap;">{{ $bl }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size:12px;color:#94a3b8;font-style:italic;padding:4px 0;">Tidak ada penugasan pada pertemuan ini.</p>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    @else
        <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
            <div style="font-size:40px;margin-bottom:10px;">📅</div>
            <div style="font-size:14px;font-weight:600;color:#475569;">Belum ada pertemuan untuk mata pelajaran ini.</div>
        </div>
    @endif

</div>
</x-student-layout>
