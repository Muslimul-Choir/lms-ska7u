<x-student-layout>
<x-slot name="heading">Jadwal Pelajaran</x-slot>

@php
    $todayIndex = date('N');
    $daysMap = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
    $todayName = $daysMap[$todayIndex] ?? 'Senin';
@endphp

<div style="max-width:720px;margin:0 auto;padding:20px 16px;" x-data="{ activeHari: '{{ $todayName }}' }">

    {{-- Kelas info strip --}}
    <div style="background:linear-gradient(135deg,rgba(107,26,43,0.9),rgba(61,10,19,0.9));backdrop-filter:blur(12px);border:1px solid rgba(201,152,42,0.25);border-radius:14px;padding:14px 18px;margin-bottom:18px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 20px rgba(0,0,0,0.25);">
        <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,152,42,0.2);border:1px solid rgba(201,152,42,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
            </svg>
        </div>
        <div>
            <div style="font-size:14px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">{{ $siswa->Kelas?->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan }} {{ $siswa->Kelas?->Bagian?->nama_bagian }}</div>
            <div style="font-size:11px;color:#64748b;margin-top:1px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Jadwal Pelajaran Mingguan</div>
        </div>
    </div>

    {{-- Day tabs --}}
    <div class="day-tabs-container">
        @foreach($hariList as $hari)
        <button @click="activeHari='{{ $hari }}'"
            :class="activeHari==='{{ $hari }}' ? 'day-tab-btn day-tab-active' : 'day-tab-btn'"
            :style="activeHari==='{{ $hari }}'
                ? 'background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;box-shadow:0 4px 14px rgba(107,26,43,0.45);'
                : 'background:transparent;color:#94a3b8;'"
            type="button">
            <span>{{ $hari }}</span>
            @if($hari === $todayName)
                <span style="display:inline-block;width:5px;height:5px;background:#c9982a;border-radius:50%;margin-left:5px;vertical-align:middle;box-shadow:0 0 6px #c9982a;"></span>
            @endif
        </button>
        @endforeach
    </div>

    {{-- Schedule per day --}}
    @foreach($hariList as $hari)
    <div x-show="activeHari==='{{ $hari }}'" x-cloak style="display:flex;flex-direction:column;gap:12px;">
        @php $hasAny = false; @endphp
        @foreach($jamList as $jam)
            @php $schedules = $grid[$jam->id][$hari] ?? collect(); @endphp
            @if($schedules->count() > 0)
                @php $hasAny = true; @endphp
                @foreach($schedules as $sched)
                <div style="display:flex;align-items:stretch;background:rgba(22,28,45,0.7);backdrop-filter:blur(12px);border-radius:14px;border:1px solid rgba(255,255,255,0.08);overflow:hidden;transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-1.5px)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.35)';this.style.borderColor='rgba(201,152,42,0.2)';" onmouseout="this.style.transform='none';this.style.boxShadow='none';this.style.borderColor='rgba(255,255,255,0.08)';">
                    <div style="width:4px;background:linear-gradient(180deg,#6B1A2B,#c9982a);flex-shrink:0;"></div>
                    <div style="padding:16px;flex:1;min-width:0;display:flex;flex-direction:column;gap:5px;">
                        <div style="font-size:12px;font-weight:700;color:#fbbf24;display:flex;align-items:center;gap:6px;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                        </div>
                        <div style="font-size:16px;font-weight:800;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $sched->nama_display }}</div>
                        @if($sched->nama_guru)
                        <div style="font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:6px;margin-top:2px;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            {{ $sched->nama_guru }}
                        </div>
                        @endif
                    </div>
                    @if($sched->nama_kegiatan)
                    <div style="display:flex;align-items:center;padding:0 16px;">
                        <span style="font-size:10px;font-weight:800;padding:3px 12px;border-radius:99px;background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.25);white-space:nowrap;text-transform:uppercase;letter-spacing:.05em;">Kegiatan</span>
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        @endforeach
        @if(!$hasAny)
        <div style="padding:56px 20px;text-align:center;background:rgba(22,28,45,0.6);border-radius:16px;border:1px dashed rgba(255,255,255,0.12);">
            <div style="width:60px;height:60px;margin:0 auto 14px;border-radius:16px;background:rgba(201,152,42,0.1);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="26" height="26" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <div style="font-size:14px;font-weight:600;color:#64748b;">Tidak ada jadwal pelajaran</div>
            <div style="font-size:12px;color:#475569;margin-top:4px;">Nikmati hari libur Anda!</div>
        </div>
        @endif
    </div>
    @endforeach

</div>

<style>
.day-tabs-container {
    background: rgba(22, 28, 45, 0.7);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 6px;
    display: flex;
    gap: 6px;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    margin-bottom: 18px;
}
.day-tabs-container::-webkit-scrollbar {
    display: none;
}
.day-tab-btn {
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 700;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.25s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    flex-shrink: 0;
    letter-spacing: .02em;
    display: flex;
    align-items: center;
    justify-content: center;
}
.day-tab-btn:hover:not(.day-tab-active) {
    color: #fff !important;
    background: rgba(255, 255, 255, 0.04) !important;
}
</style>
</x-student-layout>
