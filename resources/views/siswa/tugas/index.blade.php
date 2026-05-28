<x-student-layout>
    <x-slot name="heading">Tugas & Evaluasi</x-slot>

    <div style="max-width:900px;margin:0 auto;padding:16px;" x-data="{ tab: 'belum' }">

        {{-- Tab bar --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);background:#e2e8f0;border-radius:12px;padding:4px;gap:4px;margin-bottom:16px;">
            <button @click="tab='belum'" :style="tab==='belum' ? 'background:#fff;color:#6B1A2B;box-shadow:0 1px 4px rgba(0,0,0,.1);' : 'background:transparent;color:#64748b;'"
                style="padding:9px 4px;font-size:11px;font-weight:700;border-radius:9px;border:none;cursor:pointer;transition:all .2s;text-transform:uppercase;letter-spacing:.03em;font-family:'Plus Jakarta Sans',sans-serif;">
                Belum ({{ count($belumDikerjakan) }})
            </button>
            <button @click="tab='pending'" :style="tab==='pending' ? 'background:#fff;color:#6B1A2B;box-shadow:0 1px 4px rgba(0,0,0,.1);' : 'background:transparent;color:#64748b;'"
                style="padding:9px 4px;font-size:11px;font-weight:700;border-radius:9px;border:none;cursor:pointer;transition:all .2s;text-transform:uppercase;letter-spacing:.03em;font-family:'Plus Jakarta Sans',sans-serif;">
                Diperiksa ({{ count($menungguDinilai) }})
            </button>
            <button @click="tab='selesai'" :style="tab==='selesai' ? 'background:#fff;color:#6B1A2B;box-shadow:0 1px 4px rgba(0,0,0,.1);' : 'background:transparent;color:#64748b;'"
                style="padding:9px 4px;font-size:11px;font-weight:700;border-radius:9px;border:none;cursor:pointer;transition:all .2s;text-transform:uppercase;letter-spacing:.03em;font-family:'Plus Jakarta Sans',sans-serif;">
                Selesai ({{ count($selesai) }})
            </button>
        </div>

        {{-- Tab: Belum Dikerjakan --}}
        <div x-show="tab==='belum'" style="display:flex;flex-direction:column;gap:10px;">
            @forelse($belumDikerjakan as $item)
                @php $task=$item['task']; $isPast=$task->batas_waktu && \Carbon\Carbon::parse($task->batas_waktu)->isPast(); @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}" style="display:flex;align-items:center;gap:14px;background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 6px rgba(0,0,0,.07);text-decoration:none;border:1px solid {{ $isPast ? '#fecdd3' : '#e2e8f0' }};transition:transform .15s,box-shadow .15s;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 16px rgba(0,0,0,.1)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 6px rgba(0,0,0,.07)'">
                    <div style="width:44px;height:44px;border-radius:12px;background:{{ $isPast ? '#fee2e2' : '#fef3c7' }};display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">{{ $isPast ? '⏰' : '📝' }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;flex-wrap:wrap;gap:8px;">
                            <span style="font-weight:600;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            @if($task->batas_waktu)<span style="color:{{ $isPast ? '#ef4444' : '#16a34a' }};">⏱ {{ \Carbon\Carbon::parse($task->batas_waktu)->format('d M Y') }}</span>@endif
                        </div>
                    </div>
                    <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:{{ $isPast ? '#fee2e2' : '#fef3c7' }};color:{{ $isPast ? '#991b1b' : '#92400e' }};white-space:nowrap;flex-shrink:0;">{{ $isPast ? 'Terlewat' : 'Aktif' }}</span>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
                    <div style="font-size:40px;margin-bottom:10px;">🎉</div>
                    <div style="font-size:14px;font-weight:600;color:#475569;">Semua tugas sudah dikerjakan!</div>
                    <div style="font-size:12px;margin-top:4px;">Tidak ada tugas yang tersisa.</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Menunggu Dinilai --}}
        <div x-show="tab==='pending'" style="display:flex;flex-direction:column;gap:10px;" x-cloak>
            @forelse($menungguDinilai as $item)
                @php $task=$item['task']; @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}" style="display:flex;align-items:center;gap:14px;background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 6px rgba(0,0,0,.07);text-decoration:none;border:1px solid #bfdbfe;transition:transform .15s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                    <div style="width:44px;height:44px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">⏳</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;flex-wrap:wrap;gap:8px;">
                            <span style="font-weight:600;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            <span>Dikumpulkan {{ $item['submission']->created_at->format('d M, H:i') }}</span>
                        </div>
                    </div>
                    <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:#dbeafe;color:#1d4ed8;white-space:nowrap;flex-shrink:0;">Diperiksa</span>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
                    <div style="font-size:40px;margin-bottom:10px;">📂</div>
                    <div style="font-size:14px;font-weight:600;color:#475569;">Tidak ada tugas yang sedang diperiksa.</div>
                </div>
            @endforelse
        </div>

        {{-- Tab: Selesai --}}
        <div x-show="tab==='selesai'" style="display:flex;flex-direction:column;gap:10px;" x-cloak>
            @forelse($selesai as $item)
                @php $task=$item['task']; $pct=min(($item['assessment']->nilai/$task->nilai_maksimal)*100,100); @endphp
                <a href="{{ route('siswa.tugas.show', $task->id) }}" style="display:flex;align-items:center;gap:14px;background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 6px rgba(0,0,0,.07);text-decoration:none;border-left:4px solid #22c55e;border-top:1px solid #e2e8f0;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;transition:transform .15s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                    <div style="width:44px;height:44px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">✅</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $task->judul }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;flex-wrap:wrap;gap:8px;">
                            <span style="font-weight:600;">{{ $task->Mapel?->nama_mapel ?? $task->guruMapel?->Mapel?->nama_mapel }}</span>
                            <span style="color:#7c3aed;font-weight:700;">Nilai: {{ $item['assessment']->nilai }}/{{ $task->nilai_maksimal }}</span>
                        </div>
                    </div>
                    <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;background:#f0fdf4;color:#15803d;white-space:nowrap;flex-shrink:0;">Selesai</span>
                    <svg width="16" height="16" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div style="padding:48px 20px;text-align:center;background:#fff;border-radius:14px;border:1px dashed #cbd5e1;color:#94a3b8;">
                    <div style="font-size:40px;margin-bottom:10px;">📊</div>
                    <div style="font-size:14px;font-weight:600;color:#475569;">Belum ada tugas yang selesai dinilai.</div>
                </div>
            @endforelse
        </div>

    </div>
</x-student-layout>
