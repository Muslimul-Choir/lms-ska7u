<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'LMS SKA7U') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sl-brand:    #6B1A2B;
            --sl-accent:   #c9982a;
            --sl-gold:     #c9982a;
            --sl-bg:       #f4f6fb;
            --sl-surface:  #ffffff;
            --sl-text:     #0f172a;
            --sl-muted:    #64748b;
            --sl-border:   #e2e8f0;
            --sl-radius:   14px;
            --sl-shadow:   0 1px 8px rgba(0,0,0,.07), 0 4px 16px rgba(0,0,0,.04);
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--sl-bg);
            color: var(--sl-text);
            margin: 0;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        main { animation: fadeUp .3s ease; }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(6px); }
            to   { opacity:1; transform:none; }
        }
        /* Safe area for bottom nav - ensure content is not covered */
        .sl-page { 
            padding-bottom: 140px; 
            min-height: calc(100vh - 56px);
        }
        @media (min-width: 640px) {
            .sl-page { 
                padding-bottom: 140px; /* Keep same padding for tablet */
            }
        }
        @media (min-width: 1024px) { 
            .sl-page { 
                padding-bottom: 140px; /* Keep same padding for desktop */
                min-height: auto;
            } 
        }
        /* Desktop navbar - not sticky */
        #student-header { position: sticky; top: 0; z-index: 50; }
        @media (min-width: 1024px) {
            #student-header { position: relative; top: auto; }
        }
    </style>
</head>
<body x-data x-cloak>

{{-- ══ TOP HEADER ══ --}}
<header id="student-header" style="background:linear-gradient(135deg,#6B1A2B 0%,#2D0810 100%);box-shadow:0 2px 12px rgba(0,0,0,.25);">
    <div style="max-width:900px;margin:0 auto;padding:0 16px;height:56px;display:flex;align-items:center;gap:12px;">

        {{-- Logo / Back button --}}
        @isset($back)
            {{ $back }}
        @else
            <a href="{{ route('siswa.dashboard') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:10px;color:#fff;text-decoration:none;flex-shrink:0;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.22)'" onmouseout="this.style.background='rgba(255,255,255,.12)'">
                <x-student-logo class="w-7 h-7" />
            </a>
        @endisset

        {{-- Page title --}}
        <div style="flex:1;min-width:0;">
            @isset($heading)
                <div style="font-size:15px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $heading }}</div>
            @else
                <div style="font-size:15px;font-weight:700;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;">LMS SKA7U</div>
            @endisset
        </div>

        {{-- Avatar + dropdown --}}
        @auth
        <div style="position:relative;flex-shrink:0;" x-data="{ open: false }">
            <button @click="open = !open" style="display:flex;align-items:center;gap:7px;background:rgba(255,255,255,.12);border:none;border-radius:10px;padding:5px 10px 5px 5px;cursor:pointer;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.12)'">
                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#E8930A,#c9982a);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span style="font-size:12px;font-weight:600;color:#fff;max-width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                <svg width="13" height="13" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;opacity:.7;transition:transform .2s;" :style="open ? 'transform:rotate(180deg)' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 style="position:absolute;top:calc(100% + 8px);right:0;width:210px;background:#fff;border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.18);border:1px solid #e2e8f0;overflow:hidden;z-index:100;" x-cloak>

                {{-- User info --}}
                <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;background:#fafafa;">
                    <div style="font-size:13px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</div>
                </div>

                <a href="{{ route('siswa.profil') }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;text-decoration:none;color:#374151;font-size:13px;font-weight:600;transition:background .15s;border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="width:28px;height:28px;border-radius:8px;background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="14" height="14" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    Profil Saya
                </a>

                <a href="{{ route('siswa.dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;text-decoration:none;color:#374151;font-size:13px;font-weight:600;transition:background .15s;border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="width:28px;height:28px;border-radius:8px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    </div>
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:10px;padding:12px 16px;width:100%;background:transparent;border:none;cursor:pointer;color:#dc2626;font-size:13px;font-weight:600;transition:background .15s;text-align:left;" onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='transparent'">
                        <div style="width:28px;height:28px;border-radius:8px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="14" height="14" fill="none" stroke="#dc2626" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        </div>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</header>

{{-- ══ FLASH MESSAGES (SweetAlert) ══ --}}
@if(session('success'))
<x-alerts.success>{{ session('success') }}</x-alerts.success>
@endif

