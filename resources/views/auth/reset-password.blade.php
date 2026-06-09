<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - {{ config('app.name', 'App') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('gerbang-skaju.jpg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 0;
            pointer-events: none;
        }

        /* ── Scene ── */
        .scene {
            position: relative;
            z-index: 1;
            width: min(480px, 96vw);
            perspective: 1400px;
        }

        /* ── Book shadow ── */
        .book-shadow {
            position: absolute;
            bottom: -20px;
            left: 5%;
            right: 5%;
            height: 30px;
            background: radial-gradient(ellipse, rgba(0, 0, 0, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            animation: shadowIn 0.5s 1.4s forwards;
        }

        @keyframes shadowIn {
            to {
                opacity: 1;
            }
        }

        /* ── Card ── */
        .card {
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.25),
                0 8px 40px rgba(255, 255, 255, 0.15),
                0 25px 60px rgba(0, 0, 0, 0.35),
                0 0 80px rgba(255, 255, 255, 0.08);
            transform: rotateY(-90deg) scaleX(0.6);
            opacity: 0;
            animation: openCard 0.75s cubic-bezier(0.23, 1, 0.32, 1) 0.5s forwards;
        }

        @keyframes openCard {
            0% {
                transform: rotateY(-90deg) scaleX(0.6);
                opacity: 0;
            }

            60% {
                transform: rotateY(4deg);
                opacity: 1;
            }

            100% {
                transform: rotateY(0deg);
                opacity: 1;
            }
        }

        /* Gold strip */
        .gold-strip {
            height: 3px;
            background: linear-gradient(90deg, #E8930A, #F5A623, #E8930A);
        }

        /* ── Corner ornament ── */
        .orn {
            position: absolute;
            z-index: 6;
            opacity: 0.2;
        }

        .orn-tr {
            top: 16px;
            right: 16px;
            transform: rotate(90deg);
        }

        /* ── Card content ── */
        .card-content {
            position: relative;
            padding: clamp(24px, 3.5vh, 36px) clamp(28px, 4vw, 44px) clamp(28px, 4vh, 38px);
            opacity: 0;
            animation: fadeIn 0.4s 1.1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .form-accent {
            width: 32px;
            height: 2.5px;
            border-radius: 2px;
            background: linear-gradient(90deg, #E8930A, #F5A623);
            margin-bottom: 16px;
            animation: accentSlide 0.5s 1.3s both;
        }

        @keyframes accentSlide {
            from {
                width: 0;
                opacity: 0;
            }

            to {
                width: 32px;
                opacity: 1;
            }
        }

        .form-eyebrow {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            color: rgba(107, 26, 43, 0.55);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: clamp(18px, 2.5vw, 22px);
            line-height: 1.2;
            margin-bottom: 6px;
            color: #2D0810;
        }

        .form-sub {
            font-size: 12.5px;
            color: #9a8880;
            margin-bottom: 20px;
            line-height: 1.65;
        }

        /* Fields */
        .field {
            margin-bottom: 12px;
        }

        .field-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.65px;
            color: #a08070;
            margin-bottom: 5px;
        }

        .field-label em {
            color: #E8930A;
            font-style: normal;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #c8b4a8;
            pointer-events: none;
            z-index: 1;
        }

        .field-input {
            width: 100%;
            padding: 9px 12px 9px 35px;
            border-radius: 9px;
            border: 1.5px solid #ecddd4;
            background: rgba(255, 255, 255, 0.65);
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #2D0810;
            outline: none;
            transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
        }

        .field-input::placeholder {
            color: #c8b4a8;
        }

        .field-input:focus {
            border-color: #E8930A;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(232, 147, 10, 0.11);
        }

        .field-input.is-error {
            border-color: rgba(220, 60, 60, 0.5);
            background: rgba(220, 60, 60, 0.05);
        }

        .pw-toggle {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px;
            color: #c8b4a8;
            transition: color 0.18s;
        }

        .pw-toggle:hover {
            color: #E8930A;
        }

        .err-msg {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            color: #e05555;
            margin-top: 4px;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            height: 3px;
            border-radius: 2px;
            background: #ecddd4;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            border-radius: 2px;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }

        .strength-hint {
            font-size: 11px;
            color: #c8b4a8;
            margin-top: 3px;
        }

        /* Buttons row */
        .btn-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
        }

        .back-link {
            font-size: 12px;
            font-weight: 600;
            color: #E8930A;
            text-decoration: none;
            transition: color 0.18s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-link:hover {
            color: #F5A623;
        }

        .btn-submit {
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(135deg, #6B1A2B, #9B3045);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 18px rgba(107, 26, 43, 0.35);
            transition: transform 0.15s, opacity 0.2s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, rgba(232, 147, 10, 0.5), transparent);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            opacity: 0.92;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Page number */
        .pg-num {
            position: absolute;
            bottom: 12px;
            right: 16px;
            z-index: 10;
            font-size: 10.5px;
            letter-spacing: 2.5px;
            font-family: 'Poppins', sans-serif;
            color: rgba(107, 26, 43, 0.22);
        }

        /* Field stagger */
        .f1 {
            animation: fadeUp 0.45s 1.20s both;
        }

        .f2 {
            animation: fadeUp 0.45s 1.28s both;
        }

        .f3 {
            animation: fadeUp 0.45s 1.36s both;
        }

        .f4 {
            animation: fadeUp 0.45s 1.44s both;
        }

        .f5 {
            animation: fadeUp 0.45s 1.52s both;
        }

        .f6 {
            animation: fadeUp 0.45s 1.60s both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 600px) {

            html,
            body {
                overflow: auto;
            }

            .scene {
                width: 96vw;
            }
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
                    <path d="M2 2h14M2 2v14" stroke="#E8930A" stroke-width="1.5" />
                    <circle cx="2" cy="2" r="1.5" fill="#E8930A" />
                </svg>
            </div>

            <div class="card-content">

                <div class="form-accent"></div>

                <p class="form-eyebrow f1">Keamanan Akun</p>
                <h2 class="form-title f1">Reset Password</h2>
                <p class="form-sub f2">Buat password baru yang kuat untuk melindungi akun Anda.</p>

                <form method="POST" action="{{ route('password.store') }}" id="reset-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div class="field f3">
                        <label for="email" class="field-label">Email <em>*</em></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email"
                                value="{{ old('email', $request->email) }}" placeholder="nama@domain.com" required
                                autofocus autocomplete="username"
                                class="field-input {{ $errors->has('email') ? 'is-error' : '' }}">
                        </div>
                        @error('email')
                            <p class="err-msg">
                                <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field f4">
                        <label for="password" class="field-label">Password Baru <em>*</em></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" placeholder="Min. 8 karakter" required
                                autocomplete="new-password"
                                class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                style="padding-right:36px" oninput="checkStrength(this.value)">
                            <button type="button" class="pw-toggle"
                                onclick="togglePw('password','eye-show-1','eye-hide-1')">
                                <svg id="eye-show-1" style="display:block;width:15px;height:15px;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-hide-1" style="display:none;width:15px;height:15px;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        {{-- Strength bar --}}
                        <div class="strength-bar-wrap">
                            <div class="strength-bar" id="strength-bar"></div>
                        </div>
                        <p class="strength-hint" id="strength-hint"></p>
                        @error('password')
                            <p class="err-msg">
                                <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="field f5">
                        <label for="password_confirmation" class="field-label">Konfirmasi Password <em>*</em></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                placeholder="Ulangi password baru" required autocomplete="new-password"
                                class="field-input {{ $errors->has('password_confirmation') ? 'is-error' : '' }}"
                                style="padding-right:36px" oninput="checkMatch()">
                            <button type="button" class="pw-toggle"
                                onclick="togglePw('password_confirmation','eye-show-2','eye-hide-2')">
                                <svg id="eye-show-2" style="display:block;width:15px;height:15px;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-hide-2" style="display:none;width:15px;height:15px;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <p class="strength-hint" id="match-hint"></p>
                        @error('password_confirmation')
                            <p class="err-msg">
                                <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="btn-row f6">
                        <a href="{{ route('login') }}" class="back-link">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali login
                        </a>
                        <button type="submit" id="btn-submit" class="btn-submit">
                            <span id="btn-icon-send">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </span>
                            <span id="btn-icon-loading" style="display:none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5"
                                    style="animation:spin 0.8s linear infinite;">
                                    <path stroke-linecap="round" d="M12 2a10 10 0 0 1 10 10" />
                                </svg>
                            </span>
                            <span id="btn-label">Reset Password</span>
                        </button>
                    </div>

                </form>

            </div>

            <span class="pg-num">- 03 -</span>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePw(inputId, showId, hideId) {
            const pw = document.getElementById(inputId);
            const s = document.getElementById(showId);
            const h = document.getElementById(hideId);
            if (pw.type === 'password') {
                pw.type = 'text';
                s.style.display = 'none';
                h.style.display = 'block';
            } else {
                pw.type = 'password';
                s.style.display = 'block';
                h.style.display = 'none';
            }
        }

        // Password strength checker
        function checkStrength(val) {
            const bar = document.getElementById('strength-bar');
            const hint = document.getElementById('strength-hint');
            if (!val) {
                bar.style.width = '0%';
                hint.textContent = '';
                return;
            }

            let score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    w: '20%',
                    color: '#e05555',
                    text: 'Sangat lemah'
                },
                {
                    w: '40%',
                    color: '#E8930A',
                    text: 'Lemah'
                },
                {
                    w: '60%',
                    color: '#f0b429',
                    text: 'Cukup'
                },
                {
                    w: '80%',
                    color: '#6B1A2B',
                    text: 'Kuat'
                },
                {
                    w: '100%',
                    color: '#2d7a3a',
                    text: 'Sangat kuat'
                },
            ];
            const lvl = levels[Math.min(score, 4)];
            bar.style.width = lvl.w;
            bar.style.background = lvl.color;
            hint.textContent = lvl.text;
            hint.style.color = lvl.color;

            checkMatch();
        }

        // Match checker
        function checkMatch() {
            const pw = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            const hint = document.getElementById('match-hint');
            if (!conf) {
                hint.textContent = '';
                return;
            }
            if (pw === conf) {
                hint.textContent = '✓ Password cocok';
                hint.style.color = '#2d7a3a';
            } else {
                hint.textContent = '✗ Password tidak cocok';
                hint.style.color = '#e05555';
            }
        }

        // Loading state on submit
        document.getElementById('reset-form').addEventListener('submit', function(e) {
            const btn = document.getElementById('btn-submit');
            if (btn.disabled) {
                e.preventDefault();
                return;
            }
            btn.disabled = true;
            document.getElementById('btn-icon-send').style.display = 'none';
            document.getElementById('btn-icon-loading').style.display = 'inline-flex';
            document.getElementById('btn-label').textContent = 'Memproses...';
        });
    </script>

</body>

</html>
