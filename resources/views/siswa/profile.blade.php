<x-student-layout>
<x-slot name="heading">Profil Saya</x-slot>

<div style="max-width:720px;margin:0 auto;padding:16px;display:flex;flex-direction:column;gap:16px;">

    {{-- Avatar Card --}}
    <div style="background:linear-gradient(135deg,#6B1A2B 0%,#2D0810 100%);border-radius:16px;padding:24px 20px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-30px;right:-30px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.05);"></div>
        <div style="position:absolute;bottom:-20px;left:-20px;width:100px;height:100px;border-radius:50%;background:rgba(201,152,42,.08);"></div>
        <div style="display:flex;align-items:center;gap:16px;position:relative;z-index:1;">
            <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#E8930A,#c9982a);border:3px solid rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,.3);">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size:18px;font-weight:800;color:#fff;margin:0 0 3px;font-family:'Plus Jakarta Sans',sans-serif;">{{ $user->name }}</h2>
                <p style="font-size:13px;color:rgba(255,255,255,.7);margin:0 0 6px;">{{ $user->email }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(201,152,42,.25);border-radius:99px;padding:3px 10px;font-size:11px;color:#fde68a;font-weight:600;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M12 21v-3.41"/></svg>
                        Siswa
                    </span>
                    @if($siswa?->Kelas)
                    <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.12);border-radius:99px;padding:3px 10px;font-size:11px;color:#fff;font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18v3H3V3z"/></svg>
                        {{ $siswa->Kelas->Tingkatan?->nama_tingkatan }} {{ $siswa->Kelas->Jurusan?->nama_jurusan }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Info Akun --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="width:32px;height:32px;border-radius:9px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            </div>
            <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Informasi Akun</span>
        </div>
        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:0;">

            @php
                $infoRows = [
                    [
                        'label' => 'Nama Lengkap',
                        'value' => $siswa?->nama_lengkap ?? $user->name,
                        'bg'    => '#eff6ff',
                        'svg'   => '<svg width="15" height="15" fill="none" stroke="#2563eb" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>',
                    ],
                    [
                        'label' => 'Email',
                        'value' => $user->email,
                        'bg'    => '#f0fdf4',
                        'svg'   => '<svg width="15" height="15" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>',
                    ],
                    [
                        'label' => 'Tanggal Lahir',
                        'value' => $siswa?->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-',
                        'bg'    => '#fdf4ff',
                        'svg'   => '<svg width="15" height="15" fill="none" stroke="#9333ea" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>',
                    ],
                    [
                        'label' => 'Agama',
                        'value' => $siswa?->agama ?? '-',
                        'bg'    => '#fff7ed',
                        'svg'   => '<svg width="15" height="15" fill="none" stroke="#ea580c" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12a8.959 8.959 0 01.284-2.253"/></svg>',
                    ],
                    [
                        'label' => 'Kelas',
                        'value' => $siswa?->Kelas
                            ? trim(($siswa->Kelas->Tingkatan?->nama_tingkatan ?? '').' '.($siswa->Kelas->Jurusan?->nama_jurusan ?? '').' '.($siswa->Kelas->Bagian?->nama_bagian ?? ''))
                            : '-',
                        'bg'    => '#f0fdf4',
                        'svg'   => '<svg width="15" height="15" fill="none" stroke="#15803d" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M12 21v-3.41"/></svg>',
                    ],
                    [
                        'label' => 'Status Email',
                        'value' => $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi',
                        'bg'    => $user->email_verified_at ? '#f0fdf4' : '#fffbeb',
                        'svg'   => $user->email_verified_at
                            ? '<svg width="15" height="15" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                            : '<svg width="15" height="15" fill="none" stroke="#d97706" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>',
                    ],
                ];
            @endphp

            @foreach($infoRows as $i => $row)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 0;{{ $i < count($infoRows)-1 ? 'border-bottom:1px solid #f8fafc;' : '' }}">
                <div style="width:34px;height:34px;border-radius:9px;background:{{ $row['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    {!! $row['svg'] !!}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">{{ $row['label'] }}</div>
                    <div style="font-size:14px;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $row['value'] }}</div>
                </div>
                @if($row['label'] === 'Status Email')
                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;background:{{ $user->email_verified_at ? '#dcfce7' : '#fef3c7' }};color:{{ $user->email_verified_at ? '#15803d' : '#92400e' }};white-space:nowrap;flex-shrink:0;">
                        {{ $user->email_verified_at ? 'Aktif' : 'Pending' }}
                    </span>
                @endif
            </div>
            @endforeach

        </div>
    </div>

    {{-- Ganti Password --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="width:32px;height:32px;border-radius:9px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            </div>
            <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Ganti Password</span>
        </div>
        <div style="padding:20px;">
            @if($errors->any())
            <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:#fff1f2;border:1.5px solid #fecdd3;border-radius:12px;margin-bottom:14px;">
                <svg width="18" height="18" fill="none" stroke="#dc2626" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <div style="font-size:13px;color:#9f1239;">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
            @endif
            <form action="{{ route('siswa.profil.password') }}" method="POST">
                @csrf @method('PUT')
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px;">Password Saat Ini</label>
                    <div style="position:relative;">
                        <input type="password" id="current_password" name="current_password" required
                            style="width:100%;padding:11px 42px 11px 14px;border:1.5px solid {{ $errors->has('current_password') ? '#fca5a5' : '#e2e8f0' }};border-radius:10px;font-size:14px;outline:none;background:#f8fafc;transition:border-color .2s;"
                            onfocus="this.style.borderColor='#6B1A2B';this.style.background='#fff'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"
                            placeholder="Masukkan password saat ini">
                        <button type="button" onclick="togglePassword('current_password')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;padding:6px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background .2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                            <svg id="eye-current_password" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <svg id="eye-slash-current_password" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px;">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" id="new_password" name="password" required
                            style="width:100%;padding:11px 42px 11px 14px;border:1.5px solid {{ $errors->has('password') ? '#fca5a5' : '#e2e8f0' }};border-radius:10px;font-size:14px;outline:none;background:#f8fafc;transition:border-color .2s;"
                            onfocus="this.style.borderColor='#6B1A2B';this.style.background='#fff'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"
                            placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword('new_password')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;padding:6px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background .2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                            <svg id="eye-new_password" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <svg id="eye-slash-new_password" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px;">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            style="width:100%;padding:11px 42px 11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;background:#f8fafc;transition:border-color .2s;"
                            onfocus="this.style.borderColor='#6B1A2B';this.style.background='#fff'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'"
                            placeholder="Ulangi password baru">
                        <button type="button" onclick="togglePassword('password_confirmation')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;padding:6px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background .2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                            <svg id="eye-password_confirmation" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <svg id="eye-slash-password_confirmation" width="18" height="18" fill="none" stroke="#64748b" viewBox="0 0 24 24" stroke-width="2" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,#6B1A2B,#9B3045);color:#fff;border:none;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:opacity .2s;display:flex;align-items:center;justify-content:center;gap:8px;" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Perbarui Password
                </button>
            </form>
            
            <script>
            function togglePassword(fieldId) {
                const input = document.getElementById(fieldId);
                const eyeIcon = document.getElementById('eye-' + fieldId);
                const eyeSlashIcon = document.getElementById('eye-slash-' + fieldId);
                
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeSlashIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeSlashIcon.style.display = 'none';
                }
            }
            </script>
        </div>
    </div>

    {{-- Logout --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.07);overflow:hidden;">
        <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;">
            <div style="width:32px;height:32px;border-radius:9px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
            </div>
            <span style="font-size:15px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;">Keluar dari Akun</span>
        </div>
        <div style="padding:20px;">
            <p style="font-size:13px;color:#64748b;margin:0 0 14px;">Keluar dari sesi aktif Anda di perangkat ini.</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width:100%;padding:12px;background:#fff;color:#dc2626;border:1.5px solid #fecdd3;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:background .2s;display:flex;align-items:center;justify-content:center;gap:8px;" onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='#fff'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </div>

</div>
</x-student-layout>
