<x-student-layout>
<x-slot name="heading">Absensi Pertemuan</x-slot>
<x-slot name="back">
    @php
        $backUrl = request('redirect_to') ?? route('siswa.materi.index');
    @endphp
    <a href="{{ $backUrl }}" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:all .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
</x-slot>

<div style="max-width:720px;margin:0 auto;padding:20px 16px;display:flex;flex-direction:column;gap:14px;" x-data="attendanceModal()">
    
    {{-- Info Card --}}
    <div style="background:rgba(59,130,246,0.1);border-left:4px solid #3b82f6;border-radius:12px;padding:16px;">
        <div style="display:flex;align-items:start;gap:12px;">
            <svg width="20" height="20" fill="none" stroke="#3b82f6" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;margin-top:1px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            <div style="flex:1;">
                <h3 style="font-size:14px;font-weight:800;color:#60a5fa;margin:0 0 4px;font-family:'Plus Jakarta Sans',sans-serif;">Absensi untuk Semua Konten</h3>
                <p style="font-size:12px;color:#94a3b8;margin:0;line-height:1.5;">
                    Setelah absen pada pertemuan ini, Anda dapat mengakses seluruh <strong>materi, tugas, dan kuis</strong> tanpa perlu melakukan absensi berulang kali.
                </p>
            </div>
        </div>
    </div>

    {{-- Pertemuan Info --}}
    <div style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px;">
        <div style="display:flex;align-items:start;gap:16px;margin-bottom:18px;">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);display:flex;align-items:center;justify-content:center;color:#c9982a;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:11px;font-weight:700;color:#c9982a;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px;">
                    Pertemuan {{ $pertemuanModel->nomor_pertemuan }}
                </div>
                <h2 style="font-size:17px;font-weight:800;color:#f1f5f9;margin:0 0 6px;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $pertemuanModel->JadwalBelajar?->Mapel?->nama_mapel ?? $pertemuanModel->JadwalBelajar?->GuruMapel?->Mapel?->nama_mapel ?? 'Mata Pelajaran' }}
                </h2>
                <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:12px;color:#94a3b8;">
                    @if($pertemuanModel->tanggal)
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        {{ \Carbon\Carbon::parse($pertemuanModel->tanggal)->format('d M Y') }}
                    </span>
                    @endif
                    @if($pertemuanModel->guru)
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        {{ $pertemuanModel->guru->nama_lengkap }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content yang akan bisa diakses --}}
        @if(isset($contentCount) && ($contentCount['materi'] > 0 || $contentCount['tugas'] > 0 || $contentCount['kuis'] > 0))
        <div style="background:rgba(201,152,42,0.05);border:1px solid rgba(201,152,42,0.15);border-radius:12px;padding:14px;margin-bottom:16px;">
            <div style="font-size:11px;font-weight:700;color:#fbbf24;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75m-.75 11.25h-10.5a2.25 2.25 0 01-2.25-2.25v-6.75a2.25 2.25 0 012.25-2.25h10.5a2.25 2.25 0 012.25 2.25v6.75a2.25 2.25 0 01-2.25 2.25z"/></svg>
                Konten yang Akan Terbuka:
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @if($contentCount['materi'] > 0)
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:900;color:#60a5fa;">{{ $contentCount['materi'] }}</div>
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;margin-top:2px;">Materi</div>
                </div>
                @endif
                @if($contentCount['tugas'] > 0)
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:900;color:#fbbf24;">{{ $contentCount['tugas'] }}</div>
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;margin-top:2px;">Tugas</div>
                </div>
                @endif
                @if($contentCount['kuis'] > 0)
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:10px;text-align:center;">
                    <div style="font-size:18px;font-weight:900;color:#f472b6;">{{ $contentCount['kuis'] }}</div>
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;margin-top:2px;">Kuis</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Deadline Info --}}
        @if($batasAbsensi)
        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:12px;padding:14px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;flex-wrap:wrap;gap:6px;">
                <span style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Batas Waktu Absensi</span>
                <span style="font-size:11px;font-weight:700;font-family:monospace;padding:2px 8px;background:rgba(239,68,68,0.12);color:#f87171;border:1px solid rgba(239,68,68,0.2);border-radius:99px;" x-text="countdown"></span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#f1f5f9;font-weight:600;">
                <svg width="15" height="15" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ \Carbon\Carbon::parse($batasAbsensi)->format('d M Y, H:i') }} WIB</span>
            </div>
            @if(now()->gt($batasAbsensi))
                <div style="margin-top:8px;font-size:12px;color:#f87171;font-weight:600;display:flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    Batas waktu terlewat - Anda akan tercatat terlambat
                </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Attendance Form --}}
    <form action="{{ route('siswa.attendance.mark') }}" method="POST" style="background:rgba(22,28,45,0.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px;" @submit="handleSubmit">
        @csrf
        <input type="hidden" name="id_pertemuan" value="{{ $pertemuanModel->id }}">
        <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

        <h3 style="font-size:13px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin:0 0 16px;display:flex;align-items:center;gap:6px;">
            <svg width="15" height="15" fill="none" stroke="#60a5fa" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pilih Kehadiran
        </h3>

        {{-- Status Options --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:18px;">
            {{-- Hadir --}}
            <label style="position:relative;cursor:pointer;">
                <input type="radio" name="status" value="hadir" x-model="status" required style="position:absolute;opacity:0;width:0;height:0;" class="sr-only">
                <div :style="status==='hadir' ? 'border-color:#34d399;background:rgba(16,185,129,0.12);box-shadow:0 0 12px rgba(16,185,129,0.25);' : 'border-color:rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);'"
                     style="height:96px;border-radius:12px;border:2px solid;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;transition:all .25s;"
                     onmouseover="this.style.borderColor=this.parentElement.firstElementChild.checked?'#34d399':'rgba(255,255,255,0.18)'"
                     onmouseout="this.style.borderColor=this.parentElement.firstElementChild.checked?'#34d399':'rgba(255,255,255,0.08)'">
                    <svg width="24" height="24" fill="none" :stroke="status==='hadir'?'#34d399':'#94a3b8'" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span :style="status==='hadir'?'color:#34d399;':'color:#94a3b8;'" style="font-size:12px;font-weight:700;">Hadir</span>
                </div>
            </label>

            {{-- Izin --}}
            <label style="position:relative;cursor:pointer;">
                <input type="radio" name="status" value="izin" x-model="status" required style="position:absolute;opacity:0;width:0;height:0;" class="sr-only">
                <div :style="status==='izin' ? 'border-color:#fbbf24;background:rgba(245,158,11,0.12);box-shadow:0 0 12px rgba(245,158,11,0.25);' : 'border-color:rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);'"
                     style="height:96px;border-radius:12px;border:2px solid;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;transition:all .25s;"
                     onmouseover="this.style.borderColor=this.parentElement.firstElementChild.checked?'#fbbf24':'rgba(255,255,255,0.18)'"
                     onmouseout="this.style.borderColor=this.parentElement.firstElementChild.checked?'#fbbf24':'rgba(255,255,255,0.08)'">
                    <svg width="24" height="24" fill="none" :stroke="status==='izin'?'#fbbf24':'#94a3b8'" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span :style="status==='izin'?'color:#fbbf24;':'color:#94a3b8;'" style="font-size:12px;font-weight:700;">Izin</span>
                </div>
            </label>

            {{-- Sakit --}}
            <label style="position:relative;cursor:pointer;">
                <input type="radio" name="status" value="sakit" x-model="status" required style="position:absolute;opacity:0;width:0;height:0;" class="sr-only">
                <div :style="status==='sakit' ? 'border-color:#60a5fa;background:rgba(59,130,246,0.12);box-shadow:0 0 12px rgba(59,130,246,0.25);' : 'border-color:rgba(255,255,255,0.08);background:rgba(255,255,255,0.02);'"
                     style="height:96px;border-radius:12px;border:2px solid;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;transition:all .25s;"
                     onmouseover="this.style.borderColor=this.parentElement.firstElementChild.checked?'#60a5fa':'rgba(255,255,255,0.18)'"
                     onmouseout="this.style.borderColor=this.parentElement.firstElementChild.checked?'#60a5fa':'rgba(255,255,255,0.08)'">
                    <svg width="24" height="24" fill="none" :stroke="status==='sakit'?'#60a5fa':'#94a3b8'" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span :style="status==='sakit'?'color:#60a5fa;':'color:#94a3b8;'" style="font-size:12px;font-weight:700;">Sakit</span>
                </div>
            </label>
        </div>

        {{-- Keterangan (Optional for Izin/Sakit) --}}
        <div x-show="status === 'izin' || status === 'sakit'" x-cloak x-transition style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px;">Keterangan <span style="color:#475569;font-weight:normal;">(opsional)</span></label>
            <textarea name="keterangan" rows="3" 
                style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;font-size:14px;outline:none;background:rgba(255,255,255,0.02);color:#f1f5f9;transition:border-color .2s;resize:vertical;"
                onfocus="this.style.borderColor='#6B1A2B';this.style.background='rgba(255,255,255,0.04)'"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)';this.style.background='rgba(255,255,255,0.02)'"
                placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
            :disabled="loading || !status"
            :style="loading || !status ? 'opacity:0.5;cursor:not-allowed;' : ''"
            style="width:100%;padding:12px;background:linear-gradient(135deg,#c9982a,#f0be3d);color:#1a0a00;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:opacity .2s, transform .2s;display:flex;align-items:center;justify-content:center;gap:8px;"
            onmouseover="if(this.style.cursor!=='not-allowed')this.style.opacity='0.9'"
            onmouseout="if(this.style.cursor!=='not-allowed')this.style.opacity='1'">
            <template x-if="!loading">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <template x-if="loading">
                <svg style="animation:spin 1s linear infinite;" width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <span x-text="loading ? 'Memproses...' : 'Konfirmasi Absensi'"></span>
        </button>
    </form>

    {{-- Cancel Link --}}
    <div style="text-align:center;margin-top:10px;">
        @php
            $cancelUrl = request('redirect_to') ?? route('siswa.materi.index');
        @endphp
        <a href="{{ $cancelUrl }}" style="font-size:13px;color:#64748b;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#f1f5f9'" onmouseout="this.style.color='#64748b'">
            ← Kembali ke Beranda
        </a>
    </div>
</div>

@push('scripts')
<script>
function attendanceModal() {
    return {
        status: '',
        loading: false,
        countdown: '',
        deadline: @json($batasAbsensi ? \Carbon\Carbon::parse($batasAbsensi)->timestamp : null),
        
        init() {
            if (this.deadline) {
                this.updateCountdown();
                setInterval(() => this.updateCountdown(), 1000);
            }
        },
        
        updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const diff = this.deadline - now;
            
            if (diff <= 0) {
                this.countdown = 'Terlewat';
                return;
            }
            
            const hours = Math.floor(diff / 3600);
            const minutes = Math.floor((diff % 3600) / 60);
            const seconds = diff % 60;
            
            if (hours > 0) {
                this.countdown = `${hours}j ${minutes}m`;
            } else if (minutes > 0) {
                this.countdown = `${minutes}m ${seconds}d`;
            } else {
                this.countdown = `${seconds}d`;
            }
        },
        
        handleSubmit(event) {
            if (!this.status) {
                event.preventDefault();
                alert('Pilih status kehadiran terlebih dahulu!');
                return;
            }
            this.loading = true;
        }
    }
}
</script>
@endpush

<style>
[x-cloak] { display: none !important; }
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

</x-student-layout>
