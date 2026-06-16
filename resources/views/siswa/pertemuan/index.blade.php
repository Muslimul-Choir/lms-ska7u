<x-student-layout>
<x-slot name="heading">Jadwal Pertemuan</x-slot>

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:12px;">

    {{-- Filter --}}
    <form method="GET" action="{{ route('siswa.pertemuan.index') }}" style="display:flex;align-items:center;gap:10px;background:rgba(22,28,45,0.75);backdrop-filter:blur(10px);border-radius:12px;padding:12px 16px;border:1px solid rgba(255,255,255,0.09);">
        <svg width="16" height="16" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <select name="id_mapel" onchange="this.form.submit()" style="flex:1;border:none!important;outline:none!important;font-size:13px;color:#e2e8f0!important;background:transparent!important;font-family:'Inter',sans-serif;box-shadow:none!important;">
            <option value="">Semua Mata Pelajaran</option>
            @foreach($mapels as $mapel)
                <option value="{{ $mapel->id }}" {{ $mapelFilter == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
            @endforeach
        </select>
    </form>

    {{-- List --}}
    @forelse($pertemuans as $pertemuan)
        @php
            $status = strtolower($pertemuan->status ?? 'dijadwalkan');
            $mapelNama = $pertemuan->jadwalBelajar?->mapel?->nama_mapel ?? $pertemuan->jadwalBelajar?->nama_kegiatan ?? 'Pertemuan';
            $guruNama  = $pertemuan->jadwalBelajar?->guruMapel?->guru?->nama_lengkap ?? '-';
            $accentColors = ['selesai'=>'#22c55e','berlangsung'=>'#3b82f6','dibatalkan'=>'#ef4444','dijadwalkan'=>'#f59e0b'];
            $badgeColors  = [
                'selesai'     => ['rgba(34,197,94,0.12)','#4ade80','rgba(34,197,94,0.25)'],
                'berlangsung' => ['rgba(59,130,246,0.12)','#60a5fa','rgba(59,130,246,0.25)'],
                'dibatalkan'  => ['rgba(239,68,68,0.12)', '#f87171','rgba(239,68,68,0.25)'],
                'dijadwalkan' => ['rgba(245,158,11,0.12)','#fbbf24','rgba(245,158,11,0.25)'],
            ];
            $accent = $accentColors[$status] ?? '#f59e0b';
            [$bbg,$btc,$bborder] = $badgeColors[$status] ?? ['rgba(148,163,184,0.12)','#94a3b8','rgba(148,163,184,0.25)'];
        @endphp
        <a href="{{ route('siswa.pertemuan.show', $pertemuan->id) }}"
           style="display:flex;align-items:stretch;background:rgba(22,28,45,0.7);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;text-decoration:none;transition:transform .15s,box-shadow .15s;"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(0,0,0,0.35)'"
           onmouseout="this.style.transform='none';this.style.boxShadow='none'">
            <div style="width:4px;background:{{ $accent }};flex-shrink:0;"></div>
            <div style="padding:14px 16px;flex:1;min-width:0;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</div>
                <div style="font-size:15px;font-weight:800;color:#f1f5f9;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelNama }}</div>
                <div style="font-size:12px;color:#64748b;margin-top:5px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
                    @if($pertemuan->tanggal)
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }}
                    </span>
                    @endif
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        {{ $guruNama }}
                    </span>
                </div>
            </div>
            <div style="display:flex;align-items:center;padding:0 14px;gap:8px;">
                <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:{{ $bbg }};color:{{ $btc }};border:1px solid {{ $bborder }};white-space:nowrap;">{{ ucfirst($status) }}</span>
                <svg width="16" height="16" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    @empty
        <div style="padding:52px 20px;text-align:center;background:rgba(22,28,45,0.5);border-radius:14px;border:1px dashed rgba(255,255,255,0.1);">
            <div style="width:60px;height:60px;margin:0 auto 14px;border-radius:16px;background:rgba(201,152,42,0.1);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="26" height="26" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <div style="font-size:14px;font-weight:600;color:#64748b;">Belum ada pertemuan terjadwal.</div>
        </div>
    @endforelse

    {{ $pertemuans->links() }}

</div>
</x-student-layout>
