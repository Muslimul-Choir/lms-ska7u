<x-app-layout>
    <x-slot name="header">
        <div class="lms-page-banner">
            <div class="lms-banner-deco lms-banner-deco-1"></div>
            <div class="lms-banner-deco lms-banner-deco-2"></div>
            <div class="lms-banner-deco lms-banner-deco-3"></div>
            <nav class="lms-breadcrumb">
                <a href="{{ route('dashboard') }}" class="lms-breadcrumb-link">Dashboard</a>
                <span class="lms-breadcrumb-sep">/</span>
                <span class="lms-breadcrumb-active">Profil Saya</span>
            </nav>
            <h2 class="lms-banner-title">Profil Saya</h2>
            <p class="lms-banner-sub">Kelola informasi akun dan keamanan Anda</p>
        </div>
    </x-slot>

    {{-- ============================================================
         GLOBAL PROFILE STYLES — shared by all 4 partials
    ============================================================ --}}
    <style>
        /* ---- Base Variables ---- */
        :root {
            --lms-maroon:       #6B1A2B;
            --lms-maroon-mid:   #7D2035;
            --lms-maroon-light: #9B3045;
            --lms-gold:         #E8930A;
            --lms-gold-light:   #F5A623;
            --lms-gold-pale:    #FDF3E3;
            --lms-gold-border:  #FDDFA0;
        }

        /* ---- Page Banner ---- */
        .lms-page-banner {
            background: linear-gradient(135deg, #6B1A2B 0%, #4A0F1E 55%, #2D0810 100%);
            margin: -1.5rem -1.5rem 0;
            padding: 1.2rem 2rem 1.4rem;
            position: relative;
            overflow: hidden;
        }
        .lms-banner-deco {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            border: 1.5px solid rgba(232,147,10,0.18);
        }
        .lms-banner-deco-1 { width:160px; height:160px; top:-40px; right:30px; }
        .lms-banner-deco-2 { width:90px;  height:90px;  top:30px;  right:120px; border-color:rgba(232,147,10,0.10); }
        .lms-banner-deco-3 { width:50px;  height:50px;  top:60px;  right:60px;  border-color:rgba(255,255,255,0.08); }
        .lms-breadcrumb      { font-size:12.5px; color:rgba(255,255,255,0.5); margin-bottom:5px; }
        .lms-breadcrumb-link { color:rgba(255,255,255,0.5); text-decoration:none; transition:color .2s; }
        .lms-breadcrumb-link:hover { color:var(--lms-gold-light); }
        .lms-breadcrumb-sep  { margin:0 7px; color:rgba(255,255,255,0.3); }
        .lms-breadcrumb-active { color:var(--lms-gold-light); font-weight:600; }
        .lms-banner-title    { font-size:22px; font-weight:700; color:#fff; margin:0 0 3px; letter-spacing:-.3px; }
        .lms-banner-sub      { font-size:13px; color:rgba(255,255,255,0.5); margin:0; }

        /* ---- Card Shell ---- */
        .lms-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.07);
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        /* ---- Card Header ---- */
        .lms-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px 18px;
            border-bottom: 1px solid #F3F4F6;
            background: #FAFAFA;
        }
        .lms-card-icon {
            width: 42px; height: 42px;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .lms-card-icon-gold  { background: var(--lms-gold-pale); }
        .lms-card-icon-red   { background: #FEF2F2; }
        .lms-card-icon-slate { background: #F1F5F9; }
        .lms-card-header-text h3 {
            font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 2px;
        }
        .lms-card-header-text p {
            font-size: 12px; color: #9CA3AF; margin: 0;
        }

        /* ---- Card Body ---- */
        .lms-card-body { padding: 24px; }

        /* ---- Form Labels ---- */
        .lms-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: .55px;
            margin-bottom: 7px;
        }

        /* ---- Input Wrapper ---- */
        .lms-input-wrap { position: relative; }
        .lms-input-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #CBD5E1;
            display: flex; align-items: center;
        }

        /* ---- Text Input ---- */
        .lms-input {
            width: 100%;
            padding: 10px 14px 10px 42px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 14px;
            color: #111827;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            -webkit-appearance: none;
        }
        .lms-input::placeholder { color: #C4CAD4; }
        .lms-input:focus {
            border-color: var(--lms-gold);
            box-shadow: 0 0 0 3px rgba(232,147,10,0.13);
        }
        .lms-input-error {
            border-color: #FCA5A5 !important;
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08) !important;
        }

        /* ---- Error Message ---- */
        .lms-error {
            display: flex; align-items: center; gap: 5px;
            font-size: 12px; color: #DC2626;
            margin-top: 5px;
        }

        /* ---- Buttons ---- */
        .lms-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity .2s, transform .1s, background .2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .lms-btn:active { transform: scale(.98); }

        .lms-btn-primary {
            background: linear-gradient(135deg, var(--lms-maroon) 0%, var(--lms-maroon-light) 100%);
            color: #fff;
        }
        .lms-btn-primary:hover { opacity: .88; color: #fff; }

        .lms-btn-ghost {
            background: #F9FAFB;
            color: #374151;
            border: 1.5px solid #E5E7EB;
        }
        .lms-btn-ghost:hover { background: #F3F4F6; }

        .lms-btn-danger-soft {
            background: #FEF2F2;
            color: #B91C1C;
            border: 1.5px solid #FECACA;
        }
        .lms-btn-danger-soft:hover { background: #FEE2E2; }

        .lms-btn-danger-solid {
            background: #DC2626;
            color: #fff;
            border: 1.5px solid #DC2626;
        }
        .lms-btn-danger-solid:hover { background: #B91C1C; }

        /* ---- Success Toast ---- */
        .lms-toast {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 13px; font-weight: 500; color: #15803D;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            padding: 8px 14px;
            border-radius: 8px;
        }

        /* ---- Divider ---- */
        .lms-divider { height: 1px; background: #F3F4F6; margin: 20px 0; }

        /* ---- Password Strength ---- */
        .lms-strength-track {
            height: 5px; background: #F3F4F6;
            border-radius: 99px; overflow: hidden;
            margin-top: 8px;
        }
        .lms-strength-fill {
            height: 100%; width: 0%;
            border-radius: 99px;
            transition: width .35s ease, background .35s ease;
        }
        .lms-strength-label {
            font-size: 11.5px; margin-top: 5px; font-weight: 600;
        }

        /* ---- Warning / Info Notice ---- */
        .lms-notice {
            display: flex; gap: 12px;
            padding: 13px 16px;
            border-radius: 10px;
        }
        .lms-notice-warn {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
        }
        .lms-notice-info {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
        }
        .lms-notice-icon { flex-shrink:0; margin-top:1px; }
        .lms-notice-text { font-size:13px; line-height:1.65; margin:0; color:#92400E; }

        /* ---- Badges ---- */
        .lms-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600;
            padding: 4px 10px; border-radius: 20px;
            margin-top: 8px;
        }
        .lms-badge-verified  { background:#F0FDF4; color:#15803D; border:1px solid #BBF7D0; }
        .lms-badge-warn      { background:#FFFBEB; color:#B45309; border:1px solid #FDE68A; }
        .lms-badge-role      { background:var(--lms-gold-pale); color:#854F0B; border:1px solid var(--lms-gold-border); }

        /* ---- Avatar Strip ---- */
        .lms-avatar-strip {
            display: flex; align-items: center; gap: 16px;
            padding: 0 2px 20px;
        }
        .lms-avatar {
            width: 76px; height: 76px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--lms-gold) 0%, var(--lms-maroon) 100%);
            border: 4px solid #fff;
            box-shadow: 0 4px 18px rgba(107,26,43,0.22);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .lms-avatar-name  { font-size:17px; font-weight:700; color:#111827; margin:0 0 2px; }
        .lms-avatar-email { font-size:13px; color:#9CA3AF; margin:0 0 5px; }

        /* ---- Form Group Spacing ---- */
        .lms-form-group { margin-bottom: 18px; }

        /* ---- Action Row ---- */
        .lms-action-row {
            display: flex; align-items: center; gap: 12px;
            flex-wrap: wrap; padding-top: 6px;
        }
    </style>

    <div class="py-6">
        <div class="w-full sm:px-6 lg:px-8 space-y-5">

            {{-- ---- Avatar / User Strip ---- --}}
            <div class="lms-avatar-strip">
                <div class="lms-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="lms-avatar-name">{{ Auth::user()->name }}</p>
                    <p class="lms-avatar-email">{{ Auth::user()->email }}</p>
                    <span class="lms-badge lms-badge-role">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Administrator
                    </span>
                </div>
            </div>

            {{-- ---- 1. Profile Information ---- --}}
            <div class="lms-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- ---- 2. Update Password ---- --}}
            <div class="lms-card">
                @include('profile.partials.update-password-form')
            </div>

            {{-- ---- 3. Delete Account ---- --}}
            <div class="lms-card">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>