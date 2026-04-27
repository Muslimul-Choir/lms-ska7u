<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background-color:#f0fdf4; font-family:Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4; padding:40px 0;">
    <tr>
      <td align="center">

        <!-- Container -->
        <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08); border:1px solid #dcfce7;">
          
          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(90deg,#16a34a,#4ade80); color:#ffffff; padding:22px 24px;">
              <h1 style="margin:0; font-size:18px;">{{ config('app.name') }}</h1>
              <p style="margin:4px 0 0; font-size:13px; opacity:0.9;">Sistem Informasi Sekolah</p>
            </td>
          </tr>

          <!-- Accent -->
          <tr>
            <td style="height:4px; background-color:#fde68a;"></td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:26px; color:#374151; font-size:14px; line-height:1.7;">
              
              <p style="margin:0 0 12px;">
                Halo <strong>{{ $siswa->nama_lengkap }}</strong> 👋,
              </p>

              <p style="margin:0 0 16px;">
                Selamat datang! Akun LMS Anda telah berhasil dibuat. Silakan gunakan informasi berikut untuk mulai mengakses sistem:
              </p>

              <!-- Info Box -->
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px; margin-bottom:18px;">
                <tr>
                  <td style="font-size:14px; color:#166534;">
                    <p style="margin:4px 0;"><strong>URL Login :</strong> {{ url('/login') }}</p>
                    <p style="margin:4px 0;"><strong>Email :</strong> {{ $siswa->email }}</p>
                    <p style="margin:4px 0;"><strong>Password :</strong> {{ $password }}</p>
                  </td>
                </tr>
              </table>

              <!-- Warning -->
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef9c3; border-left:4px solid #facc15; padding:12px; margin-bottom:18px;">
                <tr>
                  <td style="font-size:12px; color:#854d0e;">
                    ⚠️ Demi keamanan, disarankan untuk segera mengganti password Anda setelah login pertama.
                  </td>
                </tr>
              </table>

              <!-- Button -->
              <table width="100%" cellpadding="0" cellspacing="0" style="text-align:center; margin-bottom:18px;">
                <tr>
                  <td>
                    <a href="{{ url('/login') }}"
                       style="display:inline-block; background-color:#16a34a; color:#ffffff; text-decoration:none; padding:11px 22px; border-radius:6px; font-size:14px; font-weight:bold;">
                      Mulai Login
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Closing -->
              <p style="margin:16px 0 0;">
                Semoga sistem ini dapat membantu aktivitas Anda. Jika mengalami kendala, silakan hubungi admin.
              </p>

              <p style="margin:12px 0 0;">
                Salam hangat,<br>
                <strong>{{ config('app.name') }}</strong>
              </p>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#f8fafc; text-align:center; font-size:12px; color:#94a3b8; padding:16px; border-top:1px solid #e2e8f0;">
              Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>