<x-student-layout>
<x-slot name="heading">Materi Pembelajaran</x-slot>

<div style="max-width:900px;margin:0 auto;padding:16px;">

    {{-- Subject header --}}
    <div style="margin-bottom:14px;">
        <p style="font-size:13px;font-weight:600;color:#64748b;margin:0 0 2px;">Kelas {{ $siswa->Kelas?->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan }}</p>
        <h2 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;font-family:'Plus Jakarta Sans',sans-serif;">Pilih Mata Pelajaran</h2>
    </div>

    @if($mapels->count() > 0)
        @php
            $colors = [
                ['#dbeafe','#1d4ed8'],['#dcfce7','#15803d'],['#fef3c7','#92400e'],
                ['#ede9fe','#5b21b6'],['#fce7f3','#9d174d'],['#e0f2fe','#0369a1'],
                ['#fef9c3','#713f12'],['#f0fdf4','#166534'],
            ];
            $emojis = ['📐','📖','🔬','💻','🎨','🇬🇧','🗺️','⚖️','⚽','🕌','🎵','🧪'];
        @endphp
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
            @foreach($mapels as $i => $mapel)
                @php [$cbg,$ctxt] = $colors[$i % count($colors)]; $ico = $emojis[$mapel->id % count($emojis)]; @endphp
                <a href="{{ route('siswa.materi.mapel', $mapel->id) }}" style="display:flex;align-items:center;gap:14px;background:#fff;border-radius:14px;padding:16px;box-shadow:0 1px 6px rgba(0,0,0,.07);text-decoration:none;border:1px solid #e2e8f0;transition:transform .15s,border-color .15s,box-shadow .15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='{{ $ctxt }}';this.style.boxShadow='0 4px 16px rgba(0,0,0,.1)'" onmouseout="this.style.transform='none';this.style.borderColor='#e2e8f0';this.style.boxShadow='0 1px 6px rgba(0,0,0,.07)'">
                    <div style="width:48px;height:48px;border-radius:12px;background:{{ $cbg }};display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">{{ $ico }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $mapel->nama_mapel }}</div>
                        <div style="font-size:11px;color:#64748b;font-weight:500;text-transform:uppercase;letter-spacing:.03em;margin-top:2px;">{{ $mapel->kode_mapel ?? 'MAPEL' }}</div>
                    </div>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endforeach
        </div>
    @else
        <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
            <div style="font-size:40px;margin-bottom:10px;">📁</div>
            <div style="font-size:14px;font-weight:600;color:#475569;">Belum ada mata pelajaran terdaftar.</div>
            <div style="font-size:12px;margin-top:4px;">Hubungi admin jika ini tidak sesuai.</div>
        </div>
    @endif

</div>
</x-student-layout>
