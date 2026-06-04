<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password — {{ config('app.name', 'App') }}</title>
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

        /* Alert */
        .alert {
            margin-bottom: 16px; padding: 9px 13px; border-radius: 10px;
            font-size: 12.5px; font-weight: 500;
            background: rgba(232,147,10,0.1); border: 1px solid rgba(232,147,10,0.28);
            color: #8a5000;
        }

        /* Fields */
        .field { margin-bottom: 16px; }
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

        .err-msg {
            display: flex; align-items: center; gap: 4px;
            font-size: 11.5px; color: #e05555; margin-top: 4px;
        }

        /* Buttons row */
        .btn-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-top: 4px;
        }

        .back-link {
            font-size: 12px; font-weight: 600; color: #E8930A;
            text-decoration: none; transition: color 0.18s;
            display: flex; align-items: center; gap: 5px;
        }
        .back-link:hover { color: #F5A623; }

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

                {{-- Session status --}}
                @if(session('status'))
                <div class="alert f1">{{ session('status') }}</div>
                @endif

                <p class="form-eyebrow f1">Reset Akses</p>
                <h2 class="form-title f1">Lupa Password?</h2>
                <p class="form-sub f2">Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk membuat password baru.</p>

                <form method="POST" action="{{ route('password.email') }}">
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

                    {{-- Buttons --}}
                    <div class="btn-row f4">
                        <a href="{{ route('login') }}" class="back-link">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali login
                        </a>
                        <button type="submit" id="btn-submit" class="btn-submit">
                            {{-- Icon kirim (default) --}}
                            <span id="btn-icon-send">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            {{-- Icon loading spinner --}}
                            <span id="btn-icon-loading" style="display:none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 0.8s linear infinite;">
                                    <path stroke-linecap="round" d="M12 2a10 10 0 0 1 10 10"/>
                                </svg>
                            </span>
                            <span id="btn-label">Kirim Tautan</span>
                        </button>
                    </div>

                </form>

            </div>

            <span class="pg-num">— 02 —</span>
        </div>
    </div>

    <style>
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
    </style>

    <script>
        const COOLDOWN_KEY  = 'pw_reset_cooldown_until';
        const COOLDOWN_SECS = 30;

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
            label.textContent = 'Kirim Tautan';
            localStorage.removeItem(COOLDOWN_KEY);
        }

        // Cek apakah ada cooldown yang tersisa dari session sebelumnya
        (function checkStoredCooldown() {
            const until = parseInt(localStorage.getItem(COOLDOWN_KEY) || '0', 10);
            const now   = Math.floor(Date.now() / 1000);
            const left  = until - now;
            if (left > 0) startCooldown(left);
        })();

        // Handle submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (btn.disabled) { e.preventDefault(); return; }

            // Set loading state
            btn.disabled = true;
            btn.classList.remove('cooldown');
            iconSend.style.display = 'none';
            iconLoad.style.display = 'inline-flex';
            label.textContent = 'Mengirim...';
        });

        // Jika halaman diload ulang dengan session status (berarti email berhasil dikirim),
        // langsung mulai cooldown
        @if(session('status'))
            (function() {
                const until = Math.floor(Date.now() / 1000) + COOLDOWN_SECS;
                localStorage.setItem(COOLDOWN_KEY, until);
                startCooldown(COOLDOWN_SECS);
            })();
        @endif
    </script>

</body>
</html>