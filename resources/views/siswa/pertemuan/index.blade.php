<x-student-layout>
<x-slot name="heading">Jadwal Pertemuan</x-slot>

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:12px;">

    {{-- Filter --}}
    <form method="GET" action="{{ route('siswa.pertemuan.index') }}" style="display:flex;align-items:center;gap:10px;background:#fff;border-radius:12px;padding:12px 16px;box-shadow:0 1px 4px rgba(0,0,0,.06);border:1px solid #e2e8f0;">
        <span style="font-size:18px;">🔍</span>
        <select name="id_mapel" onchange="this.form.submit()" style="flex:1;border:none;outline:none;font-size:13px;color:#0f172a;background:transparent;font-family:'Inter',sans-serif;">
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
            $badgeColors  = ['selesai'=>['#dcfce7','#15803d'],'berlangsung'=>['#dbeafe','#1d4ed8'],'dibatalkan'=>['#fee2e2','#991b1b'],'dijadwalkan'=>['#fef3c7','#92400e']];
            $accent = $accentColors[$status] ?? '#f59e0b';
            [$bbg,$btc] = $badgeColors[$status] ?? ['#f1f5f9','#475569'];
        @endphp
        <a href="{{ route('siswa.pertemuan.show', $pertemuan->id) }}" style="display:flex;align-items:stretch;background:#fff;border-radius:14px;box-shadow:0 1px 6px rgba(0,0,0,.07);overflow:hidden;text-decoration:none;border:1px solid #e2e8f0;transition:transform .15s,box-shadow .15s;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 16px rgba(0,0,0,.1)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 6px rgba(0,0,0,.07)'">
            <div style="width:5px;background:{{ $accent }};flex-shrink:0;"></div>
            <div style="padding:14px 16px;flex:1;min-width:0;">
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Pertemuan ke-{{ $pertemuan->nomor_pertemuan }}</div>
                <div style="font-size:15px;font-weight:800;color:#0f172a;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapelNama }}</div>
                <div style="font-size:12px;color:#64748b;margin-top:5px;display:flex;flex-wrap:wrap;gap:10px;">
                    @if($pertemuan->tanggal)<span>📅 {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d M Y') }}</span>@endif
                    <span>👨‍🏫 {{ $guruNama }}</span>
                </div>
            </div>
            <div style="display:flex;align-items:center;padding:0 14px;gap:8px;">
                <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:{{ $bbg }};color:{{ $btc }};white-space:nowrap;">{{ ucfirst($status) }}</span>
                <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    @empty
        <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
            <div style="font-size:40px;margin-bottom:10px;">📭</div>
            <div style="font-size:14px;font-weight:600;color:#475569;">Belum ada pertemuan terjadwal.</div>
        </div>
    @endforelse

    {{ $pertemuans->links() }}

</div>
</x-student-layout>
