<x-student-layout>
<x-slot name="heading">Mata Pelajaran</x-slot>

<style>
.mp-tab-nav { display:flex; gap:6px; background:rgba(15,20,35,0.7); backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:5px; margin-bottom:22px; }
.mp-tab-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:7px; padding:9px 8px; font-size:12px; font-weight:700; text-decoration:none; border-radius:10px; transition:all .22s cubic-bezier(.4,0,.2,1); color:#64748b; letter-spacing:.02em; position:relative; overflow:visible; }
.mp-tab-btn:hover { color:#cbd5e1; background:rgba(255,255,255,0.05); }
.mp-tab-btn.active { background:linear-gradient(135deg,#c9982a,#f0be3d); color:#1a0800; box-shadow:0 4px 16px rgba(201,152,42,0.35); }
.mp-tab-btn.active svg { stroke:#1a0800; }
.mp-tab-btn svg { stroke:#64748b; transition:stroke .22s; flex-shrink:0; }
.mp-tab-btn:hover svg { stroke:#cbd5e1; }
.tab-badge { position:absolute; top:-6px; right:-6px; min-width:20px; height:20px; background:#ef4444; color:#fff; font-size:11px; font-weight:800; border-radius:99px; display:flex; align-items:center; justify-content:center; padding:0 5px; line-height:1; box-shadow:0 2px 8px rgba(239,68,68,0.4); animation:badgePop .3s cubic-bezier(.34,1.56,.64,1); }
@keyframes badgePop { from{transform:scale(0)} to{transform:scale(1)} }

.mapel-card { display:flex; align-items:center; gap:14px; background:rgba(18,24,40,0.75); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,0.07); border-radius:16px; padding:18px; text-decoration:none; transition:transform .2s,border-color .2s,box-shadow .2s; position:relative; overflow:hidden; }
.mapel-card::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.03),transparent); pointer-events:none; }
.mapel-card:hover { transform:translateY(-3px); box-shadow:0 12px 36px rgba(0,0,0,0.5); }
.mapel-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:transform .2s; }
.mapel-card:hover .mapel-icon { transform:scale(1.08); }
.mapel-name { font-size:14px; font-weight:800; color:#f1f5f9; line-height:1.3; font-family:'Plus Jakarta Sans',sans-serif; margin-bottom:4px; }
.mapel-code { font-size:11px; color:#475569; font-weight:600; text-transform:uppercase; letter-spacing:.06em; }
.mapel-arrow { width:32px; height:32px; border-radius:8px; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:background .2s,transform .2s; }
.mapel-card:hover .mapel-arrow { background:rgba(255,255,255,0.1); transform:translateX(3px); }

@keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
</style>

<div style="max-width:960px;margin:0 auto;padding:20px 16px;">

    {{-- Tab navigation --}}
    <div class="mp-tab-nav">
        <a href="{{ route('siswa.materi.index') }}" class="mp-tab-btn active">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Mata Pelajaran
        </a>
        <a href="{{ route('siswa.tugas.index') }}" class="mp-tab-btn">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
            Tugas Saya
            @if($tugasBelumCount > 0)
                <span class="tab-badge">{{ $tugasBelumCount > 99 ? '99+' : $tugasBelumCount }}</span>
            @endif
        </a>
        <a href="{{ route('siswa.kuis.index') }}" class="mp-tab-btn">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
            Kuis Saya
            @if($kuisTersediaCount > 0)
                <span class="tab-badge">{{ $kuisTersediaCount > 99 ? '99+' : $kuisTersediaCount }}</span>
            @endif
        </a>
    </div>

    {{-- Header --}}
    <div style="margin-bottom:22px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <div style="width:3px;height:18px;background:linear-gradient(180deg,#c9982a,#f0be3d);border-radius:2px;"></div>
            <p style="font-size:11px;font-weight:700;color:#64748b;margin:0;text-transform:uppercase;letter-spacing:.08em;">Kelas {{ $siswa->Kelas?->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas?->Jurusan?->nama_jurusan }}</p>
        </div>
        <h2 style="font-size:22px;font-weight:800;color:#f1f5f9;margin:0;font-family:'Plus Jakarta Sans',sans-serif;padding-left:13px;">Pilih Mata Pelajaran</h2>
    </div>

    @if($mapels->count() > 0)
        @php
            $palettes = [
                ['rgba(59,130,246,0.18)','#60a5fa','rgba(59,130,246,0.3)'],
                ['rgba(16,185,129,0.18)','#34d399','rgba(16,185,129,0.3)'],
                ['rgba(245,158,11,0.18)','#fbbf24','rgba(245,158,11,0.3)'],
                ['rgba(139,92,246,0.18)','#a78bfa','rgba(139,92,246,0.3)'],
                ['rgba(244,114,182,0.18)','#f472b6','rgba(244,114,182,0.3)'],
                ['rgba(14,165,233,0.18)','#38bdf8','rgba(14,165,233,0.3)'],
                ['rgba(234,179,8,0.18)', '#facc15','rgba(234,179,8,0.3)'],
                ['rgba(239,68,68,0.18)', '#f87171','rgba(239,68,68,0.3)'],
            ];
            $subjectPaths = [
                'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7.5 21h9A2.25 2.25 0 0018.75 18.75V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75',
                'M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155',
                'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605',
                'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5',
                'M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5',
            ];
        @endphp
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
            @foreach($mapels as $i => $mapel)
                @php
                    [$cbg,$ctxt,$cborder] = $palettes[$i % count($palettes)];
                    $iconPath = $subjectPaths[$i % count($subjectPaths)];
                @endphp
                <a href="{{ route('siswa.materi.mapel', $mapel->id) }}"
                   class="mapel-card"
                   style="border-color:rgba(255,255,255,0.07);"
                   onmouseover="this.style.borderColor='{{ $cborder }}'"
                   onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'">
                    <div class="mapel-icon" style="background:{{ $cbg }};border:1px solid {{ $cborder }};animation:floatY 3.5s ease-in-out {{ ($i%3)*0.6 }}s infinite;">
                        <svg width="22" height="22" fill="none" stroke="{{ $ctxt }}" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
                        </svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="mapel-name">{{ $mapel->nama_mapel }}</div>
                        <div class="mapel-code">{{ $mapel->kode_mapel ?? 'MAPEL' }}</div>
                    </div>
                    <div class="mapel-arrow">
                        <svg width="14" height="14" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div style="padding:60px 20px;text-align:center;background:rgba(18,24,40,0.6);border-radius:20px;border:1px dashed rgba(255,255,255,0.1);">
            <div style="width:68px;height:68px;margin:0 auto 16px;border-radius:18px;background:rgba(201,152,42,0.1);border:1px solid rgba(201,152,42,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="30" height="30" fill="none" stroke="#c9982a" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div style="font-size:15px;font-weight:700;color:#64748b;margin-bottom:6px;">Belum ada mata pelajaran terdaftar</div>
            <div style="font-size:12px;color:#334155;">Hubungi admin jika ini tidak sesuai.</div>
        </div>
    @endif

</div>
</x-student-layout>
