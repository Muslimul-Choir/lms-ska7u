<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — {{ config('app.name', 'App') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; }

        body {
            font-family: 'DM Sans', sans-serif;
            height: 100vh; width: 100vw;
            display: flex; align-items: center; justify-content: center;
            background-image: url('gerbang-skaju.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Overlay blur di atas background */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 0;
            pointer-events: none;
        }

        /* ── Scene ── */
        .scene {
            position: relative; z-index: 1;
            width: min(760px, 96vw);
            height: min(470px, 90vh);
            perspective: 1400px;
        }

        /* ── Book shadow ── */
        .book-shadow {
            position: absolute;
            bottom: -20px; left: 5%; right: 5%; height: 30px;
            background: radial-gradient(ellipse, rgba(0,0,0,0.2) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            animation: shadowIn 0.5s 1.4s forwards;
        }
        @keyframes shadowIn { to { opacity: 1; } }

        /* ── Book ── */
        .book {
            width: 100%; height: 100%;
        }

        /* ── Pages wrapper ── */
        .pages {
            display: flex; width: 100%; height: 100%;
            border-radius: 4px 18px 18px 4px;
            overflow: hidden;
            box-shadow:
                -18px 28px 60px rgba(0,0,0,0.22),
                18px 28px 60px rgba(0,0,0,0.15),
                0 2px 8px rgba(0,0,0,0.12);
        }

        /* ── Spine crease ── */
        .spine {
            position: absolute; left: 50%; top: 0; bottom: 0; width: 2px;
            transform: translateX(-50%); z-index: 20; pointer-events: none;
            background: linear-gradient(180deg,
                transparent 0%,
                rgba(107,26,43,0.2) 15%,
                rgba(107,26,43,0.45) 50%,
                rgba(107,26,43,0.2) 85%,
                transparent 100%);
            box-shadow: 1px 0 3px rgba(255,255,255,0.08), -1px 0 4px rgba(0,0,0,0.25);
        }

        /* ── LEFT page — animasi buka dari kanan ke kiri ── */
        .left-page {
            width: 50%; height: 100%; position: relative; overflow: hidden;
            border-radius: 4px 0 0 4px;
            transform-origin: right center;
            transform: rotateY(90deg);
            opacity: 0;
            animation: openLeft 0.75s cubic-bezier(0.23, 1, 0.32, 1) 0.5s forwards;
        }
        @keyframes openLeft {
            0%   { transform: rotateY(90deg) scaleX(0.6); opacity: 0; }
            60%  { transform: rotateY(-4deg); opacity: 1; }
            100% { transform: rotateY(0deg); opacity: 1; }
        }

        .left-cover {
            position: absolute; inset: 0;
            background: linear-gradient(155deg, #6B1A2B 0%, #4A0F1E 45%, #2D0810 100%);
        }
        .left-cover::before {
            content: ''; position: absolute; inset: 0; opacity: 0.07;
            background-image: repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);
            background-size: 4px 4px;
        }
        .left-img {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; opacity: 0.3; mix-blend-mode: luminosity;
        }
        .left-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(155deg,
                rgba(107,26,43,0.88) 0%,
                rgba(45,8,16,0.65) 50%,
                rgba(15,4,8,0.92) 100%);
        }
        .left-page::after {
            content: ''; position: absolute; top:0; right:0; bottom:0; width:50px;
            background: linear-gradient(to right, transparent, rgba(0,0,0,0.45));
            z-index: 5; pointer-events: none;
        }

        /* ── RIGHT page — animasi buka dari kiri ke kanan ── */
        .right-page {
            width: 50%; height: 100%; position: relative; overflow: hidden;
            border-radius: 0 18px 18px 0;
            background: #ffffff;
            transform-origin: left center;
            transform: rotateY(-90deg);
            opacity: 0;
            animation: openRight 0.75s cubic-bezier(0.23, 1, 0.32, 1) 0.5s forwards;
        }
        @keyframes openRight {
            0%   { transform: rotateY(-90deg) scaleX(0.6); opacity: 0; }
            60%  { transform: rotateY(4deg); opacity: 1; }
            100% { transform: rotateY(0deg); opacity: 1; }
        }
        .right-page::before {
            content: ''; position: absolute; inset: 0;
            background: #ffffff;
            pointer-events: none;
        }
        .right-page::after {
            content: ''; position: absolute; top:0; left:0; bottom:0; width:45px;
            background: linear-gradient(to left, transparent, rgba(0,0,0,0.12));
            z-index: 2; pointer-events: none;
        }

        /* Gold strip */
        .gold-strip {
            position: absolute; top: 0; left: 0; right: 0; height: 3px; z-index: 10;
            background: linear-gradient(90deg, #E8930A, #F5A623, #E8930A);
        }

        /* ── Corner ornaments ── */
        .orn { position: absolute; z-index: 6; opacity: 0.2; }
        .orn-tl { top: 12px; left: 12px; }
        .orn-br { bottom: 12px; right: 20px; transform: rotate(180deg); }
        .orn-tr { top: 12px; right: 12px; transform: rotate(90deg); }

        /* ── LEFT content ── */
        .left-content {
            position: relative; z-index: 10; height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
            padding: clamp(20px,3vh,32px) clamp(20px,3vw,36px) clamp(20px,3vh,28px) clamp(20px,3vw,32px);
            opacity: 0;
            animation: fadeIn 0.4s 1.1s forwards;
        }
        @keyframes fadeIn { to { opacity: 1; } }

        .brand-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(232,147,10,0.18); border: 1px solid rgba(232,147,10,0.35);
            margin-bottom: 16px;
        }
        .left-eyebrow {
            font-size: 10px; text-transform: uppercase; letter-spacing: 2.5px;
            color: rgba(232,147,10,0.72); font-weight: 600; margin-bottom: 7px;
        }
        .left-title {
            font-family: 'Playfair Display', serif; font-weight: 700; color: #fff;
            font-size: clamp(20px,3vw,26px); line-height: 1.2; margin-bottom: 8px;
        }
        .left-sub {
            font-size: 12px; color: rgba(255,255,255,0.38); line-height: 1.65; margin-bottom: 18px;
        }
        .divider-row { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .divider-row span { height: 1px; width: 22px; background: #E8930A; opacity: 0.5; }
        .divider-row i { width: 4px; height: 4px; border-radius: 50%; background: #E8930A; opacity: 0.5; font-style: normal; }
        .feat { display: flex; align-items: center; gap: 9px; margin-bottom: 9px; }
        .feat-dot { width: 4px; height: 4px; border-radius: 50%; background: #E8930A; opacity: 0.55; flex-shrink: 0; }
        .feat-text { font-size: 12px; color: rgba(255,255,255,0.38); }
        .glass-card {
            background: rgba(255,255,255,0.09); border: 1px solid rgba(255,255,255,0.13);
            border-radius: 14px; padding: 14px 18px;
        }
        .glass-label { font-size: 9.5px; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.38); margin-bottom: 4px; }
        .glass-text { font-size: 12.5px; color: rgba(255,255,255,0.82); font-weight: 500; }

        /* ── RIGHT content ── */
        .right-content {
            position: relative; z-index: 10; height: 100%;
            display: flex; flex-direction: column; justify-content: center;
            padding: clamp(18px,3vh,32px) clamp(20px,3vw,36px) clamp(18px,3vh,28px) clamp(28px,4vw,44px);
            opacity: 0;
            animation: fadeIn 0.4s 1.1s forwards;
        }

        .form-accent {
            width: 32px; height: 2.5px; border-radius: 2px;
            background: linear-gradient(90deg, #E8930A, #F5A623);
            margin-bottom: 18px;
            animation: accentSlide 0.5s 1.3s both;
        }
        @keyframes accentSlide {
            from { width: 0; opacity: 0; }
            to   { width: 32px; opacity: 1; }
        }

        .form-eyebrow {
            font-size: 10px; text-transform: uppercase; letter-spacing: 2.5px;
            color: rgba(107,26,43,0.55); font-weight: 600; margin-bottom: 5px;
        }
        .form-title {
            font-family: 'Playfair Display', serif; font-weight: 700;
            font-size: clamp(18px,2.5vw,22px); line-height: 1.2; margin-bottom: 4px;
            color: #2D0810;
        }
        .form-sub { font-size: 12px; color: #9a8880; margin-bottom: 18px; line-height: 1.5; }

        /* Alert */
        .alert {
            margin-bottom: 14px; padding: 9px 13px; border-radius: 10px;
            font-size: 12.5px; font-weight: 500;
            background: rgba(232,147,10,0.1); border: 1px solid rgba(232,147,10,0.28);
            color: #8a5000;
        }

        /* Fields */
        .field { margin-bottom: 12px; }
        .field-label {
            display: block; font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.65px;
            color: #a08070; margin-bottom: 5px;
        }
        .field-label em { color: #E8930A; font-style: normal; }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: #c8b4a8; pointer-events: none; z-index: 1;
        }

        .field-input {
            width: 100%; padding: 9px 12px 9px 35px;
            border-radius: 9px; border: 1.5px solid #ecddd4;
            background: rgba(255,255,255,0.65);
            font-size: 13px; font-family: 'DM Sans', sans-serif;
            color: #2D0810; outline: none;
            transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
        }
        .field-input::placeholder { color: #c8b4a8; }
        .field-input:focus {
            border-color: #E8930A;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(232,147,10,0.11);
        }
        .field-input.is-error { border-color: rgba(220,60,60,0.5); background: rgba(220,60,60,0.05); }

        .pw-toggle {
            position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: 2px;
            color: #c8b4a8; transition: color 0.18s;
        }
        .pw-toggle:hover { color: #E8930A; }

        .err-msg {
            display: flex; align-items: center; gap: 4px;
            font-size: 11.5px; color: #e05555; margin-top: 4px;
        }

        /* Extras row */
        .extras-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .remember-label { display: flex; align-items: center; gap: 6px; cursor: pointer; user-select: none; }
        .remember-label input[type="checkbox"] {
            appearance: none; -webkit-appearance: none;
            width: 14px; height: 14px; border-radius: 4px;
            border: 1.5px solid #d0bdb0; background: rgba(255,255,255,0.7);
            cursor: pointer; flex-shrink: 0; transition: all 0.18s;
        }
        .remember-label input[type="checkbox"]:checked {
            background: linear-gradient(135deg,#E8930A,#F5A623); border-color: #E8930A;
        }
        .remember-label input[type="checkbox"]:checked::after {
            content: ''; display: block; width: 8px; height: 4.5px;
            border-left: 2px solid #fff; border-bottom: 2px solid #fff;
            transform: rotate(-45deg); margin: 2px auto 0;
        }
        .remember-text { font-size: 12px; color: #9a8880; }
        .forgot-link { font-size: 12px; font-weight: 600; color: #E8930A; text-decoration: none; transition: color 0.18s; }
        .forgot-link:hover { color: #F5A623; }

        /* Submit btn */
        .btn-submit {
            width: 100%; padding: 10px 16px; border: none; border-radius: 10px; cursor: pointer;
            background: linear-gradient(135deg, #6B1A2B, #9B3045);
            color: #fff; font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 18px rgba(107,26,43,0.35);
            transition: transform 0.15s, opacity 0.2s; position: relative; overflow: hidden;
        }
        .btn-submit::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1.5px;
            background: linear-gradient(90deg,transparent,rgba(232,147,10,0.5),transparent);
        }
        .btn-submit:hover { transform: translateY(-1px); opacity: 0.92; }
        .btn-submit:active { transform: translateY(0); }

        /* Register */
        .reg-row { margin-top: 12px; text-align: center; font-size: 12px; color: #b09888; }
        .reg-row a { color: #E8930A; font-weight: 600; text-decoration: none; transition: color 0.18s; }
        .reg-row a:hover { color: #F5A623; }

        /* Page number */
        .pg-num {
            position: absolute; bottom: 12px; right: 16px; z-index: 10;
            font-size: 10.5px; letter-spacing: 2.5px;
            font-family: 'Playfair Display', serif;
            color: rgba(107,26,43,0.22);
        }

        /* Field stagger anim */
        .f1 { animation: fadeUp 0.45s 1.20s both; }
        .f2 { animation: fadeUp 0.45s 1.28s both; }
        .f3 { animation: fadeUp 0.45s 1.36s both; }
        .f4 { animation: fadeUp 0.45s 1.44s both; }
        .f5 { animation: fadeUp 0.45s 1.52s both; }
        .f6 { animation: fadeUp 0.45s 1.60s both; }
        @keyframes fadeUp {
            from { opacity:0; transform: translateY(10px); }
            to   { opacity:1; transform: translateY(0); }
        }

        /* ── Responsive: stack on small screens ── */
        @media (max-width: 600px) {
            html, body { overflow: auto; }
            .scene { width: 96vw; height: auto; }
            .book { height: auto; }
            .pages { flex-direction: column; border-radius: 12px; height: auto; }
            .left-page { display: none; }
            .right-page { width: 100%; border-radius: 12px; }
            .spine { display: none; }
        }
    </style>
</head>
<body>

    {{-- ════ BOOK SCENE ════ --}}
    <div class="scene">
        <div class="book-shadow"></div>
        <div class="book">
            <div class="pages" style="position:relative;">

                {{-- Spine crease --}}
                <div class="spine"></div>

                {{-- ══════ LEFT PAGE ══════ --}}
                <div class="left-page">
                    <div class="left-cover"></div>
                    <img class="left-img"
                         src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=700&q=75"
                         alt="">
                    <div class="left-overlay"></div>
                    <div class="gold-strip"></div>

                    {{-- Ornaments --}}
                    <div class="orn orn-tl">
                        <svg width="44" height="44" fill="none" viewBox="0 0 44 44">
                            <path d="M2 2h18M2 2v18" stroke="#E8930A" stroke-width="1.5"/>
                            <path d="M7 7h10M7 7v10" stroke="#E8930A" stroke-width="0.8"/>
                            <circle cx="2" cy="2" r="2" fill="#E8930A"/>
                        </svg>
                    </div>
                    <div class="orn orn-br">
                        <svg width="36" height="36" fill="none" viewBox="0 0 36 36">
                            <path d="M2 2h14M2 2v14" stroke="#E8930A" stroke-width="1.5"/>
                            <circle cx="2" cy="2" r="1.5" fill="#E8930A"/>
                        </svg>
                    </div>

                    <div class="left-content">
                        <div>
                            <div class="brand-icon">
                                <img src="{{ asset('LogoSMKN7Batam.png') }}"
                                    alt="Logo SMKN 7 Batam"
                                    class="w-8 h-8 object-contain">
                            </div>
                            <p class="left-eyebrow">Learning Management System</p>
                            <h1 class="left-title">{{ config('app.name', 'LMS App') }}</h1>
                            <p class="left-sub">Mendukung proses pembelajaran dan pengelolaan akademik dalam satu platform yang terintegrasi.</p>
                            <div class="divider-row"><span></span><i></i><span></span></div>
                            @foreach(['Pembelajaran digital terpusat','Akses mudah untuk seluruh pengguna','Informasi dan laporan terkelola dengan baik'] as $f)
                            <div class="feat">
                                <div class="feat-dot"></div>
                                <div class="feat-text">{{ $f }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="glass-card">
                            <p class="glass-label">Selamat Datang</p>
                            <p class="glass-text">Silahkan Masuk Untuk Melanjutkan</p>
                        </div>
                    </div>
                </div>

                {{-- ══════ RIGHT PAGE ══════ --}}
                <div class="right-page">
                    <div class="gold-strip"></div>

                    {{-- Corner ornament TR --}}
                    <div class="orn orn-tr">
                        <svg width="36" height="36" fill="none" viewBox="0 0 36 36">
                            <path d="M2 2h14M2 2v14" stroke="#E8930A" stroke-width="1.5"/>
                            <circle cx="2" cy="2" r="1.5" fill="#E8930A"/>
                        </svg>
                    </div>

                    <div class="right-content">

                        <div class="form-accent"></div>

                        @if(session('status'))
                        <div class="alert">{{ session('status') }}</div>
                        @endif

                        <p class="form-eyebrow f1">Autentikasi</p>
                        <h2 class="form-title f1">Selamat datang</h2>
                        <p class="form-sub f2">Masuk ke akun Anda untuk melanjutkan</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="field f3">
                                <label for="email" class="field-label">Email <em>*</em></label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <input id="email" type="email" name="email"
                                           value="{{ old('email') }}"
                                           placeholder="nama@domain.com"
                                           required autofocus autocomplete="username"
                                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}">
                                </div>
                                @error('email')
                                    <p class="err-msg">
                                        <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="field f4">
                                <label for="password" class="field-label">Password <em>*</em></label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                    <input id="password" type="password" name="password"
                                           placeholder="••••••••"
                                           required autocomplete="current-password"
                                           class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                           style="padding-right:36px">
                                    <button type="button" class="pw-toggle" onclick="togglePw()">
                                        <svg id="eye-show" style="display:block;width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="eye-hide" style="display:none;width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="err-msg">
                                        <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Remember + Forgot --}}
                            <div class="extras-row f5">
                                <label class="remember-label">
                                    <input id="remember_me" type="checkbox" name="remember">
                                    <span class="remember-text">Ingat saya</span>
                                </label>
                                @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn-submit f6">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk
                            </button>

                        </form>

                        {{-- @if(Route::has('register'))
                        <p class="reg-row">
                            Belum punya akun?
                            <a href="{{ route('register') }}">Daftar sekarang</a>
                        </p>
                        @endif --}}

                    </div>

                    <span class="pg-num">— 01 —</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePw() {
            const pw = document.getElementById('password');
            const s = document.getElementById('eye-show');
            const h = document.getElementById('eye-hide');
            if (pw.type === 'password') {
                pw.type = 'text';
                s.style.display = 'none'; h.style.display = 'block';
            } else {
                pw.type = 'password';
                s.style.display = 'block'; h.style.display = 'none';
            }
        }
    </script>
</body>
</html>