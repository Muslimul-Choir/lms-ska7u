<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotPengajarOnly
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
            if ($user->guru->status_pengajar === 'pengajar') {
                abort(403, 'Halaman ini hanya untuk Wali Kelas.');
            }
        }
        
        return $next($request);
    }
}
