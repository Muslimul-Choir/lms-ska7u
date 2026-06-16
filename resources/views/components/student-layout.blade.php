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
            --sl-brand:       #6B1A2B;
            --sl-brand-dark:  #3D0A13;
            --sl-accent:      #c9982a;
            --sl-gold:        #c9982a;
            --sl-gold-light:  #f0be3d;
            --sl-bg:          #0b0f19;
            --sl-bg2:         #111827;
            --sl-surface:     rgba(22, 28, 45, 0.70);
            --sl-surface-s:   rgba(30, 38, 58, 0.85);
            --sl-text:        #f1f5f9;
            --sl-text-muted:  #94a3b8;
            --sl-border:      rgba(255,255,255,0.08);
            --sl-border-gold: rgba(201,152,42,0.35);
            --sl-radius:      14px;
            --sl-shadow:      0 4px 24px rgba(0,0,0,0.4), 0 1px 4px rgba(0,0,0,0.2);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--sl-bg);
            background-image:
                linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
            background-size: 40px 40px;
            color: var(--sl-text);
            margin: 0;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity:0; }
            to   { opacity:1; }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,152,42,0); }
            50%       { box-shadow: 0 0 18px 4px rgba(201,152,42,0.18); }
        }
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-4px); }
        }

        main { animation: fadeUp .35s ease both; }

        .sl-card {
            background: var(--sl-surface);
            border: 1px solid var(--sl-border);
            border-radius: var(--sl-radius);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        }
        .sl-card:hover {
            border-color: rgba(201,152,42,0.25);
            box-shadow: 0 4px 32px rgba(0,0,0,.35);
        }
        .sl-btn-gold {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg,#c9982a,#f0be3d);
            color: #1a0a00;
            font-weight: 700;
            border-radius: 99px;
            border: none; cursor: pointer;
            transition: opacity .18s, transform .18s;
        }
        .sl-btn-gold:hover { opacity: .9; transform: translateY(-1px); }

        /* ── Badge colors ── */
        .badge-hadir  { background: rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.25); }
        .badge-izin   { background: rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.25); }
        .badge-sakit  { background: rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.25); }
        .badge-alpha  { background: rgba(239,68,68,0.15);  color:#f87171; border:1px solid rgba(239,68,68,0.25); }

        /* ── Page container ── */
        .sl-page {
            padding-bottom: 90px;
            min-height: calc(100vh - 56px);
        }
        @media (min-width: 640px) { .sl-page { padding-bottom: 100px; } }
        @media (min-width: 1024px) { .sl-page { padding-bottom: 100px; min-height: auto; } }

        /* ── Header ── */
        #student-header {
            position: sticky; top: 0; z-index: 50;
            background: rgba(11,15,25,0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 2px 20px rgba(0,0,0,0.35);
        }
        @media (min-width: 1024px) { #student-header { position: relative; top: auto; } }

        /* ── Bottom nav ── */
        #bottom-nav {
            background: rgba(11,15,25,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255,255,255,0.07);
            box-shadow: 0 -4px 20px rgba(0,0,0,0.4);
        }
        .bnav-item { display:flex;flex-direction:column;align-items:center;gap:3px;flex:1;text-decoration:none;padding:8px 4px;border-radius:10px;transition:all .15s; }
        .bnav-item.active { color:#c9982a; }
        .bnav-item:not(.active) { color:#64748b; }
        .bnav-item:not(.active):hover { color:#94a3b8; }
        .bnav-label { font-size:9px; font-weight:600; letter-spacing:.03em; }

        /* ── Dropdown ── */
        .sl-dropdown {
            background: #161e2e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.5);
            overflow: hidden;
        }
        .sl-dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            text-decoration: none;
            color: #cbd5e1;
            font-size: 13px; font-weight: 600;
            transition: background .15s;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .sl-dropdown-item:last-child { border-bottom: none; }
        .sl-dropdown-item:hover { background: rgba(255,255,255,0.05); color: #f1f5f9; }
        .sl-dropdown-icon {
            width: 28px; height: 28px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        /* ── Progress bar ── */
        .sl-progress { height: 6px; background: rgba(255,255,255,0.08); border-radius: 99px; overflow: hidden; }
        .sl-progress-bar { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#c9982a,#f0be3d); transition: width .6s ease; }

        /* ── Alert box ── */
        .sl-alert { border-radius: 12px; padding: 14px 16px; border: 1px solid; }
        .sl-alert-info  { background: rgba(59,130,246,0.1);  border-color: rgba(59,130,246,0.25);  color: #93c5fd; }
        .sl-alert-warn  { background: rgba(245,158,11,0.1);  border-color: rgba(245,158,11,0.25);  color: #fcd34d; }
        .sl-alert-success { background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.25); color: #6ee7b7; }
        .sl-alert-danger  { background: rgba(239,68,68,0.1);  border-color: rgba(239,68,68,0.25);  color: #fca5a5; }

        /* ── Utility ── */
        .text-gold { color: var(--sl-gold); }
        .text-muted { color: var(--sl-text-muted); }
        .border-gold { border-color: var(--sl-border-gold); }

        /* ── Input overrides for dark ── */
        input, textarea, select {
            background: rgba(30,38,58,0.7) !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            color: #f1f5f9 !important;
            border-radius: 10px !important;
        }
        input:focus, textarea:focus, select:focus {
            outline: none !important;
            border-color: rgba(201,152,42,0.5) !important;
            box-shadow: 0 0 0 3px rgba(201,152,42,0.1) !important;
        }
        input::placeholder, textarea::placeholder { color: #475569 !important; }
        select option { background: #161e2e; color: #f1f5f9; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(201,152,42,0.4); border-radius: 99px; }

        /* ── Link ── */
        .sl-link { color: #c9982a; text-decoration: none; font-weight: 600; }
        .sl-link:hover { color: #f0be3d; }

        /* ── SweetAlert2 Dark Styling ── */
        .swal2-popup {
            background: rgba(22, 28, 45, 0.96) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            color: #f1f5f9 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        }
        .swal2-title {
            color: #fff !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 800 !important;
        }
        .swal2-html-container {
            color: #cbd5e1 !important;
            font-family: 'Inter', sans-serif !important;
        }
        .swal2-confirm {
            background: linear-gradient(135deg,#c9982a,#f0be3d) !important;
            color: #1a0a00 !important;
            font-weight: 700 !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(201,152,42,0.25) !important;
            border: none !important;
            padding: 10px 24px !important;
        }
        .swal2-cancel {
            background: rgba(255,255,255,0.06) !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 10px !important;
            padding: 10px 24px !important;
        }
        .swal2-icon {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .swal2-success-circular-line, .swal2-success-fix {
            background: transparent !important;
        }
    </style>
</head>
<body x-data x-cloak>

{{-- ══ TOP HEADER ══ --}}
<header id="student-header">
    <div style="max-width:960px;margin:0 auto;padding:0 16px;height:56px;display:flex;align-items:center;gap:12px;">

        {{-- Logo / Back button --}}
        @isset($back)
            {{ $back }}
        @else
            <a href="{{ route('siswa.dashboard') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:rgba(201,152,42,0.15);border:1px solid rgba(201,152,42,0.25);border-radius:10px;color:#c9982a;text-decoration:none;flex-shrink:0;transition:background .2s;" onmouseover="this.style.background='rgba(201,152,42,0.25)'" onmouseout="this.style.background='rgba(201,152,42,0.15)'">
                <x-student-logo class="w-7 h-7" />
            </a>
        @endisset

        {{-- Page title --}}
        <div style="flex:1;min-width:0;">
            @isset($heading)
                <div style="font-size:15px;font-weight:700;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif;">{{ $heading }}</div>
            @else
                <div style="font-size:15px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">LMS SKA7U</div>
            @endisset
        </div>

        {{-- Notification Bell --}}
        @auth
        <div style="position:relative;flex-shrink:0;margin-right:4px;" x-data="{ open: false, unreadCount: 0, notifications: [], loading: false,
            async fetchNotifications() {
                this.loading = true;
                try {
                    let res = await fetch('{{ route('siswa.notifications.index') }}');
                    if (res.ok) {
                        let data = await res.json();
                        this.notifications = data.notifications;
                        this.unreadCount = data.unreadCount;
                    }
                } catch(e) { console.error(e); }
                this.loading = false;
            },
            async markAllAsRead() {
                try {
                    let res = await fetch('{{ route('siswa.notifications.readAll') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (res.ok) {
                        this.unreadCount = 0;
                        this.notifications.forEach(n => n.read_at = new Date().toISOString());
                    }
                } catch(e) { console.error(e); }
            },
            formatTime(dateStr) {
                let date = new Date(dateStr);
                let now = new Date();
                let diffMs = now - date;
                let diffMins = Math.floor(diffMs / 60000);
                if (diffMins < 1) return 'Baru saja';
                if (diffMins < 60) return diffMins + ' menit yang lalu';
                let diffHours = Math.floor(diffMins / 60);
                if (diffHours < 24) return diffHours + ' jam yang lalu';
                let diffDays = Math.floor(diffHours / 24);
                if (diffDays === 1) return 'Kemarin';
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            },
            init() {
                this.fetchNotifications();
                setInterval(() => this.fetchNotifications(), 30000);
            }
        }">
            <button @click="open = !open" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:#94a3b8;cursor:pointer;position:relative;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='#f1f5f9';" onmouseout="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#94a3b8';">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <template x-if="unreadCount > 0">
                    <span style="position:absolute;top:-4px;right:-4px;min-width:16px;height:16px;background:#ef4444;border-radius:99px;font-size:9px;font-weight:800;color:#fff;display:flex;align-items:center;justify-content:center;padding:0 3px;border:2px solid #0b0f19;animation:glowPulse 2s infinite;" x-text="unreadCount"></span>
                </template>
            </button>

            {{-- Notifications Dropdown --}}
            <div x-show="open" @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="sl-dropdown" style="position:absolute;top:calc(100% + 8px);right:0;width:300px;z-index:100;max-height:400px;display:flex;flex-direction:column;" x-cloak>
                 
                 <div style="padding:10px 14px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.02);">
                     <span style="font-size:12px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;">Notifikasi</span>
                     <button x-show="unreadCount > 0" @click="markAllAsRead()" style="font-size:10px;font-weight:600;color:#c9982a;background:none;border:none;cursor:pointer;padding:2px 4px;border-radius:4px;transition:color 0.15s;" onmouseover="this.style.color='#f0be3d'" onmouseout="this.style.color='#c9982a'">
                         Tandai dibaca
                     </button>
                 </div>

                 <div style="flex:1;overflow-y:auto;max-height:300px;">
                     <template x-if="loading && notifications.length === 0">
                         <div style="padding:20px;text-align:center;color:#64748b;font-size:11px;">Memuat...</div>
                     </template>

                     <template x-if="notifications.length === 0 && !loading">
                         <div style="padding:30px 20px;text-align:center;color:#64748b;font-size:11px;display:flex;flex-direction:column;align-items:center;gap:8px;">
                             <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:#475569;">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                             </svg>
                             Belum ada notifikasi
                         </div>
                     </template>

                     <template x-for="item in notifications" :key="item.id">
                         <a :href="'/siswa/notifications/' + item.id + '/read'" 
                            style="display:flex;gap:10px;padding:12px 14px;text-decoration:none;transition:background 0.15s;border-bottom:1px solid rgba(255,255,255,0.05);"
                            :style="item.read_at === null ? 'background:rgba(201,152,42,0.04);' : ''"
                            onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                            :onmouseout="item.read_at === null ? 'this.style.background=\'rgba(201,152,42,0.04)\'' : 'this.style.background=\'transparent\''">
                             
                             <div style="flex-shrink:0;width:26px;height:26px;border-radius:8px;display:flex;align-items:center;justify-content:center;"
                                  :style="
                                     item.data.type === 'jadwal' ? 'background:rgba(59,130,246,0.15); color:#60a5fa;' :
                                     item.data.type === 'mapel'  ? 'background:rgba(245,158,11,0.15); color:#f59e0b;' :
                                     item.data.type === 'materi' ? 'background:rgba(16,185,129,0.15); color:#34d399;' :
                                     item.data.type === 'tugas'  ? 'background:rgba(239,68,68,0.15); color:#f87171;' :
                                     'background:rgba(167,139,250,0.15); color:#c084fc;'
                                  ">
                                 <template x-if="item.data.type === 'jadwal'">
                                     <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                 </template>
                                 <template x-if="item.data.type === 'mapel'">
                                     <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                 </template>
                                 <template x-if="item.data.type === 'materi'">
                                     <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                 </template>
                                 <template x-if="item.data.type === 'tugas'">
                                     <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                 </template>
                                 <template x-if="item.data.type === 'kuis'">
                                     <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                 </template>
                             </div>

                             <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:2px;">
                                 <div style="font-size:11px;font-weight:700;color:#e2e8f0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" x-text="item.data.title"></div>
                                 <div style="font-size:10px;color:#94a3b8;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" x-text="item.data.message"></div>
                                 <div style="font-size:8px;color:#475569;margin-top:2px;" x-text="formatTime(item.created_at)"></div>
                             </div>

                             <template x-if="item.read_at === null">
                                 <div style="width:6px;height:6px;border-radius:50%;background:#ef4444;align-self:center;flex-shrink:0;"></div>
                             </template>
                         </a>
                     </template>
                 </div>
            </div>
        </div>
        @endauth

        {{-- Avatar + dropdown --}}
        @auth
        <div style="position:relative;flex-shrink:0;" x-data="{ open: false }">
            <button @click="open = !open" style="display:flex;align-items:center;gap:7px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:5px 10px 5px 5px;cursor:pointer;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#c9982a,#f0be3d);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#1a0a00;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span style="font-size:12px;font-weight:600;color:#e2e8f0;max-width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                <svg width="13" height="13" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;transition:transform .2s;" :style="open ? 'transform:rotate(180deg)' : ''">
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
                 class="sl-dropdown" style="position:absolute;top:calc(100% + 8px);right:0;width:220px;z-index:100;" x-cloak>

                {{-- User info --}}
                <div style="padding:14px 16px;border-bottom:1px solid rgba(255,255,255,0.07);background:rgba(255,255,255,0.03);">
                    <div style="font-size:13px;font-weight:700;color:#f1f5f9;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
                    <div style="font-size:11px;color:#64748b;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</div>
                </div>

                <a href="{{ route('siswa.profil') }}" class="sl-dropdown-item">
                    <div class="sl-dropdown-icon" style="background:rgba(245,158,11,0.15);">
                        <svg width="14" height="14" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    Profil Saya
                </a>

                <a href="{{ route('siswa.dashboard') }}" class="sl-dropdown-item">
                    <div class="sl-dropdown-icon" style="background:rgba(16,185,129,0.15);">
                        <svg width="14" height="14" fill="none" stroke="#34d399" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    </div>
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sl-dropdown-item" style="width:100%;background:transparent;border:none;cursor:pointer;text-align:left;color:#f87171;">
                        <div class="sl-dropdown-icon" style="background:rgba(239,68,68,0.15);">
                            <svg width="14" height="14" fill="none" stroke="#ef4444" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        </div>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</header>

{{-- ══ FLASH MESSAGES ══ --}}
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
<nav id="bottom-nav" class="fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center h-16 px-1">
    @php
        $pendingTugas = 0;
        $pendingKuis = 0;
        if(Auth::check()) {
            $siswaModel = \App\Models\Siswa::where('id_user', Auth::id())->first();
            if($siswaModel) {
                $pendingTugas = \App\Models\Tugas::whereHas('GuruMapel.JadwalBelajar', fn($q) => $q->where('id_kelas', $siswaModel->id_kelas))
                    ->whereHas('Mapel', fn($q) => $q->forAgama($siswaModel->agama))
                    ->where('status','published')
                    ->whereDoesntHave('PengumpulanTugas', fn($q) => $q->where('id_siswa', $siswaModel->id))
                    ->count();
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
    <a href="{{ route('siswa.dashboard') }}" class="bnav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.dashboard') ? '#c9982a' : 'none' }}" stroke="{{ request()->routeIs('siswa.dashboard') ? '#c9982a' : '#64748b' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
        </div>
        <span class="bnav-label">Home</span>
    </a>

    {{-- Mapel --}}
    <a href="{{ route('siswa.materi.index') }}" class="bnav-item {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.materi.*') ? '#c9982a' : 'none' }}" stroke="{{ request()->routeIs('siswa.materi.*') ? '#c9982a' : '#64748b' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            @php $pendingCount = $pendingTugas + $pendingKuis; @endphp
            @if($pendingCount > 0)
            <span style="position:absolute;top:-6px;right:-8px;min-width:16px;height:16px;background:#ef4444;border-radius:99px;font-size:9px;font-weight:800;color:#fff;display:flex;align-items:center;justify-content:center;padding:0 4px;border:2px solid #0b0f19;">{{ $pendingCount }}</span>
            @endif
        </div>
        <span class="bnav-label">Mapel</span>
    </a>

    {{-- Absensi --}}
    <a href="{{ route('siswa.absensi.index') }}" class="bnav-item {{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.absensi.*') ? '#c9982a' : 'none' }}" stroke="{{ request()->routeIs('siswa.absensi.*') ? '#c9982a' : '#64748b' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="bnav-label">Absensi</span>
    </a>

    {{-- Jadwal --}}
    <a href="{{ route('siswa.jadwal.index') }}" class="bnav-item {{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? 'active' : '' }}">
        <div style="position:relative;display:inline-block;">
            <svg width="20" height="20" fill="{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? '#c9982a' : 'none' }}" stroke="{{ request()->routeIs('siswa.jadwal.*') || request()->routeIs('siswa.pertemuan.*') ? '#c9982a' : '#64748b' }}" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
        </div>
        <span class="bnav-label">Jadwal</span>
    </a>
</nav>
@endauth

@stack('scripts')
</body>
</html>
