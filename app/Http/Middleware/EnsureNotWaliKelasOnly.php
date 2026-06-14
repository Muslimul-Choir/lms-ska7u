<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotWaliKelasOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'guru' && $user->guru) {
            if ($user->guru->status_pengajar === 'walikelas') {
                abort(403, 'Halaman ini tidak dapat diakses oleh Wali Kelas.');
            }
        }
        return $next($request);
    }
}
