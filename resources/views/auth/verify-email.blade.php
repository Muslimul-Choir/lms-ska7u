<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email — {{ config('app.name', 'App') }}</title>
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
            width: min(480px, 96vw);
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

        /* ── Card ── */
        .card {
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.25),
                0 8px 40px rgba(255,255,255,0.15),
                0 25px 60px rgba(0,0,0,0.35),
                0 0 80px rgba(255,255,255,0.08);
            transform: rotateY(-90deg) scaleX(0.6);
            opacity: 0;
            animation: openCard 0.75s cubic-bezier(0.23, 1, 0.32, 1) 0.5s forwards;
        }
        @keyframes openCard {
            0%   { transform: rotateY(-90deg) scaleX(0.6); opacity: 0; }
            60%  { transform: rotateY(4deg); opacity: 1; }
            100% { transform: rotateY(0deg); opacity: 1; }
        }

        /* Gold strip */
        .gold-strip {
            height: 3px;
            background: linear-gradient(90deg, #E8930A, #F5A623, #E8930A);
        }

        /* ── Corner ornament ── */
        .orn { position: absolute; z-index: 6; opacity: 0.2; }
        .orn-tr { top: 16px; right: 16px; transform: rotate(90deg); }

        /* ── Card content ── */
        .card-content {
            position: relative;
            padding: clamp(28px,4vh,40px) clamp(28px,4vw,44px);
            opacity: 0;
            animation: fadeIn 0.4s 1.1s forwards;
        }
        @keyframes fadeIn { to { opacity: 1; } }

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
            font-size: clamp(18px,2.5vw,22px); line-height: 1.2; margin-bottom: 6px;
            color: #2D0810;
        }
        .form-sub {
            font-size: 12.5px; color: #9a8880; margin-bottom: 24px;
            line-height: 1.65;
        }

        /* Alert success */
        .alert-success {
            margin-bottom: 16px; padding: 9px 13px; border-radius: 10px;
            font-size: 12.5px; font-weight: 500;
            background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.28);
            color: #166534;
            display: flex; align-items: flex-start; gap: 7px;
        }
        .alert-success svg { flex-shrink: 0; margin-top: 1px; }

        /* Icon envelope illustration */
        .email-icon-wrap {
            display: flex; justify-content: center;
            margin-bottom: 20px;
        }
        .email-icon-bg {
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(232,147,10,0.12), rgba(107,26,43,0.10));
            display: flex; align-items: center; justify-content: center;
            border: 1.5px solid rgba(232,147,10,0.2);
            animation: iconPulse 2.5s ease-in-out infinite;
        }
        @keyframes iconPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(232,147,10,0.15); }
            50%       { box-shadow: 0 0 0 10px rgba(232,147,10,0); }
        }

        /* Buttons row */
        .btn-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-top: 4px;
        }

        .logout-btn {
            font-size: 12px; font-weight: 600; color: #a08070;
            background: none; border: none; cursor: pointer;
            text-decoration: none; transition: color 0.18s;
            display: flex; align-items: center; gap: 5px;
            font-family: 'DM Sans', sans-serif;
        }
        .logout-btn:hover { color: #6B1A2B; }

        .btn-submit {
            padding: 10px 22px; border: none; border-radius: 10px; cursor: pointer;
            background: linear-gradient(135deg, #6B1A2B, #9B3045);
            color: #fff; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 18px rgba(107,26,43,0.35);
            transition: transform 0.15s, opacity 0.2s; position: relative; overflow: hidden;
        }
        .btn-submit::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1.5px;
            background: linear-gradient(90deg,transparent,rgba(232,147,10,0.5),transparent);
        }
        .btn-submit:hover { transform: translateY(-1px); opacity: 0.92; }
        .btn-submit:active { transform: translateY(0); }

        /* Page number */
        .pg-num {
            position: absolute; bottom: 12px; right: 16px; z-index: 10;
            font-size: 10.5px; letter-spacing: 2.5px;
            font-family: 'Playfair Display', serif;
            color: rgba(107,26,43,0.22);
        }

        /* Field stagger */
        .f1 { animation: fadeUp 0.45s 1.20s both; }
        .f2 { animation: fadeUp 0.45s 1.28s both; }
        .f3 { animation: fadeUp 0.45s 1.36s both; }
        .f4 { animation: fadeUp 0.45s 1.44s both; }
        .f5 { animation: fadeUp 0.45s 1.52s both; }
        @keyframes fadeUp {
            from { opacity:0; transform: translateY(10px); }
            to   { opacity:1; transform: translateY(0); }
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }
        .btn-submit.cooldown {
            background: linear-gradient(135deg, #4a4a4a, #666);
            box-shadow: 0 4px 18px rgba(0,0,0,0.2);
        }

        @media (max-width: 600px) {
            html, body { overflow: auto; }
            .scene { width: 96vw; }
        }
    </style>
</head>
<body>

    <div class="scene">
        <div class="book-shadow"></div>

        <div class="card" style="position:relative;">
            <div class="gold-strip"></div>

            {{-- Corner ornament --}}
            <div class="orn orn-tr">
                <svg width="36" height="36" fill="none" viewBox="0 0 36 36">
                    <path d="M2 2h14M2 2v14" stroke="#E8930A" stroke-width="1.5"/>
                    <circle cx="2" cy="2" r="1.5" fill="#E8930A"/>
                </svg>
            </div>

            <div class="card-content">

                <div class="form-accent"></div>

                {{-- Email icon --}}
                <div class="email-icon-wrap f1">
                    <div class="email-icon-bg">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#E8930A" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <p class="form-eyebrow f1">Konfirmasi Akun</p>
                <h2 class="form-title f1">Verifikasi Email</h2>
                <p class="form-sub f2">
                    Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan. Jika tidak menerima email, kami dapat mengirimkan yang baru.
                </p>

                {{-- Status sukses --}}
                @if (session('status') == 'verification-link-sent')
                <div class="alert-success f2">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Link verifikasi telah dikirim ke email Anda. Silakan cek inbox atau folder spam.
                </div>
                @endif

                {{-- Buttons --}}
                <div class="btn-row f3">

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </form>

                    {{-- Kirim ulang --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" id="btn-submit" class="btn-submit">
                            <span id="btn-icon-send">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 8-16 8V4z"/>
                                </svg>
                            </span>
                            <span id="btn-icon-loading" style="display:none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 0.8s linear infinite;">
                                    <path stroke-linecap="round" d="M12 2a10 10 0 0 1 10 10"/>
                                </svg>
                            </span>
                            <span id="btn-label">Kirim Ulang Email</span>
                        </button>
                    </form>

                </div>

            </div>

            <span class="pg-num">— 03 —</span>
        </div>
    </div>

    <script>
        const COOLDOWN_KEY  = 'verify_resend_cooldown_until';
        const COOLDOWN_SECS = 60;

        const btn      = document.getElementById('btn-submit');
        const label    = document.getElementById('btn-label');
        const iconSend = document.getElementById('btn-icon-send');
        const iconLoad = document.getElementById('btn-icon-loading');

        let cooldownTimer = null;

        function startCooldown(secondsLeft) {
            btn.disabled = true;
            btn.classList.add('cooldown');
            iconSend.style.display = 'none';
            iconLoad.style.display = 'none';

            function tick() {
                label.textContent = 'Tunggu ' + secondsLeft + 's';
                if (secondsLeft <= 0) {
                    resetBtn();
                    return;
                }
                secondsLeft--;
                cooldownTimer = setTimeout(tick, 1000);
            }
            tick();
        }

        function resetBtn() {
            btn.disabled = false;
            btn.classList.remove('cooldown');
            iconSend.style.display = 'inline-flex';
            iconLoad.style.display = 'none';
            label.textContent = 'Kirim Ulang Email';
            localStorage.removeItem(COOLDOWN_KEY);
        }

        // Cek cooldown tersisa
        (function checkStoredCooldown() {
            const until = parseInt(localStorage.getItem(COOLDOWN_KEY) || '0', 10);
            const now   = Math.floor(Date.now() / 1000);
            const left  = until - now;
            if (left > 0) startCooldown(left);
        })();

        // Handle submit
        document.querySelectorAll('form').forEach(function(form) {
            if (!form.querySelector('#btn-submit')) return;
            form.addEventListener('submit', function(e) {
                if (btn.disabled) { e.preventDefault(); return; }
                btn.disabled = true;
                btn.classList.remove('cooldown');
                iconSend.style.display = 'none';
                iconLoad.style.display = 'inline-flex';
                label.textContent = 'Mengirim...';
            });
        });

        // Jika status berhasil dikirim, mulai cooldown
        @if(session('status') == 'verification-link-sent')
            (function() {
                const until = Math.floor(Date.now() / 1000) + COOLDOWN_SECS;
                localStorage.setItem(COOLDOWN_KEY, until);
                startCooldown(COOLDOWN_SECS);
            })();
        @endif
    </script>

</body>
</html>