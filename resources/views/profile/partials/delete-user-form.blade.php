<section>

    {{-- Card Header --}}
    <div class="lms-card-header">
        <div class="lms-card-icon lms-card-icon-red">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="1.8">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </div>
        <div class="lms-card-header-text">
            <h3>{{ __('Hapus Akun') }}</h3>
            <p>{{ __('Tindakan ini bersifat permanen dan tidak dapat dibatalkan') }}</p>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="lms-card-body">

        {{-- Warning Notice --}}
        <div class="lms-notice lms-notice-warn" style="margin-bottom:20px;">
            <span class="lms-notice-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </span>
            <p class="lms-notice-text">
                {{ __('Setelah akun dihapus, semua data dan resource akan dihapus secara permanen. Harap unduh semua data penting Anda sebelum melanjutkan.') }}
            </p>
        </div>

        {{-- Trigger Button --}}
        <button
            class="lms-btn lms-btn-danger-soft"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            {{ __('Hapus Akun Saya') }}
        </button>

    </div>

    {{-- ---- Confirmation Modal ---- --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:28px 28px 24px;">
            @csrf
            @method('delete')

            {{-- Modal Header --}}
            <div style="display:flex; align-items:flex-start; gap:14px; margin-bottom:18px;">
                <div style="width:46px; height:46px; border-radius:12px; background:#FEF2F2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h2 style="font-size:17px; font-weight:700; color:#111827; margin:0 0 5px;">
                        {{ __('Yakin ingin menghapus akun?') }}
                    </h2>
                    <p style="font-size:13px; color:#6B7280; line-height:1.65; margin:0;">
                        {{ __('Semua data akan dihapus secara permanen. Masukkan kata sandi Anda untuk konfirmasi tindakan ini.') }}
                    </p>
                </div>
            </div>

            <div class="lms-divider" style="margin:0 0 20px;"></div>

            {{-- Password Field --}}
            <div class="lms-form-group">
                <label for="delete_password" class="lms-label">{{ __('Kata Sandi') }}</label>
                <div class="lms-input-wrap">
                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        class="lms-input {{ $errors->userDeletion->get('password') ? 'lms-input-error' : '' }}"
                        placeholder="{{ __('Masukkan kata sandi Anda') }}"
                    />
                </div>
                @foreach ($errors->userDeletion->get('password') as $message)
                    <p class="lms-error">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                @endforeach
            </div>

            {{-- Modal Actions --}}
            <div style="display:flex; justify-content:flex-end; align-items:center; gap:10px; padding-top:4px;">
                <button
                    type="button"
                    class="lms-btn lms-btn-ghost"
                    x-on:click="$dispatch('close')"
                >
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="lms-btn lms-btn-danger-solid">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>

        </form>
    </x-modal>

</section>