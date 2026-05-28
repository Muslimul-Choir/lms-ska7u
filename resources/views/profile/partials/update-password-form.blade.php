<section>

    {{-- Card Header --}}
    <div class="lms-card-header">
        <div class="lms-card-icon lms-card-icon-gold">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E8930A" stroke-width="1.8">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        <div class="lms-card-header-text">
            <h3>{{ __('Ubah Kata Sandi') }}</h3>
            <p>{{ __('Gunakan kata sandi panjang dan aman untuk melindungi akun') }}</p>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="lms-card-body">

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div class="lms-form-group">
                <label for="update_password_current_password" class="lms-label">
                    {{ __('Kata Sandi Saat Ini') }}
                </label>

                <div class="lms-input-wrap password-wrap">

                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>

                    <input
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        class="lms-input {{ $errors->updatePassword->get('current_password') ? 'lms-input-error' : '' }}"
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi saat ini"
                    >

                    {{-- Toggle Eye --}}
                    <button
                        type="button"
                        class="lms-eye-btn"
                        onclick="togglePassword('update_password_current_password', this)"
                    >
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

                        <svg class="eye-close hidden" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>

                </div>
            </div>

            {{-- New Password --}}
            <div class="lms-form-group">

                <label for="update_password_password" class="lms-label">
                    {{ __('Kata Sandi Baru') }}
                </label>

                <div class="lms-input-wrap password-wrap">

                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                        </svg>
                    </span>

                    <input
                        id="update_password_password"
                        name="password"
                        type="password"
                        class="lms-input {{ $errors->updatePassword->get('password') ? 'lms-input-error' : '' }}"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        oninput="lmsPasswordStrength(this.value)"
                    >

                    <button
                        type="button"
                        class="lms-eye-btn"
                        onclick="togglePassword('update_password_password', this)"
                    >
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

                        <svg class="eye-close hidden" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>

                </div>

                {{-- Strength --}}
                <div class="lms-strength-track">
                    <div class="lms-strength-fill" id="lms-strength-bar"></div>
                </div>

                <p class="lms-strength-label" id="lms-strength-text">
                    Masukkan kata sandi baru
                </p>

            </div>

            {{-- Confirm Password --}}
            <div class="lms-form-group">

                <label for="update_password_password_confirmation" class="lms-label">
                    {{ __('Konfirmasi Kata Sandi') }}
                </label>

                <div class="lms-input-wrap password-wrap">

                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                        </svg>
                    </span>

                    <input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="lms-input"
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi baru"
                    >

                    <button
                        type="button"
                        class="lms-eye-btn"
                        onclick="togglePassword('update_password_password_confirmation', this)"
                    >
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

                        <svg class="eye-close hidden" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>

                </div>
            </div>

            {{-- Submit --}}
            <div class="lms-action-row">
                <button type="submit" class="lms-btn lms-btn-primary">
                    Simpan Kata Sandi
                </button>
            </div>

        </form>
    </div>
</section>

<style>
.password-wrap{
    position: relative;
}

.lms-eye-btn{
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    color: #6B7280;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lms-eye-btn svg{
    width: 20px;
    height: 20px;
}

.hidden{
    display: none;
}
</style>

<script>
function togglePassword(id, btn)
{
    const input = document.getElementById(id);

    const eyeOpen  = btn.querySelector('.eye-open');
    const eyeClose = btn.querySelector('.eye-close');

    if(input.type === 'password')
    {
        input.type = 'text';

        eyeOpen.classList.add('hidden');
        eyeClose.classList.remove('hidden');
    }
    else
    {
        input.type = 'password';

        eyeOpen.classList.remove('hidden');
        eyeClose.classList.add('hidden');
    }
}

function lmsPasswordStrength(val)
{
    var bar  = document.getElementById('lms-strength-bar');
    var text = document.getElementById('lms-strength-text');

    if (!bar || !text) return;

    var score = 0;

    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    var levels = [
        { pct: '0%', bg: '#E5E7EB', color: '#9CA3AF', label: 'Masukkan kata sandi baru' },
        { pct: '25%', bg: '#EF4444', color: '#DC2626', label: 'Lemah' },
        { pct: '50%', bg: '#F59E0B', color: '#D97706', label: 'Sedang' },
        { pct: '75%', bg: '#22C55E', color: '#16A34A', label: 'Kuat' },
        { pct: '100%', bg: '#15803D', color: '#15803D', label: 'Sangat Kuat ✓' }
    ];

    var lvl = val.length === 0 ? 0 : Math.min(score, 4);

    bar.style.width = levels[lvl].pct;
    bar.style.background = levels[lvl].bg;

    text.textContent = levels[lvl].label;
    text.style.color = levels[lvl].color;
}
</script>