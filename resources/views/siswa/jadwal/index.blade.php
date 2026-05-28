<x-student-layout>
<x-slot name="heading">Jadwal Pelajaran</x-slot>

@php
    $todayIndex = date('N');
    $daysMap = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
    $todayName = $daysMap[$todayIndex] ?? 'Senin';
@endphp

<div style="max-width:720px;margin:0 auto;padding:16px;" x-data="{ activeHari: '{{ $todayName }}' }">

    {{-- Kelas info strip --}}
    <div style="background:linear-gradient(135deg,#6B1A2B,#2D0810);border-radius:12px;padding:12px 16px;margin-bottom:14px;display:flex;align-items:center;gap:10px;">
        <span style="font-size:20px;">🏫</span>
        <div>
            <div style="font-size:13px;font-weight:700;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;">{{ $siswa->Kelas?->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan }} {{ $siswa->Kelas?->Bagian?->nama_bagian }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,.6);margin-top:1px;">Jadwal Pelajaran Mingguan</div>
        </div>
    </div>

    {{-- Day tabs --}}
    <div style="display:flex;overflow-x:auto;gap:8px;padding-bottom:8px;margin-bottom:14px;scrollbar-width:none;-ms-overflow-style:none;">
        @foreach($hariList as $hari)
        <button @click="activeHari='{{ $hari }}'"
            :style="activeHari==='{{ $hari }}'
                ? 'background:linear-gradient(135deg,#6B1A2B,#2D0810);color:#fff;border-color:#6B1A2B;box-shadow:0 2px 8px rgba(107,26,43,.35);'
                : 'background:#fff;color:#475569;border-color:#e2e8f0;'"
            style="padding:8px 18px;font-size:13px;font-weight:700;border-radius:10px;border:1.5px solid;cursor:pointer;white-space:nowrap;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;">
            {{ $hari }}
        </button>
        @endforeach
    </div>

    {{-- Schedule per day --}}
    @foreach($hariList as $hari)
    <div x-show="activeHari==='{{ $hari }}'" x-cloak style="display:flex;flex-direction:column;gap:10px;">
        @php $hasAny = false; @endphp
        @foreach($jamList as $jam)
            @php $schedules = $grid[$jam->id][$hari] ?? collect(); @endphp
            @if($schedules->count() > 0)
                @php $hasAny = true; @endphp
                @foreach($schedules as $sched)
                <div style="display:flex;align-items:stretch;background:#fff;border-radius:14px;box-shadow:0 1px 6px rgba(0,0,0,.07);overflow:hidden;border:1px solid #e2e8f0;">
                    <div style="width:5px;background:linear-gradient(180deg,#6B1A2B,#c9982a);flex-shrink:0;"></div>
                    <div style="padding:14px 16px;flex:1;min-width:0;">
                        <div style="font-size:12px;font-weight:700;color:#c9982a;display:flex;align-items:center;gap:4px;margin-bottom:4px;">
                            🕒 {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                        </div>
                        <div style="font-size:15px;font-weight:800;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $sched->nama_display }}</div>
                        @if($sched->nama_guru)
                        <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;align-items:center;gap:4px;">👨‍🏫 {{ $sched->nama_guru }}</div>
                        @endif
                    </div>
                    @if($sched->nama_kegiatan)
                    <div style="display:flex;align-items:center;padding:0 14px;">
                        <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:99px;background:#fef3c7;color:#92400e;">Kegiatan</span>
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        @endforeach
        @if(!$hasAny)
        <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
            <div style="font-size:36px;margin-bottom:8px;">🏖️</div>
            <div style="font-size:14px;font-weight:600;color:#475569;">Tidak ada jadwal pada hari {{ $hari }}.</div>
        </div>
        @endif
    </div>
    @endforeach

</div>
</x-student-layout>
