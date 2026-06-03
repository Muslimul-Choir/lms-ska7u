<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
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
    }
}