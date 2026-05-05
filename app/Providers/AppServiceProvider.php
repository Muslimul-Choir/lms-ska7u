<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
    }
}