@if(session('error'))
<x-alerts.error>{{ session('error') }}</x-alerts.error>
@endif

{{-- ══ MAIN CONTENT ══ --}}
<main class="sl-page">
    {{ $slot }}
</main>

{{-- ══ BOTTOM NAV ══ --}}
@auth
<nav id="bottom-nav" class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 shadow-lg flex justify-around items-center h-16 px-1" style="box-shadow:0 -4px 16px rgba(0,0,0,.08);">
    @php
        $pendingTugas = 0;
        $pendingKuis = 0;
        if(Auth::check()) {
            $siswaModel = \App\Models\Siswa::where('id_user', Auth::id())->first();
            if($siswaModel) {
                // Ganti query menggunakan JadwalBelajar untuk mendapatkan kelas
                // Filter juga berdasarkan agama siswa untuk mapel agama
                $pendingTugas = \App\Models\Tugas::whereHas('GuruMapel.JadwalBelajar', fn($q) => $q->where('id_kelas', $siswaModel->id_kelas))
                    ->whereHas('Mapel', fn($q) => $q->forAgama($siswaModel->agama))
                    ->where('status','published')
                    ->whereDoesntHave('PengumpulanTugas', fn($q) => $q->where('id_siswa', $siswaModel->id))
                    ->count();
                
                // Count available kuis dengan filter agama
                $now = now();
                $pendingKuis = \App\Models\Kuis::whereHas('guruMapel.JadwalBelajar', fn($q) => $q->where('id_kelas', $siswaModel->id_kelas))
                    ->whereHas('guruMapel.Mapel', fn($q) => $q->forAgama($siswaModel->agama))
                    ->where('status', 'published')
                    ->where('batas_mulai', '<=', $now)
                    ->where('batas_selesai', '>=', $now)
                    ->whereDoesntHave('HasilKuis', fn($q) => $q->where('id_siswa', $siswaModel->id))
                    ->count();
            }
        }
    @endphp

    {{-- Home --}}
    <a href="{{ route('siswa.dashboard') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.dashboard') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.dashboard') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.dashboard') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.dashboard') ? '700' : '500' }};">Home</span>
    </a>

    {{-- Materi --}}
    <a href="{{ route('siswa.materi.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.materi.*') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.materi.*') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.materi.*') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.materi.*') ? '700' : '500' }};">Materi</span>
    </a>

    {{-- Tugas --}}
    <a href="{{ route('siswa.tugas.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.tugas.*') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.tugas.*') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.tugas.*') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            @if($pendingTugas > 0)
            <span style="position:absolute;top:-6px;right:-8px;min-width:16px;height:16px;background:#ef4444;border-radius:99px;font-size:9px;font-weight:800;color:#fff;display:flex;align-items:center;justify-content:center;padding:0 4px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,0.2);">{{ $pendingTugas }}</span>
            @endif
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.tugas.*') ? '700' : '500' }};">Tugas</span>
    </a>

    {{-- Kuis --}}
    <a href="{{ route('siswa.kuis.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.kuis.*') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.kuis.*') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.kuis.*') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
            </svg>
            @if($pendingKuis > 0)
            <span style="position:absolute;top:-6px;right:-8px;min-width:16px;height:16px;background:#ef4444;border-radius:99px;font-size:9px;font-weight:800;color:#fff;display:flex;align-items:center;justify-content:center;padding:0 4px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,0.2);">{{ $pendingKuis }}</span>
            @endif
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.kuis.*') ? '700' : '500' }};">Kuis</span>
    </a>

    {{-- Absensi --}}
    <a href="{{ route('siswa.absensi.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.absensi.*') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.absensi.*') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.absensi.*') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.absensi.*') ? '700' : '500' }};">Absensi</span>
    </a>

    {{-- Jadwal --}}
    <a href="{{ route('siswa.jadwal.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:background .15s;{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? 'color:#6B1A2B;' : 'color:#94a3b8;' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? '#6B1A2B' : 'none' }}" stroke="{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? '#6B1A2B' : '#94a3b8' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
        </div>
        <span style="font-size:9px;font-weight:{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? '700' : '500' }};">Jadwal</span>
    </a>
</nav>
@endauth

@stack('scripts')
</body>
</html>
