<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        // Listen for Login and Logout events to log them automatically
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            \App\Models\ActivityLog::create([
                'id_user' => $event->user->id,
                'aksi' => 'LOGIN',
                'modul' => 'AUTH',
                'tabel_target' => 'users',
                'id_target' => $event->user->id,
                'deskripsi' => 'Pengguna berhasil masuk ke sistem.',
                'status_aksi' => 'sukses',
                'ip_address' => \Illuminate\Support\Facades\Request::ip() ?? '127.0.0.1',
                'user_agent' => substr(\Illuminate\Support\Facades\Request::userAgent() ?? 'Unknown', 0, 300),
                'session_id' => session()->getId(),
            ]);
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user) {
                \App\Models\ActivityLog::create([
                    'id_user' => $event->user->id,
                    'aksi' => 'LOGOUT',
                    'modul' => 'AUTH',
                    'tabel_target' => 'users',
                    'id_target' => $event->user->id,
                    'deskripsi' => 'Pengguna keluar dari sistem.',
                    'status_aksi' => 'sukses',
                    'ip_address' => \Illuminate\Support\Facades\Request::ip() ?? '127.0.0.1',
                    'user_agent' => substr(\Illuminate\Support\Facades\Request::userAgent() ?? 'Unknown', 0, 300),
                    'session_id' => session()->getId(),
                ]);
            }
        });

        RateLimiter::for('send-email-all', function (Request $request) {
            return Limit::perMinutes(10, 2)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function ($request, array $headers) {

                    $seconds = (int) ($headers['Retry-After'] ?? 0);

                    $minutes = floor($seconds / 60);
                    $remainingSeconds = $seconds % 60;
                    $retryAt = now()->addSeconds($seconds)->format('H:i:s');

                    return redirect()->back()->with(
                        'error',
                        "Batas pengiriman email massal telah tercapai. Coba lagi dalam {$minutes} menit {$remainingSeconds} detik (sekitar pukul {$retryAt})."
                    );
                });
        });

        RateLimiter::for('import-data', function (Request $request) {
            return Limit::perMinutes(5, 5)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function ($request, array $headers) {

                    $seconds = (int) ($headers['Retry-After'] ?? 0);

                    $minutes = floor($seconds / 60);
                    $remainingSeconds = $seconds % 60;
                    $retryAt = now()->addSeconds($seconds)->format('H:i:s');

                    return redirect()->back()->with(
                        'error',
                        "Terlalu banyak proses import. Silakan coba lagi dalam {$minutes} menit {$remainingSeconds} detik (sekitar pukul {$retryAt})."
                    );
                });
        });

        RateLimiter::for('export-data', function (Request $request) {
            return Limit::perMinute(20)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function ($request, array $headers) {

                    $seconds = (int) ($headers['Retry-After'] ?? 0);

                    $minutes = floor($seconds / 60);
                    $remainingSeconds = $seconds % 60;
                    $retryAt = now()->addSeconds($seconds)->format('H:i:s');

                    return redirect()->back()->with(
                        'error',
                        "Terlalu banyak permintaan export. Silakan coba lagi dalam {$minutes} menit {$remainingSeconds} detik (sekitar pukul {$retryAt})."
                    );
                });
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email — ' . config('app.name'))
                ->greeting('Halo!')
                ->line('Klik tombol di bawah ini untuk memverifikasi alamat email Anda.')
                ->action('Verifikasi Email', $url)
                ->line('Jika Anda tidak membuat akun, abaikan email ini.');
        });

        // ── Model Observers for Notifications ──
        \App\Models\Mapel::created(function ($mapel) {
            try {
                $query = \App\Models\Siswa::with('User');
                if ($mapel->agama) {
                    $query->where('agama', $mapel->agama);
                }
                $students = $query->get();
                foreach ($students as $siswa) {
                    if ($siswa->User) {
                        $siswa->User->notify(new \App\Notifications\AcademicNotification(
                            'mapel',
                            'Mata Pelajaran Baru: ' . $mapel->nama_mapel,
                            "Mata pelajaran baru '" . $mapel->nama_mapel . "' (" . $mapel->kode_mapel . ") telah ditambahkan ke sistem.",
                            route('siswa.materi.index'),
                            false
                        ));
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error notifying Mapel creation: " . $e->getMessage());
                if (app()->runningInConsole()) {
                    echo "Mapel Observer Exception: " . $e->getMessage() . "\n";
                }
            }
        });

        \App\Models\JadwalBelajar::created(function ($jadwal) {
            try {
                if ($jadwal->id_kelas) {
                    $students = \App\Models\Siswa::where('id_kelas', $jadwal->id_kelas)->with('User')->get();
                    $mapelName = $jadwal->nama_display;
                    foreach ($students as $siswa) {
                        if ($siswa->User) {
                            $siswa->User->notify(new \App\Notifications\AcademicNotification(
                                'jadwal',
                                'Jadwal Baru: ' . $mapelName,
                                "Jadwal belajar baru untuk '" . $mapelName . "' pada hari " . ucfirst($jadwal->hari) . " telah ditambahkan.",
                                route('siswa.jadwal.index'),
                                false
                            ));
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error notifying Jadwal creation: " . $e->getMessage());
                if (app()->runningInConsole()) {
                    echo "Jadwal Observer Exception: " . $e->getMessage() . "\n";
                }
            }
        });

        \App\Models\Materi::created(function ($materi) {
            try {
                $kelasIds = [];
                if ($materi->Pertemuan && $materi->Pertemuan->JadwalBelajar) {
                    $kelasIds[] = $materi->Pertemuan->JadwalBelajar->id_kelas;
                } elseif ($materi->id_guru_mapel) {
                    $kelasIds = \App\Models\JadwalBelajar::where('id_guru_mapel', $materi->id_guru_mapel)->pluck('id_kelas')->toArray();
                }
                
                if (!empty($kelasIds)) {
                    $students = \App\Models\Siswa::whereIn('id_kelas', $kelasIds)->with('User')->get();
                    foreach ($students as $siswa) {
                        if ($siswa->User) {
                            $siswa->User->notify(new \App\Notifications\AcademicNotification(
                                'materi',
                                'Materi Baru: ' . $materi->judul,
                                "Materi pembelajaran baru '" . $materi->judul . "' telah diterbitkan untuk mata pelajaran " . ($materi->Mapel?->nama_mapel ?? $materi->GuruMapel?->Mapel?->nama_mapel ?? '') . ".",
                                route('siswa.materi.show', $materi->id),
                                true
                            ));
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error notifying Materi creation: " . $e->getMessage());
                if (app()->runningInConsole()) {
                    echo "Materi Observer Exception: " . $e->getMessage() . "\n";
                }
            }
        });

        \App\Models\Tugas::created(function ($tugas) {
            try {
                $kelasIds = [];
                if ($tugas->Pertemuan && $tugas->Pertemuan->JadwalBelajar) {
                    $kelasIds[] = $tugas->Pertemuan->JadwalBelajar->id_kelas;
                } elseif ($tugas->id_guru_mapel) {
                    $kelasIds = \App\Models\JadwalBelajar::where('id_guru_mapel', $tugas->id_guru_mapel)->pluck('id_kelas')->toArray();
                }

                if (!empty($kelasIds)) {
                    $students = \App\Models\Siswa::whereIn('id_kelas', $kelasIds)->with('User')->get();
                    $batasWaktuFormatted = $tugas->batas_waktu ? $tugas->batas_waktu->format('d M Y H:i') : '-';
                    foreach ($students as $siswa) {
                        if ($siswa->User) {
                            $siswa->User->notify(new \App\Notifications\AcademicNotification(
                                'tugas',
                                'Tugas Baru: ' . $tugas->judul,
                                "Tugas baru '" . $tugas->judul . "' telah diterbitkan. Batas waktu pengumpulan: " . $batasWaktuFormatted . ".",
                                route('siswa.tugas.show', $tugas->id),
                                true
                            ));
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error notifying Tugas creation: " . $e->getMessage());
                if (app()->runningInConsole()) {
                    echo "Tugas Observer Exception: " . $e->getMessage() . "\n";
                }
            }
        });

        \App\Models\Kuis::created(function ($kuis) {
            try {
                $kelasIds = [];
                if ($kuis->Pertemuan && $kuis->Pertemuan->JadwalBelajar) {
                    $kelasIds[] = $kuis->Pertemuan->JadwalBelajar->id_kelas;
                } elseif ($kuis->id_guru_mapel) {
                    $kelasIds = \App\Models\JadwalBelajar::where('id_guru_mapel', $kuis->id_guru_mapel)->pluck('id_kelas')->toArray();
                }

                if (!empty($kelasIds)) {
                    $students = \App\Models\Siswa::whereIn('id_kelas', $kelasIds)->with('User')->get();
                    $batasMulaiFormatted = $kuis->batas_mulai ? $kuis->batas_mulai->format('d M Y H:i') : '-';
                    $batasSelesaiFormatted = $kuis->batas_selesai ? $kuis->batas_selesai->format('d M Y H:i') : '-';
                    foreach ($students as $siswa) {
                        if ($siswa->User) {
                            $siswa->User->notify(new \App\Notifications\AcademicNotification(
                                'kuis',
                                'Kuis Baru: ' . $kuis->judul,
                                "Kuis baru '" . $kuis->judul . "' telah ditambahkan. Batas pengerjaan mulai: " . $batasMulaiFormatted . " sampai " . $batasSelesaiFormatted . ".",
                                route('siswa.kuis.show', $kuis->id),
                                true
                            ));
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error notifying Kuis creation: " . $e->getMessage());
                if (app()->runningInConsole()) {
                    echo "Kuis Observer Exception: " . $e->getMessage() . "\n";
                }
            }
        });
    }
}