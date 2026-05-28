<section>

    {{-- Card Header --}}
    <div class="lms-card-header">
        <div class="lms-card-icon lms-card-icon-gold">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E8930A" stroke-width="1.8">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div class="lms-card-header-text">
            <h3>{{ __('Informasi Profil') }}</h3>
            <p>{{ __('Perbarui nama dan alamat email akun Anda') }}</p>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="lms-card-body">

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Name --}}
            <div class="lms-form-group">
                <label for="name" class="lms-label">{{ __('Nama Lengkap') }}</label>
                <div class="lms-input-wrap">
                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="lms-input {{ $errors->get('name') ? 'lms-input-error' : '' }}"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="{{ __('Masukkan nama lengkap') }}"
                    />
                </div>
                @foreach ($errors->get('name') as $message)
                    <p class="lms-error">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                @endforeach
            </div>

            {{-- Email --}}
            <div class="lms-form-group">
                <label for="email" class="lms-label">{{ __('Alamat Email') }}</label>
                <div class="lms-input-wrap">
                    <span class="lms-input-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="lms-input {{ $errors->get('email') ? 'lms-input-error' : '' }}"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="username"
                        placeholder="{{ __('Masukkan alamat email') }}"
                    />
                </div>
                @foreach ($errors->get('email') as $message)
                    <p class="lms-error">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </p>
                @endforeach

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="lms-notice lms-notice-warn" style="margin-top:10px;">
                        <span class="lms-notice-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </span>
                        <div>
                            <p class="lms-notice-text" style="margin-bottom:6px;">
                                {{ __('Email Anda belum diverifikasi.') }}
                            </p>
                            <button form="send-verification" style="font-size:12px; color:#D97706; background:none; border:none; padding:0; cursor:pointer; text-decoration:underline; font-weight:700;">
                                {{ __('Klik di sini untuk kirim ulang email verifikasi') }}
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p style="margin-top:6px; font-size:12px; color:#15803D; font-weight:600;">
                                    ✓ {{ __('Link verifikasi baru telah dikirim.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @else
                    <span class="lms-badge lms-badge-verified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ __('Email telah terverifikasi') }}
                    </span>
                @endif
            </div>

            {{-- Action Row --}}
            <div class="lms-action-row">
                <button type="submit" class="lms-btn lms-btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    {{ __('Simpan Perubahan') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <span
                        class="lms-toast"
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2500)"
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ __('Perubahan tersimpan!') }}
                    </span>
                @endif
            </div>

        </form>
    </div>

</section>